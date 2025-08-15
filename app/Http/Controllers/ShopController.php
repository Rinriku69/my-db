<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopController extends Controller
{
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
