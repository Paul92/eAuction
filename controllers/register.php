<?php

class Register extends Controller {

  function __construct() {
      parent::__construct();
  }

  function index() {
      $this->view->render('register/index');
  }

  function run() {
      $arr = $this->model->run();
      $this->view->render('register/index', $arr);
  }

}

