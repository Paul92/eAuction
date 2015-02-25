<?php

require 'models/HashModel.php';

class LoginModel extends HashModel {

    const WRONG_USER_OR_PASS = 'Wrong user of password. Please retry.';
    const NO_NICKNAME_MSG    = 'Please insert a nickname.';
    const NO_PASSWORD_MSG    = 'Please insert a password.';

    public function __construct() {
        parent::__construct();
    }

    public function run() {
        $errors    = array();
        $formArray = array();
        if (!isset($_POST['nickname']) || empty($_POST['nickname']))
            $errors['nickname'] = self::NO_NICKNAME_MSG;
        else
            $nickname = $_POST['nickname'];

        if (!isset($_POST['password']) || empty($_POST['password']))
            $errors['password'] = self::NO_PASSWORD_MSG;
        else
            $password = $_POST['password'];

        if (empty($errors)) {
            $fetchHashQuery = 'SELECT password FROM users WHERE nickname = :nick';
            $fetchHashStmt  = $this->db->prepare($fetchHashQuery);
            $fetchHashStmt->execute(array(':nick' => $nickname));
            $array = $fetchHashStmt->fetch(PDO::FETCH_ASSOC);
            if (empty($array)) {
                $errors[] = self::WRONG_USER_OR_PASS;
            } else {
                $hash = $array['password'];
                if (/*$this->validate_password($password, $hash)*/ $password==$hash) {
                    Session::set('loggedIn', true);
                    header('location: ../index');
                } else {
                    $errors[] = self::WRONG_USER_OR_PASS;
                }
            }
        }
        if (empty($errors))
            return(array('errors' => $errors,
                         'formArray' => array('password' => $password,
                                              'nickname' => $nickname)));
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
