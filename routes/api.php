<?php

use App\Http\Controllers\AdminControllers\CategoryController;
use App\Http\Controllers\ClientControllers\ClientOrdersController;
use App\Http\Controllers\ClientControllers\ClientProductsController;
use App\Http\Controllers\AdminControllers\OrderController;
use App\Http\Controllers\AdminControllers\ProductController;
use App\Http\Controllers\AdminControllers\UserController;
use App\Http\Controllers\AuthControllers\AuthenticationController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->group(function () {

    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('users', UserController::class);

    Route::controller(ClientOrdersController::class)->group(function () {
        Route::get('my-orders', 'myOrders');

    });

    Route::controller(ClientProductsController::class)->group(function () {
        Route::get('home-products', 'index');

    });

    Route::controller(AuthenticationController::class)->group(function () {
        Route::post('login', 'login');
        Route::post('register', 'register');
    });

});
