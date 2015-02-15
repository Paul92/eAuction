<?php

class Controller {

    function __construct() {
        $this->view = new View();
    }

    public function loadModel($moduleName) {
        $modelName = ucfirst($moduleName) . 'Model';
        $filePath = "models/$modelName.php";

        if (file_exists($filePath)) {
            require $filePath;
            $this->model = new $modelName();
        }
    }

}
