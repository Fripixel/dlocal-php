<?php

return [
    "sandbox"    => [
        "base_uri"            => "https://sandbox.dlocal.com",
        "login"               => "e797cde343",
        "trans_key"           => "ec59b73731",
        "secret_key"          => "bb368bcfb21ae2491e83897ad227956a6",
        "user_agent"          => "MerchantTest / 1.0",
        "country"             => "BR",
        "currency"            => "BRL",
        "payment_method_flow" => [
            "credit_card"   => "REDIRECT",
            "bank_transfer" => "REDIRECT",
            "boleto"        => "REDIRECT",
        ],
        "notification_url"    => "https://dev.dlocal-php-sdk.com.br/notifications.php",
        "callback_url"        => "https://dev.dlocal-php-sdk.com.br",
    ],
    "production" => [
        "base_uri"            => "https://api.dlocal.com",
        "login"               => "f7f13a51cf",
        "trans_key"           => "1ba8595968",
        "secret_key"          => "81e4fdb7afbfd9d588da38bb286e6c74a",
        "user_agent"          => "MerchantTest / 1.0",
        "country"             => "BR",
        "currency"            => "BRL",
        "payment_method_flow" => [
            "credit_card"   => "REDIRECT",
            "bank_transfer" => "REDIRECT",
            "boleto"        => "REDIRECT",
        ],
        "notification_url"    => "https://dev.dlocal-php-sdk.com.br/notifications.php",
        "callback_url"        => "https://dev.dlocal-php-sdk.com.br",
    ],
];
