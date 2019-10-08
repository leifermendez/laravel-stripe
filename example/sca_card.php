<?php

include __DIR__ . "/../vendor/autoload.php";

use leifermendez\stripe\StripeSCA;

$credentials = array(
    'pk' => 'pk_test_mUJpYCgBgLwfXMh2bnIwDqzE00Ziajrgxh',
    'sk' => 'sk_test_SNt0OVFRj3XV4ACe63Qu3DLE000FSv3nqP',
    'mode' => 'sandbox'
);
$stripe = new StripeSCA($credentials);

$charge = array(
    'amount' => floatval(1900),
    'currency' => 'EUR',
    'payment_method_types' => ['card'],
    'customer' => 'cus_FuCTSmnMDVFzEo'
);


$response = $stripe->charge_sca($charge);

var_dump($response);
