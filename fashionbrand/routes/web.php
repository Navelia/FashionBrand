<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth'])->group(function () {
    Route::middleware(['can:staff'])->group(function () {
        Route::resource('admin/category', CategoryController::class);
        Route::resource('admin/customer', CustomerController::class);
        Route::resource('admin/type', TypeController::class);
        Route::resource('admin/product', ProductController::class);
        Route::resource('admin/transaction', TransactionController::class);

        Route::post('/admin/product/getunit', [ProductController::class, 'getUnit'])->name('product.getUnit');
        Route::post('/admin/product/getdimension', [ProductController::class, 'getDimension'])->name('product.getDimension');

        Route::get('/admin/report', [TransactionController::class, 'reporting'])->name('transaction.report');
        Route::put('/admin/product/updatestock/{product}', [ProductController::class, 'addStock'])->name('product.updateStock');
        Route::get('/admin/product/showaddstock/{product}', [ProductController::class, 'showAddStock'])->name('product.showAddStock');
    });
    Route::middleware(['can:owner'])->group(function () {
        Route::post('/admin/customer/addcustomer', [UserController::class, 'addCustomer'])->name('user.addCustomer');
    });
    Route::middleware(['can:customer'])->group(function () {
        Route::post('customer/addtocart', [TransactionController::class, 'addToCart'])->name('transaction.addtocart');
        Route::get('customer/cart', [TransactionController::class, 'cart'])->name('transaction.cart');
        Route::post('customer/checkout', [TransactionController::class, 'checkout'])->name('transaction.checkout');
        Route::get('customer/profile', [CustomerController::class, 'profile'])->name('customer.profile');
        Route::get('customer/transaction/detail/{transaction}', [TransactionController::class, 'custDetail'])->name('transaction.custDetail');
    });
});

Auth::routes();

Route::get('/', [ProductController::class, 'displayCatalog'])->name('customer.catalog');
