<?php

use App\Http\Controllers\Frontend\FrontendController;
use Illuminate\Support\Facades\Route;


Route::get('/', [FrontendController::class, 'index']);
Route::get('/product-details', [FrontendController::class, 'productDetails']);
Route::get('/shop', [FrontendController::class, 'shopProducts']); 
Route::get('/privacy-policy', [FrontendController::class, 'privacyPolicy']);
Route::get('/terms-conditions', [FrontendController::class, 'termsConditions']);
Route::get('/refund-policy', [FrontendController::class, 'refundPolicy']);
Route::get('/payment-policy', [FrontendController::class, 'paymentPolicy']);
Route::get('/aboutus', [FrontendController::class, 'aboutUs']);
Route::get('/contactus', [FrontendController::class, 'contactUs']);
Route::get('/view-cart', [FrontendController::class, 'viewCart']);
Route::get('/checkout', [FrontendController::class, 'checkout']);
Route::get('/order-confirmation', [FrontendController::class, 'orderConfirmation']);
Route::get('/category-products', [FrontendController::class, 'categoryProducts']);
Route::get('/subcategory-products', [FrontendController::class, 'subCategoryProducts']);
Route::get('/type-products', [FrontendController::class, 'typeProducts']);