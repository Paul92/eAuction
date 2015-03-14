<link rel="stylesheet" href="<?php echo ROOT_URL;?>/public/css/niceTable.css">
<h1 class="page-header">Bid History</h1>
<?php require('views/dashboard/index.php');?>
<br>
<div style="margin: 0 auto;" class="row">
<table class="col-xs-12">
  <thead>
    <tr class="row">
      <th class="col-md-3">Date & Time</th>
      <th class="col-md-3">Item Name</th>
      <th class="col-md-3">Seller Name</th>
      <th class="col-md-3">Value Bidded (&pound;)</th>
    </tr>
  </thead>
  <tbody>
<?php
foreach ($bids as $bid) {
  echo '<tr class="row">' . "\n";
  echo '<td class="col-md-3 col-sm-3 col-xs-4">' . $bid['time'] . "</td>\n";
  echo '<td class="col-md-3 col-sm-3 col-xs-3">';
  echo '<a href=' . ROOT_URL . '/item/item/' . $bid['id'] . '>';
  echo $bid['name'] . "</a></td>\n";
  echo '<td class="col-md-3 col-sm-3 col-xs-3">';
  echo '<a href="' . ROOT_URL . '/dashboard/viewProfile/' . $bid['sellerId'];
  echo '">'.$bid['sellerName']."</a></td>\n";
  echo '<td class="col-md-3 col-sm-3 col-xs-2">' . $bid['value']. "</td>\n";
  echo "</tr>\n";

}
?>
  </tbody>
</table>
  
</div>
