<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.frontendapp', function ($view) {
            return $view->with('categories', Category::with('subCategory')->get());
        });
        view()->composer('layouts.frontendapp', function ($view) {
            $count = 0;
            if (Auth::check()) {
                $count = Cart::where('user_id', auth()->user()->id)->count();
            }
            return $view->with('cartCount', $count);
        });
    }
}
