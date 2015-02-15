<?php

class Bootstrap {

    function __construct() {

        $url = "";
        // Set index as default url if none is specified.
        if (!isset($_GET['url']) && empty($_GET['url']))
            $url = 'index';   // CREATE CONSTANT!!!
        else
            $url = $_GET['url'];

        // Remove extra slashes at the end of the url.
        $url = rtrim($url, '/');

        // Tokenize the url using / as separator.
        $url = explode('/', $url);

        $file = "controllers/$url[0].php"; // CREATE CONSTANT!!!

        if (file_exists($file)) {
            require $file;
        } else {
            require 'controllers/error.php';   // CREATE CONSTANT!!!
            $controller = new Error();
            return false;
        }

        Session::init();
        $controller = new $url[0];
        $controller->loadModel($url[0]);

        // The url format is host/controllers/method/parameter
        // Each controller coresponds to a page. The default method called is
        // index.
        if (isset($url[2]))
            $arg = $url[2];
        else
            $arg = null;

        if (isset($url[1])) {
            if (method_exists($controller, $url[1])) {
                $controller->{$url[1]}($arg);
            } else {
                require 'controllers/error.php';   // CREATE CONSTANT!!!
                $controller = new Error();
                $controller->index();
            }
        } else {
            $controller->index(1);
        }

        return true;
    }

}
