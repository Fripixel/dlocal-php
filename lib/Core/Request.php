<?php

namespace Fripixel\DLocal\Core;

use GuzzleHttp\Client;

class Request
{
    public $client = null;

    public $baseURI = null;

    public $timeout = 30.0;

    public function __construct($config, $debug = false)
    {
        $this->client = new Client([
            'base_uri' => $config->base_uri,
            'timeout'  => $this->timeout,
            'debug'    => $debug,
        ]);

        $this->baseURI = $config->base_uri;
    }

    public function get($url, $headers)
    {

        $headers = $this->convertHeaders($headers);

        $curl = curl_init();

        $url = $this->baseURI . $url;
        
        curl_setopt_array($curl, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => $this->timeout,
            CURLOPT_CUSTOMREQUEST  => 'GET',
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_FAILONERROR    => false,
            CURLOPT_HTTPHEADER     => $headers
        ]);

        $response = curl_exec($curl);
        $error    = curl_error($curl);

        curl_close($curl);

        if (!$error) {
            return $response;
        } else {
            echo "cURL Error #:" . $error;
        }
    }

    public function post($url, $headers, $body)
    {

        $headers = $this->convertHeaders($headers);

        $body = $this->convertBody($body);

        $curl = curl_init();

        $url = $this->baseURI . $url;

        curl_setopt_array($curl, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => $this->timeout,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_FAILONERROR    => false,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $body,
            CURLOPT_HTTPHEADER     => $headers,
        ]);

        $response = curl_exec($curl);
        $error    = curl_error($curl);

        curl_close($curl);

        if (!$error) {
            return $response;
        } else {
            echo "cURL Error #:" . $error;
        }
    }

    public function convertHeaders($headers)
    {
        $convertedHeaders = [];
        foreach ($headers as $key => $header) {
            $value = "{$key}: {$header}";
            array_push($convertedHeaders, $value);
        }
        return $convertedHeaders;
    }

    public function convertBody($body)
    {
        return json_encode($body);
    }
}
