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
    	<h4>Delete Category</h4>
        <p></p>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-body"> 
          <!-- PANEL START --> 
          
          <!--ERROR-->
          <?php if(isset($message)) { ?>
          	<div class="alert alert-danger" id="advert-error"><?php echo $message; ?></div>
          <?php } ?>
          
          <!-- PANEL END --> 
        </div>
      </div>
    </div>
  </div>
</div>
