<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
?>

<h4>Redeem Voucher</h4>
<p>Please enter your voucher code below.</p>
<?php if(@$message) { ?>
    <div class="alert alert-danger"><?php echo @$message; ?></div>
<?php } else { ?>
	<?php if(@$success) { ?>
    	<div class="alert alert-success">Your voucher code was redeemed, please check your emails for confirmation.</div>
    <?php } ?>
<?php } ?>
<form action="" method="post">
	<div class="form-group">
    	<label>Voucher Code:</label>
        <input type="text" name="voucher_code" value="" class="form-control">    	
    </div>
    <div class="form-group">
    	<input type="submit" name="_redeem-voucher" value="Redeem" class="btn btn-default">
    </div>
</form>