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
        	
            <h4>Great News, you bought an item from this store!</h4>
            <p>If you have not yet made a payment via Bank transfer, please do that now using the reference number below.</p>
            <h4>Paying via Bank Transfer? Pay Now!</h4>
            <p>If your making a payment via bank transfer please send a payment to the following account number below. Use your account username as a reference.</p>
                        
            <ul class="list-group">
              <li class="list-group-item">Reference: <?php echo substr(lib::get('reference',false,true,true),0,10); ?></li>
              <li class="list-group-item">Account Number: USD0RD00024100</li>
            </ul>
			            
        </div>
    </div>
</div>