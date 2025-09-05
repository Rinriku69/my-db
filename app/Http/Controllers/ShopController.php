<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopController extends SearchableController
{
    #[\Override] //to notaion if parent change the function name
    function getQuery() : Builder {
    return Shop::orderBy('code');
    }

    function list() : View{
        $shops = Shop::Orderby('code')->get();
        return view('shops.list',[
            'shops' => $shops
        ]);
    }
    function view(string $shopCode) : View{
        $shops = Shop::where('code',$shopCode)->firstOrFail();
        return view('shops.view',[
            'shop' => $shops
        ]);
    }
}
