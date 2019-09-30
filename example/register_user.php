<?php

include __DIR__ . "/../vendor/autoload.php";

use leifermendez\stripe\Stripe;

$stripe = new Stripe(
    'pk_test_mUJpYCgBgLwfXMh2bnIwDqzE00Ziajrgxh',
    'sk_test_SNt0OVFRj3XV4ACe63Qu3DLE000FSv3nqP',
    'sandbox');

$customer_data = array(
    'email' => 'sca@gmail.com',
    'source' => 'tok_1FOO42HBaMrHjOH4Cu0dnogU' //**
);

$response = $stripe->saveCustomer($customer_data);

var_dump($response);
