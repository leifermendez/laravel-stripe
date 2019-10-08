<?php

include __DIR__ . "/../vendor/autoload.php";

use leifermendez\stripe\StripeSCA;

$credentials = array(
    'pk' => 'pk_test_mUJpYCgBgLwfXMh2bnIwDqzE00Ziajrgxh',
    'sk' => 'sk_test_SNt0OVFRj3XV4ACe63Qu3DLE000FSv3nqP',
    'mode' => 'sandbox'
);
$stripe = new StripeSCA($credentials);

$customer_data = array(
    'email' => 'sca@gmail.com',
    'source' => 'tok_1FOO42HBaMrHjOH4Cu0dnogU' //**
);

$response = $stripe->saveCustomer($customer_data);

var_dump($response);
