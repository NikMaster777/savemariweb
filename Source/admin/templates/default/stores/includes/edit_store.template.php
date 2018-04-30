<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Creative Miles
 *@Start: 12th June 2016
*/
if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
?><div class="container content-wrapper">
	<div class="row header-row">
    	<div class="col-sm-6 left">
        	<h3>Edit Store</h3>
        </div>
        <div class="col-sm-6 right">
        	<div class="form-group">
                
            </div>
        </div>
    </div>
    <?php if(@$message) { ?>
    <div class="row">
    	<div class="col-sm-12">
            <div class="alert alert-danger">
                <span class="glyphicon glyphicon-exclamation-sign"></span> <?php echo $message; ?>
            </div> 
        </div>
    </div>
    <?php } ?>
    <div class="row">
    	<div class="col-sm-12">
        	
            <form action="" method="post">
    
            <div class="form-group">
              <label>Store Username: </label>
              <input type="text" class="form-control" name="store_username" value="https://www.savemari.com/store/<?php echo rememberMe($store, 'store_username','store_username'); ?>" placeholder="" disabled/>
            </div>
            
            <div class="form-group">
              <label>Store Title:</label>
              <input type="text" class="form-control" name="store_title" value="<?php echo rememberMe($store, 'store_title','store_title'); ?>" placeholder="Store Name"/>
            </div>
            
            <div class="form-group">
              <label>Store Description:</label>
              <textarea type="text" class="form-control" name="store_description" rows="4" cols="0" placeholder="Store Description"/><?php echo rememberMe($store, 'store_description','store_description'); ?></textarea>
            </div>
            
            <div class="form-group">
              <label>Store Keywords:</label>
              <textarea type="text" class="form-control" name="store_keywords" rows="4" cols="0" placeholder="e.g. cars, car parts, wheels"/><?php echo rememberMe($store, 'store_keywords','store_keywords'); ?></textarea>
            </div>
            
            <div class="form-group">
              <label>Store About Us:</label>
              <textarea type="text" class="form-control" name="store_aboutus" rows="4" cols="0" placeholder="We started in early 2007 designing a fantastic range of clothing for all customers. We take provide in our products and want you to enjoy them as much as we enjoyed creating them."/><?php echo rememberMe($store, 'store_aboutus','store_aboutus'); ?></textarea>
            </div>
            
            <h4>Contact Information <small>This will be used when customers need to contact you.</small></h4>
            
            <div class="form-group">
              <label>Email:</label>
              <input type="text" class="form-control" name="store_email" value="<?php echo rememberMe($store, 'store_email','store_email'); ?>" placeholder="sales@domain.co.uk"/>
            </div>
            <div class="form-group">
              <label>Address: (This will be displayed on the contact page)</label>
              <textarea type="text" class="form-control" name="store_address" rows="4" cols="0" placeholder="My Company Name
        1234 Some Street
        Cool City, Somewhere 12345"/><?php echo rememberMe($store, 'store_address','store_address'); ?></textarea>
            </div>
            
            <div class="form-group">
              <label>Phone Number: (This will be displayed on the contact page)</label>
              <input type="text" class="form-control" name="store_phone" value="<?php echo rememberMe($store, 'store_phone','store_phone'); ?>" placeholder="+4407876567876"/>
            </div>
            
            <h4>Social Media <small>This will be displayed on the website header.</small></h4>
            <div class="form-group">
              <label>Twitter URL:</label>
              <input type="text" class="form-control" name="store_twitter" value="<?php echo rememberMe($store, 'store_twitter','store_twitter'); ?>" placeholder="https://www.twitter.com/name"/>
            </div>                  
        
            <div class="form-group">
              <label>Facbeook URL:</label>
              <input type="text" class="form-control" name="store_facebook" value="<?php echo rememberMe($store, 'store_facebook','store_facebook'); ?>" placeholder="https://www.facebook.com/name"/>
            </div>
            <div class="form-group">
              <label>Google URL:</label>
              <input type="text" class="form-control" name="store_google" value="<?php echo rememberMe($store, 'store_google','store_google'); ?>" placeholder="http://www.google.com/business/name"/>
            </div>
            
            <h4>Payment Details <small>Please provide payment details such as <b>PayNow</b>, <b>Bank Sort Code and Account Number</b> or <b>PayPal</b></small></h4>
            
            <div class="form-group">
                <textarea class="form-control" name="store_paymentmethod"><?php echo rememberMe($store, 'store_paymentmethod','store_paymentmethod'); ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Store Activated</label>
                <select name="store_activated" class="form-control">
                	<option value="1" <?php if(rememberMe($store, 'store_activated','store_activated') == 1) { echo 'selected="selected"';} ?>>Yes, Store Activated</option>
                    <option value="0" <?php if(rememberMe($store, 'store_activated','store_activated') == 0) { echo 'selected="selected"';} ?>>No, Store Deactivated</option>
                </select>
            </div>
            
            <div class="form-group pull-right">
              <input type="hidden" name="store_id" value="<?php echo lib::get('store_id'); ?>" />
              <input type="submit" class="btn btn-default" name="_edit-store" value="Edit Store"/>
            </div>
            
        
        </form>
            
            
                                   
        </div>
    </div>
</div>