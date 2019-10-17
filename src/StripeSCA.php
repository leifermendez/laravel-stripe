<?php

namespace leifermendez\stripe;

use leifermendez\stripe\Curl;
use leifermendez\stripe\Helpers;

class StripeSCA
{
    private $response;
    private $mode = 'sandbox';
    private $endpoint = 'https://api.stripe.com';
    private $auth_bearer = null;
    private $curl;
    private $pk;
    private $sk;


    public function __construct($data)
    {
        $this->response = new Helpers;
        $this->curl = (new Curl());
        $this->pk = $data['pk'];
        $this->sk = $data['sk'];
        $this->mode = $data['mode'];
        $this->auth_bearer = 'Authorization: Bearer ' . $this->sk;

    }


    public function auth()
    {
        try {

            $response = $this->curl->get(
                $this->endpoint . '/v1/charges',
                [],
                [$this->auth_bearer]
            );


            if ($response['errno']) {
                throw new \Exception($response['errmsg']);
            }
            $response = $this->response->json(
                json_decode($response['content'], true),
                '', $response['http_code']);

            return $response;

        } catch (\Exception $e) {
            $response = $this->response->json_error(null, $e->getMessage());
            return $response;
        }
    }

    public function saveCustomer($data)
    {
        try {
            $save_card = array();
            $userExists = array(
                'id' => null,
                'source' => null
            );

            $dataUserExists = $this->getCardByUser(
                ['email' => 'leifer33@gmail.com']
            );

            $dataUserExists = json_decode($dataUserExists, 1);
            if ($dataUserExists['data'] && count($dataUserExists['data']['data'])) {
                $userExists = $dataUserExists['data']['data'];
                $userExists = array(
                    'id' => $userExists[0]['id'],
                    'source' => $userExists[0]['default_source']
                );
            }

            if (!$userExists['id']) {
                $response = $this->curl->post(
                    $this->endpoint . '/v1/customers',
                    $data,
                    [$this->auth_bearer]
                );
            } else {
                $response = $this->curl->get(
                    $this->endpoint . '/v1/customers/' . $userExists['id'],
                    $data,
                    [$this->auth_bearer]
                );
            }


            $res = json_decode($response['content'], true);

            $response = $this->response->json(
                $res,
                '', $response['http_code']);
            return $response;

        } catch (\Exception $e) {
            $response = $this->response->json_error(null, $e->getMessage());
            return $response;
        }
    }

    public function tokenCard($data)
    {
        try {

            $response = $this->curl->post(
                $this->endpoint . '/v1/tokens',
                $data,
                [$this->auth_bearer]
            );


            $response = $this->response->json(
                json_decode($response['content'], true),
                '', $response['http_code']);

            return $response;

        } catch (\Exception $e) {
            $response = $this->response->json_error(null, $e->getMessage());
            return $response;
        }
    }

    private function saveCard($user_id, $source)
    {
        try {

            $data = array(
                'source' => $source
            );

            $response = $this->curl->post(
                $this->endpoint . '/v1/customers/' . $user_id . '/sources',
                $data,
                [$this->auth_bearer]
            );

            $res = json_decode($response['content'], true);
            return $res;

        } catch (\Exception $e) {
            $response = $this->response->json_error(null, $e->getMessage());
            return $response;
        }
    }

    public function charge($data)
    {
        try {

            $response = $this->curl->post(
                $this->endpoint . '/v1/charges',
                $data,
                [$this->auth_bearer]
            );

            $response = $this->response->json(
                json_decode($response['content'], true),
                '', $response['http_code']);

            return $response;

        } catch (\Exception $e) {
            $response = $this->response->json_error(null, $e->getMessage());
            return $response;
        }
    }

    public function charge_sca($data)
    {
        try {

            $response = $this->curl->post(
                $this->endpoint . '/v1/payment_intents',
                $data,
                [$this->auth_bearer]
            );

            $response = $this->response->json(
                json_decode($response['content'], true),
                '', $response['http_code']);

            return $response;

        } catch (\Exception $e) {
            $response = $this->response->json_error(null, $e->getMessage());
            return $response;
        }
    }

    public function confirm_payment($id, $data)
    {
        try {

            $response = $this->curl->post(
                $this->endpoint . '/v1/payment_intents/' . $id . '/confirm',
                $data,
                [$this->auth_bearer]
            );

            $response = $this->response->json(
                json_decode($response['content'], true),
                '', $response['http_code']);

            return $response;

        } catch (\Exception $e) {
            $response = $this->response->json_error(null, $e->getMessage());
            return $response;
        }
    }

    public function payment_method_attached($id, $data)
    {
        try {

            $response = $this->curl->post(
                $this->endpoint . '/v1/payment_intents/' . $id,
                $data,
                [$this->auth_bearer]
            );

            $response = $this->response->json(
                json_decode($response['content'], true),
                '', $response['http_code']);

            return $response;

        } catch (\Exception $e) {
            $response = $this->response->json_error(null, $e->getMessage());
            return $response;
        }
    }

    public function payment_method($data)
    {
        try {

            $response = $this->curl->post(
                $this->endpoint . '/v1/payment_methods',
                $data,
                [$this->auth_bearer]
            );

            $response = $this->response->json(
                json_decode($response['content'], true),
                '', $response['http_code']);

            return $response;

        } catch (\Exception $e) {
            $response = $this->response->json_error(null, $e->getMessage());
            return $response;
        }
    }

    public function getCard($data)
    {
        try {
            $response = $this->curl->get(
                $this->endpoint . '/v1/customers/' . $data['customer'] . '/sources/' . $data['card'],
                [],
                [$this->auth_bearer]
            );


            if ($response['errno']) {
                throw new \Exception($response['errmsg']);
            }
            $response = $this->response->json(
                json_decode($response['content'], true),
                '', $response['http_code']);

            return $response;

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getCardByUser($data)
    {
        try {
            $response = $this->curl->get(
                $this->endpoint . '/v1/customers',
                ['email' => $data['email']],
                [$this->auth_bearer]
            );


            if ($response['errno']) {
                throw new \Exception($response['errmsg']);
            }
            $response = $this->response->json(
                json_decode($response['content'], true),
                '', $response['http_code']);

            return $response;

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
