<?php

use App\Http\Controllers\Api\GeneralDataController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//General Data...
Route::get('/general-data', [GeneralDataController::class, 'getGeneralData']);
Route::get('/getcategories', [GeneralDataController::class, 'getCategories']);
Route::get('/getsubcategories', [GeneralDataController::class, 'getSubCategories']);

//Products...
Route::get('/getProducts', [ProductController::class, 'getProducts']);
Route::get('/get-product-details/{slug}', [ProductController::class, 'getProductDetails']);
Route::get('/get-typewise-products', [ProductController::class, 'getTypewiseProducts']);
Route::get('/get-categorywise-products/{id}', [ProductController::class, 'getCategoryewiseProducts']);
Route::get('/get-subcategorywise-products/{id}', [ProductController::class, 'getSubCategoryewiseProducts']);

//Order..
Route::post('/add-to-cart', [OrderController::class, 'addToCart']);
Route::get('/add-to-cart/delete/{id}', [OrderController::class, 'deleteAddToCart']);
Route::get('/add-to-cart/list/{ip_address}', [OrderController::class, 'getCartList']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
