<?php

namespace Fripixel\DLocal\Core;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Request
{
    public $client = null;

    public $baseURI = null;

    public $timeout = 2.0;

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
        try {
            $response = $this->client->request("GET", $url, [
                "headers" => $headers,
            ]);
            return $response->getBody();
        } catch (ClientException $e) {
            return $e->getResponse()->getBody();
        }
    }

    public function post($url, $headers, $body)
    {
        try {
            $response = $this->client->request("POST", $url, [
                "headers" => $headers,
                "json"    => $body,
            ]);
            return $response->getBody();
        } catch (ClientException $e) {
            return $e->getResponse()->getBody();
        }
    }
    
}
