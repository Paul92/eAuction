<!DOCTYPE html>
<html>
  <head>
    <title> bootstrap </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo ROOT_URL;?>/public/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo ROOT_URL;?>/public/css/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
    <link rel="stylesheet" href="<?php echo ROOT_URL;?>/public/css/style.css">
    <link rel="stylesheet" href="<?php echo ROOT_URL;?>/public/css/jquery.fileupload.css">
    <link rel="stylesheet" href="<?php echo ROOT_URL;?>/public/css/jquery.fileupload-ui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo ROOT_URL;?>/public/css/slider.css">

    <link href="<?php echo ROOT_URL;?>/imageViewer/PhotoSwipe/_site/site-assets/site.css?v=4.0.6-1.0.4" rel="stylesheet" />
    <link href="<?php echo ROOT_URL;?>/imageViewer/PhotoSwipe/dist/photoswipe.css?v=4.0.6-1.0.4" rel="stylesheet" />
    <link href="<?php echo ROOT_URL;?>/imageViewer/PhotoSwipe/dist/default-skin/default-skin.css?v=4.0.6-1.0.4" rel="stylesheet" />

<style type="text/css">
    .bs-example{
      margin: 20px;
    }
    .yellow{
      background-color: #00FF00;
    }
    .blue{
      background-color: #0000FF;
    }
    .red{
      background-color: #FF0000;
    }
  /* Fix alignment issue of label on extra small devices in Bootstrap 3.2 */
    .form-horizontal .control-label{
        padding-top: 7px;
    }
.center {
    margin-left: auto;
    margin-right: auto;
    width: 50%;
}
.col-condensed {
  margin-left: 0px;
  margin-right: 0px;
    padding-left: 0px;
    padding-right: 0px;
}
.top10 {
  margin-top: 10px;
}
.top20 {
  margin-top: 20px;
}
.navbar {
  margin-bottom: 5px;
}
.white {
  background-color: #EEEEEE;
}
html,body{
    height: 100%;
    width: 100%;
}

#wrapper {
    padding: 10px;
/*   min-height: -webkit-calc(100% - 100px);     /* Chrome */
/*   min-height: -moz-calc(100% - 100px);     /* Firefox */
    min-height: calc(98% - 100px);     /* native */
}
#footer {
    position: relative;
    clear:both;
}
.desc {
    margin-left: -20px;
    margin-right: -10px;
}
.noLeft {
    margin-left: -30px;
}
</style>
  </head>
  <body>
    <div id="header" class="navbar navbar-inverse navbar-static-top">
      <div class="container">
        <a href="index" class="navbar-brand"> eAuction </a>
        <button class="navbar-toggle" data-toggle="collapse" data-target=".navHeaderCollapse">
          <span class="icon-bar"> </span>
          <span class="icon-bar"> </span>
          <span class="icon-bar"> </span>
        </button>
        <div class="collapse navbar-collapse navHeaderCollapse">
          <ul class="nav navbar-nav navbar-right">
            <li>
              <a href="<?php echo ROOT_URL;?>/index">
                <span class="glyphicon glyphicon-home"></span> Home
              </a>
            </li>
            <?php if (Session::get('loggedIn')): ?>
            <li>
              <a href="<?php echo ROOT_URL;?>/newAuction">
                <span class="glyphicon glyphicon-plus"></span> Open Auction
              </a>
            </li>
            <li>
              <a href="<?php echo ROOT_URL;?>/dashboard">
                <span class="glyphicon glyphicon-user"></span> Dashboard
              </a>
            </li>
            <li>
              <a href="<?php echo ROOT_URL;?>/logout">
                <span class="glyphicon glyphicon-log-out"></span> Logout
              </a>
            </li>
            <?php else: ?>
            <li>
              <a href="<?php echo ROOT_URL;?>/login">
                <span class="glyphicon glyphicon-log-in"></span> Login
              </a>
            </li>
            <li>
              <a href="<?php echo ROOT_URL;?>/register">
                <span class="glyphicon glyphicon-globe"></span> Register
              </a>
            </li>
            <?php endif ?>
          </ul>
        </div>
      </div>
    </div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="<?php echo ROOT_URL;?>/public/js/bootstrap.js"></script>
    <div id = wrapper>
