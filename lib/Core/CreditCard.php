<?php

namespace Fripixel\DLocal\Core;

class CreditCard extends PaymentMethod
{
    public function __construct($order, $card, $customer, $config)
    {
        parent::__construct($config);

        $this->order = $order;

        $this->card = $card;

        $this->customer = $customer;

        $this->url = '/secure_payments';

        $this->paymentMethodId = "CARD";

        $this->country = $this->config->country;

        $this->currency = $this->config->currency;

        $this->paymentMethodFlow = $this->config->payment_method_flow;

        // $this->paymentMethodFlow = "REDIRECT";
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
            "card"                => [
                "holder_name"      => $this->card->holder_name,
                "number"           => $this->card->number,
                "cvv"              => $this->card->cvv,
                "expiration_month" => $this->card->expiration_month,
                "expiration_year"  => $this->card->expiration_year,
                "installments"     => $this->card->installments,
                "installments_id"   => $this->card->installments_id,
            ],
            "order_id"            => $this->order->id,
            "notification_url"    => $this->notificationURL,
            "callback_url"        => $this->callbackURL,
        ];

        if (isset($this->customer->user_reference)) {
            $this->body["payer"]["user_reference"] = $this->customer->user_reference;
        }

        if (isset($this->customer->address)) {
            $this->body["payer"]["address"] = (array) $this->customer->address;
        }

        $this->headers = $this->getHeaders();

        $this->response = $this->post($this->url, $this->headers, $this->body);

        return $this;
    }
}
