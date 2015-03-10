<?php

class Item extends Controller {

    function __construct() {
        parent::__construct();
    }

    function item($itemId, $error = '') {
        $itemData  = $this->model->getItem($itemId);
        $images    = $this->model->getImages($itemId);
        $mainImage = $this->model->getMainImage($itemId);
        $this->view->render('item/index', array('item' => $itemData,
                                                'mainImage' => $mainImage,
                                                'error' => $error));
    }

    function bid($itemId) {
        $error = $this->model->newBid();
        if ($error !== true)
            $this->item($itemId, $error);
        else
            header('Location: ' . ROOT_URL . '/index/index/bid_created');
    }
}
