<div class="container">

  <h1 class="page-header"> Open new auction </h1>

<?php if (isset($errors) && !empty($errors)) {

     foreach($errors as $error) {
        echo '<div class="alert alert-danger" role="alert">';
        echo '<span class="glyphicon glyphicon-exclamation-sign"
              aria-hidden="true"> </span>';
        echo '<a class="close" data-dismiss="alert">×</a>';
        echo '<span class="sr-only">Error: </span>';
        echo '<strong> Error: </strong>' . $error;
        echo '</div>';
     }
}?>
  <div class="row">
    <form id="fileupload" class="form-horizontal" method="post"
          action="<?php echo ROOT_URL;?>/newAuction/runNewAuction">
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <div class="top10 col-sm-12">
              <label for="name" class="control-label col-sm-4">Item name</label>
              <div class="col-sm-8">
                  <input type="text" class="form-control" id="name" value=
                  "<?php if (isset($formArray['name']))
                             echo $formArray['name'];?>"
                    name="name" placeholder="Item name">
              </div>
            </div>
            <div class="top10 col-sm-12">
              <label for="category" class="control-label col-sm-4">Category</label>
              <div class="col-sm-8">
                  <select name="category" id="category" class="form-control">
                    <?php foreach ($category as $cat) {
                    echo "<option value=\"" . $cat['id'] . ' ';
                    if (isset($formArray['category']) && 
                        $formArray['category'] == $cat['id'])
                        echo 'selected ';
                    echo "\">" . $cat['name'] . "</option>\n";
                    }?>
                  </select>
              </div>
            </div>

            <div class="top10 col-sm-12">
              <label for="auctionType" class="control-label col-sm-4">Auction Type</label>
              <div class="col-sm-8">
                  <select id="auctionType" name="auctionType" class="form-control">
                  <option value="1"
                  <?php if (isset($formArray['auctionType']) &&
                            $formArray['auctionType'] == 1)
                            echo 'selected ';?>
                  > English Auction </option>
                  <option value="2"
                  <?php if (isset($formArray['auctionType']) &&
                            $formArray['auctionType'] == 2)
                            echo 'selected ';?>
                  > Dutch Auction </option>
                  <option value="3"
                  <?php if (isset($formArray['auctionType']) &&
                            $formArray['auctionType'] == 3)
                            echo 'selected ';?>
                  > English Auction with hidden bids </option>
                  <option value="4"
                  <?php if (isset($formArray['auctionType']) &&
                            $formArray['auctionType'] == 4)
                            echo 'selected ';?>
                  > Vickery Auction </option>
                  <option value="5"
                  <?php if (isset($formArray['auctionType']) &&
                            $formArray['auctionType'] == 5)
                            echo 'selected ';?>
                  > Buy it now </option>
                  </select>
              </div>
            </div>

            <div class="top10 col-sm-12">
              <label for="startPrice" class="control-label col-sm-4">Start price</label>
              <div class="col-sm-8">
                  <input type="text" class="form-control" id="startPrice" value=
                  "<?php if (isset($formArray['startPrice']))
                             echo $formArray['startPrice'];?>"
                    name="startPrice" placeholder="Start Price">
              </div>
            </div>

            <div class="top10 col-sm-12">
              <label for="duration" class="control-label col-sm-4">Auction Duration (days)</label>
              <div class="col-sm-8">
                  <input type="text" class="form-control" id="duration" value=
                  "<?php if (isset($formArray['duration']))
                             echo $formArray['duration'];?>"
                    name="duration" placeholder="Auction Duration">
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            <div class="row">
              <label for="description" class="control-label col-sm-4">Item description</label>
              <div class="col-sm-8">
                <textarea id="description" name="description" 
                          class="form-control" rows="8"><?php
                             if(isset($formArray['description'])) 
                               echo $formArray['description']; ?></textarea>
              </div>
            </div>
            <div class="top10 row">
              <label for="featured" class="control-label col-sm-4">Featured product</label>
              <input id="featured" name="featured" type="checkbox"
                <?php if (isset($formArray['featured']) &&
                          $formArray['featured'])
                            echo 'checked';?>
                class="checkbox col-sm-1">
            </div>
          </div>
        </div>
      </div>
      <div style="margin-top:30px" class="row">
          <button type="submit" class="col-xs-4 col-xs-offset-5 btn btn-primary">
              <i class="glyphicon glyphicon-circle-arrow-right"></i>
              <span>Submit</span>
          </button>
      </div>
    </form>
  </div>
</div>

