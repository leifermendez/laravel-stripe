<?php

include __DIR__ . "/../vendor/autoload.php";

use leifermendez\stripe\StripeSCA;

$credentials = array(
    'pk' => 'pk_test_mUJpYCgBgLwfXMh2bnIwDqzE00Ziajrgxh',
    'sk' => 'sk_test_SNt0OVFRj3XV4ACe63Qu3DLE000FSv3nqP',
    'mode' => 'sandbox'
);
$stripe = new StripeSCA($credentials);

$card_data = array(
    'type' => 'card',
    'card' => [
        'token' => 'tok_1FOMsGHBaMrHjOH4HC829ZPm'
    ]
);

$response = $stripe->payment_method($card_data);

var_dump($response);
