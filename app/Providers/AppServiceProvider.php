<?php

namespace App\Providers;

use App\Category;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('name', function ($attribute, $value, $parameters, $validator) {
            return preg_match("/^[\p{Cyrillic}\- ]+$/u", $value);
        });

        View::share('categories', Category::all());
    }
}
