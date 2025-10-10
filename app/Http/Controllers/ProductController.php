<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Psr\Http\Message\ServerRequestInterface;
use Illuminate\View\View;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ProductController extends SearchableController
{
    const int max_items = 5;
    #[\Override]
    function getQuery(): Builder | Relation
    {
        $product = Product::orderBy('code');
        //$product_cat = $product->shops;
        return $product;
    }

    #[\Override]
    function applyWhereToFilterByTerm(Builder $query, string $word): void {
    parent::applyWhereToFilterByTerm($query, $word);
    
    $query->orWhereHas('category', function (Builder $q) use ($word) {
            $q->where('name', 'LIKE', "%{$word}%");
        });
    
    }  

    #[\Override]
    function prepareCriteria(array $criteria): array
    {
        return [
            ...parent::prepareCriteria($criteria),
            'minPrice' => (($criteria['minPrice'] ?? null) === null)
                ? null
                : (float) $criteria['minPrice'],
            'maxPrice' => (($criteria['maxPrice'] ?? null) === null)
                ? null
                : (float) $criteria['maxPrice'],
        ];
    }

    #[\Override]
    function filter(Builder | Relation $query, array $criteria): Builder | Relation
    {
        $query = parent::filter($query, $criteria);
        $query = $this->filterByPrice(
            $query,
            $criteria['minPrice'],
            $criteria['maxPrice'],
        );

        return $query;
    }

    function list(ServerRequestInterface $request): View
    {
        Gate::authorize('list', Product::class);
        $criteria = $this->prepareCriteria($request->getQueryParams());
        $query = $this->search($criteria)
            ->withCount('shops')
            ->with('category');
        return view('products.list', [
            'criteria' => $criteria,
            'products' => $query->paginate(self::max_items)
        ]);
    }


    function view(string $productCode): view
    {
        
        $product = Product::where('code', $productCode)
            ->with('category')
            ->firstOrFail();
        Gate::authorize('view', $product);  
        return view('products.view', [
            'product' => $product,
        ]);
    }

    function CreateForm(): View
    {
        Gate::authorize('create', Product::class);  
        $category = Category::get();
        return view('products.create-form',
    ['categories' => $category,]);
    }

    function create(ServerRequestInterface $request): RedirectResponse
    {
         Gate::authorize('create', Product::class);  
        //$product = Product::create($request->getParsedBody()); mass insert
        try{
        $data = $request->getParsedBody();
        $category = Category::find($data['category_code']);

        $product = new Product();
        $product->fill($data);
        $product->category()->associate($category);
        $product->save();

        return redirect(
            session()->get('bookmarks.products.create-form', route('products.list'))
        )
        ->with('status','Product '.$product->code.' was created');
    } catch(QueryException $excp){
        return redirect()->back()
        ->withInput()
        ->withErrors([
            'alert' => $excp->errorInfo[2],//errorInfo is only key for QueryException!!
        ]);
    }
    }

    function UpdateForm(string $productCode): View
    {
         
        $product = $this->find($productCode);
        Gate::authorize('update', $product);  
        $category = Category::get();
        return view('products.update-form', [
            'product' => $product,
            'categories' => $category,
        ]);
    }

    function update(
        ServerRequestInterface $request,
        string $productCode,
    ): RedirectResponse {
        $data = $request->getParsedBody();
        $product = $this->find($productCode);
        Gate::authorize('update', $product); 
        try{
        $category = Category::find($data['category_code']);

        $product->fill($data);
        $product->category()->associate($category);
        $product->save();
        /* $product = $this->find($productCode);
        $product->fill($request->getParsedBody());
        $product->save(); */ //mass update

        return redirect()->route('products.view', [
            'productCode' => $product->code,
        ])->with('status','Product '.$product->code.' was updated');
    }catch(QueryException $excp){
        return redirect()->back()
        ->withInput()
        ->withErrors([
            'alert' => $excp->errorInfo[2],//errorInfo is only key for QueryException!!
        ]);
    }
}

    function delete(string $productCode): RedirectResponse
    {
        $product = $this->find($productCode);
        Gate::authorize('delete',$product); 
        $product->delete();
        
        return redirect(
            session()->get('bookmarks.products.view', route('products.list'))
        )
        ->with('status','Product '.$product->code.' was Deleted');
    }

    function viewShops(
        ServerRequestInterface $request,
        ShopController $shopController,
        string $productCode
    ): View {
        $product = $this->find($productCode);
        Gate::authorize('list',$product); 
        $criteria = $shopController->prepareCriteria($request->getQueryParams());
        $query = $shopController
            ->filter($product->shops(), $criteria)
            ->withCount('products');
        return view('products.view-shops', [
            'product' => $product,
            'criteria' => $criteria,
            'shops' => $query->paginate($shopController::max_items),
        ]);
    }
    function AddShopsForm(
        ServerRequestInterface $request,
        ShopController $shopController,
        string $productCode
    ): View {
        $product = $this->find($productCode);
        Gate::authorize('update',$product); 
        $criteria = $shopController->prepareCriteria($request->getQueryParams());
        $query = $shopController
            ->getQuery()
            ->whereDoesntHave(
                'products',
                function (Builder $innerQuery) use ($product) {
                    return $innerQuery->where('code', $product->code);
                },
            );
        $query = $shopController->filter($query, $criteria)
            ->withCount('products');
        return view('products.add-shops', [
            'product' => $product,
            'criteria' => $criteria,
            'shops' => $query->paginate($shopController::max_items),
        ]);
    }

    function addShop(
        ServerRequestInterface $request,
        ShopController $shopController,
        string $productCode,
    ): RedirectResponse {
        $product = $this->find($productCode);
        Gate::authorize('update',$product); 

        try{ 
        $data = $request->getParsedBody();
        $shop = $shopController
            ->getQuery()
            ->whereDoesntHave(
                'products',
                function (Builder $innerQuery) use ($product) {
                    return $innerQuery->where('code', $product->code);
                },
            )
            ->where('code', $data['shop'])
            ->firstOrFail();
        $product->shops()->attach($shop);
        return redirect()->back()
        ->with('status','Shop '.$data['shop'].' was added to product '.$productCode);
       
    }catch(QueryException $excp){
        return redirect()
        ->back()
        ->withErrors([
            'alert'=>$excp->errorInfo[2]]);
    }catch(ModelNotFoundException $excp){
        return redirect()
        ->back()
        ->withErrors([
            'alert'=>$excp->getMessage()]);
    }
    }

    function removeShop(
        ServerRequestInterface $request,
        string $productCode,
    ): RedirectResponse {
        $product = $this->find($productCode);
        $data = $request->getParsedBody();
       Gate::authorize('update',$product); 
        $shop = $product->shops()
            ->where('code', $data['shop'])
            ->firstOrFail();
        
        $product->shops()->detach($shop);
        return redirect()->back()
        ->with('status','Shop '.$data['shop'].' was removed from product '.$productCode);
    }
}
