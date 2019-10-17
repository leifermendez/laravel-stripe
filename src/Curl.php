<?php


namespace leifermendez\stripe;


class Curl
{
    private function curl($url = null, $method = 'GET', $data = array(), $headers = array(), $auth = array())
    {
        try {
            $user_agent = 'Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';

            $options = array(

                CURLOPT_CUSTOMREQUEST => $method,        //set request type post or get
                CURLOPT_POST => ($method === 'POST') ? true : false,        //set to GET
                CURLOPT_POSTFIELDS => http_build_query($data),        //set to GET
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_USERAGENT => $user_agent, //set user agent
                CURLOPT_RETURNTRANSFER => true,     // return web page
                CURLOPT_HEADER => false,    // don't return headers
                CURLOPT_FOLLOWLOCATION => true,     // follow redirects
                CURLOPT_ENCODING => "",       // handle all encodings
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_AUTOREFERER => true,     // set referer on redirect
                CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
                CURLOPT_TIMEOUT => 120,      // timeout on response
                CURLOPT_MAXREDIRS => 10,       // stop after 10 redirects
                //CURLOPT_USERPWD => $auth[0] . ":" . $auth[1]
            );

            $ch = curl_init($url);
            curl_setopt_array($ch, $options);
            $content = curl_exec($ch);
            $err = curl_errno($ch);
            $errmsg = curl_error($ch);
            $header = curl_getinfo($ch);
            curl_close($ch);

            $header['errno'] = $err;
            $header['errmsg'] = $errmsg;
            $header['content'] = $content;
            return $header;

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function get($url = null, $data = array(), $headers = array(), $auth = array())
    {
        return $this->curl($url, 'GET', $data, $headers, $auth);
    }

    public function post($url = null, $data = array(), $headers = array(), $auth = array())
    {
        return $this->curl($url, 'POST', $data, $headers, $auth);
    }
}