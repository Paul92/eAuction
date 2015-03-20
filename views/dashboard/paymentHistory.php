<link rel="stylesheet" href="<?php echo ROOT_URL;?>/public/css/niceTable.css">
<h1 class="page-header">Payment History</h1>
<?php require('views/dashboard/index.php');?>
<?php if (empty($payments)): ?>
<div class="alert alert-warning top20" role="alert">This user has not done any payments yet.</div>
<?php else: ?>
<div style="margin: 0 auto;" class="row">
<table class="col-xs-12">
  <thead>
    <tr class="row">
      <th class="col-md-3">Date & Time</th>
      <th class="col-md-3">Transaction ID</th>
      <th class="col-md-3">Item Name</th>
      <th class="col-md-3">Item Value (&pound;)</th>
    </tr>
  </thead>
  <tbody>
<?php
foreach ($payments as $payment) {
  echo '<tr class="row">' . "\n";
  echo '<td class="col-xs-3">' . $payment['time'] . "</td>\n";
  echo '<td class="col-xs-3">';
  echo $payment['transactionId'] . "</td>\n";
  echo '<td class="col-xs-3">';
  echo $payment['itemName'] . "</td>\n";
  echo '<td class="col-xs-3">' . $payment['grandTotal']. "</td>\n";
  echo "</tr>\n";

}
?>
  </tbody>
</table>
<?php endif;?>
  
</div>
