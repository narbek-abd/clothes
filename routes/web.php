<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MainController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Person\OrderController as personOrderController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [MainController::class, 'index'])->name('index');

Route::get('/categories', [MainController::class, 'categories'])->name('categories');
Route::get('/category/{cat_name}', [MainController::class, 'category'])->name('category');

Route::get('/product/{product_code}', [MainController::class, 'product'])->name('product');

Route::prefix('basket')->group(function () {
	Route::middleware(['basket_not_empty'])->group(function() {
		Route::get('/', [BasketController::class, 'basket'])->name('basket');
		Route::get('/place', [BasketController::class, 'basketPlace'])->name('basket-place');
		Route::post('/remove/{id}', [BasketController::class, 'basketRemove'])->name('basket-remove');
		Route::post('/confirm', [BasketController::class, 'basketConfirm'])->name('basket-confirm');
	});

	Route::post('/add/{id}', [BasketController::class, 'basketAdd'])->name('basket-add');
});


Route::middleware(['auth', 'is_admin'])->group(function() {
	Route::get('admin/orders', [OrderController::class, 'index'])->name('orders.index');
	Route::get('admin/order/{order}', [OrderController::class, 'show'])->name('orders.show');
	Route::resource('admin/categories', CategoryController::class);
	Route::resource('admin/products', ProductController::class);
});

Route::middleware(['auth'])->group(function () {
	Route::get('person/orders', [personOrderController::class, 'index'])->name('person.orders.index');
	Route::get('person/orders/{order}', [personOrderController::class, 'show'])->name('person.orders.show');
});

require __DIR__.'/auth.php';
