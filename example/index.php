<?php

include __DIR__ . "/../vendor/autoload.php";

use leifermendez\stripe\Stripe;

$stripe = new Stripe(
    'pk_test_mUJpYCgBgLwfXMh2bnIwDqzE00Ziajrgxh',
    'sk_test_SNt0OVFRj3XV4ACe63Qu3DLE000FSv3nqP',
    'sandbox');

$response = $stripe->auth();

var_dump($response);
