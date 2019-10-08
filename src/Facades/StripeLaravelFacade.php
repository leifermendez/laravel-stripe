<?php

namespace leifermendez\stripe;

use Illuminate\Support\Facades\Facade;

class StripeLaravelFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'StripeSCA';
    }
}