<?php

use App\Http\Controllers\ProductController;
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