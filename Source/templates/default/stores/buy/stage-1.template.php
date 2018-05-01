<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
?>

<div class="container" id="content">
	<div class="row">
    	<div class="col-sm-12">
            <?php require(ROOT.'/templates/default/stores/buy/progressbar.template.php'); ?>
        </div>
    </div>
    <div class="row">
    	<div class="col-sm-12">
        	
            <hr />
            
            <?php if(@$message) { ?><div class="alert alert-danger"><?php echo $message; ?></div><?php } ?>            
            
            <!-- STAGE 1 -->
            <div id="stage1">
            	
                <form action="" method="post">
            	<input type="hidden" name="product_id" value="<?php echo lib::get('product_id'); ?>">
                <div class="panel panel-default" id="payment-methods">
                    <div class="panel-heading">Your details</div>
                    <div class="panel-body">
                    
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" class="form-control" value="" name="user_firstname">
                        </div>
                        
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" class="form-control" value="" name="user_lastname">
                        </div>
                        
                        <div class="form-group">
                            <label>Address 1</label>
                            <input type="text" class="form-control" value="" name="user_address1">
                        </div>
                        
                        <div class="form-group">
                            <label>Address 2</label>
                            <input type="text" class="form-control" value="" name="user_address2">
                        </div>
                                                
                        <div class="form-group">
                            <label>Zip/Postcode</label>
                            <input type="text" class="form-control" value="" name="user_postcode">
                        </div>
                        
                        <div class="form-group">
                            <label>Email Address:</label>
                            <input type="text" class="form-control" value="" name="user_email">
                        </div>
                        
                        <div class="form-group">
                            <label>Mobile/Cell Number:</label>
                            <input type="text" class="form-control" value="" name="user_mobile">
                        </div>
                                                                                                                        
                   </div>
                </div>   
                                
                <div class="panel panel-default" id="payment-methods">
                    <div class="panel-heading">Choose a payment method</div>
                    <div class="panel-body">
                        <script type="text/javascript">$(document).ready(function() {$(".image-picker").imagepicker();});</script>
                        <select class="image-picker show-html" name="payment_method">
                          <option value=""></option>
                          <option data-img-src="<?php echo DOMAIN; ?>/templates/default/images/icons/paypal-logo.png" value="1"></option>
                          <option data-img-src="<?php echo DOMAIN; ?>/templates/default/images/icons/paynow-logo.png" value="2"></option>
                          <option data-img-src="<?php echo DOMAIN; ?>/templates/default/images/icons/bank-logo.png" value="3"></option>
                        </select>
                    </div>
                </div>
                <div class="pull-right">
                    <div class="form-group">
                        <input type="submit" class="btn btn-default" value="Make a Payment" name="_stage-1-submit"/>
                    </div>
                </div>
                </form>
                
            </div>
                
        </div>
    </div>
</div>