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

function getStateUF($stateName)
{
    $states = [
        'AC' => 'Acre',
        'AL' => 'Alagoas',
        'AP' => 'Amapá',
        'AM' => 'Amazonas',
        'BA' => 'Bahia',
        'CE' => 'Ceará',
        'DF' => 'Distrito Federal',
        'ES' => 'Espírito Santo',
        'GO' => 'Goiás',
        'MA' => 'Maranhão',
        'MT' => 'Mato Grosso',
        'MS' => 'Mato Grosso do Sul',
        'MG' => 'Minas Gerais',
        'PA' => 'Pará',
        'PB' => 'Paraíba',
        'PR' => 'Paraná',
        'PE' => 'Pernambuco',
        'PI' => 'Piauí',
        'RJ' => 'Rio de Janeiro',
        'RN' => 'Rio Grande do Norte',
        'RS' => 'Rio Grande do Sul',
        'RO' => 'Rondônia',
        'RR' => 'Roraima',
        'SC' => 'Santa Catarina',
        'SP' => 'São Paulo',
        'SE' => 'Sergipe',
        'TO' => 'Tocantins',
    ];

    return array_search($stateName, $states);
}
