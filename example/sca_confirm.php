<?php

include __DIR__ . "/../vendor/autoload.php";

use leifermendez\stripe\Stripe;

$stripe = new Stripe(
    'pk_test_mUJpYCgBgLwfXMh2bnIwDqzE00Ziajrgxh',
    'sk_test_SNt0OVFRj3XV4ACe63Qu3DLE000FSv3nqP',
    'sandbox');

$id = 'pi_1FOO4lHBaMrHjOH45tpaFGYE';

$data = array(
    'payment_method' => 'card_1FOO42HBaMrHjOH4CEB1fuHj'
);


$response = $stripe->confirm_payment($id, $data);

var_dump($response);
