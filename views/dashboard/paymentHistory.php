<link rel="stylesheet" href="<?php echo ROOT_URL;?>/public/css/niceTable.css">
<h1 class="page-header">Payment History</h1>
<?php require('views/dashboard/index.php');?>
<br>
<div style="margin: 0 auto;" class="row">
<table class="col-xs-12">
  <thead>
    <tr class="row">
      <th class="col-md-3">Date & Time</th>
      <th class="col-md-2">Transaction ID</th>
      <th class="col-md-3">Item Name</th>
      <th class="col-md-2">Item Value (&pound;)</th>
      <th class="col-md-2">Grand Total (&pound;)</th>
    </tr>
  </thead>
  <tbody>
<?php
foreach ($payments as $payment) {
  echo '<tr class="row">' . "\n";
  echo '<td class="col-md-3 col-sm-3 col-xs-4">' . $payment['time'] . "</td>\n";
  echo '<td class="col-md-2 col-sm-2 col-xs-3">';
  echo $payment['transactionId'] . "</td>\n";
  echo '<td class="col-md-3 col-sm-3 col-xs-3">';
  echo $payment['itemName'] . "</td>\n";
  echo '<td class="col-md-2 col-sm-2 col-xs-2">' . $payment['itemPrice']. "</td>\n";
  echo '<td class="col-md-2 col-sm-2 col-xs-2">' . $payment['grandTotal']. "</td>\n";
  echo "</tr>\n";

}
?>
  </tbody>
</table>
  
</div>
