<?php

class DashboardModel extends Model {

    const NO_NICKNAME_MSG         = 'Please insert a nickname.';
    const NO_PASSWORD_MSG         = 'Please insert a password.';
    const NO_CONFIRM_PASSWORD_MSG = 'Please confirm the password.';
    const NO_SURNAME_MSG          = 'Please insert a surname.';
    const NO_FIRSTNAME_MSG        = 'Please insert a first name.';
    const NO_EMAIL_MSG            = 'Please insert an email.';
    const NO_PAYPAL_EMAIL_MSG     = 'Please insert a PayPal email address.';
    const NO_PHONE_NUMBER_MSG     = 'Please insert a phone number.';
    const NO_CITY_MSG             = 'Please insert a city.';
    const NO_COUNTRY_MSG          = 'Please insert a country.';
    const NO_POST_CODE_MSG        = 'Please insert a post code.';
    const NO_ADDRESS_LINE1_MSG    = 'Please insert an address line.';

    const BAD_EMAIL_MSG           = 'Email address not valid.';
    const BAD_PAYPAL_EMAIL_MSG    = 'PayPal email address not valid.';
    const PASSWORD_TOO_SHORT      = 'Please insert a password longer than 6.';
    const PASSWORD_NO_LETTERS     = 'The password must contain at least one letter';
    const PASSWORD_NO_DIGITS      = 'The password must contain at least one digit';
    const PASSWORDS_DO_NOT_MATCH  = 'Passwords do not match.';
    const BAD_PHONE_NUMBER_MSG    = 'The phone number has an inappropiate format.';

    const NOT_ACCEPTED_TC         = 'Please read and accept the
                                     <a href="TC">Terms and Conditions</a>.';

    const ADDRESS_ALREADY_EXISTS  = 'This address is already registered. Please insert a new address.';
    const NICKNAME_ALREADY_EXISTS = 'This nickname is already in use. Please insert another nickname.';
    const EMAIL_ALREADY_EXISTS    = 'This email is already in use. Please insert another email.';
    const PAYPAL_EMAIL_ALREADY_EXISTS = 'The PayPal email is already in use. Please insert another one.';


    const SUCESSFUL               = 'User succesfully created.';

    const ADDRESS_COLUMNS = array('country', 'county', 'city',
                                  'addressLine1', 'addressLine2',
                                  'postCode');
    function __construct() {
        parent::__construct();
    }

    private function validatePhone($phone) {
        $phone = str_replace(' ', '', $phone);
        return preg_match("/^[\+0-9\-\(\)\s]*$/", $phone);
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
                  INNER JOIN auctionType ON item.auctionType = auctionType.id
                  WHERE item.sellerId = :id';
        $stmt = $this->db->executeQuery($query,
                                        array('id' => $userId));
        $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

    public function getPaymentHistory() {
        $query = 'SELECT transactionId, itemName, paymentDescription,
                         grandTotal, time
                  FROM payment
                  WHERE userId = :id';
        $stmt = $this->db->executeQuery($query,
                                        array('id' => Session::get('userId')));
        $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $array;
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
        require('libs/Payment.php');
        $payment = new myPayment($itemId, $itemName, $itemPrice, $sellerEmail);
        $payment->makePayment();
    }

    public function getProfileData($userId) {
        $query = 'SELECT users.nickname,
                         users.surname,
                         users.firstName,
                         users.middleName,
                         users.title,
                         users.rating,
                         users.email,
                         users.password,
                         users.phone,
                         users.PayPalEmail,
                         address.country,
                         address.county,
                         address.city,
                         address.addressLine1,
                         address.addressLine2,
                         address.postCode
                 FROM users
                 INNER JOIN address ON users.billingAddress = address.id
                 WHERE users.id = :id';
        $stmt = $this->db->executeQuery($query, array('id' => $userId));
        $profileData = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
        return $profileData;
    }

    public function updateProfile($userId) {
        $registerErrors = array();

        if (isset($_POST['password']) && !empty($_POST['password'])) {
            $formArray['password'] = $_POST['password'];
          if (!isset($_POST['confirmPassword']) ||
              empty($_POST['confirmPassword']))
            $registerErrors['confirmPassword'] = self::NO_CONFIRM_PASSWORD_MSG;
            if(strlen($_POST['password']) < 6)
                $registerErrors['password'] = self::PASSWORD_TOO_SHORT;
            else if(!preg_match('/[a-zA-Z]/', $_POST['password']))
                $registerErrors['password'] = self::PASSWORD_NO_LETTERS;
            else if(!preg_match('/\d/', $_POST['password']))
                $registerErrors['password'] = self::PASSWORD_NO_DIGITS;
            else if(!isset($registerErrors['confirmPassword']) &&
                    $_POST['password'] != $_POST['confirmPassword'])
                $registerErrors['password'] = self::PASSWORDS_DO_NOT_MATCH;
        }

        $formArray['title'] = $_POST['title'];

        if (!isset($_POST['surname']) || empty($_POST['surname']))
            $registerErrors['surname'] = self::NO_SURNAME_MSG;
        else
            $formArray['surname'] = $_POST['surname'];

        if (!isset($_POST['firstName']) || empty($_POST['firstName']))
            $registerErrors['firstName'] = self::NO_FIRSTNAME_MSG;
        else
            $formArray['firstName'] = $_POST['firstName'];

        if (isset($_POST['middleName']) || empty($_POST['middleName']))
            $formArray['middleName'] = $_POST['middleName'];

        if (!isset($_POST['email']) || empty($_POST['email']))
            $registerErrors['email'] = self::NO_EMAIL_MSG;
        else {
            $formArray['email'] = $_POST['email'];
            if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
                $registerErrors['email'] = self::BAD_EMAIL_MSG;
        }

        if (!isset($_POST['paypalEmail']) || empty($_POST['paypalEmail']))
            $registerErrors['paypalEmail'] = self::NO_PAYPAL_EMAIL_MSG;
        else {
            $formArray['paypalEmail'] = $_POST['paypalEmail'];
            if(!filter_var($_POST['paypalEmail'], FILTER_VALIDATE_EMAIL))
                $registerErrors['paypalEmail'] = self::BAD_PAYPAL_EMAIL_MSG;
        }

        if (!isset($_POST['phone']) || empty($_POST['phone']))
            $registerErrors['phone'] = self::NO_PHONE_NUMBER_MSG;
        else {
            $formArray['phone'] = $_POST['phone'];
            if (!$this->validatePhone($_POST['phone']))
                $registerErrors['phone'] = self::BAD_PHONE_NUMBER_MSG;
        }

        if (!isset($_POST['city']) || empty($_POST['city']))
            $registerErrors['city'] = self::NO_CITY_MSG;
        else
            $formArray['city'] = $_POST['city'];

        if (!isset($_POST['country']) || empty($_POST['country']))
            $registerErrors['country'] = self::NO_COUNTRY_MSG;
        else
            $formArray['country'] = $_POST['country'];

        if (!isset($_POST['addressLine1']) || empty($_POST['addressLine1']))
            $registerErrors['addressLine1'] = self::NO_ADDRESS_LINE1_MSG;
        else
            $formArray['addressLine1'] = $_POST['addressLine1'];

        if (!isset($_POST['postCode']) || empty($_POST['postCode']))
            $registerErrors['postCode'] = self::NO_POST_CODE_MSG;
        else
            $formArray['postCode'] = $_POST['postCode'];

        if (isset($_POST['addressLine2']))
            $formArray['addressLine2'] = $_POST['addressLine2'];

        if (isset($_POST['county']))
            $formArray['county'] = $_POST['county'];

        if (empty($registerErrors)) {
            $processRet = $this->process($formArray);
            if (is_string($processRet))
                $registerErrors['process'] = $processRet;
        }
        return array('errors' => $registerErrors, 'formArray' => $formArray);
    }

    private function updateAddress($values) {
        $selectQuery = 'SELECT billingAddress FROM users WHERE id = :id';
        $rowStmt = $this->db->executeQuery($selectQuery,
                                     array('id' => Session::get('userId')));
        $addressId = $rowStmt->fetch(PDO::FETCH_ASSOC)['billingAddress'];

        $updateQuery = 'UPDATE address SET country = :country,
                                           county = :county,
                                           city = :city,
                                           addressLine1 = :addressLine1,
                                           addressLine2 = :addressLine2,
                                           postCode = :postCode
                        WHERE id = :id';

        $this->db->executeQuery($updateQuery,
                              array('id' => $addressId,
                                    'country' => $values['country'],
                                    'county' => $values['county'],
                                    'city' => $values['city'],
                                    'addressLine1' => $values['addressLine1'],
                                    'addressLine2' => $values['addressLine2'],
                                    'postCode' => $values['postCode']));

        return true;
    }

    private function updateUser($values) {
        $userColumns = array('nickname', 'surname', 'firstName', 'middleName',
                             'title', 'email', 'password', 'phone');

//        $values['password'] = $this->create_hash($values['password']);

        $array = array('userId' => Session::get('userId'),
                       'surname' => $values['surname'],
                       'firstName' => $values['firstName'],
                       'middleName' => $values['middleName'],
                       'title' => $values['title'],
                       'email' => $values['email'],
                       'phone' => $values['phone'],
                       'paypalEmail' => $values['paypalEmail']);


        $updateQuery = 'UPDATE users SET surname = :surname,
                                         firstName = :firstName,
                                         middleName = :middleName,
                                         title = :title,
                                         email = :email,
                                         phone = :phone,
                                         PayPalEmail = :paypalEmail';
        if (isset($_POST['password']) && !empty($_POST['password'])) {
            $updateQuery .= ', password = :password';
            $array['password'] = $values['password'];
        }

        $updateQuery .= ' WHERE id = :userId';

        $this->db->executeQuery($updateQuery, $array);
        return true;
    }

    private function process($formArray) {
        $addressId = self::updateAddress($formArray);
        $userRet   = self::updateUser($formArray);
        if (is_string($userRet))
            return $userRet;
        return true;
    }

    private function create_hash($password) {
        // format: algorithm:iterations:salt:hash
        $salt = base64_encode($this->mcrypt_create_iv(PBKDF2_SALT_BYTE_SIZE, 
                                               MCRYPT_DEV_URANDOM));
        return PBKDF2_HASH_ALGORITHM.':'.PBKDF2_ITERATIONS.":".$salt.":".
               base64_encode(pbkdf2(PBKDF2_HASH_ALGORITHM, $password, $salt,
                                    PBKDF2_ITERATIONS, PBKDF2_HASH_BYTE_SIZE,
                                    true
                                   )
                            );
    }

}
