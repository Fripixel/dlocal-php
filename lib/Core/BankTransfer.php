<?php

namespace Fripixel\DLocal\Core;

class BankTransfer extends PaymentMethod
{
    public function __construct($order, $paymentMethodId)
    {
        parent::__construct();

        $this->order = $order;

        $this->url = '/payments';

        $this->paymentMethodId = $paymentMethodId;
        
        $this->country = $this->config->country;

        $this->currency = $this->config->currency;

        // $this->paymentMethodFlow = $this->config->payment_method_flow;

        $this->paymentMethodFlow = "REDIRECT";
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
            "notification_url"    => $this->notificationUrl,
        ];

        $this->headers = $this->getHeaders();
        
        $this->response = $this->post($this->url, $this->headers, $this->body);

        return $this;
    }

}
