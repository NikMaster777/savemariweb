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
    	<div class="col-sm-6">
        </div>
        <div class="col-sm-6">
            <div class="clearfix">
            	
                <!--PAGINATE
            	<?php if(in_array(lib::get('option'), array('featured-listings','sponsered-listings')) | lib::get('option') == '') { ?>
                <ul class="pagination pull-right">
                    <?php echo $paginate->renderPages(); ?>
                </ul>
                <?php } ?>-->
                
            </div>
        </div>
    </div>
        
    <div class="row">
    	<div class="col-sm-3">
        	
            <!--PANEL-->
            <div class="panel panel-default">
            	<div class="panel-heading">Filter Results</div>
            	<div class="panel-body">
                	
                    <form action="<?php echo DOMAIN; ?>" method="get">
            		<input type="hidden" name="page" value="search" />
                    <div class="form-group">
                    <input type="hidden" name="query" value="<?php echo lib::get('query'); ?>" />
                    <input type="hidden" name="sidefilter" value="1" />
                    <select name="city" id="user_city" class="form-control">
                        <option class="" value="">Select City/Town</option>
                        <?php foreach($cities AS $city_id => $city_name) { ?>
                            <option value="<?php echo $city_id; ?>" <?php if(lib::get('city') == $city_id) { echo 'selected';} ?>><?php echo $city_name; ?></option>
                        <?php } ?>
                    </select>
                    </div>
                    
                    <div class="form-group">
                         <select name="category" id="user_cat" class="form-control">
                                <option value="">Select Category</option>
                                <?php foreach($categories AS $key => $parent) { ?>
                                <option value="<?php echo lib::san($parent['cat_id']); ?>" <?php if(lib::get('category') == $parent['cat_id']) { echo 'selected';} ?>><?php echo lib::san($parent['cat_name']); ?></option>
                                <!-- <?php foreach($parent['cat_child'] AS $child_key => $child) { ?>
                                <option value="<?php echo lib::san($child['cat_id']); ?>" <?php if(lib::get('category') == $child['cat_id']) { echo 'selected';} ?>>- <?php echo lib::san($child['cat_name']); ?></option>	
                                <?php } ?> -->
                            <?php } ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                    	<input class="btn btn-default" type="submit" id="search_button" value="Filter" name="">
                    </div>
                    </form>
                    
                </div>
             </div>
            
        	<?php if(@lib::get('category')) { ?>
        	<div class="panel with-nav-tabs panel-default">
              <div class="panel-heading"><p>Sub Categories</p></div>
              <div class="panel-body">
                <ul class="nav nav-pills nav-stacked dashboard-sidebar">
                  <?php $catSQL = db::query("SELECT * FROM `".config::$db_prefix."categories` WHERE `cat_parentid`='".db::mss($cat_id)."'"); 
				  while($catData = db::fetch($catSQL)) { ?>
                  <li><a href="<?php echo DOMAIN; ?>/index.php?<?php echo preg_replace('/\&subcat\=(.*)/', '', $_SERVER['QUERY_STRING']); ?>&subcat=<?php echo $catData['cat_id']; ?>"><?php echo $catData['cat_name']; ?></a></li>
                  <?php } ?>
                </ul>
              </div>
            </div>
            <?php } else { ?>
            <div class="panel with-nav-tabs panel-default">
              <div class="panel-heading"><p>Categories</p></div>
              <div class="panel-body">
                <ul class="nav nav-pills nav-stacked dashboard-sidebar">
                  <?php $catSQL = db::query("SELECT * FROM `".config::$db_prefix."categories` WHERE `cat_parentid`='0'"); 
				  while($catData = db::fetch($catSQL)) { ?>
                  <li><a href="<?php echo DOMAIN; ?>/index.php?<?php echo preg_replace('/\&category\=(.*)/', '', $_SERVER['QUERY_STRING']); ?>&category=<?php echo $catData['cat_id']; ?>"><?php echo $catData['cat_name']; ?></a></li>
                  <?php } ?>
                </ul>
              </div>
            </div>
            <?php } ?>
            
        </div>
        <div class="col-sm-9">
        
        	<!--CONTENT-->
            <div class="panel panel-default">
              <div class="panel-body">
  			  	<?php require(ROOT.'/templates/default/listing_search.template.php'); ?>
              </div>
            </div>
            
            <!--PAGINATE-->
            <?php if(in_array(lib::get('option'), array('featured-listings','sponsered-listings')) | lib::get('option') == '') { ?>
            <ul class="pagination pull-right">
				<?php echo $paginate->renderPages(); ?>
            </ul>
            <?php } ?>
            
        </div>
        
        
    </div>
    
</div>

