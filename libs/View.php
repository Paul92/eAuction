<?php

class View {

    function __construct() {
    }

    public function render($name, $vars = null) {
        $errors = array();
        if (is_array($vars)) {
            extract($vars);
        }
        require 'views/header.php';
        require "views/$name.php";
        require 'views/footer.php';
    }
}
