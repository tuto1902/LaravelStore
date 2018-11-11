<?php

namespace App\Providers;

use App\Shopping\Cart;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('App\Contracts\PaymentContract', 'App\Services\StripePayment');

        View::composer('layouts.app', function ($view) {
            $view->with(['cart' => new Cart()]);
        });
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
