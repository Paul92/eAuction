  <nav class="navbar navbar-default" role="navigation">
      <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand">Dashboard</a>
  </div>
  <div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav nav-justified">
     <?php if (isset($userId) && $userId == Session::get('userId')): ?>
      <li><a href="<?php echo ROOT_URL;?>/dashboard/editProfile">Edit profile</a></li>
      <li><a href="<?php echo ROOT_URL;?>/dashboard/paymentHistory/<?php echo $userId;?>">Payment History</a></li>
     <?php else:?>
      <li><a href="<?php echo ROOT_URL;?>/dashboard/viewProfile">View profile</a></li>
     <?php $userId = Session::get('userId'); endif;?>
      <li><a href="<?php echo ROOT_URL;?>/dashboard/bidHistory/<?php echo $userId;?>">Bid History</a></li>
      <li><a href="<?php echo ROOT_URL;?>/dashboard/openedAuctions/<?php echo $userId;?>">Opened Auctions</a></li>
    </ul>
  </div>
</nav>
