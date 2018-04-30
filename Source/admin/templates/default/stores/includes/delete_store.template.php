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
    	<div class="col-sm-12 left">
        	<h3>Are you sure, this will delete everything!</h3>
            <p>Using this button will remove, products, product images, invoices and anything else assciated with this store!</p>
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
            
            <div class="form-group pull-left">
              <input type="hidden" name="store_id" value="<?php echo lib::get('store_id'); ?>" />
              <input type="submit" class="btn btn-danger" name="_delete-store" value="Delete Store"/>
            </div>
            
        	</form>
                                         
        </div>
    </div>
</div>