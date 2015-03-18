<?php
$PayPalMode         = 'sandbox'; // sandbox or live
$PayPalApiUsername  = 'hasman2008ukea1_api2.hotmail.co.uk'; //PayPal API Username
$PayPalApiEmail     = 'hasman2008ukseller1@hotmail.co.uk';
$PayPalApiPassword  = 'GLUEMD37ZRCGUDX5'; //Paypal API password
$PayPalApiSignature = 'AiPC9BjkCyDFQXbSkoZcgqH3hpacAiJDSU1cTOPvMulWmlYVfjZvbSyD'; //Paypal API Signature
$PayPalCurrencyCode = 'GBP'; //Paypal Currency Code
$PayPalCancelURL    = 'http://localhost'; //Cancel URL if user clicks cancel

$taxPercent         = 0.2;
$handalingCost      = 0; //Handling cost for this order.
$insuranceCost      = 0; //shipping insurance cost for this order.
$shippinDiscount    = 0;    //Shipping discount for this order. Specify this as negative number.
$shippinCost        = 0; //Although you may change the value later,
                            //try to pass in a shipping amount that is reasonably accurate.

$feePercent = 0.1;
$maxFee = 200;

$paypalmode = ($PayPalMode=='sandbox') ? '.sandbox' : '';
$PayPalReturnURL    = 'http://localhost/process2.php';
?>
