<?php

require __DIR__ . "/../vendor/autoload.php";

$log = new Monolog\Logger('dlocal');

$log->pushHandler(
    new Monolog\Handler\StreamHandler(
        __DIR__ . '/debug.log',
        Monolog\Logger::INFO
    )
);

$log->info("notification", $_POST);
