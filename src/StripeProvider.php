<?php
namespace leifermendez\stripe;

use Illuminate\Support\ServiceProvider;

class StripeProvider extends ServiceProvider {
    public function register()
    {
        $this->app->singleton('StripeSCA', function () {
            return new StripeSCA();
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