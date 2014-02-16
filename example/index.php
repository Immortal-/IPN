<?php
include("ipn.php");

$ipn = new \PayPal\IPN(array(
    "business" => "roger@github.com",
    "currency_code" => "USD"
));

$ipn->generateForm(array(
    "item_name" => "Croissant au chocolat",
    "amount" => "0.80",
    "quantity" => array(
        "type" => "number",
        "class" => "quantityCSS",
        "placeholder" => "Quantity",
        "required" => "required"
    ),
    "custom" => json_encode(array("USER_ID" => 12, "FOOD_ID" => 3)),
    "notify_url" => "http://".$_SERVER["SERVER_NAME"]."/process_ipn.php",
    "return" => "http://".$_SERVER["SERVER_NAME"]."/success_payment.php",
    "cancel_return" => "http://".$_SERVER["SERVER_NAME"]."/cancel_payment.php",
))->printForm();


