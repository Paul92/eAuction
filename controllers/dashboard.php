<?php

class Dashboard extends Controller {

    public function __construct() {
        parent::__construct();
    }

    function index() {
        $this->view->render('dashboard/index');
    }

    public function logout() {
        Session::remove('loggedIn');
        header('location: ../index');
    }
}
