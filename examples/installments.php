<?php
header("Content-Type: application/json");

require __DIR__ . "/../vendor/autoload.php";

define("DLOCAL_CONFIG_PATH", __DIR__ . '/config.php'); 

define("DLOCAL_ENV", "production"); 

use Fripixel\DLocal\Core\Installments;
use Fripixel\DLocal\Data\Card;

$card = new Card;

$card->number = "5276600074988786";

$card->amount = 100.00;

$card->installments = 2;

$installments = new Installments($card);

echo $installments->generate();
