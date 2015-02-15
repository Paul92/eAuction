<!doctype html>
<html>
  <head>
    <title> Test </title>
    <link rel="stylesheet" href="<?php echo ROOT_URL;?>/public/css/default.css" />
  </head>
<body>

  <div id="header">
    <a href="<?php echo ROOT_URL;?>/index">Index</a>
    <a href="<?php echo ROOT_URL;?>/help">Help</a>

    <?php if (Session::get('loggedIn')): ?>
    <a href="dashboard/logout">Logout</a>
    <?php else: ?>
    <a href="<?php echo ROOT_URL;?>/login">Login</a>
    <a href="<?php echo ROOT_URL;?>/register">Register</a>
    <?php endif ?>

  </div>

  <div id="content">
