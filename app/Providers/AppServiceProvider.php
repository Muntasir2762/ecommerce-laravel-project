<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function($view){
            $view->with('globalSiteSettings', Setting::first());
            $view->with('globalCarts', Cart::where('ip_address', request()->ip())->with('product')->get());
            $view->with('globalCartCount', Cart::where('ip_address', request()->ip())->count());
        });
    }
}
