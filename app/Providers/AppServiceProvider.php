<?php

namespace App\Providers;

use App\Services\Admin\Category\CategoryService;
use App\Services\Admin\Category\CategoryServiceImpl;
use App\Services\Admin\Product\ProductService;
use App\Services\Admin\Product\ProductServiceImpl;
use App\Services\Cart\CartService;
use App\Services\Cart\CartServiceImpl;
use App\Services\User\UserService;
use App\Services\User\UserServiceImpl;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CartService::class, CartServiceImpl::class);
        $this->app->bind(UserService::class, UserServiceImpl::class);
        $this->app->bind(CategoryService::class, CategoryServiceImpl::class);
        $this->app->bind(ProductService::class, ProductServiceImpl::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
