<?php

include __DIR__ . "/../vendor/autoload.php";

use leifermendez\stripe\Stripe;

/**
 * Testing card
 * https://stripe.com/docs/payments/cards/testing#cards
 */

$stripe = new Stripe(
    'pk_test_mUJpYCgBgLwfXMh2bnIwDqzE00Ziajrgxh',
    'sk_test_SNt0OVFRj3XV4ACe63Qu3DLE000FSv3nqP',
    'sandbox');

$card_data = array(
    'card' => [
        'number' => 4000002500003155,
        'exp_month' => 12,
        'exp_year' => 2020,
        'cvc' => 123
    ]
);

$response = $stripe->tokenCard($card_data);

var_dump($response);
