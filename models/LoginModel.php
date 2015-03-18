<?php

require 'models/HashModel.php';

class LoginModel extends HashModel {

    const WRONG_USER_OR_PASS = 'Wrong user of password. Please retry.';
    const NO_LOGIN_MSG       = 'Please insert a login.';
    const NO_PASSWORD_MSG    = 'Please insert a password.';

    public function __construct() {
        parent::__construct();
    }

    public function run() {
        $errors    = array();
        $formArray = array();
        if (!isset($_POST['login']) || empty($_POST['login']))
            $errors['login'] = self::NO_LOGIN_MSG;
        else
            $login = $_POST['login'];

        if (!isset($_POST['password']) || empty($_POST['password']))
            $errors['password'] = self::NO_PASSWORD_MSG;
        else
            $password = $_POST['password'];

        if (empty($errors)) {
            $fetchHashQuery = 'SELECT id, password FROM users WHERE
                               nickname = :login OR email = :login';
            $fetchHashStmt  = $this->db->prepare($fetchHashQuery);
            $fetchHashStmt->execute(array(':login' => $login));
            $array = $fetchHashStmt->fetch(PDO::FETCH_ASSOC);
            if (empty($array)) {
                $errors[] = self::WRONG_USER_OR_PASS;
            } else {
                $hash = $array['password'];
                if (/*$this->validate_password($password, $hash)*/ $password==$hash) {
                    Session::set('loggedIn', true);
                    Session::set('userId', $array['id']);
                    $this->generateWonAuction($array['id']);
                    header('location: ../index');
                } else {
                    $errors[] = self::WRONG_USER_OR_PASS;
                }
            }
        }
        if (!empty($errors))
            return(array('errors' => $errors,
                         'formArray' => array('password' => $password,
                                              'login' => $login)));
        else
            return(array('errors' => $errors));
    }

    private function generateWonAuction($userId) {
        $this->generateWonEnglishAuction($userId);
        $this->generateWonVickeryAuction($userId);
        $this->setNoOfWonAuctionsCookie($userId);
    }

    private function setNoOfWonAuctionsCookie($userId) {
        $query = 'SELECT COUNT(*) AS noOfAuctions FROM wonAuctions
                  WHERE userId = :id AND payed = false';
        $stmt = $this->db->executeQuery($query, array('id' => $userId));
        $noOfAuctions = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['noOfAuctions'];
        Session::set('noOfAuctions', $noOfAuctions);
    }

    private function generateWonEnglishAuction($userId) {
        $query = 'INSERT INTO wonAuctions
                  SELECT item.id AS itemId,
                         bid.bidderId AS userId,
                         bid.value AS value,
                         false,
                         item.endDate
                  FROM item
                  INNER JOIN bid ON item.id = bid.itemId
                  INNER JOIN
                        (SELECT itemId, MAX(value) AS value
                         FROM bid GROUP BY itemId) maxValues
                  ON maxValues.itemId = item.id
                  WHERE bid.bidderId = :id
                    AND bid.value = maxValues.value
                    AND item.endDate <= CURDATE()
                    AND (item.auctionType = 1 OR item.auctionType = 3)
                    AND item.id NOT IN
                        (SELECT itemId FROM wonAuctions WHERE
                                userId = bid.bidderId)';
        $this->db->executeQuery($query, array('id' => $userId));
    }
    private function generateWonVickeryAuction($userId) {
        $query = 'SELECT item.id AS itemId,
                         bid.bidderId AS userId,
                         bid.value AS value,
                         false,
                         item.endDate
                  FROM item
                  INNER JOIN bid ON item.id = bid.itemId
                  WHERE bid.bidderId = :id
                    AND item.endDate <= CURDATE()
                    AND item.auctionType = 2
                  ORDER BY bid.value DESC
                  LIMIT 1
                  OFFSET 1';
        $this->db->executeQuery($query, array('id' => $userId));
    }

    private function validate_password($password, $correct_hash) {
        $params = explode(":", $correct_hash);
        if(count($params) < HASH_SECTIONS)
           return false;
        $pbkdf2 = base64_decode($params[HASH_PBKDF2_INDEX]);
        return slow_equals($pbkdf2, pbkdf2($params[HASH_ALGORITHM_INDEX],
                                           $password, $params[HASH_SALT_INDEX],
                                           (int)$params[HASH_ITERATION_INDEX],
                                           strlen($pbkdf2), true
                                          )
                          );
    }
}

