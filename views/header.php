<!DOCTYPE html>
<html>
  <head>
    <title> bootstrap </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo ROOT_URL;?>/public/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo ROOT_URL;?>/public/css/styles.css" rel="stylesheet">

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
    .color-red{
      color: #FF0000;
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

#header{
    height: 50px;
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
              <a href="index">
                <span class="glyphicon glyphicon-home"></span> Home
              </a>
            </li>
            <?php if (Session::get('loggedIn')): ?>
            <li>
              <a href="newAuction">
                <span class="glyphicon glyphicon-plus"></span> Open Auction
              </a>
            </li>
            <li>
              <a href="dashboard">
                <span class="glyphicon glyphicon-user"></span> Dashboard
              </a>
            </li>
            <li>
              <a href="dashboard/logout">
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
