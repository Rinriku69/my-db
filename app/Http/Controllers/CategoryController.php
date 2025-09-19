<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Category;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\RedirectResponse;

use Illuminate\View\View;
use Psr\Http\Message\ServerRequestInterface;
use Illuminate\Http\Request;

class CategoryController extends SearchableController
{
    const int max_items = 5;
    #[\Override]
    function getQuery(): Builder | Relation
    {
        $Category =Category::orderBy('code');
        //$product_cat = $product->shops;
        return $Category;
    }
    function list(ServerRequestInterface $request) : View{
        $criteria = $this->prepareCriteria($request->getQueryParams());
        $query = $this->search($criteria)->withCount('products');
        return view('categories.list',[
            'categories' => $query->paginate(self::max_items),
            'criteria' => $criteria,
        ]);
    }

    function CreateForm(): View {
    return view('categories.create-form');
    }

    function create(ServerRequestInterface $request): RedirectResponse {
    $categories = Category::create($request->getParsedBody());

    return redirect()->route('categories.list');
    }

    function view(string $categoryCode) : View{
        $category = Category::where('code',$categoryCode)->firstOrFail();
        return view('categories.view',[
            'category' => $category
        ]);
    }

    function UpdateForm(string $categoryCode): View {
    $category = $this->find($categoryCode);

    return view('categories.update-form', [
    'category' => $category,
    ]);
    }

    function update(
    ServerRequestInterface $request,
    string $categoryCode,
    ): RedirectResponse {
    $category = $this->find($categoryCode);
    $category->fill($request->getParsedBody());
    $category->save();

    return redirect()->route('categories.view', [
    'categoryCode' => $category->code,
    ]);
    }

    function delete(string $categoryCode): RedirectResponse {
    $category = $this->find($categoryCode);
    $category->delete();

    return redirect()->route('categories.list');
    }

    function viewProducts(
        ServerRequestInterface $request,
        ProductController $productController,
        string $categoryCode
    ): View {
        $product = $this->find($categoryCode);
        $criteria = $productController->prepareCriteria($request->getQueryParams());
        $query = $productController
            ->filter($product->products(), $criteria)
            ->with('category')
            ->withCount('shops');
        return view('categories.view-products', [
            'categoryCode' => $categoryCode,
            'criteria' => $criteria,
            'products' => $query->paginate($productController::max_items),
        ]);
    }
    
    function addProductsForm(
        ServerRequestInterface $request,
        ProductController $productController,
        string $categoryCode
    ): View {
        $category = $this->find($categoryCode);
        $criteria = $productController->prepareCriteria($request->getQueryParams());

        $query = $productController
            ->getQuery()
            ->whereDoesntHave(
                'category',
                function (Builder $innerQuery) use ($category) {
                    return $innerQuery->where('code', $category->code);
                },
            );
        $query = $productController->filter($query, $criteria)
            ->withCount('shops');

       /*  $query = $productController
            ->filter($product->products(), $criteria)
            ->with('category')
            ->withCount('shops'); */
        return view('categories.add-products', [
            'category' => $category,
            'criteria' => $criteria,
            'products' => $query->paginate($productController::max_items),
        ]);
    }

    function addProducts(
        ServerRequestInterface $request,
        ProductController $productController,
        string $categoryCode
    ): RedirectResponse {
        $category = $this->find($categoryCode);
        $data = $request->getParsedBody();
        $product = $productController
            ->getQuery()
            ->whereDoesntHave(
                'category',
                function (Builder $innerQuery) use ($category) {
                    return $innerQuery->where('code', $category->code);
                },
            )
            ->where('code', $data['product'])
            ->firstOrFail();
        $category->products()->save($product);
        return redirect()->back();
    }
      
}
