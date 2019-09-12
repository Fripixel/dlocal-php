<?php
header("Content-Type: application/json");

require __DIR__ . "/../vendor/autoload.php";

define("DLOCAL_CONFIG_PATH", __DIR__ . '/config.php'); 

define("DLOCAL_ENV", "sandbox"); 

$order = new Fripixel\DLocal\Data\Order;

$order->id = "123946578";

$orders = new Fripixel\DLocal\Core\Orders($order);

echo $orders->generate();
