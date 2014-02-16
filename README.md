


### Setup
Simply download the library in the folder you want, then include it in your project.

#####Useful
[PayPal's input element variables](https://developer.paypal.com/webapps/developer/docs/classic/paypal-payments-standard/integration-guide/Appx_websitestandard_htmlvariables/)


### Starting
Create a new IPN object and pass an array with basic information that is necessary for the IPN, such as your PayPal receiving email and the currency you'd like to use.
```php
$ipn = new \PayPal\IPN(array(
    "business" => "roger@github.com",
    "currency_code" => "USD"
));
```

#### Generating a form
You can let the library generate a HTML form, just pass an associative array through with the correct field names. After that you can chain the printForm function to immediately echo out the form.
```php
$ipn->generateForm(array(
    "item_name" => "Croissant au chocolat",
    "amount" => "0.80",
    "custom" => json_encode(array("USER_ID" => 12, "FOOD_ID" => 3)),
    "notify_url" => "http://".$_SERVER["SERVER_NAME"]."/process_ipn.php",
    "return" => "http://".$_SERVER["SERVER_NAME"]."/success_payment.php",
    "cancel_return" => "http://".$_SERVER["SERVER_NAME"]."/cancel_payment.php",
))->printForm();
```


If you want to customize each input field, such as giving a quantity field, you can achieve this by adding an array to its name in the first array.
```php
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
```

Now that you've got your IPN form done you want to be able to verify incoming payments. The library will verify whether the transaction is legitimate and verified by PayPal, **you will have to do price and other checks yourself!**
Verifying is done really easy, just create a new IPN object and call the verify method.
```php
// PHP 5.4+
$ipn = (new \PayPal\IPN)->verify();

// < PHP 5.4
$ipn = new \PayPal\IPN();
$ipn->verify();
```
The first way is only available in PHP 5.4+ because since that release method chaining on object instantiation has been added.


For price and other checks you will need to access the variables of the transaction. You can either retrieve all variables of the function in an array or object, or access the variables directly.
```php
// For a stdClass object
$ipnVariables = $ipn->getData();
$paidAmount = $ipnVariables->mc_gross;

// For an associative array
$ipnVariables = $ipn->getData(TRUE);
$paidAmount = $ipnVariables['mc_gross'];

$croissantPrice = 0.80;

if($croissantPrice != $paidAmount)
{
    echo "Paid amount does not equal price!";
}

```

Accessing the variables directly
```php
$croissantPrice = 0.80;
$paidAmount = $ipn->mc_gross;

if($croissantPrice != $paidAmount)
{
    echo "Paid amount does not equal price!";
}
```

If you want to log the IPN processing you can do so by setting log to TRUE after instantiating the IPN object. The default logfile is 'IPNLog.txt'.
```php
$ipn = new \PayPal\IPN();
$ipn->log = TRUE;
$ipn->verify();

```
