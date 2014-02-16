<?php
include("IPN.php");

// PHP 5.4+
$ipn = (new \PayPal\IPN)->verify();

// < PHP 5.4
// $ipn = new \PayPal\IPN();
// $ipn->verify();


