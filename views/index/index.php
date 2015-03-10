<script type="text/javascript" src="<?php echo ROOT_URL;?>/public/js/slider.js"></script>
<div id = "row">
<?php
if (isset($info) && !empty($info) && $info != 1) {
    echo '<div class="alert alert-info" role="alert">';
    echo '<span class="glyphicon glyphicon-info-sign" aria-hidden="true"> </span>';
    echo '<a class="close" data-dismiss="alert">×</a>';
    echo '<span class="sr-only">Error: </span>';
    echo '<strong> Info: </strong>' . $info;
    echo '</div>';
}?>

  <div class="row">
    <form class="form-horizontal" action="<?php echo ROOT_URL;?>/index/search" method="post">
      <div class="form-group">
        <div class="top10 col-sm-12">
          <div class="col-sm-offset-2 col-sm-6 col-xs-8 col-xs-offset-1">
            <input type="text" class="form-control" id="searchString"
                   name="searchString" placeholder="Search">
          </div>
          <button type="submit" class="btn col-md-1 col-xs-2 btn-primary">
            <span class="glyphicon glyphicon-search"></span> Search
          </button>
        </div>
      </div>
    </form>
  </div>

  <div id="sidebar">
    <div class="sn sidebar-nav">
      <div class="sn navbar navbar-default" role="navigation">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <span class="visible-xs navbar-brand">Categories</span>
        </div>
        <div class="sn navbar-collapse collapse sidebar-navbar-collapse">
          <ul class="nav navbar-nav">
            <?php
            foreach ($categories as $category) {
                echo '<li><a href="'. ROOT_URL . '/index/category/';
                echo $category['id'];
                echo '">' . $category['category'] . '<span class=';
                echo '"badge" style="float:right">' . $category['noOfItems'];
                echo '</span></a></li>'."\n";
            }?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
  </div>

  <div id="cont">
    <div class="slider_wrapper">
      <ul id="image_slider" >
        <?php
          foreach ($featuredImages as $image) {
            echo '<li><img alt="placeholder" src="';
            echo ROOT_URL.'/'.$image['filePath'] . '" height="340" width="320"></li>';
          }
        ?>
      </ul>
      <span class="nvgt" id="prev"></span>
      <span class="nvgt" id="next"></span>
    </div>
  </div>


  <div id="cont2" class = "container">
    <div id="thumbnailsRow" class = " row">
      <?php foreach ($newestItems as $item) {
          echo '<div class = "thumbDiv col-md-4">' . "\n";
          echo '<img class="thumb" alt="' . $item['mainPicture'];
          echo '" src="' . ROOT_URL . '/' . $item['mainPicture'] . "\">\n";
          echo '<h3><a href = "' . ROOT_URL . '/item/item/' . $item['id'] . '">';
          echo $item['name'] . "</a></h3>\n";
          echo '<div class="row">';
          echo '<h6 class="col-xs-7 removeTop10"><em>' . $item['auctionType'] . "</em></h6>\n";
          echo '<span class="col-xs-3 label label-';
          if ($item['finished'] == 1) {
              echo "danger\">Closed</span>\n";
          } else {
              echo "success\">Open</span>\n"; 
          }
          echo "</div>\n";
          echo $item['categoryId'];
          echo '<p>' . $item['description'] . "</p>\n";
          echo "</div>\n";
      } ?>
<!--
      <div class = "thumbDiv col-md-4">
        <img class="thumb" alt="iage" src="<?php echo ROOT_URL;?>/permanentStorage/1_vim-shortcuts.png">
        <h3><a href = "#">$500 Gaming PC Build</a></h3>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting.
           leap into electronic typesetting, remaining essentially. </p>
           <a href = "#" class = "btn btn-default">Read More</a>
      </div>
-->
    </div>
  </div>

</div>

