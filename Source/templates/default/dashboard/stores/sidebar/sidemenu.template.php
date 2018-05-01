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
  <div class="panel-heading"><p>Main Menu</p></div>
  <div class="panel-body">
    <ul class="nav nav-pills nav-stacked dashboard-sidebar">
      <li <?php if(!lib::get('option')) { echo 'class="active"'; } ?>><a href="<?php echo DOMAIN; ?>/index.php?page=dashboard&view=store&action=manage">Dashboard</a></li>
      <li <?php if(lib::get('option') == 'manage-products') { echo 'class="active"'; } ?>><a href="<?php echo DOMAIN; ?>/index.php?page=dashboard&view=store&action=manage&option=manage-products">Manage Products</a></li>
      <li <?php if(lib::get('option') == 'custom-fields') { echo 'class="active"'; } ?>><a href="<?php echo DOMAIN; ?>/index.php?page=dashboard&view=store&action=manage&option=custom-fields">Custom Fields</a></li>
      <li <?php if(lib::get('option') == 'categories') { echo 'class="active"'; } ?>><a href="<?php echo DOMAIN; ?>/index.php?page=dashboard&view=store&action=manage&option=categories">Manage Categories</a></li>
      <li <?php if(lib::get('option') == 'redeem') { echo 'class="active"'; } ?>><a href="<?php echo DOMAIN; ?>/index.php?page=dashboard&view=store&action=manage&option=redeem">Redeem Code</a></li>
    </ul>
  </div>
</div>

<div class="panel with-nav-tabs panel-default">
  <div class="panel-heading"><p>Store Settings</p></div>
  <div class="panel-body">
    <ul class="nav nav-pills nav-stacked dashboard-sidebar">
      <li <?php if(lib::get('option') == 'edit-store') { echo 'class="active"'; } ?>><a href="<?php echo DOMAIN; ?>/index.php?page=dashboard&view=store&action=manage&option=edit-store">Edit Store</a></li>
      <li <?php if(lib::get('option') == 'edit-banners') { echo 'class="active"'; } ?>><a href="<?php echo DOMAIN; ?>/index.php?page=dashboard&view=store&action=manage&option=edit-banners">Edit Banners</a></li>
      <li <?php if(lib::get('option') == 'edit-colors') { echo 'class="active"'; } ?>><a href="<?php echo DOMAIN; ?>/index.php?page=dashboard&view=store&action=manage&option=edit-colors">Edit Colors</a></li>
      <li <?php if(lib::get('option') == 'edit-logo') { echo 'class="active"'; } ?>><a href="<?php echo DOMAIN; ?>/index.php?page=dashboard&view=store&action=manage&option=edit-logo">Edit Logo</a></li>
    </ul>
  </div>
</div>