<?php
namespace leifermendez\stripe;

use Illuminate\Support\ServiceProvider;

class StripeProvider extends ServiceProvider {
    public function register()
    {
        $this->app->singleton('StripeSCA', function () {
            $credentials = array(
                'pk' => env('STRIPE_PK'),
                'sk' => env('STRIPE_SK'),
                'mode' => env('STRIPE_MODE'),
            );
            return new StripeSCA($credentials);
        }
        );
    }
    /**
     * @return array
     */
    public function provides()
    {
        return array('StripeSCA');
    }
}