<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Psr\Http\Message\ServerRequestInterface;

class ShopController extends SearchableController
{

    const int max_items = 5;
    #[\Override] //to notaion if parent change the function name
    function getQuery() : Builder | Relation{
    return Shop::orderBy('code');
    }

    #[\Override]
    function applyWhereToFilterByTerm(Builder $query, string $word): void {
    //parent::applyWhereToFilterByTerm($query,$word)
    $query
    ->where('code', 'LIKE', "%{$word}%")
    ->orWhere('name', 'LIKE', "%{$word}%")
    ->orWhere('owner','LIKE',"%{$word}%");
    }

    


    function list(ServerRequestInterface $request) : View{
        $criteria = $this->prepareCriteria($request->getQueryParams());
        $query = $this->search($criteria)->withCount('products');
        return view('shops.list',[
            'shops' => $query->paginate(self::max_items),
            'criteria' => $criteria,
        ]);
    }
    function view(string $shopCode) : View{
        $shops = Shop::where('code',$shopCode)->firstOrFail();
        return view('shops.view',[
            'shop' => $shops
        ]);
    }

    function CreateForm(): View {
    Gate::authorize('create',Shop::class);
    return view('shops.create-form');
    }

    function create(ServerRequestInterface $request): RedirectResponse {
    $shop = Shop::create($request->getParsedBody());
    Gate::authorize('create',$shop);

    return redirect(
        session()->get('bookmarks.shops.create-form', route('shops.list'))
    )
    ->with('status','Shop '.$shop->code.' was created');
    }

    function UpdateForm(string $shopCode): View {
    $shop = $this->find($shopCode);
    Gate::authorize('update',$shop);

    return view('shops.update-form', [
    'shop' => $shop,
    ]);
    }

    function update(
    ServerRequestInterface $request,
    string $shopCode,
    ): RedirectResponse {
    $shop = $this->find($shopCode);
    Gate::authorize('update',$shop);
    $shop->fill($request->getParsedBody());
    $shop->save();

    return redirect()->route('shops.view', [
    'shopCode' => $shop->code,
    ])
    ->with('status','Shop '.$shop->code.' was updated');;
    }

    function delete(string $shopCode): RedirectResponse {
    $shop = $this->find($shopCode);
    Gate::authorize('delete',$shop);
    $shop->delete();

    return redirect(
        session()->get('bookmarks.shops.view', route('shops.list'))
    )
    ->with('status','Shop '.$shop->code.' was deleted');
    }

    function viewProducts(
        ServerRequestInterface $request,
        ProductController $productController,
        string $shopCode
    ): View {
        $shop = $this->find($shopCode);
        $criteria = $productController->prepareCriteria($request->getQueryParams());
        $query = $productController
            ->filter($shop->products(), $criteria)
            ->with('category')
            ->withCount('shops');
        return view('shops.view-products', [
            'shop' => $shop,
            'criteria' => $criteria,
            'products' => $query->paginate($productController::max_items),
        ]);
    }
    function AddProductsForm(
        ServerRequestInterface $request,
        ProductController $productController,
        string $shopCode
    ): View {
        $shop = $this->find($shopCode);
        Gate::authorize('create',$shop);
        $criteria = $productController->prepareCriteria($request->getQueryParams());
       $query = $productController
            ->getQuery()
            ->whereDoesntHave(
                'shops',
                function (Builder $innerQuery) use ($shop) {
                    return $innerQuery->where('code', $shop->code);
                },
            );
        $query = $productController->filter($query, $criteria)
            ->withCount('shops');
        return view('shops.add-products', [
            'shop' => $shop,
            'criteria' => $criteria,
            'products' => $query->paginate($productController::max_items),
        ]);
    }

    function addProduct(
        ServerRequestInterface $request,
       ProductController $productController,
        string $shopCode
    ): RedirectResponse {
        $shop = $this->find($shopCode);
        Gate::authorize('create',$shop);
        $data = $request->getParsedBody();
        $product = $productController
            ->getQuery()
            ->whereDoesntHave(
                'shops',
                function (Builder $innerQuery) use ($shop) {
                    return $innerQuery->where('code', $shop->code);
                },
            )
            ->where('code', $data['product'])
            ->firstOrFail();
        $shop->products()->attach($product);
        return redirect()->back()
        ->with('status','Product '.$data['product'].' was added to Shop '
    .$shop->code);
    }

    function removeProduct(
        ServerRequestInterface $request,
        string $shopCode,
    ): RedirectResponse {
        $shop = $this->find($shopCode);
        Gate::authorize('create',$shop);
        $data = $request->getParsedBody();
       
        $product = $shop->products()
            ->where('code', $data['product'])
            ->firstOrFail();
        
        $shop->products()->detach($product);
        return redirect()->back()
        ->with('status','Product '.$data['product'].' was removed from Shop '
    .$shop->code);
    } 


}
