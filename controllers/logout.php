<?php

class Logout extends Controller {

  function __construct() {
      parent::__construct();
  }

  function index() {
      Session::remove('loggedIn');
      Session::remove('userId');
      header('Location: index');
  }

}

