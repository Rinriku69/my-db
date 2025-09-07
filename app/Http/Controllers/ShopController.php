<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Shop;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Psr\Http\Message\ServerRequestInterface;

class ShopController extends SearchableController
{

    const int max_items = 5;
    #[\Override] //to notaion if parent change the function name
    function getQuery() : Builder {
    return Shop::orderBy('code');
    }

    #[\Override]
    function applyWhereToFilterByTerm(Builder $query, string $word): void {
    $query
    ->where('code', 'LIKE', "%{$word}%")
    ->orWhere('name', 'LIKE', "%{$word}%")
    ->orWhere('owner','LIKE',"%{$word}%");
    }

    function list(ServerRequestInterface $request) : View{
        $criteria = $this->prepareCriteria($request->getQueryParams());
        $query = $this->search($criteria);
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
    return view('shops.create-form');
    }

    function create(ServerRequestInterface $request): RedirectResponse {
    $shop = Shop::create($request->getParsedBody());

    return redirect()->route('shops.list');
    }

    function UpdateForm(string $shopCode): View {
    $shop = $this->find($shopCode);

    return view('shops.update-form', [
    'shop' => $shop,
    ]);
    }

    function update(
    ServerRequestInterface $request,
    string $shopCode,
    ): RedirectResponse {
    $shop = $this->find($shopCode);
    $shop->fill($request->getParsedBody());
    $shop->save();

    return redirect()->route('shops.view', [
    'shopCode' => $shop->code,
    ]);
    }

    function delete(string $shopCode): RedirectResponse {
    $shop = $this->find($shopCode);
    $shop->delete();

    return redirect()->route('shops.list');
    }
}
