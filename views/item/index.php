<div class="container">
  <h1 class="page-header"> <?php
    echo $item['name'];
    echo '</h1>';
    if (isset($error) && !empty($error)) {
      echo '<div class="alert alert-danger" role="alert">';
      echo '<span class="glyphicon glyphicon-exclamation-sign"';
      echo 'aria-hidden="true"> </span>';
      echo '<a class="close" data-dismiss="alert">×</a>';
      echo '<span class="sr-only">Error: </span>';
      echo '<strong> Error: </strong>' . $error;
      echo '</div>';
    }?>

  <div class="row">
    <div class="col-sm-6 col-xs-12">
      <img src="<?php echo ROOT_URL . '/' . $mainImage?>" width="100%">
    </div>
    <div class="col-sm-6 col-xs-12">
      <form class="form-horizontal" method="post"
            action="<?php echo ROOT_URL . '/item/bid/' . $item['id'];?>">
        <input type="hidden" name="itemId" value="<?php echo $item['id'];?>">
        <input type="hidden" name="auctionType"
               value="<?php echo $item['auctionTypeId'];?>">
        <input type="hidden" name="startPrice"
               value="<?php echo $item['startPrice'];?>">
        <table class="table">
          <tr>
            <td>
              <label>Seller nickname:</label>
            </td>
            <td>
              <label><a href="<?php echo ROOT_URL . "/user/user/" . $item['sellerId'];?>">John</a></label>
            </td>
            <td></td>
          </tr>
          <tr>
            <td>
              <label>Seller rating:</label>
            </td>
            <td>
              <label><?php echo $item['sellerRating'];?></label>
            </td>
            <td></td>
          </tr>
          <tr>
            <td>
              <label>Auction end date:</label>
            </td>
            <td>
              <label><?php echo $item['endDate'];?></label>
            </td>
            <td>
              <?php echo '<span class="col-xs-12 label label-';
              if ($item['finished'] == 1) {
                  echo "danger\">Closed</span>\n";
              } else {
                  echo "success\">Open</span>\n"; 
              }?>
            </td>
          </tr>
          <tr>
            <td>
              <?php if ($item['auctionTypeId'] != 5): ?>
                  <label>Auction start price:</label>
              <?php else: ?>
                  <label>Item price:</label>
              <?php endif;?>
            </td>
            <td>
              <label><?php echo $item['startPrice'];?> &pound;</label>
            </td>
            <td></td>
          </tr>
          <tr>
            <td>
              <label>Product category:</label>
            </td>
            <td>
              <label><a href="<?php echo ROOT_URL;?>/index/category/<?php 
                                    echo $item['categoryId']?>"><?php
                                    echo $item['category'];?></a></label>
            </td>
            <td></td>
          </tr>
          <tr>
            <td>
              <label>Auction type:</label>
            </td>
            <td>
              <label><?php echo $item['auctionType'];?></label>
            </td>
            <td></td>
          </tr>
          <?php if ($item['auctionTypeId'] == 1): ?>
          <tr>
            <td>
              <label>Current maximum bid:</label>
            </td>
            <td>
              <label>
                <?php
                  if ($item['maxBid'] == null)
                      echo 'No bids';
                  else
                      echo $item['maxBid']. ' &pound;'?>
              </label>
            </td>
            <td></td>
          </tr>
          <?php endif;?>
          <?php if (Session::exists('loggedIn') && $item['finished'] == 0): ?>
          <tr>
            <td>
              <label>Bid value (&pound;):</label>
            </td>
            <td>
              <?php if ($item['auctionTypeId'] != 5): ?>
                <input type="text" class="form-control"
                       id="bidValue" name="bidValue">
              <?php endif;?>
            </td>
            <td>
              <button type="submit" class="btn btn-primary"
                ><?php
                if ($item['auctionTypeId'] == 5)
                    echo "Buy"; else echo "Bid now";?>
              </button>
            </td>
            <td></td>
          </tr>
          <?php endif;?>
        </table>
      </form>
    </div>
  </div>
  <div class="top10 row">
    <h2>
      Product description
    </h2>
    <hr>
    <p>
    <?php echo $item['description'];?>
    </p>
  </div>
</div>
