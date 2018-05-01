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
                	<?php if(lib::get('confirm') == 'confirm-email') { ?>
                    	<h4>We just sent an email to reset your password</h4>
                        <p>Please click the link inside your email to confirm the password reset.</p>
                    <?php } elseif(lib::get('confirm') == 'change-password') { ?>
                    <form action="" method="post">
                        <h4>Change Password</h4>
                        <p>Please enter a new password below to continue.</p>
                        <?php if(@$message) { ?>
                            <div class="alert alert-danger"><?php echo @$message; ?></div>
                        <?php } ?>
                        <div class="form-group">
                            <label>New Password:</label>
                            <input type="password" class="form-control" name="user_password" value="<?php echo lib::post('user_password'); ?>"/>
                        </div>
                        <div class="form-group">
                            <label>Confirm Password:</label>
                            <input type="password" class="form-control" name="user_password2" value="<?php echo lib::post('user_password2'); ?>"/>
                        </div>
                        <!-- <div class="form-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">Anti-Spam Check</div>
                                <div class="panel-body">
                                    <script src='https://www.google.com/recaptcha/api.js'></script>
                                    <div class="g-recaptcha" data-sitekey="<?php echo lib::getSetting('Security_CaptchaPublic'); ?>"></div>
                                </div>
                            </div>
                        </div> -->
                        <div class="form-group">
                        	<input type="hidden" name="code" value="<?php echo lib::get('code'); ?>">
                            <input type="submit" class="btn btn-default" value="Reset Password" name="_changepassword"/>
                        </div>
                    </form>
                    <?php } elseif(lib::get('confirm') == 'password-changed') { ?>
                    	<h4>Password Changed</h4>
                    	<p>Your password has now been changed, you can now login with your new password.</p>
                    <?php } else { ?>
                    <form action="" method="post">
                        <h4>Forgot Password</h4>
                        <p>Please enter your email address below to reset your password.</p>
                        <?php if(@$message) { ?>
                            <div class="alert alert-danger"><?php echo @$message; ?></div>
                        <?php } ?>
                        <div class="form-group">
                            <label>Email Address:</label>
                            <input type="text" class="form-control" name="user_emailaddress" value="<?php echo lib::post('user_emailaddress'); ?>" style="max-width:380px;"/>
                        </div>
                        <!-- <div class="form-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">Anti-Spam Check</div>
                                <div class="panel-body">
                                    <script src='https://www.google.com/recaptcha/api.js'></script>
                                    <div class="g-recaptcha" data-sitekey="<?php echo lib::getSetting('Security_CaptchaPublic'); ?>"></div>
                                </div>
                            </div>
                        </div> -->
                        <div class="form-group">
                            <input type="submit" class="btn btn-default" value="Reset Password" name="_resetpassword"/>
                        </div>
                    </form>
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
                    <h4>Create an Account FREE!</h4>
                    <p>Click the button below to create your account.</p>
                    <div class="form-group">
                        <a href="<?php echo DOMAIN; ?>/index.php?page=register" class="btn btn-default">Create An Account</a>
                    </div>
            	</div>
            </div>
        </div>
    </div>
</div>