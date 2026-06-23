<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', [FrontendController::class, 'index']);
Route::get('/product-details/{slug}', [FrontendController::class, 'productDetails']);
Route::get('/shop', [FrontendController::class, 'shopProducts']); 
Route::get('/privacy-policy', [FrontendController::class, 'privacyPolicy']);
Route::get('/terms-conditions', [FrontendController::class, 'termsConditions']);
Route::get('/refund-policy', [FrontendController::class, 'refundPolicy']);
Route::get('/payment-policy', [FrontendController::class, 'paymentPolicy']);
Route::get('/aboutus', [FrontendController::class, 'aboutUs']);
Route::get('/contactus', [FrontendController::class, 'contactUs']);
Route::post('/contact-message/store', [FrontendController::class, 'contactMessageStore']);
Route::get('/view-cart', [FrontendController::class, 'viewCart']);
Route::get('/checkout', [FrontendController::class, 'checkout']);
Route::get('/category-products/{slug}', [FrontendController::class, 'categoryProducts']);
Route::get('/subcategory-products/{slug}', [FrontendController::class, 'subCategoryProducts']);
Route::get('/type-products/{type}', [FrontendController::class, 'typeProducts']);
Route::get('/search-products', [FrontendController::class, 'searchProducts']);

//Order Routes..
Route::post('/add-cart-details/{id}', [FrontendController::class, 'addtocartDetailsPage']);
Route::get('/add-cart/{id}', [FrontendController::class, 'addtocart']);
Route::get('/delete-cart/{id}', [FrontendController::class, 'deleCart']);
Route::post('/customer-order-store', [FrontendController::class, 'orderStore']);
Route::get('/order-confirmation/{invoice_id}', [FrontendController::class, 'orderConfirmation']);

//Login Routes...
Route::get('/admin/login', [LoginController::class, 'adminLogin']);
Route::post('/admin/login/auth', [LoginController::class, 'adminLoginAuth']);

Route::get('/employee/login', [LoginController::class, 'employeeLogin']);
Route::post('/employee/login/auth', [LoginController::class, 'employeeLoginAuth']);

Route::get('/customer/login', [LoginController::class, 'customerLogin']);
Route::post('/customer/login/auth', [LoginController::class, 'customerLoginAuth']);
Route::get('/customer/registration', [LoginController::class, 'customerRegistration']);
Route::post('/customer/registration-store', [LoginController::class, 'customerRegistrationStore']);

Auth::routes(['login' => false, 'register' => false]);

Route::middleware(['role:admin'])->group(function(){

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

    //Product Routes...
    Route::get('/manage/product-create', [ProductController::class, 'create']);
    Route::post('/manage/product-store', [ProductController::class, 'store']);
    Route::get('/manage/product-list', [ProductController::class, 'list']);
    Route::get('/manage/product-edit/{id}', [ProductController::class, 'edit']);
    Route::post('/manage/product-update/{id}', [ProductController::class, 'update']);
    Route::get('/manage/product-delete/{id}', [ProductController::class, 'delete']);
    Route::get('/manage/product-status/{id}', [ProductController::class, 'changeStatus']);

    //Contact Message Routes...
    Route::get('/manage/contact-messages', [ContactMessageController::class, 'getContactMessages']);
    Route::get('/delete/contact-message/{id}', [ContactMessageController::class, 'deleteContactMessage']);
});


Route::middleware(['role:employee'])->group(function(){
    Route::get('/employee/dashboard', [EmployeeController::class, 'dashboard']);
    Route::get('/employee/logout', [EmployeeController::class, 'employeeLogout']);
});

Route::middleware(['role:customer'])->group(function(){
    Route::get('/customer/dashboard', [CustomerController::class, 'dashboard']);
    Route::get('/customer/logout', [CustomerController::class, 'customerLogout']);
    Route::get('/customer/profile-view', [CustomerController::class, 'customerProfileView']);
    Route::post('/customer/profile-update', [CustomerController::class, 'customerProfileUpdate']);
    Route::get('/customer/view-credentials', [CustomerController::class, 'customerCredentialView']);
    Route::post('/customer/update-credentials', [CustomerController::class, 'customerCredentialUpdate']);

    //Order Routes...
    Route::get('/customer/orders/{status}', [CustomerController::class, 'customerOrders']);
    Route::get('/customer/order-cancel/{id}', [CustomerController::class, 'customerOrderCancel']);
});

Route::middleware(['role:employee,admin'])->group(function(){
    Route::get('/admin/logout', [AdminController::class, 'adminLogout']);
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
    //Settings Routes...
    Route::get('/manage/website-settings', [SettingController::class, 'manageSetting']);
    Route::post('/manage/website-settings/update', [SettingController::class, 'updateSetting']);

    Route::get('/manage/website-policy', [SettingController::class, 'managePolicy']);
    Route::post('/manage/website-policy/update', [SettingController::class, 'updatePolicy']);

    Route::get('/manage/review-list', [ReviewController::class, 'reviewList']);
    Route::get('/manage/review-create', [ReviewController::class, 'reviewCreate']);
    Route::post('/manage/review-store', [ReviewController::class, 'reviewStore']);
    Route::get('/manage/review-edit/{id}', [ReviewController::class, 'reviewEdit']);
    Route::post('/manage/review-update/{id}', [ReviewController::class, 'reviewUpdate']);
    Route::get('/manage/review-delete/{id}', [ReviewController::class, 'reviewDelete']);

    //Order Routes...
    Route::get('/manage/orders/{status}', [OrderController::class, 'showOrders']);
    Route::get('/manage/order-details/{id}', [OrderController::class, 'detailOrder']);
    Route::post('/manage/order-update/{id}', [OrderController::class, 'updateOrder']);
    Route::post('/manage/order-details/update/{id}', [OrderController::class, 'updateOrderDetails']);
    Route::post('/manage/order-status-update/{id}', [OrderController::class, 'updateOrderStatus']);

    //Courier Entry...
    Route::get('/manage/order-courier-entry/{order_id}', [OrderController::class, 'courierEntry']);
});

Route::middleware(['role:employee,admin,customer'])->group(function(){

});