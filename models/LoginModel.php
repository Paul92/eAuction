<?php

require 'models/HashModel.php';

class LoginModel extends HashModel {

    public function __construct() {
        parent::__construct();
    }

    public function run() {
        
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
