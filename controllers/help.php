<?php

class Help extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function test($arg = "") {
        echo "That's ok";
        echo "Optional $arg";
    }

}
