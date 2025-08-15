<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Product;

class ProductController extends Controller
{
    function list() : View{
        $product = Product::orderBy('code')->get();
        return view('products.list',[
            'products' => $product
        ]);
    }


    function view(string $productCode) : view{
        $product = Product::where('code',$productCode)->firstOrFail();
        return view('products.view',[
            'product' => $product,
        ]);
    }
}
