<?php
include("IPN.php");


$ipn = new \PayPal\IPN();
if($ipn->verify())
{
  // Do on a successful payment
}


