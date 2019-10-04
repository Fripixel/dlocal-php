<?php
header("Content-Type: application/json");

require __DIR__ . "/../vendor/autoload.php";

define("DLOCAL_CONFIG_PATH", __DIR__ . '/config.php'); 

define("DLOCAL_ENV", "sandbox"); 

use Fripixel\DLocal\Core\BankTransfer;
use Fripixel\DLocal\Data\Order;

$order                  = new Order;
$order->id              = getOrderId(9);
$order->amount          = 100.00;
$order->description     = "200";
$order->payer           = [
	"name" => "Thiago Gabriel",
	"email" => "thiago@example.com",
	"document" => "53033315550",
    "address"  => [
        "state"    => getStateUF("Rio de Janeiro"),
        "city"     => "Petrópolis",
        "zip_code" => "28634-890",
        "street"   => "Rua de Teste",
        "number"   => "123",
    ],	
];

$paymentMethodId = "BB";

$bankTransfer = new BankTransfer(
	$order, 
	$paymentMethodId
);

echo $bankTransfer->generate();
