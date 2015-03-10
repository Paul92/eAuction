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
                    header('location: ../index');
                } else {
                    $errors[] = self::WRONG_USER_OR_PASS;
                }
            }
        }
        if (empty($errors))
            return(array('errors' => $errors,
                         'formArray' => array('password' => $password,
                                              'login' => $login)));
        else
            return(array('errors' => $errors));
    }

    private function validate_password($password, $correct_hash)
    {
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

