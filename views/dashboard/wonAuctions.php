<link rel="stylesheet" href="<?php echo ROOT_URL;?>/public/css/niceTable.css">
<h1 class="page-header">Won Auctions</h1>
<?php require('views/dashboard/index.php'); ?>
<?php if (empty($wonAuctions)): ?>
<div class="alert alert-warning top20" role="alert">This user has not won any auctions yet.</div>
<?php else: ?>
<div style="margin: 0 auto;" class="row">
<table class="col-xs-12 col-md-offset-2 col-md-8">
  <thead>
    <tr class="row">
      <th class="col-xs-4">Item name</th>
      <th class="col-xs-4">Value</th>
      <th class="col-xs-4">Days remaining to pay</th>
    </tr>
  </thead>
  <tbody>
<?php
foreach ($wonAuctions as $wonAuction) {
  echo '<tr class="row">' . "\n";
  echo '<td class="col-md-3 col-sm-3 col-xs-4">';
  echo '<a href="' . ROOT_URL . '/item/item/' . $wonAuction['itemId'] . '">';
  echo $wonAuction['name'] . "</a></td>\n";
  echo '<td class="col-md-3 col-sm-3 col-xs-3">';
  echo '&pound; ' . $wonAuction['value'] . "</td>\n";
  echo '<td class="col-md-3 col-sm-3 col-xs-3">';
  if ($wonAuction['daysRemaining'] < 0 && $auction['payed'] == 0) {
      echo 'Your payment time has expired';
  } else if ($wonAuction['payed'] == 1) 
      echo 'You paid for this item';
  else {
    echo '<div>';
    echo '<div class="top5 col-xs-4 col-md-6">';
    echo $wonAuction['daysRemaining'];
    echo '</div>';
    echo '<form method="post" action="' . ROOT_URL;
    echo '/dashboard/processPayment">';
    echo '<button type="submit" class="btn col-xs-8 col-md-6 btn-success">';
    echo '<input type="hidden" name="itemId" ';
    echo 'value="' . $wonAuction['itemId'] . '">';
    echo '<input type="hidden" name="itemPrice" ';
    echo 'value="' . $wonAuction['value'] . '">';
    echo '<input type="hidden" name="itemName" ';
    echo 'value="' . $wonAuction['name'] . '">';
    echo '<input type="hidden" name="sellerPayPalEmail" ';
    echo 'value="' . $wonAuction['sellerPayPalEmail'] . '">';
    echo 'Pay Now </button>';
    echo '</form>';
    echo '</div>';
  }
  echo "</td>\n";
  echo "</tr>\n";

}
?>
  </tbody>
</table>
<?php endif; ?>
</div>
