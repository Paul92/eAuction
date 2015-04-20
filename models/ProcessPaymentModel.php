<?php

class ProcessPaymentModel extends Model {

    function __construct() {
        parent::__construct();
    }

    public function storeTransactionDetails($itemId, $itemPrice, $itemName,
                                            $paymentDetails) {
        var_dump($itemId);
        var_dump($itemPrice);
        var_dump($itemName);
        var_dump($paymentDetails);
        require('config/config.php');
        $getSellerIdQuery = 'SELECT users.id FROM
                             users INNER JOIN item ON item.sellerId = users.id
                             WHERE item.id = :id';
        $stmt = $this->db->executeQuery($getSellerIdQuery,
                                        array('id' => $itemId));
        $sellerId = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['id'];

        $insertBuyerQuery = 'INSERT INTO payment
                             (transactionId, userId, itemName,
                              paymentDescription, grandTotal, time) VALUES
                             (:transactionId, :buyerId, :name,
                             CONCAT("You payed ", :grandTotal,
                                    " for ", :name, "."),
                             :grandTotal, NOW())';
        $this->db->executeQuery($insertBuyerQuery,
            array('transactionId' => $paymentDetails->senderTransactionId,
                  'buyerId' => Session::get('userId'),
                  'name' => $itemName,
                  'grandTotal' => $itemPrice));

        $insertSellerQuery = 'INSERT INTO payment
                             (transactionId, userId, itemName,
                              paymentDescription, grandTotal, time) VALUES
                             (:transactionId, :buyerId, :name,
                             "You got :grandTotal for :name.", :grandTotal,
                             NOW())';
        $fee = ($itemPrice * $feePercent > $maxFee) ? $maxFee :
                                round($itemPrice * $feePercent);
        $this->db->executeQuery($insertSellerQuery,
            array('transactionId' => $paymentDetails->transactionId,
                  'buyerId' => $sellerId,
                  'name' => $itemName,
                  'grandTotal' => $itemPrice - $fee));
    }

    public function endAuction($itemId) {
        $query = 'SELECT COUNT(*) AS noOfAuctions FROM wonAuctions
                  WHERE userId = :id AND payed = false';
        $stmt = $this->db->executeQuery($query, array('id' => $userId));
        $noOfAuctions = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['noOfAuctions'];
        Session::set('noOfAuctions', $noOfAuctions);

        $query = 'UPDATE wonAuctions SET payed = 1 WHERE itemId = ' . $itemId;
        $this->db->executeQuery($query);

        $query = 'UPDATE item SET endDate=CURDATE() WHERE id = ' . $itemId;
        $this->db->executeQuery($query);
    }

    public function sendEmail($itemId, $itemName, $itemPrice) {
        $sellerEmail  = $this->getSellerEmail($itemId);
        $buyerDetails = $this->getBuyerDetails($itemId);
        $mailContent = "Dear eAuction seller,\n\n"
                      ."Your auction for $itemName has ended "
                      ."at the price of $itemPrice pounds.\n"
                      ."Please deliver the item as soon as possible at "
                      ."the following address:\n\n\n"
                      . $buyerDetails['title'] . ' '
                      . $buyerDetails['firstName'] . ' '
                      . $buyerDetails['middleName'] . ' '
                      . $buyerDetails['surname'] . "\n"
                      . $buyerDetails['addressLine1'] . "\n"
                      . $buyerDetails['addressLine2'] . "\n"
                      . $buyerDetails['city'] . ", "
                      . $buyerDetails['county'] . "\n"
                      . $buyerDetails['country'] . "\n"
                      . $buyerDetails['postCode'] . "\n";
        mail($sellerEmail,
             "eAuction automatic message: $itemName has been bought",
             $mailContent);
    }

    private function getSellerEmail($itemId) {
        $query = "SELECT email FROM
                  users INNER JOIN item ON users.id = item.sellerId
                  WHERE item.id = $itemId";
        $stmt = $this->db->executeQuery($query)->fetch(PDO::FETCH_ASSOC);
        return $stmt['email'];
    }

    private function getBuyerDetails() {
        $userId = Session::get('userId');
        $query = "SELECT users.nickname,
                         users.firstName,
                         users.surname,
                         users.middleName,
                         users.title,
                         address.country,
                         address.county,
                         address.city,
                         address.addressLine1,
                         address.addressLine2,
                         address.postCode
                 FROM users INNER JOIN address
                            ON users.billingAddress = address.id
                 WHERE users.id = $userId";
        $stmt = $this->db->executeQuery($query)->fetch();
        return $stmt;
    }
}
