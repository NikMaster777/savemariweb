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
                	<form action="" method="post">
                    <h4>Login</h4>
                    <p>Please complete the form below to create a free account. A confirmation email will be sent to verify your address.</p>
                    <?php if(@$message) { ?>
                    	<div class="alert alert-danger"><?php echo @$message; ?></div>
                    <?php } ?>
                    <div class="form-group">
                        <label>Email Address:</label>
                        <input type="text" class="form-control" name="user_emailaddress" value="<?php echo lib::post('user_emailaddress'); ?>"/>
                    </div>
                    <div class="form-group">
                        <label>Password:</label>
                        <input type="password" class="form-control" name="user_password" value="<?php echo lib::post('user_password'); ?>"/>
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
                    	<input type="submit" class="btn btn-default" value="Login" name="_submit"/>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
        	<div class="panel panel-default">
            	<div class="panel-body">
                    <h4>Create an Account FREE!</h4>
                    <p>Click the button below to create your account.</p>
                    <div class="form-group">
                        <a href="<?php echo DOMAIN; ?>/index.php?page=register" class="btn btn-default">Create An Account</a>
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