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
                	<?php if(lib::get('confirm') == 'activation-required') { ?>
					<h4>Activation Required</h4>
                    <p>We need to verify your email address before we can continue. Please check your emails containing the activation link to activate your account. <br ?><br ?>The email usually arrvies within 10 minutes or less.</p>
					<?php } else { ?>
                    <form action="" method="post">
                    <h4>Create an Account</h4>
                    <p>Please complete the form below to create a free account. A confirmation email will be sent to verify your address.</p>
                    <?php if(@$message) { ?>
                    	<div class="alert alert-danger"><?php echo @$message; ?></div>
                    <?php } ?>
                    <div class="form-group">
                        <label>First Name:</label>
                        <input type="text" class="form-control" name="user_firstname" value="<?php echo lib::post('user_firstname'); ?>"/>
                    </div>
                    <div class="form-group">
                        <label>Last Name:</label>
                        <input type="text" class="form-control" name="user_lastname" value="<?php echo lib::post('user_lastname'); ?>"/>
                    </div>
                    <div class="form-group">
                        <label>Username:</label>
                        <input type="text" class="form-control" name="user_username" value="<?php echo lib::post('user_username'); ?>"/>
                    </div>
                    <div class="form-group">
                        <label>Email Address:</label>
                        <input type="text" class="form-control" name="user_emailaddress" value="<?php echo lib::post('user_emailaddress'); ?>"/>
                    </div>
                    <div class="form-group">
                        <label>Password:</label>
                        <input type="password" class="form-control" name="user_password" value="<?php echo lib::post('user_password'); ?>"/>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password:</label>
                        <input type="password" class="form-control" name="user_password2" value="<?php echo lib::post('user_password2'); ?>"/>
                    </div>
                    <div class="form-group">
                        <label>Address 1:</label>
                        <input type="text" class="form-control" name="user_address1" value="<?php echo lib::post('user_address1'); ?>"/>
                    </div>
                    <div class="form-group">
                        <label>Address 2:</label>
                        <input type="text" class="form-control" name="user_address2" value="<?php echo lib::post('user_address2'); ?>"/>
                    </div>
                    <div class="form-group">
                        <label>Areacode:</label>
                        <input type="text" class="form-control" name="user_postcode" value="<?php echo lib::post('user_postcode'); ?>"/>
                    </div>
                    
                    <div class="form-group">
                        <label>City:</label>
                        <select name="user_city" class="form-control">
                            <?php foreach($cities AS $city_id => $city_name) { ?>
                                <option value="<?php echo $city_id; ?>"><?php echo $city_name; ?></option>
                            <?php } ?>
                         </select>  	
                    </div>
                    <div class="form-group">
                        <label>State/Region:</label>
                        <input type="text" class="form-control" name="user_state" value="<?php echo lib::post('user_state'); ?>"/>
                    </div>
                    <div class="form-group">
                        <label>Country:</label>
                        <select name="user_country" class="form-control">
                        	<?php foreach(lib::getCountries() AS $country_id => $country_name) { ?>
                        		<option value="<?php echo $country_id; ?>" <?php if($country_id == config::$default_country) { echo 'selected="selected"'; } ?>><?php echo $country_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                    	<span><input type="checkbox" name="user_terms" value="1"/> I accept the <a href="#">Terms and Conditions</a></span>
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
                    	<input type="submit" class="btn btn-default" value="Create Account" name="_submit"/>
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