<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/
if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
?>
<div class="container">
	<div class="row">
    	<div class="col-sm-6">
        	<div class="panel panel-default">
            	<div class="panel-body">
                    <?php if(!@$message) { ?>
                    	<h4>You're good to go!</h4>
                        <p>Your account has been activated. You can now login to your account.</p>
                    <?php } else { ?>
                        <h4>Oops, We have a problem!</h4>
                        <p><?php echo $message; ?></p>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
        	<div class="panel panel-default">
            	<div class="panel-body">
                    <h4>Already a Member?</h4>
                    <p>Click the button below to login to your account.</p>
                    <div class="form-group">
                        <a href="<?php echo DOMAIN; ?>/index.php?page=login" class="btn btn-default">Login here</a>
                    </div>
            	</div>
            </div>
            <div class="panel panel-default">
            	<div class="panel-body">
                    <h4>Forgot Password?</h4>
                    <p>Click the button below to reset your password.</p>
                    <div class="form-group">
                        <a href="<?php echo DOMAIN; ?>/index.php?page=forgotpassword" class="btn btn-default">Forgot Password</a>
                    </div>
            	</div>
            </div>
        </div>
    </div>
</div>