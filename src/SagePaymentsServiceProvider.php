<?php

namespace MidwesternInteractive\Laravel;

use Illuminate\Support\ServiceProvider;
use MidwesternInteractive\Laravel\SagePayments;

class SagePaymentsServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/sagepayments.php' => config_path('sagepayments.php'),
        ], 'config');
    }

    public function register()
    {
        $this->app->singleton(SagePayments::class, function ($app) {
            return new SagePayments();
        });

        $this->mergeConfigFrom(__DIR__.'/config/sagepayments.php', 'sagepayments');
    }

    public function provides()
    {
        return [SagePayments::class];
    }
}
