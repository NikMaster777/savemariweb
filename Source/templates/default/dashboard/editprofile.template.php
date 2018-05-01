<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
?>

<h4>Edit Profile</h4>
<p>Please use the form below to edit your profile.</p>
<?php if(@$message) { ?>
    <div class="alert alert-danger"><?php echo @$message; ?></div>
<?php } else { ?>
	<?php if(@$success) { ?>
    	<div class="alert alert-success">Your profile has been edited successfully.</div>
    <?php } ?>
<?php } ?>
<form action="" method="post">
	<div class="form-group">
    	<label>Firstname:</label>
        <input type="text" name="user_firstname" value="<?php echo rememberMe('user_firstname',true); ?>" class="form-control">    	
    </div>
    <div class="form-group">
    	<label>Lastname:</label>
        <input type="text" name="user_lastname" value="<?php echo rememberMe('user_lastname',true); ?>" class="form-control">    	
    </div>
    <div class="form-group">
    	<label>Email Address:</label>
        <input type="text" name="user_emailaddress" value="<?php echo rememberMe('user_emailaddress',true); ?>" class="form-control">    	
    </div>
    <div class="form-group">
    	<label>Address 1:</label>
        <input type="text" name="user_address1" value="<?php echo rememberMe('user_address1',true); ?>" class="form-control">    	
    </div>
    <div class="form-group">
    	<label>Address 2:</label>
        <input type="text" name="user_address2" value="<?php echo rememberMe('user_address2',true); ?>" class="form-control">    	
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
    	<label>State:</label>
        <input type="text" name="user_state" value="<?php echo rememberMe('user_state',true); ?>" class="form-control">    	
    </div>
    <div class="form-group">
    	<label>Areacode:</label>
        <input type="text" name="user_postcode" value="<?php echo rememberMe('user_postcode',true); ?>" class="form-control">    	
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
    	<label>Phone Number:</label>
        <input type="text" name="user_phone" value="<?php echo rememberMe('user_phone',true); ?>" class="form-control">    	
    </div>
    <div class="form-group">
    	<label>Mobile Number:</label>
        <input type="text" name="user_mobile" value="<?php echo rememberMe('user_mobile',true); ?>" class="form-control">    	
    </div>
    <div class="form-group">
    	<label>Whatsapp Number:</label>
        <input type="text" name="user_whatsapp" value="<?php echo rememberMe('user_whatsapp',true); ?>" class="form-control">    	
    </div>
    <div class="form-group">
    	<input type="submit" name="_submit" value="Edit Profile" class="btn btn-default">
    </div>
</form>