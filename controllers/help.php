<?php

class Help extends Controller {

    function __construct() {
        echo "We are in help";
    }

    public function test($arg = "") {
        echo "That's ok";
        echo "Optional $arg";
    }

}
