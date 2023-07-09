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

Route::get('/', function () {
    return view('welcome');
});
Route::middleware(['auth'])->group(function () {
    Route::middleware(['can:staff'])->group(function () {
        Route::resource('admin/category', CategoryController::class);
        Route::resource('admin/customer', CustomerController::class);
        Route::resource('admin/type', TypeController::class);
        Route::resource('admin/product', ProductController::class);
        Route::resource('admin/transaction', TransactionController::class);

        Route::post('/admin/product/getunit', [ProductController::class, 'getUnit'])->name('product.getUnit');
        Route::post('/admin/product/getdimension', [ProductController::class, 'getDimension'])->name('product.getDimension');

        Route::get('/admin/report', [TransactionController::class,'reporting'])->name('transaction.report');
        Route::put('/admin/product/updatestock/{product}', [ProductController::class, 'addStock'])->name('product.updateStock');
Route::get('/admin/product/showaddstock/{product}', [ProductController::class, 'showAddStock'])->name('product.showAddStock');
    });
    Route::middleware(['can:owner'])->group(function () {
        Route::post('/admin/customer/addcustomer', [UserController::class, 'addCustomer'])->name('user.addCustomer');
    });
});

Auth::routes();
