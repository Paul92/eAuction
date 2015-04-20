<?php

class processPayment extends Controller{

    function __construct() {
        parent::__construct();
    }

    function storeTransactionDetails() {
        require('libs/Payment.php');
        $payment = new myPayment();

        $paymentDetails = $payment->getTransactionDetails();

        $itemId = Session::get('itemId');
        $itemPrice = Session::get('itemPrice');
        $itemName = Session::get('itemName');

        foreach ($paymentDetails->paymentInfoList->paymentInfo as $transaction)
            $this->model->storeTransactionDetails($itemId, $itemPrice,
                                                  $itemName, $transaction);

        $this->model->endAuction($itemId);
        $this->model->sendEmail($itemId, $itemName, $itemPrice);

//        Session::remove('paykey2');
//        Session::remove('itemId');
//        Session::remove('itemPrice');
//        Session::remove('itemName');
        header('Location: ' . ROOT_URL . '/index/index/payment_successful');
    }

}
