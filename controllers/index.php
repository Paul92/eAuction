<?php

class Index extends Controller{

    function __construct() {
        parent::__construct();
    }

    function index($info = null, $category = null) {
        $categories = $this->model->getCategories();
        $newestItems = $this->model->getNewestItems($category);

        if ($info == 'product_added')
            $info = 'Your auction has been successfuly created.';
        if ($info == 'user_created')
            $info = 'Your user has been created. Please login.';
        if ($info == 'bid_created')
            $info = 'Your bid has been sucessfully inserted.';

        $featuredImages = $this->model->getFeaturedImages();
        $this->view->render('index/index',
                            array('categories' => $categories,
                                  'info' => $info,
                                  'featuredImages' => $featuredImages,
                                  'newestItems' => $newestItems));
    }

    function category($category) {
        $this->index('', $category);
    }

    function search() {
        var_dump($_POST);
        $categories = $this->model->getCategories();
        $items = $this->model->getNewestItems(null,
                                              explode(' ',
                                                     $_POST['searchString']));
        $this->view->render('index/search',
                            array('categories' => $categories,
                                  'items' => $items));

    }
}
