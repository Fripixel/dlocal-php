<?php
header("Content-Type: application/json");

require __DIR__ . "/../vendor/autoload.php";

define("DLOCAL_CONFIG_PATH", __DIR__ . '/config.php'); 

define("DLOCAL_ENV", "sandbox"); 

use Fripixel\DLocal\Data\Card;
use Fripixel\DLocal\Core\CreditCard;
use Fripixel\DLocal\Core\Installments;
use Fripixel\DLocal\Data\Order;

///////////
// Order //
///////////

$order              = new Order;
$order->id          = getOrderId(9);
$order->amount      = 100.00;
$order->description = "200";
$order->payer       = [
    "name"     => "Thiago Gabriel",
    "email"    => "thiago@example.com",
    "document" => "53033315550",
    "address"  => [
        "state"    => getStateUF("Rio de Janeiro"),
        "city"     => "Petrópolis",
        "zip_code" => "28634-890",
        "street"   => "Rua de Teste",
        "number"   => "123",
    ],      
];

//////////
// Card //
//////////

$card = new Card;

$card->holder_name = "Thiago Gabriel";

$card->number = "4111111111111111";

$card->cvv = "123";

$card->expiration_month = 10;

$card->expiration_year = 2040;

$card->amount = 100.00;

$card->installments = 5;

$installments = new Installments(
    $card
);

$installments = $installments->generate()->toObject();

$card->installments_id = $installments->id;

///////////////////////
// Customer Optional //
///////////////////////

/*
$customer = new Customer;

$customer->user_reference = "REF123";

// Address required only in India

$customer->address = (object) [
"state"    => "Rio de Janeiro",
"city"     => "Volta Redonda",
"zip_code" => "27275-595",
"street"   => "Servidao B-1",
"number"   => "1106",
];
 */

$customer = null;

$creditCard = new CreditCard(
    $order,
    $card,
    $customer
);

///////////////////////////////////////////////////
// posso pegar resposta como json ou como objeto //
///////////////////////////////////////////////////

$object = false;

if ($object) {
    $response = $creditCard->generate()->toObject();

    if ($response->status === "PAID") {
        echo "{$response->status_detail}";
    } else {
        echo "{$response->status_detail}";
    }
} else {
    echo $creditCard->generate()->toJson();
}
