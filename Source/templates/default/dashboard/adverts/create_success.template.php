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
        	<h4>Great News! - It's almost ready to go live!</h4>
            <p>Your advert has been successfuly submitted, the system administrator has choosen to review all adverts before they go live! Don't worry it will only be a short while. If you have choosen to make a payment via bank transfer please follow the instructions below.</p>
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