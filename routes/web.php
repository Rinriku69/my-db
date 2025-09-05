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
    route::get('/create','CreateForm')->name('create-form');
    route::post('/create','create')->name('create');

    Route::prefix('/{productCode}')->group(static function(): void{
      route::get('','view')->name('view');
      route::get('/update','UpdateForm')->name('update-form');
      route::post('/update','update')->name('update');
      Route::post('/delete', 'delete')->name('delete');
      
    });
  });


Route::controller(ShopController::class)
  ->prefix('/shops')
  ->name('shops.')
  ->group(static function(): void{
    route::get('','list')->name('list');
    route::get('/{shopCode}','view')->name('view');
  });