<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
?>

<h4>Change Password</h4>
<p>Please enter your old password below to continue.</p>
<?php if(@$message) { ?>
    <div class="alert alert-danger"><?php echo @$message; ?></div>
<?php } else { ?>
	<?php if(@$success) { ?>
    	<div class="alert alert-success">Your password has been changed.</div>
    <?php } ?>
<?php } ?>
<form action="" method="post">
	<div class="form-group">
    	<label>Old Password:</label>
        <input type="password" name="user_password" value="" class="form-control">    	
    </div>
    <div class="form-group">
    	<label>New Password:</label>
        <input type="password" name="user_password1" value="" class="form-control">    	
    </div>
    <div class="form-group">
    	<label>Re-type Password:</label>
        <input type="password" name="user_password2" value="" class="form-control">    	
    </div>
    <div class="form-group">
    	<input type="submit" name="_submit" value="Change Password" class="btn btn-default">
    </div>
</form>