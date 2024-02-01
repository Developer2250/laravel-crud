<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;

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
        $this->app->singleton('totalUserCount', function () {
            return User::count();
        });

        $this->app->singleton('totalProductsCount', function () {
            return Product::count();
        });

        $this->app->singleton('totalCategoryCount', function () {
            return Category::count();
        });

        View::composer('*', function ($view) {
            if (auth()->user()) {
                // Now you can directly access the shared data in your views
                $view->with('totalUserCount', $this->app->make('totalUserCount'));
                $view->with('totalProductsCount', $this->app->make('totalProductsCount'));
                $view->with('totalCategoryCount', $this->app->make('totalCategoryCount'));
            }
        });
    }
}
