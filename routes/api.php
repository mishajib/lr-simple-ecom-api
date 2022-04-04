<?php

use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\ProductsController as FrontProductsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::post('register', [AuthenticationController::class, 'register'])->name('api.register');
Route::post('login', [AuthenticationController::class, 'login'])->name('api.login');
Route::post('logout', [AuthenticationController::class, 'logout'])->name('api.logout')->middleware('auth:api');
Route::middleware(['auth:api', 'admin'])->prefix('admin')->as('api.admin.')->group(function () {
    Route::get('user', [AuthenticationController::class, 'user'])->name('user');
    Route::apiResource('users', UsersController::class);
    Route::apiResource('products', ProductsController::class);
});

Route::get('products/home', [FrontProductsController::class, 'home'])->name('api.products.home');
Route::get('products/{product:slug}', [FrontProductsController::class, 'productDetails'])->name('api.products.details');
Route::get('products/search/{search}', [FrontProductsController::class, 'searchProducts'])->name('api.products.search');
