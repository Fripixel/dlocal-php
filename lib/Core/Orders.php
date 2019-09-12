<?php

namespace Fripixel\DLocal\Core;

class Orders extends PaymentMethod
{
    public function __construct($order)
    {
        parent::__construct();

        $this->order = $order;

        $this->url = '/orders/' . $this->order->id;
    }

    public function generate()
    {

        $this->body = [];

        $this->headers = $this->getHeaders();

        $this->response = $this->get($this->url, $this->headers);

        return $this;

    }

    public function getHeaders()
    {
        return [
            "Content-Type"  => $this->contentType,
            "X-Version"     => $this->version,
            "Authorization" => "{$this->authType}, Signature: {$this->getSignature()}",
            "X-Date"        => $this->date,
            "X-Login"       => $this->login,
            "X-Trans-Key"   => $this->transKey,
            "User-Agent"    => $this->userAgent,
        ];
    }

}
