<?php

class ItemModel extends Model {

    const NO_BID                 = 'Please insert a bid value.';
    const BID_INAPPROPIATE_VALUE = 'Please insert a valid bid value.';

    public function __construct() {
        parent::__construct();
    }

    public function getItem($itemId) {
        $query = 'SELECT item.id,
                         item.name,
                         item.description, 
                         item.endDate,
                         item.startPrice,
                         item.auctionType AS auctionTypeId,
                         (CURDATE() >= item.endDate) AS finished,
                         category.name AS category,
                         category.id AS categoryId,
                         users.id AS sellerId,
                         users.nickname AS sellerName,
                         users.rating AS sellerRating,
                         auctionType.name AS auctionType
                  FROM  item
                  INNER JOIN category    ON item.categoryId  = category.id
                  INNER JOIN users       ON item.sellerId    = users.id
                  INNER JOIN auctionType ON item.auctionType = auctionType.id
                  WHERE item.id = ' . $itemId;

        $stmt  = $this->db->executeQuery($query);
        $array = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
        $array['maxBid'] = $this->getMaxValue($array['id']);
        var_dump($array);

        return $array;
    }

    public function getImages($itemId) {
        $query = 'SELECT image.filePath
                  FROM  image
                  INNER JOIN item ON item.id = image.itemId';
        $stmt  = $this->db->executeQuery($query);
        $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

    public function getMainImage($itemId) {
        $query = 'SELECT image.filePath
                  FROM  image
                  INNER JOIN item ON item.id = image.itemId
                  WHERE image.main = 1';
        $stmt  = $this->db->executeQuery($query);
        $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $array[0]['filePath'];
    }

    public function getMaxValue($itemId) {
        $query = 'SELECT MAX(value) AS maxVal
                  FROM bid WHERE itemId = :itemId';
        $stmt = $this->db->executeQuery($query, array('itemId' => $itemId));
        return $stmt->fetch(PDO::FETCH_ASSOC)['maxVal'];
    }

    public function getMinValue($itemId) {
        $query = 'SELECT MIN(value) AS maxVal
                  FROM bid WHERE itemId = :itemId';
        $stmt = $this->db->executeQuery($query, array('itemId' => $itemId));
        return $stmt->fetch(PDO::FETCH_ASSOC)['maxVal'];
    }

    private function checkIfBidPossible() {
        $itemId      = $_POST['itemId'];
        $userId      = Session::get('userId');
        $bidValue    = $_POST['bidValue'];
        $auctionType = $_POST['auctionType'];
        $value       = $_POST['bidValue'];
        $startPrice  = $_POST['startPrice'];

        if ($value <= 0 || !is_numeric($value))
            return false;
        if ($auctionType == 1) {
            if ($value < $startPrice || $value <= $this->getMaxValue($itemId))
                return false;
            else
                return true;
        } else if ($auctionType == 2) {
//            if ($value > $startPrice || $value >= $this->getMinValue($itemId))
//                return false;
//            else
//                return true;
        } else if ($auctionType == 3 || $auctionType == 4) {
            if ($value > $startPrice)
                return false;
            else
                return true;
        } else
            return true;
    }

    public function newBid() {
        var_dump($_POST);
        if (!isset($_POST['bidValue']) || empty($_POST['bidValue']))
            return self::NO_BID;
        else if (!$this->checkIfBidPossible())
            return self::BID_INAPPROPIATE_VALUE;
        else {
            $itemId   = $_POST['itemId'];
            $userId   = Session::get('userId');
            $bidValue = $_POST['bidValue'];
            $query = 'INSERT INTO bid (value, time, bidderId, itemId)
                             VALUES (:value, NOW(), :bidderId, :itemId)';
            $this->db->executeQuery($query, array('value'    => $bidValue,
                                                  'bidderId' => $userId,
                                                  'itemId'   => $itemId));
            return true;
        }
    }
}