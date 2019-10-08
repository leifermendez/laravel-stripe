<?php

include __DIR__ . "/../vendor/autoload.php";

use leifermendez\stripe\StripeSCA;

$credentials = array(
    'pk' => 'pk_test_mUJpYCgBgLwfXMh2bnIwDqzE00Ziajrgxh',
    'sk' => 'sk_test_SNt0OVFRj3XV4ACe63Qu3DLE000FSv3nqP',
    'mode' => 'sandbox'
);
$stripe = new StripeSCA($credentials);

$id = 'pi_1FOO4lHBaMrHjOH45tpaFGYE';

$data = array(
    'payment_method' => 'card_1FOO42HBaMrHjOH4CEB1fuHj'
);


$response = $stripe->confirm_payment($id, $data);

var_dump($response);
