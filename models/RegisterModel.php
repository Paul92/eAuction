<?php

require 'models/HashModel.php';

class RegisterModel extends HashModel {

    const NO_NICKNAME_MSG         = 'Please insert a nickname.';
    const NO_PASSWORD_MSG         = 'Please insert a password.';
    const NO_CONFIRM_PASSWORD_MSG = 'Please confirm the password.';
    const NO_SURNAME_MSG          = 'Please insert a surname.';
    const NO_FIRSTNAME_MSG        = 'Please insert a first name.';
    const NO_EMAIL_MSG            = 'Please insert an email.';
    const NO_PHONE_NUMBER_MSG     = 'Please insert a phone number.';
    const NO_CITY_MSG             = 'Please insert a city.';
    const NO_COUNTRY_MSG          = 'Please insert a country.';
    const NO_POST_CODE_MSG        = 'Please insert a post code.';
    const NO_ADDRESS_LINE1_MSG    = 'Please insert an address line.';

    const BAD_EMAIL_MSG           = 'Email address not valid.';
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


    const SUCESSFUL               = 'User succesfully created.';

    const ADDRESS_COLUMNS = array('country', 'county', 'city',
                                  'addressLine1', 'addressLine2',
                                  'postCode');

    public function __construct() {
        parent::__construct();
    }

    private function validatePhone($phone) {
        $phone = str_replace(' ', '', $phone);
        return preg_match("/^[\+0-9\-\(\)\s]*$/", $phone);
    }

    public function run() {
        $registerErrors = array();
        $formArray = array(
                    'nickname'   => '',
                    'password'   => '',
                    'title'      => '',
                    'surname'    => '',
                    'firstName'  => '',
                    'middleName' => '',
                    'email'      => '',
                    'phone'      => '');
        if (!isset($_POST['nickname']) || empty($_POST['nickname']))
            $registerErrors['nickname'] = self::NO_NICKNAME_MSG;
        else
            $formArray['nickname'] = $_POST['nickname'];

        if (!isset($_POST['confirmPassword']) || empty($_POST['confirmPassword']))
            $registerErrors['confirmPassword'] = self::NO_CONFIRM_PASSWORD_MSG;

        if (!isset($_POST['password']) || empty($_POST['password']))
            $registerErrors['password'] = self::NO_PASSWORD_MSG;
        else {
            $formArray['password'] = $_POST['password'];
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

        if (!isset($_POST['TC']) || $_POST['TC'] != 'accepted')
            $registerErrors['TC'] = self::NOT_ACCEPTED_TC;
        else
            $formArray['TC'] = $_POST['TC'];

        if (empty($registerErrors)) {
            $processRet = $this->process($formArray);
            if (is_string($processRet))
                $registerErrors['process'] = $processRet;
        }
        return array('errors' => $registerErrors, 'formArray' => $formArray);
    }

    private function insertAddress($values) {

        $this->db->insertQuery('address', self::ADDRESS_COLUMNS, $values);

        $selectQuery = 'SELECT id FROM address WHERE ';
        foreach (self::ADDRESS_COLUMNS as $column)
            $selectQuery .= "$column = :$column and ";
        $selectQuery = substr($selectQuery, 0, strlen($selectQuery) - 5);

        $rowStmt = $this->db->executeQuery($selectQuery,
                           array('country'      => $values['country'],
                                 'county'       => $values['county'],
                                 'city'         => $values['city'],
                                 'addressLine1' => $values['addressLine1'],
                                 'addressLine2' => $values['addressLine2'],
                                 'postCode'     => $values['postCode']));

        $retVal = $rowStmt->fetch(PDO::FETCH_ASSOC)['id'];
        return (int)$retVal;
    }

    private function checkUserAndAddr($values) {
        if ($this->db->exists('users', array('email'), array('email' => $values['email'])))
            return self::EMAIL_ALREADY_EXISTS;
        else if ($this->db->exists('users', array('nickname'), array('nickname' => $values['nickname'])))
            return self::NICKNAME_ALREADY_EXISTS;
        else if ($this->db->exists('address', self::ADDRESS_COLUMNS, $values))
            return self::ADDRESS_ALREADY_EXISTS;
        else
            return false;
    }

    private function insertUser($values) {
        $userColumns = array('nickname', 'surname', 'firstName', 'middleName',
                             'title', 'email', 'password', 'phone');

//        $values['password'] = $this->create_hash($values['password']);

        $this->db->insertQuery('users', $userColumns, $values);
        return true;
    }

    private function process($formArray) {
        $error = $this->checkUserAndAddr($formArray);
        if ($error !== false)
            return $error;
        $addressId = self::insertAddress($formArray);
        if (is_string($addressId))
            return $addressId;
        $formArray['billingAddress'] = $addressId;
        $userRet = self::insertUser($formArray);
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
