<?php
session_start();

require("config/config.php");
require("libs/paypal.class.php");
require("vendor/autoload.php");

$paypalmode = ($PayPalMode=='sandbox') ? '.sandbox' : '';

    $PayPalReturnURL    = 'http://localhost/process.php';
if($_POST) //Post Data received from product list page.
{
  
    //$ItemPrice = $mysqli->query("SELECT item_price FROM products WHERE id = Product_Number");
    $ItemID         = $_POST["itemID"]; //Item ID
    
    
    $ItemQty        = 1; // Item Quantity
    $ItemName       = "Box";
    $ItemPrice      = 1;
      $ItemDesc       = "A box";

    $ItemTotalPrice = ($ItemPrice); //(Item Price x Quantity = Total) Get total amount of product; 
    //Other important variables like tax, shipping cost
    $TotalTaxAmount     = 0.2 * $ItemTotalPrice;  //Sum of tax for all items in this order. 
    $HandalingCost      = 1.00;  //Handling cost for this order.
    $InsuranceCost      = 1.00;  //shipping insurance cost for this order.
    $ShippinDiscount    = 0; //Shipping discount for this order. Specify this as negative number.
    $ShippinCost        = 2.00; //Although you may change the value later, try to pass in a shipping amount that is reasonably accurate.
    
    //Grand total including all tax, insurance, shipping cost and discount
    $GrandTotal = ($ItemTotalPrice + $TotalTaxAmount + $HandalingCost + $InsuranceCost + $ShippinCost + $ShippinDiscount);
    //Parameters for SetExpressCheckout, which will be sent to PayPal
    $padata =   '&METHOD=SetExpressCheckout'.
                '&RETURNURL='.urlencode($PayPalReturnURL ).
                '&CANCELURL='.urlencode($PayPalCancelURL).
                '&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode("SALE").
                
                '&L_PAYMENTREQUEST_0_NAME0='.urlencode($ItemName).
                '&L_PAYMENTREQUEST_0_NUMBER0='.urlencode($ItemID).
                '&L_PAYMENTREQUEST_0_DESC0='.urlencode($ItemDesc).
                '&L_PAYMENTREQUEST_0_AMT0='.urlencode($ItemPrice).
                '&L_PAYMENTREQUEST_0_QTY0='. urlencode($ItemQty).
               
                
                '&NOSHIPPING=0'. //set 1 to hide buyer's shipping address, in-case products that do not require shipping
                
                '&PAYMENTREQUEST_0_ITEMAMT='.urlencode($ItemTotalPrice).
                '&PAYMENTREQUEST_0_TAXAMT='.urlencode($TotalTaxAmount).
                '&PAYMENTREQUEST_0_SHIPPINGAMT='.urlencode($ShippinCost).
                '&PAYMENTREQUEST_0_HANDLINGAMT='.urlencode($HandalingCost).
                '&PAYMENTREQUEST_0_SHIPDISCAMT='.urlencode($ShippinDiscount).
                '&PAYMENTREQUEST_0_INSURANCEAMT='.urlencode($InsuranceCost).
                '&PAYMENTREQUEST_0_AMT='.urlencode($GrandTotal).
                '&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($PayPalCurrencyCode).
                '&LOCALECODE=GB'. //PayPal pages to match the language on your website.
                '&LOGOIMG=http://www.sanwebe.com/wp-content/themes/sanwebe/img/logo.png'. //site logo
                '&CARTBORDERCOLOR=FFFFFF'. //border color of cart
                '&ALLOWNOTE=1';
                
                ############# set session variable we need later for "DoExpressCheckoutPayment" #######
                $_SESSION['ItemName']           =  $ItemName; //Item Name
                $_SESSION['ItemPrice']          =  $ItemPrice; //Item Price
                $_SESSION['ItemNumber']         =  $ItemID; //Item ID
                $_SESSION['ItemDesc']           =  $ItemDesc; //Item description
                $_SESSION['ItemQty']            =  $ItemQty; // Item Quantity
                $_SESSION['ItemTotalPrice']     =  $ItemTotalPrice; //total amount of product; 
                $_SESSION['TotalTaxAmount']     =  $TotalTaxAmount;  //Sum of tax for all items in this order. 
                $_SESSION['HandalingCost']      =  $HandalingCost;  //Handling cost for this order.
                $_SESSION['InsuranceCost']      =  $InsuranceCost;  //shipping insurance cost for this order.
                $_SESSION['ShippinDiscount']    =  $ShippinDiscount; //Shipping discount for this order. Specify this as negative number.
                $_SESSION['ShippinCost']        =  $ShippinCost;
                $_SESSION['GrandTotal']         =  $GrandTotal;

                echo $padata;
        //We need to execute the "SetExpressCheckOut" method to obtain paypal token
        $paypal= new MyPayPal();
        
        $httpParsedResponseAr = $paypal->PPHttpPost('SetExpressCheckout', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
        //Respond according to message we receive from Paypal
        if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"]))
        {
                
                //Redirect user to PayPal store with Token received.
                $paypalurl ='https://www'.$paypalmode.'.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.$httpParsedResponseAr["TOKEN"].'';
                header('Location: '.$paypalurl);
             
        }else{
            //Show error message
            echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
            echo '<pre>';
            print_r($httpParsedResponseAr);
            echo '</pre>';
        }
}

//Paypal redirects back to this page using ReturnURL, We should receive TOKEN and Payer ID
if(isset($_GET["token"]) && isset($_GET["PayerID"]))
{
    //we will be using these two variables to execute the "DoExpressCheckoutPayment"
    //Note: we haven't received any payment yet.
    
    $token = $_GET["token"];
    $payer_id = $_GET["PayerID"];
    
    //get session variables
    $ItemName           = $_SESSION['ItemName']; //Item Name
    $ItemPrice          = $_SESSION['ItemPrice'] ; //Item Price
    $ItemID             = $_SESSION['ItemNumber']; //Item ID
    $ItemDesc           = $_SESSION['ItemDesc']; //Item ID
    $ItemQty            = $_SESSION['ItemQty']; // Item Quantity
    $ItemTotalPrice     = $_SESSION['ItemTotalPrice']; //total amount of product; 
    $TotalTaxAmount     = $_SESSION['TotalTaxAmount'] ;  //Sum of tax for all items in this order. 
    $HandalingCost      = $_SESSION['HandalingCost'];  //Handling cost for this order.
    $InsuranceCost      = $_SESSION['InsuranceCost'];  //shipping insurance cost for this order.
    $ShippinDiscount    = $_SESSION['ShippinDiscount']; //Shipping discount for this order. Specify this as negative number.
    $ShippinCost        = $_SESSION['ShippinCost'];
    $GrandTotal         = $_SESSION['GrandTotal'];

    $padata =   '&TOKEN='.urlencode($token).
                '&PAYERID='.urlencode($payer_id).
                '&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode("SALE").
                
                //set item info here, otherwise we won't see product details later  
                '&L_PAYMENTREQUEST_0_NAME0='.urlencode($ItemName).
                '&L_PAYMENTREQUEST_0_NUMBER0='.urlencode($ItemID).
                '&L_PAYMENTREQUEST_0_DESC0='.urlencode($ItemDesc).
                '&L_PAYMENTREQUEST_0_AMT0='.urlencode($ItemPrice).
                '&L_PAYMENTREQUEST_0_QTY0='. urlencode($ItemQty).


                '&PAYMENTREQUEST_0_ITEMAMT='.urlencode($ItemTotalPrice).
                '&PAYMENTREQUEST_0_TAXAMT='.urlencode($TotalTaxAmount).
                '&PAYMENTREQUEST_0_SHIPPINGAMT='.urlencode($ShippinCost).
                '&PAYMENTREQUEST_0_HANDLINGAMT='.urlencode($HandalingCost).
                '&PAYMENTREQUEST_0_SHIPDISCAMT='.urlencode($ShippinDiscount).
                '&PAYMENTREQUEST_0_INSURANCEAMT='.urlencode($InsuranceCost).
                '&PAYMENTREQUEST_0_AMT='.urlencode($GrandTotal).
                '&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($PayPalCurrencyCode);
    
    //We need to execute the "DoExpressCheckoutPayment" at this point to Receive payment from user.
    $paypal= new MyPayPal();
    $httpParsedResponseAr = $paypal->PPHttpPost('DoExpressCheckoutPayment', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
    
    //Check if everything went ok..
    if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) 
    {

            echo '<h2>Success</h2>';
            echo 'Your Transaction ID : '.urldecode($httpParsedResponseAr["PAYMENTINFO_0_TRANSACTIONID"]);
            
                //Sometimes Payment are kept pending even when transaction is complete. 
                //hence we need to notify user about it and ask him manually approve the transiction
                
                if('Completed' == $httpParsedResponseAr["PAYMENTINFO_0_PAYMENTSTATUS"])
                {
                    echo '<div style="color:green">Payment Received! Your product will be sent to you very soon!</div>';
                }
                elseif('Pending' == $httpParsedResponseAr["PAYMENTINFO_0_PAYMENTSTATUS"])
                {
                    echo '<div style="color:red">Transaction Complete, but payment is still pending! '.
                    'You need to manually authorize this payment in your <a target="_new" href="http://www.paypal.com">Paypal Account</a></div>';
                }

                // we can retrieve transaction details using either GetTransactionDetails or GetExpressCheckoutDetails
                // GetTransactionDetails requires a Transaction ID, and GetExpressCheckoutDetails requires Token returned by SetExpressCheckOut
                $padata =   '&TOKEN='.urlencode($token);
                $paypal= new MyPayPal();
                $httpParsedResponseAr = $paypal->PPHttpPost('GetExpressCheckoutDetails', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);

                if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) 
                {
          echo 'phase 2 begins';          
          //calculate amount to pay the seller
                    $BuyerTotal = $GrandTotal * 0.8;
                    echo $BuyerTotal;
                    $payRequest = new PayPal\Types\ap\PayRequest();
                    echo "it works";
                    $receiver = array();
                    $receiver[0] = new PayPal\Types\ap\Receiver();
                    $receiver[0]->amount = $BuyerTotal;
                    $receiver[0]->email ='hasman2008test1@hotmail.co.uk';//seller email
                    $receiverList = new PayPal\Types\ap\ReceiverList($receiver);
                    $payRequest->receiverList = $receiverList;
//                    $payRequest->senderEmail ='hasman2008test1@hotmail.co.uk'; //seller email
                    $payRequest->senderEmail = $PayPalApiEmail;


                    $requestEnvelope = new PayPal\Types\common\RequestEnvelope("en_US");
                    $payRequest->requestEnvelope = $requestEnvelope; 
                    $payRequest->actionType = "PAY";
                    $payRequest->cancelUrl = $PayPalReturnURL;
                    $payRequest->returnUrl = $PayPalCancelURL;
                    $payRequest->currencyCode = $PayPalCurrencyCode;

                    $sdkConfig = array(
                        "mode" => "sandbox",
                        "acct1.UserName" => $PayPalApiUsername,
                        "acct1.Password" => $PayPalApiPassword,
                        "acct1.Signature" => $PayPalApiSignature,
                        "acct1.AppId" => "APP-80W284485P519543T"
                    );
          echo 'details have been set';
                    $adaptivePaymentsService = new PayPal\Service\AdaptivePaymentsService($sdkConfig);
                    $payResponse = $adaptivePaymentsService->Pay($payRequest);
                    
                    
                    var_dump ($payResponse);
                    
                    
                    
                    
                    echo '<br /><b>Stuff to store in database :</b><br /><pre>';
                   // #### SAVE BUYER INFORMATION IN DATABASE ###
                   // 
                   // $buyerName = $httpParsedResponseAr["FIRSTNAME"].' '.$httpParsedResponseAr["LASTNAME"];
                   // $buyerEmail = $httpParsedResponseAr["EMAIL"];
                   // 
                   // //Open a new connection to the MySQL server
                   // $mysqli = new mysqli('host','username','password','database_name');
                   // 
                   // //Output any connection error
                   // if ($mysqli->connect_error) {
                   //     die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
                   // }       
                   // 
                   // $insert_row = $mysqli->query("INSERT INTO BuyerTable 
                   // (BuyerName,BuyerEmail,TransactionID,ItemName,ItemID, ItemAmount,ItemQTY)
                   // VALUES ('$buyerName','$buyerEmail','$transactionID','$ItemName',$ItemID, $ItemTotalPrice,$ItemQTY)");
                   // 
                   // if($insert_row){
                   //     print 'Success! ID of last inserted record is : ' .$mysqli->insert_id .'<br />'; 
                   // }else{
                   //     die('Error : ('. $mysqli->errno .') '. $mysqli->error);
                   // }
                   // 
                    
                } else  {
                    echo '<div style="color:red"><b>GetTransactionDetails failed:</b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
                    echo '<pre>';
                    print_r($httpParsedResponseAr);
                    echo '</pre>';

                }
    
    }else{
        echo "NOT OK";
            echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
            echo '<pre>';
            print_r($httpParsedResponseAr);
            echo '</pre>';
    }
}
?>
