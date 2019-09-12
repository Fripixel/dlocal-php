<?php

namespace Fripixel\DLocal\Core;

class Installments extends PaymentMethod
{
    public $card;

    public function __construct($card)
    {
        parent::__construct();

        $this->card = $card;

        $this->url = '/installments-plans';

        $this->country = $this->config->country;

        $this->currency = $this->config->currency;

    }

    public function generate()
    {
        $this->body = [
            "bin"      => $this->card->bin,
            "amount"   => $this->card->amount,
            "country"  => $this->country,
            "currency" => $this->currency,
        ];

        $this->headers = $this->getHeaders();

        if (DLOCAL_ENV === "sandbox") {
            ////////////////////////////////////////////////////////////
            //tenho que retornar um mockup pois no sandbox não funciona ////////////////////////////////////////////////////////////
            $response = $this->getMockInstallments();
        } else {
            $response = $this->post($this->url, $this->headers, $this->body);
        }

        $this->response = $response;

        return $this;
    }

    public function getMockInstallments()
    {

        $installments = [];

        foreach (range(1, $this->card->installments) as $parcel) {

            $count = $parcel;

            $installmentAmount = $this->getInstallmentAmount($this->card->amount, 2 * ($count - 1), $count);

            $totalAmount = $this->getTotalAmount($installmentAmount, $count);

            $installment = [
                "id"                 => "INS-{$count}",
                "installment_amount" => $installmentAmount,
                "installments"       => $count,
                "total_amount"       => $totalAmount,
            ];

            array_push($installments, $installment);
        }

        return [
            "id"           => "INS",
            "country"      => $this->country,
            "amount"       => $this->card->amount,
            "currency"     => $this->currency,
            "bin"          => $this->card->bin,
            "installments" => $installments,
        ];

    }

    public function getInstallmentAmount($amount, $tax = 10, $divisor)
    {
        return round(getPercentual($amount, $tax) / $divisor, 2);
    }

    public function getTotalAmount($total, $parcel)
    {
        return round($total * $parcel, 2);
    }

    /**
     * @return mixed
     */
    public function getCard()
    {
        return $this->card;
    }

    /**
     * @param mixed $card
     *
     * @return self
     */
    public function setCard($card)
    {
        $this->card = $card;

        return $this;
    }

    public function toJson () {
        if (is_array($this->response)) {
            return json_encode($this->response);
        } else {
            return parent::toJson();
        }
    }

    public function toObject () {
        if (is_array($this->response)) {
            return (object) $this->response;
        } else {
            return parent::toJson();
        }
    }    

}
