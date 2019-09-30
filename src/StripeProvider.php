<?php
namespace leifermendez\stripe;

use Illuminate\Support\ServiceProvider;

class StripeProvider extends ServiceProvider {
    public function register()
    {
        $this->app->singleton('Stripe', function () {
            return new Stripe();
        }
        );
    }
    /**
     * @return array
     */
    public function provides()
    {
        return array('Stripe');
    }
}