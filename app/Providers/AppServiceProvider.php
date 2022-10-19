<?php

namespace App\Providers;
use App\Models\Product;
use App\Models\Category;
use Facade\FlareClient\View;
use App\Models\CompanyProfile;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
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
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
         Paginator::useBootstrap();
         view()->share("domain", "http://localhost:84/");
         view()->share('content', CompanyProfile::first());
         view()->share('category', Category::where("status", "a")->get());
         view()->share('products', Product::where('is_website','true')->get());
    }

}



