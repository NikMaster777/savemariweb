<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
?>

<div class="panel with-nav-tabs panel-default">
  <div class="panel-heading"><p>Selling</p></div>
  <div class="panel-body">
    <ul class="nav nav-pills nav-stacked dashboard-sidebar">
      <li <?php if(!lib::get('option')) { echo 'class="active"'; } ?>><a href="<?php echo DOMAIN; ?>/index.php?page=dashboard">All Selling</a></li>
      <li <?php if(lib::get('option') == 'featured-listings') { echo 'class="active"'; } ?>><a href="<?php echo DOMAIN; ?>/index.php?page=dashboard&option=featured-listings">Featured Listings</a></li>
      <li <?php if(lib::get('option') == 'sponsered-listings') { echo 'class="active"'; } ?>><a href="<?php echo DOMAIN; ?>/index.php?page=dashboard&option=sponsered-listings">Sponsered Listings </a></li>
    </ul>
  </div>
</div>

<div class="panel with-nav-tabs panel-default">
  <div class="panel-heading"><p>My Account</p></div>
  <div class="panel-body">
    <ul class="nav nav-pills nav-stacked dashboard-sidebar">
      <li <?php if(lib::get('option') == 'edit-profile') { echo 'class="active"'; } ?>><a href="<?php echo DOMAIN; ?>/index.php?page=dashboard&option=edit-profile">Edit Profile</a></li>
      <li <?php if(lib::get('option') == 'change-password') { echo 'class="active"'; } ?>><a href="<?php echo DOMAIN; ?>/index.php?page=dashboard&option=change-password">Change Password</a></li>
    </ul>
  </div>
</div>