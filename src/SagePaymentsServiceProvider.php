<?php

namespace MidwesternInteractive\Laravel;

use Illuminate\Support\ServiceProvider;
use MidwesternInteractive\Laravel\SagePayments;

class SagePaymentsServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton(SagePayments::class, function ($app) {
            return new SagePayments();
        });
    }

    public function provides()
    {
        return [SagePayments::class];
    }
}
