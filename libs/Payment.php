<?php

class myPayment {

    private $itemId;
    private $itemName;
    private $itemPrice;
    private $sellerEmail;
    private $sdkConfig;

    public function __construct($itemId = '', $itemName = '',
                                $itemPrice = '', $sellerEmail = '') {
        require('config/config.php');
        $this->itemId = $itemId;
        $this->itemName = $itemName;
        $this->itemPrice = $itemPrice;
        $this->sellerEmail = $sellerEmail;
        $this->sdkConfig = array(
            "mode" => "sandbox",
            "acct1.UserName" => $PayPalApiUsername,
            "acct1.Password" => $PayPalApiPassword,
            "acct1.Signature" => $PayPalApiSignature,
            "acct1.AppId" => "APP-80W284485P519543T"
        );
    }

    public function makePayment() {
        require("vendor/autoload.php");
        require("config/config.php");

        $fee = ($this->itemPrice * $feePercent > $maxFee) ? $maxFee :
                                         round($this->itemPrice * $feePercent);

        $buyerTotal = $this->itemPrice;

        $payRequest = new PayPal\Types\ap\PayRequest();

        $receiver = array();

        $receiver[0] = new PayPal\Types\ap\Receiver();
        $receiver[0]->amount = $this->itemPrice - $fee;
        $receiver[0]->paymentType = 'GOODS';
        $receiver[0]->email  = $this->sellerEmail;

        $receiver[1] = new PayPal\Types\ap\Receiver();
        $receiver[1]->amount = $fee;
        $receiver[1]->paymentType = 'GOODS';
        $receiver[1]->email = $PayPalApiEmail;

        $receiverList = new PayPal\Types\ap\ReceiverList($receiver);
        $payRequest->receiverList = $receiverList;
//        $payRequest->senderEmail = $PayPalApiEmail;


        $requestEnvelope = new PayPal\Types\common\RequestEnvelope("en_US");
        $payRequest->requestEnvelope = $requestEnvelope; 
        $payRequest->actionType = "PAY";
        $payRequest->cancelUrl = $PayPalCancelURL;
        $payRequest->returnUrl = $PayPalReturnURL;
        $payRequest->currencyCode = $PayPalCurrencyCode;

        $adaptivePaymentsService =
                  new PayPal\Service\AdaptivePaymentsService($this->sdkConfig);
        $payResponse = $adaptivePaymentsService->Pay($payRequest);

        $payKey = $payResponse->payKey;
        $paypalurl = 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_ap-payment&paykey=' . $payKey;
        Session::set('payKey2', $payKey);
        Session::set('itemId', $this->itemId);
        Session::set('itemName', $this->itemName);
        Session::set('itemPrice', $this->itemPrice);
        header('Location: '.$paypalurl);
    }

    public function getTransactionDetails() {
        require("vendor/autoload.php");
        $payKey = Session::get('payKey2');

        $requestEnvelope = new PayPal\Types\common\RequestEnvelope("en_US");
        $paymentDetailsRequest =
                new PayPal\Types\ap\PaymentDetailsRequest($requestEnvelope);
        $paymentDetailsRequest->payKey = $payKey;
        
        $adaptivePaymentsService =
                new PayPal\Service\AdaptivePaymentsService($this->sdkConfig);

        $paymentDetailsResponse =
             $adaptivePaymentsService->PaymentDetails($paymentDetailsRequest);

        return $paymentDetailsResponse;
    }
}

