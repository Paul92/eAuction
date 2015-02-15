<?php

require 'models/HashModel.php';

class RegisterModel extends HashModel {

    public function __construct() {
        parent::__construct();
    }

    public function run() {
        
    }

    private function create_hash($password)
    {
        // format: algorithm:iterations:salt:hash
        $salt = base64_encode(mcrypt_create_iv(PBKDF2_SALT_BYTE_SIZE, 
                                               MCRYPT_DEV_URANDOM));
        return PBKDF2_HASH_ALGORITHM.':'.PBKDF2_ITERATIONS.":".$salt.":".
               base64_encode(pbkdf2(PBKDF2_HASH_ALGORITHM, $password, $salt,
                                    PBKDF2_ITERATIONS, PBKDF2_HASH_BYTE_SIZE,
                                    true
                                   )
                            );
    }
}
