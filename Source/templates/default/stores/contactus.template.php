<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }

//@Contact Form
if(lib::post('_submit')) {
	
	//A place to store errors;
	$errorsArray = array();
	
	//Do we have a fullname?
	if(!lib::post('_fullname')) { $errorsArray[] = 'Please enter your full name below.'; }
	if(strlen(lib::post('_fullname')) > 255) { $errorsArray[] = 'Your full name is more than 255 characters long, please shorten it.'; }
	if(!lib::post('_emailaddress')) { $errorsArray[] = 'Please enter your email address.'; }
	if(strlen(lib::post('_emailaddress')) > 255) { $errorsArray[] = 'Your email address is more than 255 characters long, please shorten it.'; }
	if(!filter_var(lib::post('_emailaddress'), FILTER_VALIDATE_EMAIL)) { $errorsArray[] = 'Please enter a valid email address to continue.'; }
	if(!lib::post('_subject')) { $errorsArray[] = 'Please enter your subject below.'; }
	if(strlen(lib::post('_subject')) > 255) { $errorsArray[] = 'Your subject is more than 255 characters long, please shorten it.'; }
	if(!lib::post('_message')) { $errorsArray[] = 'Please enter your message below.'; }
	if(strlen(lib::post('_message')) > 1500) { $errorsArray[] = 'Your message is more than 1500 characters long, please shorten it.'; }
	
	//Do we have any errors?
	if(count($errorsArray)) {
		$message = $errorsArray[0];
	} else {
		if(@$store['store_email']) {
			@mail($store['store_email'], 'You have a new message from your SaveMari.com Store', strip_tags(lib::post('_message')), 'From: SaveMari <no-reply@savemari.com>');
			$success = true;
		} else {
			$message = 'The store owner has not yet configured an email address.';	
		}
	}		
}

?>
<div class="container" id="content">
	<div class="row">
    	<div class="col-sm-6">
        	<h4>Contact Us</h4>
            <p>Please fill out the contact form below to contact the store owner directly.</p>
            <?php if(@$message) { echo '<div class="alert alert-danger">'.$message.'</div>'; } else { if(@$success) { echo '<div class="alert alert-danger">Your message was sent to the store owner.</div>'; } }?>
            <form action="" method="post">
                <div class="form-group">
                    <label>Full Name:</label>
                    <input type="text" name="_fullname" value="" placeholder="" class="form-control">
                </div> 
                <div class="form-group">
                    <label>Your Email:</label>
                    <input type="text" name="_emailaddress" value="" placeholder="" class="form-control">
                </div>      	
                <div class="form-group">
                    <label>Subject:</label>
                    <input type="text" name="_subject" value="" placeholder="" class="form-control">
                </div>
                <div class="form-group">
                    <label>Message:</label>
                    <textarea cols="" rows="8" class="form-control" name="_message"></textarea>
                </div>
                <div class="form-group">
                    <input type="submit" name="_submit" value="Send Message" class="btn btn-default">
                </div>
            </form>
        </div>
    	<div class="col-sm-6">
        	<h4>Address</h4>
            <p><?php if($store['store_address']) { echo lib::san($store['store_address']).'<br />'; } ?>
			<?php if($store['store_email']) { echo lib::san($store['store_email']).'<br />'; } ?>
			<?php if($store['store_phone']) { echo lib::san($store['store_phone']).'<br />'; } ?></p>
        </div>
    </div>
</div>