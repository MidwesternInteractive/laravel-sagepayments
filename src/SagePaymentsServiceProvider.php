<?php

namespace MidwesternInteractive\LaravelSagePayments;

use Illuminate\Support\ServiceProvider;

/**
 * Class SagePaymentsServiceProvider
 * @package MidwesternInteractive\LaravelSagePayments
 *
 * The Laravel Service Provider for LaravelSagePayments Service
 */
class SagePaymentsServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $config = __DIR__ . '/config/config.php';
        $this->mergeConfigFrom($config, 'sagepayments');
        $this->publishes([$config => config_path('sagepayments.php')]);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['sagepayments', 'MidwesternInteractive\SagePayments'];
    }
}
