<?php
header("Content-Type: application/json");

require __DIR__ . "/../vendor/autoload.php";

define("DLOCAL_CONFIG_PATH", __DIR__ . '/config.php'); 

define("DLOCAL_ENV", "sandbox"); 

use Fripixel\DLocal\Core\Boleto;
use Fripixel\DLocal\Data\Order;

$order                  = new Order;
$order->id              = getOrderId(9);
$order->amount          = 100.50;
$order->description     = "200";
$order->payer           = (object)[
	"name" => "Thiago Gabriel",
	"email" => "thiago@example.com",
	"document" => "53033315550"
];

$boleto = new Boleto($order);

echo $boleto->generate();

