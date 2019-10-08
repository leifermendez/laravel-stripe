<?php

namespace leifermendez\stripe;

use Illuminate\Support\Facades\Facade;

class StripeLaravel extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'StripeLaravel';
    }
}