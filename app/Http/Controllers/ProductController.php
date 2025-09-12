<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Psr\Http\Message\ServerRequestInterface;
use Illuminate\View\View;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\Relation;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ProductController extends SearchableController
{
    const int max_items = 5;
    #[\Override]
    function getQuery(): Builder | Relation
    {
        $product =Product::orderBy('code');
        //$product_cat = $product->shops;
        return $product;
    }

    /* #[\Override]
    function applyWhereToFilterByTerm(Builder $query, string $word): void {
    //parent::applyWhereToFilterByTerm($query,$word)
    $query
    ->where('code', 'LIKE', "%{$word}%")
    ->orWhere('name', 'LIKE', "%{$word}%")
    ->orWhere('owner','LIKE',"%{$word}%");
    } */

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
        return view('products.view', [
            'product' => $product,
        ]);
    }

    function CreateForm(): View
    {
        return view('products.create-form');
    }

    function create(ServerRequestInterface $request): RedirectResponse
    {
        $product = Product::create($request->getParsedBody());

        return redirect()->route('products.list');
    }

    function UpdateForm(string $productCode): View
    {
        $product = $this->find($productCode);

        return view('products.update-form', [
            'product' => $product,
        ]);
    }

    function update(
        ServerRequestInterface $request,
        string $productCode,
    ): RedirectResponse {
        $product = $this->find($productCode);
        $product->fill($request->getParsedBody());
        $product->save();

        return redirect()->route('products.view', [
            'productCode' => $product->code,
        ]);
    }

    function delete(string $productCode): RedirectResponse
    {
        $product = $this->find($productCode);
        $product->delete();

        return redirect()->route('products.list');
    }

    function viewShops(
        ServerRequestInterface $request,
        ShopController $shopController,
        string $productCode
    ): View {
        $product = $this->find($productCode);
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
}
