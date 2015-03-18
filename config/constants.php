<?php

require('config.inc.php');

define("ROOT_URL", "http://localhost");
define("ROOT_DIR", "/home/paul/git/eauction");

define("DB_HOST", $database_host);
define("DB_TYPE", "mysql");
define("DB_NAME", "2014_comp10120_y7");
define("DB_USER", $database_user);
define("DB_PASS", $database_pass);

define("PBKDF2_HASH_ALGORITHM", "sha256");
define("PBKDF2_ITERATIONS", 1000);
define("PBKDF2_SALT_BYTE_SIZE", 24);
define("PBKDF2_HASH_BYTE_SIZE", 24);

define("HASH_SECTIONS", 4);
define("HASH_ALGORITHM_INDEX", 0);
define("HASH_ITERATION_INDEX", 1);
define("HASH_SALT_INDEX", 2);
define("HASH_PBKDF2_INDEX", 3);
