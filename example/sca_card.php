<?php

include __DIR__ . "/../vendor/autoload.php";

use leifermendez\stripe\Stripe;

$stripe = new Stripe(
    'pk_test_mUJpYCgBgLwfXMh2bnIwDqzE00Ziajrgxh',
    'sk_test_SNt0OVFRj3XV4ACe63Qu3DLE000FSv3nqP',
    'sandbox');

$charge = array(
    'amount' => floatval(1900),
    'currency' => 'EUR',
    'payment_method_types' => ['card'],
    'customer' => 'cus_FuCTSmnMDVFzEo'
);


$response = $stripe->charge_sca($charge);

var_dump($response);
