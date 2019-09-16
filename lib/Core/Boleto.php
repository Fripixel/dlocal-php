<?php

namespace Fripixel\DLocal\Core;

use Fripixel\DLocal\Core\PaymentMethod;

class Boleto extends PaymentMethod
{
    public function __construct($order)
    {
        parent::__construct();

        $this->order = $order;

        $this->url = '/payments';

        $this->paymentMethodId = "BL";

        $this->country = $this->config->country;

        $this->currency = $this->config->currency;

        $this->paymentMethodFlow = $this->config->payment_method_flow["boleto"];

        $this->notificationURL = $this->config->notification_url["boleto"];

        $this->callbackURL = $this->config->callback_url["boleto"];
        
    }

    public function generate()
    {
        $this->body = [
            "amount"              => $this->order->amount,
            "currency"            => $this->currency,
            "country"             => $this->country,
            "payment_method_id"   => $this->paymentMethodId,
            "description"         => $this->order->description,
            "payment_method_flow" => $this->paymentMethodFlow,
            "payer"               => [
                "name"     => $this->order->payer->name,
                "email"    => $this->order->payer->email,
                "document" => $this->order->payer->document,
            ],
            "order_id"            => $this->order->id,
            "notification_url"    => $this->notificationURL,
            "callback_url"        => $this->callbackURL,
        ];

        $this->headers = $this->getHeaders();

        $this->response = $this->post($this->url, $this->headers, $this->body);

        return $this;

    }

}
