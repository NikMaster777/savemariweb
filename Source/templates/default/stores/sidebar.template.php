<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/
if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
?>

<div class="panel panel-default">
  <div class="panel-heading"><span class="glyphicon glyphicon-search"></span> Search</div>
  <div class="panel-body">
    <form method="post" action="<?php echo STORE_URL; ?>&page=products">
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Search" name="search_query">
      </div>
      <div class="form-group">
        <label>Category</label>
        <select name="product_catid" id="product_catid" class="form-control">
          <option value="">-- All Categories --</option>
          <?php if(db::nRows("SELECT `cat_id`,`cat_storeid` FROM `".config::$db_prefix."store_categories` WHERE `cat_storeid`='".$store['store_id']."'") > 0) { ?>
          <?php 
			  $catSQL = db::query("SELECT `cat_name`,`cat_id` FROM `".config::$db_prefix."store_categories` WHERE `cat_storeid`='".$store['store_id']."'"); 
			  while($catData = db::fetch($catSQL)) { 
		  ?>
          <option value="<?php echo $catData['cat_id']; ?>"><?php echo lib::san($catData['cat_name']); ?></option>
          <?php } ?>
          <?php } else { ?>
          <option value="">-- No Categories --</option>
          <?php } ?>
        </select>
      </div>
      <div class="form-group">
        <input type="hidden" name="filter" value="1">
        <button type="submit" class="btn btn-default">Submit</button>
      </div>
    </form>
  </div>
</div>
