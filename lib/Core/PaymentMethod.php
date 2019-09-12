<?php

namespace Fripixel\DLocal\Core;

use Fripixel\DLocal\Core\Request;
use Noodlehaus\Config;

class PaymentMethod
{
    public $config = null;

    public $url = '/payments';

    public $request = null;

    public $response = null;

    public $signature = null;

    public $contentType = "application/json";

    public $headers = [];

    public $body = [];

    public $bodyLength = 0;

    public $userAgent = "";

    public $version = "2.1";

    public $authType = "V2-HMAC-SHA256";

    public $date = null;

    public $login = null;

    public $secretKey = null;

    public $transKey = null;

    public $country = "BR";

    public $currency = "BRL";

    public $paymentMethodId = "BL";

    public $paymentMethodFlow = "REDIRECT";

    public $notificationUrl = "";

    public $callbackURL = "";

    public function __construct()
    {
        $this->config = $this->getConfig();

        $this->request = $this->getRequest();

        $this->date            = $this->getDate();
        $this->login           = $this->getLogin();
        $this->transKey        = $this->getTransKey();
        $this->userAgent       = $this->getUserAgent();
        $this->secretKey       = $this->getSecretKey();
        $this->notificationURL = $this->getNotificationURL();
        $this->callbackURL     = $this->getCallbackURL();
    }

    public function __toString()
    {
        return $this->toJson();
    }

    public function getRequest()
    {
        return new Request($this->config);
    }

    public function getConfig()
    {

        if (defined("DLOCAL_CONFIG_PATH")) {
            $path = DLOCAL_CONFIG_PATH;
        } else {
            $path = __DIR__ . '/../../examples/config.php';
        }

        if (defined("DLOCAL_ENV")) {
            $env = DLOCAL_ENV;
        } else {
            $env = "sandbox";
        }

        $config = new Config($path);

        return (object) $config->get($env);
    }

    public function get($url, $headers)
    {
        return $this->request->get($url, $headers);
    }

    public function post($url, $headers, $body)
    {
        return $this->request->post($this->url, $headers, $body);
    }

    /**
     * @return mixed
     */
    public function getSignature()
    {
        if (!empty($this->body)) {
            $message = $this->login . $this->date . json_encode($this->body);
        } else {
            $message = $this->login . $this->date;
        }

        return hash_hmac("sha256", $message, $this->secretKey);
    }

    /**
     * @param mixed $signature
     *
     * @return self
     */
    public function setSignature($signature)
    {
        $this->signature = $signature;

        return $this;
    }

    public function getBodyLength()
    {
        return strlen(json_encode($this->body));
    }

    /**
     * @return mixed
     */
    public function getUserAgent()
    {
        return $this->config->user_agent;
    }

    /**
     * @param mixed $userAgent
     *
     * @return self
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return getXDate();
    }

    /**
     * @param mixed $date
     *
     * @return self
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->config->login;
    }

    /**
     * @param mixed $login
     *
     * @return self
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTransKey()
    {
        return $this->config->trans_key;
    }

    /**
     * @param mixed $transKey
     *
     * @return self
     */
    public function setTransKey($transKey)
    {
        $this->transKey = $transKey;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSecretKey()
    {
        return $this->config->secret_key;
    }

    /**
     * @param mixed $secret
     *
     * @return self
     */
    public function setSecretKey($secretKey)
    {
        $this->secretKey = $secretKey;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNotificationUrl()
    {
        return $this->config->notification_url;
    }

    /**
     * @param mixed $notificationUrl
     *
     * @return self
     */
    public function setNotificationUrl($notificationUrl)
    {
        $this->notificationUrl = $notificationUrl;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getHeaders()
    {
        return [
            "Content-Type"   => $this->contentType,
            "X-Version"      => $this->version,
            "Authorization"  => "{$this->authType}, Signature: {$this->getSignature()}",
            "X-Date"         => $this->date,
            "X-Login"        => $this->login,
            "X-Trans-Key"    => $this->transKey,
            "User-Agent"     => $this->userAgent,
            "Content-Length" => $this->getBodyLength(),
        ];
    }

    /**
     * @param mixed $headers
     *
     * @return self
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCallbackURL()
    {
        return $this->config->callback_url;
    }

    /**
     * @param mixed $callbackURL
     *
     * @return self
     */
    public function setCallbackURL($callbackURL)
    {
        $this->callbackURL = $callbackURL;

        return $this;
    }

    public function toJson()
    {
        // guzzle streams response
        return $this->response->getContents();
    }

    public function toObject()
    {
        // array response
        return json_decode($this->response);
    }

}
