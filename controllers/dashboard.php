<?php

class Dashboard extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->editProfile(Session::get('userId'));
    }

    public function editProfile($userId) {
        $userData = $this->model->getProfileData($userId);
        $this->view->render('dashboard/editProfile',
                            array('userId' => $userId,
                                  'formArray' => $userData));
    }

    public function viewProfile($userId) {
        $this->editProfile($userId);
//        $this->view->render('dashboard/editProfile',
//                            array('userId' => $userId));
    }

    public function bidHistory($userId) {
        $bidHistory = $this->model->getBidHistory($userId);
        $this->view->render('dashboard/bidHistory',
                     array('bids' => $bidHistory,
                           'userId' => $userId));
    }

    public function openedAuctions($userId) {
        $auctionHistory = $this->model->getAuctionHistory($userId);
        $this->view->render('dashboard/openedAuctions',
                     array('auctions' => $auctionHistory,
                           'userId' => $userId));
    }

    public function paymentHistory($userId) {
        $payments = $this->model->getPaymentHistory();
        $this->view->render('dashboard/paymentHistory',
                            array('payments' => $payments,
                                  'userId' => $userId));
    }

    public function wonAuctions($userId) {
        $wonAuctions = $this->model->getWonAuctions();
        $this->view->render('dashboard/wonAuctions',
                            array('wonAuctions' => $wonAuctions,
                                  'userId' => $userId));
    }

    public function processPayment() {
        $this->model->makePayment($_POST['itemId'], $_POST['itemName'],
                                  $_POST['itemPrice'],
                                  $_POST['sellerPayPalEmail']);
    }

    public function updateProfile($userId) {
        $errors = $this->model->updateProfile($userId);
        if (isset($arr['errors']) && !empty($arr['errors']))
            $this->view->render('register/index', $arr);
        else
            header('Location: '.ROOT_URL.'/index/index/user_updated');
    }

    public function logout() {
        Session::remove('loggedIn');
        Session::remove('userId');
        header('location: ../index');
    }


}
