<?php

namespace App\Providers;

use App\Channel;
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

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //       ------------ Sharing Variables toCertain View
        \View::composer('*',function($view) {
           $view->with('channels',\App\Channel::all());
        });
        //--------------- To all Views-------
//        View::share('channels', Channel::all());
    }
}
