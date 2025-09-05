<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Psr\Http\Message\ServerRequestInterface;
use Illuminate\View\View;
use App\Models\Product;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ProductController extends SearchableController
{
    const int max_items= 5;
    #[\Override]
    function getQuery() : Builder {
    return Product::orderBy('code');
    }

    #[\Override]
    function prepareCriteria(array $criteria) : array {
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
    function filter(Builder $query, array $criteria) : Builder {
    $query = parent::filter($query, $criteria);
    $query = $this->filterByPrice(
    $query,
    $criteria['minPrice'],
    $criteria['maxPrice'],
    );

return $query;
}

    function list(ServerRequestInterface $request) : View{
        $criteria = $this->prepareCriteria($request->getQueryParams());
        $query = $this->search($criteria);
        return view('products.list',[
            'criteria' => $criteria,
            'products' => $query->paginate(self::max_items)
        ]);
    }


    function view(string $productCode) : view{
        $product = Product::where('code',$productCode)->firstOrFail();
        return view('products.view',[
            'product' => $product,
        ]);
    }

    function CreateForm(): View {
    return view('products.create-form');
    }

    function create(ServerRequestInterface $request): RedirectResponse {
    $product = Product::create($request->getParsedBody());

    return redirect()->route('products.list');
    }

    function UpdateForm(string $productCode): View {
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

    function delete(string $productCode): RedirectResponse {
    $product = $this->find($productCode);
    $product->delete();

    return redirect()->route('products.list');
    }
}
