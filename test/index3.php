<?php
include_once("config/config.php");
?>

<form method="post" action="process.php">
<input type="hidden" name="itemID" value="123" /> 
<input type="hidden" name="itemQty" value="1" /> 
<input class="dw_button" type="submit" name="submitbutt" value="Buy (225.00 <?php echo $PayPalCurrencyCode; ?>)" />
</form>
