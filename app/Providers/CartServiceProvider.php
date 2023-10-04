<?php

namespace App\Providers;

use App\Repostroies\Cart\CartReposotiry;
use App\Repostroies\Cart\CookieReposotiry;
use App\Repostroies\Cart\DatabaseReposotiry;
use App\Repostroies\Cart\SessionReposotiry;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CartReposotiry::class,function($app){ //تسجيل الكارت ب السيؤفز كونتينر
               // dd(config('cart.driver'));
                 if(config('cart.driver')=='database'){
                    return new DatabaseReposotiry();
                 }


                 if (config('cart.driver')=='cookie'){
                    return new CookieReposotiry ();

                 }


                 return new SessionReposotiry();


             // return new DatabaseReposotiry;

        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
