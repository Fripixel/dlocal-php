<?php

function getXDate()
{
    $now = microtime(true);
    return gmdate('Y-m-d\TH:i:s', $now) . sprintf('.%03dZ', round(($now - floor($now)) * 1000));
}

function generateRandomString($length = 9)
{
    return substr(str_shuffle("0123456789"), 0, $length);
}

function getOrderId($length)
{
    return generateRandomString($length);
}

function getCreditCardBin($cardNumber)
{
    return substr($cardNumber, 0, 6);
}

function getPercentual($amount, $tax = 10)
{
    return $amount + (($tax / 100) * $amount);
}

function getAddition($amount, $tax = 10)
{
    return $amount * (1 + ($tax / 100));
}
