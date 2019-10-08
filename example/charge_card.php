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
    'amount' => floatval(2000),
    'currency' => 'EUR',
    'source' => 'tok_1FOLuCHBaMrHjOH4AfN5dStc',
    'description' => 'Pago demo'
);

$response = $stripe->charge($charge);

var_dump($response);
