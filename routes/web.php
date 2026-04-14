<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\LoginController;
use Illuminate\Support\Facades\Auth;
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

//Login Routes...
Route::get('/admin/login', [LoginController::class, 'adminLogin']);
Route::post('/admin/login/auth', [LoginController::class, 'adminLoginAuth']);

Route::get('/employee/login', [LoginController::class, 'employeeLogin']);
Route::post('/employee/login/auth', [LoginController::class, 'employeeLoginAuth']);

Route::get('/customer/login', [LoginController::class, 'customerLogin']);
Route::post('/customer/login/auth', [LoginController::class, 'customerLoginAuth']);

Auth::routes(['login' => false, 'register' => false]);

Route::middleware(['role:admin'])->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/admin/logout', [AdminController::class, 'adminLogout']);

    //Category Routes...
    Route::get('/manage/category-create', [CategoryController::class, 'create']);
    Route::post('/manage/category-store', [CategoryController::class, 'store']);
    Route::get('/manage/category-list', [CategoryController::class, 'list']);
    Route::get('/manage/category-edit/{id}', [CategoryController::class, 'edit']);
    Route::post('/manage/category-update/{id}', [CategoryController::class, 'update']);
    Route::get('/manage/category-delete/{id}', [CategoryController::class, 'delete']);

    //SubCategory Routes...
    Route::get('/manage/subcategory-create', [SubCategoryController::class, 'create']);
    Route::post('/manage/subcategory-store', [SubCategoryController::class, 'store']);
    Route::get('/manage/subcategory-list', [SubCategoryController::class, 'list']);
    Route::get('/manage/subcategory-edit/{id}', [SubCategoryController::class, 'edit']);
    Route::post('/manage/subcategory-update/{id}', [SubCategoryController::class, 'update']);
    Route::get('/manage/subcategory-delete/{id}', [SubCategoryController::class, 'delete']);
});


Route::middleware(['role:employee'])->group(function(){
    Route::get('/employee/dashboard', [EmployeeController::class, 'dashboard']);
    Route::get('/employee/logout', [EmployeeController::class, 'employeeLogout']);
});

Route::middleware(['role:customer'])->group(function(){
    Route::get('/customer/dashboard', [CustomerController::class, 'dashboard']);
    Route::get('/customer/logout', [CustomerController::class, 'customerLogout']);
});