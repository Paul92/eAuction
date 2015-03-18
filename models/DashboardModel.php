<?php

class DashboardModel extends Model {

    function __construct() {
        parent::__construct();
    }

    public function getBidHistory($userId) {
        $query = 'SELECT bid.value,
                         bid.time,
                         item.name,
                         item.id,
                         users.nickname AS sellerName,
                         users.id AS sellerId
                  FROM bid INNER JOIN item ON item.id = bid.itemId
                           INNER JOIN users ON users.id = :id
                  WHERE bid.bidderId = :id
                  ORDER BY bid.time ASC';
        $stmt = $this->db->executeQuery($query,
                                        array('id' => $userId));
        $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

    public function getAuctionHistory($userId) {
        $query = 'SELECT item.name,
                         category.name AS category,
                         item.endDate,
                         item.id,
                         category.id AS categoryId,
                         (CURDATE() >= item.endDate) AS finished,
                         auctionType.name AS auctionType
                  FROM item INNER JOIN category
                  ON item.categoryId = category.id
                  INNER JOIN auctionType ON item.auctionType = auctionType.id';
        $stmt = $this->db->executeQuery($query,
                                        array('id' => $userId));
        $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

    public function getPaymentHistory() {
        $query = 'SELECT transactionId, itemName, paymentDescription,
                         itemPrice, grandTotal, time
                  FROM payment
                  WHERE userId = 1';
        $stmt = $this->db->executeQuery($query,
                                        array('id' => Session::get('userId')));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getWonAuctions() {
        $query = 'SELECT item.name,
                         wonAuctions.itemId,
                         wonAuctions.value,
                         wonAuctions.payed,
                         wonAuctions.date,
                         3 - CURDATE() + wonAuctions.date AS daysRemaining,
                         users.PayPalEmail AS sellerPayPalEmail
                  FROM wonAuctions
                  INNER JOIN item ON item.id = wonAuctions.itemId
                  INNER JOIN users ON item.sellerId = users.id
                  WHERE wonAuctions.userId = :id
                  ORDER BY daysRemaining';
        $stmt = $this->db->executeQuery($query,
                                        array('id' => Session::get('userId')));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function makePayment($itemId, $itemName,
                                $itemPrice, $sellerEmail) {
        require("vendor/autoload.php");
        require("config/config.php");

        $taxAmount = $taxPercent * $itemPrice;

        $fee = ($itemPrice * $feePercent > $maxFee) ? $maxFee :
                                                  ($itemPrice * $feePercent);

        $buyerTotal = $itemPrice - $fee + $taxAmount + $handalingCost
                    + $insuranceCost + $shippinCost + $shippinDiscount;


        $payRequest = new PayPal\Types\ap\PayRequest();

        $receiver = array();

        $receiver[0] = new PayPal\Types\ap\Receiver();
        $receiver[0]->amount = $buyerTotal;
        $receiver[0]->paymentType = 'GOODS';
        $receiver[0]->email  = $sellerEmail;

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
        $adaptivePaymentsService = new PayPal\Service\AdaptivePaymentsService($sdkConfig);
        $payResponse = $adaptivePaymentsService->Pay($payRequest);

        $payKey = $payResponse->payKey;
        $paypalurl = 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_ap-payment&paykey=' . $payKey;
        var_dump($payResponse);
       // header('Location: '.$paypalurl);
    }

}
