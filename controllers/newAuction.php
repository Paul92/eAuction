<?php

class NewAuction extends Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        if (Session::exists('userId')) {
            $categories = $this->model->getCategories();
            $this->view->render('newAuction/index', array('category' => $categories));
        } else {
            header('Location: '. ROOT_URL . '/login');
        }
    }

    function runNewAuction() {
        $arr = $this->model->submitForm();
        if (isset($arr['errors']) && !empty($arr['errors'])) {
            $arr['category'] = $this->model->getCategories();
            $this->view->render('newAuction/index', $arr);
        } else if ($arr['formArray']['featured']) {
            $this->model->makeFeaturedPayment();
        } else {
            header('Location: ' . ROOT_URL . '/newAuction/uploadPictures');
        }
    }

    function runFeaturedPayment() {
        $this->model->receiveFeaturedPayment();
        header('Location: ' . ROOT_URL . '/newAuction/uploadPictures');
    }

    function uploadPictures() {
        if (!Session::exists('itemId')) {
            header('Location: '.ROOT_URL.'/index');
        } else {
            $this->view->render('newAuction/uploadPictures');
        }
    }

    function runUploadPictures() {
        $this->model->uploadPictures();
        header('Location: '.ROOT_URL.'/index/index/product_added');
    }

    function upload() {
        require 'libs/UploadHandler.php';
        $upload_handler = new UploadHandler();
    }

    function test() {
        $this->view->render('newAuction/uploadPictures');
    }


}

