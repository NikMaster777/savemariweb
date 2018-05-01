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
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-body">
        	<h4>Great News! - Your store has been created!</h4>
            <p>Your store will be available shortly inside your dashboard, If you have not yet made a payment via Bank transfer, please do that now using the reference number below.</p>
            <br />
            <h4>Paying via Bank Transfer? Pay Now!</h4>
            <p>If your making a payment via bank transfer please send a payment to the following account number below. Use your account username as a reference.</p>
                        
            <ul class="list-group">
              <li class="list-group-item">Reference: <?php echo session::data('user_username',false,true,true); ?></li>
              <li class="list-group-item">Account Number: USD0RD00024100</li>
            </ul>

            <div class="pull-left">          
                <a href="<?php echo DOMAIN; ?>/index.php?page=dashboard" class="btn btn-default">Back to Dashboard</a>
            </div>
        </div>
      </div>
    </div>
 </div>
</div>