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
      if (isset($arr['errors']) && !empty($arr['errors']))
          $this->view->render('register/index', $arr);
      else
          header('Location: '.ROOT_URL.'/index/index/user_created');
  }

}

