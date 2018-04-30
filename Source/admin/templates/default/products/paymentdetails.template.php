<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Creative Miles
 *@Start: 12th June 2016
*/
if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
?>
<div class="container content-wrapper">
	<div class="row header-row">
    	<div class="col-sm-6 left">
        	<h3>Payment Details</h3>
            <p>Make a payment to the store owner, once done mark this product as paid.</p>
        </div>
        <div class="col-sm-6 right">
        	<div class="form-group">
                
            </div>
        </div>
    </div>
    <div class="row">
    	<div class="col-sm-12">
            <form action="" method="post">
                <div class="form-group">
                    <label>Payment Details</label>
                    <textarea name="" class="form-control"><?php echo lib::san($storeData['store_paymentmethod']); ?></textarea>    
                </div>     
                <div class="form-group">
                	<input type="hidden" name="product_id" value="<?php echo lib::get('advert_id'); ?>" class="btn btn-success"/>
                    <input type="submit" name="_mark-paid" value="Mark Paid" class="btn btn-success"/>  
                </div>   
            </form>        
        </div>
    </div>
    <div class="row footer-row">
    	<div class="col-sm-4 left"></div>
    	<div class="col-sm-8 right">
        	
        </div>
    </div>
</div>