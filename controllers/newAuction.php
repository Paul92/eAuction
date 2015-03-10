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
            header('Location: /login');
        }
    }

    function runNewAuction() {
        $arr = $this->model->submitForm();
        if (isset($arr['errors']) && !empty($arr['errors'])) {
            $arr['category'] = $this->model->getCategories();
            $this->view->render('newAuction/index', $arr);
        } else if ($arr['formArray']['featured']) {
            header('Location: /newAuction/featuredPayment');
        } else {
            header('Location: /newAuction/uploadPictures');
        }
    }

    function featuredPayment() {
        $this->view->render('newAuction/featuredPayment');
    }

    function runFeaturedPayment() {
        header('Location: /newAuction/uploadPictures');
    }

    function uploadPictures() {
        if (!Session::exists('itemId')) {
            header('Location: /index');
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

