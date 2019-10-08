<?php

namespace leifermendez\stripe;

use leifermendez\stripe\StripeSCA;

class StripeService
{
    /**
     */
    public function to($crendential)
    {
        $builder = new StripeSCA($crendential);

        return $builder;
    }
}