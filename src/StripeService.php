<?php

namespace leifermendez\stripe;

use leifermendez\stripe\Stripe;

class StripeService
{
    /**
     */
    public function to($crendential)
    {
        $builder = new Stripe(
            $crendential['pk'],
            $crendential['sk']
        );

        return $builder;
    }
}