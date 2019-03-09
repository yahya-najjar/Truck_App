<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        // view()->composer('admin.layouts.sidebar', function($view){
        //     $counts['slider'] = Slider::all()->count();
        //     $counts['team'] = Member::all()->count();
        //     $counts['project'] = Project::all()->count();
        //     $counts['solutions'] = Solution::all()->count();
        //     $counts['mssoft'] = Mssoft::all()->count();
        //     $counts['services'] = Service::all()->count();
        //     $counts['product'] = Product::all()->count();
        //     $counts['category'] = Category::all()->count();
        //     $counts['pages'] = Page::all()->count();

        //     return $view->with('counts', $counts);

        // });
        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
