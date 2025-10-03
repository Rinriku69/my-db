<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware([

  'cache.headers:no_store;no_cache;must_revalidate;max_age=0',

])->group(function () {

  Route::get('/', function () {
    return view('welcome');
  });

  Route::controller(LoginController::class)
    ->prefix('auth')
    ->group(static function (): void {
      route::get('/login', 'showForm')->name('login');
      route::post('/login', 'authenticate')->name('authenticate');
      route::post('/logout', 'logout')->name('logout');
    });

  Route::middleware(['auth'])->group(static function (): void {
    Route::controller(ProductController::class)
      ->prefix('/products')
      ->name('products.')
      ->group(static function (): void {
        route::get('', 'list')->name('list');
        route::get('/create', 'CreateForm')->name('create-form');
        route::post('/create', 'create')->name('create');

        Route::prefix('/{productCode}')->group(static function (): void {
          route::get('', 'view')->name('view');
          route::get('/update', 'UpdateForm')->name('update-form');
          route::post('/update', 'update')->name('update');
          Route::post('/delete', 'delete')->name('delete');
          Route::prefix('/shops')->group(static function (): void {
            Route::get('', 'viewShops')->name('view-shops');
            Route::get('/add', 'AddShopsForm')->name('add-shops-form');
            Route::post('/add', 'addShop')->name('add-shops');
            Route::post('/remove', 'removeShop')->name('remove-shop');
          });
        });
      });


    Route::controller(ShopController::class)
      ->prefix('/shops')
      ->name('shops.')
      ->group(static function (): void {
        route::get('', 'list')->name('list');
        route::get('/create', 'CreateForm')->name('create-form');
        route::post('/create', 'create')->name('create');

        Route::prefix('/{shopCode}')->group(static function (): void {
          route::get('', 'view')->name('view');
          route::get('/update', 'UpdateForm')->name('update-form');
          route::post('/update', 'update')->name('update');
          Route::post('/delete', 'delete')->name('delete');
          Route::prefix('/products')->group(static function (): void {
            Route::get('', 'viewProducts')->name('view-products');
            Route::get('/add', 'AddProductsForm')->name('add-product-form');
            Route::post('/add', 'addProduct')->name('add-product');
            Route::post('/remove', 'removeProduct')->name('remove-product');
          });
        });
      });

    Route::controller(CategoryController::class)
      ->prefix('/categories')
      ->name('categories.')
      ->group(static function (): void {
        route::get('', 'list')->name('list');
        route::get('/create', 'CreateForm')->name('create-form');
        route::post('/create', 'create')->name('create');

        Route::prefix('/{categoryCode}')->group(static function (): void {
          route::get('', 'view')->name('view');
          route::get('/update', 'UpdateForm')->name('update-form');
          route::post('/update', 'update')->name('update');
          Route::post('/delete', 'delete')->name('delete');
          Route::prefix('/products')->group(static function (): void {
            Route::get('', 'viewProducts')->name('view-products');
            Route::get('/add', 'addProductsForm')->name('add-product-form');
            Route::post('/add', 'addProducts')->name('add-product');
          });
        });
      });
      Route::controller(UserController::class)
      ->prefix('/users')
      ->name('users.')
      ->group(static function (): void {
        route::get('', 'list')->name('list');
        route::get('/create', 'createForm')->name('create-form');
        route::post('/create', 'create')->name('create');
       
    Route::prefix('/{user}')->group(static function (): void {
        route::get('/view', 'view')->name('view');
        route::post('/delete', 'delete')->name('delete');
        route::get('/updateForm', 'updateForm')->name('updateForm');
        route::post('/update', 'update')->name('update');

        });
    Route::name('selves.')->group(static function (): void {
          route::get('/selvesview', 'selvesview')->name('view');
          route::get('/selvesupdate', 'selvesUpdateForm')->name('updateForm');
          route::post('/selvesupdate', 'selvesUpdate')->name('update');
        });
      });
  });
});
