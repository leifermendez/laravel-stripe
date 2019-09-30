<?php

include __DIR__ . "/../vendor/autoload.php";

use leifermendez\stripe\Stripe;

$stripe = new Stripe(
    'pk_test_mUJpYCgBgLwfXMh2bnIwDqzE00Ziajrgxh',
    'sk_test_SNt0OVFRj3XV4ACe63Qu3DLE000FSv3nqP',
    'sandbox');

$charge = array(
    'amount' => floatval(2000),
    'currency' => 'EUR',
    'source' => 'tok_1FOLuCHBaMrHjOH4AfN5dStc',
    'description' => 'Pago demo'
);

$response = $stripe->charge($charge);

var_dump($response);
