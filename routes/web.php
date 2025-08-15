<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::controller(ProductController::class)
  ->prefix('/products')
  ->name('products.')
  ->group(static function(): void{
    route::get('','list')->name('list');
    route::get('/{productCode}','view')->name('view');
  });


Route::controller(ShopController::class)
  ->prefix('/shops')
  ->name('shops.')
  ->group(static function(): void{
    route::get('','list')->name('list');
    route::get('/{shopCode}','view')->name('view');
  });