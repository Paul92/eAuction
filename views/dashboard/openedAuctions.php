<link rel="stylesheet" href="<?php echo ROOT_URL;?>/public/css/niceTable.css">
<h1 class="page-header">Opened Auctions</h1>
<?php require('views/dashboard/index.php'); ?>
<div style="margin: 0 auto;" class="row">
<?php if (empty($auctions)): ?>
<div class="alert alert-warning top20" role="alert">This user has not opened any auctions yet.</div>
<?php else: ?>
<table class="col-xs-12">
  <thead>
    <tr class="row">
      <th class="col-md-3">Item name</th>
      <th class="col-md-3">Category</th>
      <th class="col-md-3">End date</th>
      <th class="col-md-3">Auction Type</th>
    </tr>
  </thead>
  <tbody>
<?php
  foreach ($auctions as $auction) {
    echo '<tr class="row">' . "\n";
    echo '<td class="col-md-3 col-sm-3 col-xs-4">';
    echo '<a href="' . ROOT_URL . '/item/item/' . $auction['id'] . '">';
    echo $auction['name'] . "</a></td>\n";
    echo '<td class="col-md-3 col-sm-3 col-xs-3">';
    echo '<a href="' . ROOT_URL . '/index/category/' . $auction['categoryId'];
    echo '">' . $auction['category'] . "</a></td>\n";
    echo '<td class="col-md-3 col-sm-3 col-xs-3">' . $auction['endDate'] . "</td>\n";
    echo '<td class="col-md-3 col-sm-3 col-xs-2">' . $auction['auctionType']. "</td>\n";
    echo "</tr>\n";
  }
?>
  </tbody>
</table>
<?php endif;?>
  
</div>
