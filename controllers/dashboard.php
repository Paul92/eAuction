<?php

class Dashboard extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->editProfile(Session::get('userId'));
    }

    public function editProfile($userId) {
        $this->view->render('dashboard/editProfile',
                            array('userId' => $userId));
    }

    public function viewProfile($userId) {
        $this->view->render('dashboard/viewProfile',
                            array('userId' => $userId));
    }

    public function bidHistory($userId) {
        $bidHistory = $this->model->getBidHistory($userId);
        $this->view->render('dashboard/bidHistory',
                     array('bids' => $bidHistory,
                           'thisUser' => $userId == Session::get('userId')));
    }

    public function openedAuctions($userId) {
        $auctionHistory = $this->model->getAuctionHistory($userId);
        $this->view->render('dashboard/openedAuctions',
                     array('auctions' => $auctionHistory,
                           'thisUser' => $userId == Session::get('userId')));
    }

    public function paymentHistory($userId) {
        $this->view->render('dashboard/paymentHistory');
    }

    public function logout() {
        Session::remove('loggedIn');
        header('location: ../index');
    }


}
