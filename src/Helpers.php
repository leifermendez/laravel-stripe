<?php

namespace leifermendez\stripe;
class Helpers
{
    private $code_ok = 200;
    private $code_error = 401;
    private $code_internal = 500;

    public function json($data = array(), $message = '', $code = null)
    {
        try {
            $res = array(
                'status' => 'success',
                'data' => $data,
                'code' => (!$code) ? $this->code_ok : $code
            );
            return json_encode($res);
        } catch (\Exception $e) {
            $res = array(
                'status' => 'fail',
                'message' => $e->getMessage(),
                'code' => (!$code) ? $this->code_internal : $code
            );
            return json_encode($res);
        }
    }

    public function json_error($data = array(), $message = '', $code = null)
    {
        try {
            $res = array(
                'status' => 'error',
                'data' => json_encode($data),
                'message' => $message,
                'code' => (!$code) ? $this->code_ok : $code
            );
            return json_encode($res);
        } catch (\Exception $e) {
            $res = array(
                'status' => 'fail',
                'message' => $e->getMessage(),
                'code' => (!$code) ? $this->code_internal : $code
            );

            return json_encode($res);
        }
    }
}