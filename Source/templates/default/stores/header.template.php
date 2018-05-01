<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $store['store_title']; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content=""/>
<link rel="canonical" href="<?php echo DOMAIN; ?>/stores/<?php echo $store['store_username']; ?>" />
<meta property="og:locale" content="en_US" />
<meta property="og:type" content="website" />
<meta property="og:title" content="<?php echo $store['store_title']; ?>" />
<meta property="og:description" content="<?php echo $store['store_title']; ?>" />
<meta property="og:url" content="<?php echo DOMAIN; ?>" />
<meta property="og:site_name" content="<?php echo $store['store_title']; ?>" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:description" content="<?php echo $store['store_title']; ?>" />
<meta name="twitter:title" content="<?php echo $store['store_title']; ?>" />
<meta name="google-site-verification" content="<?php echo $store['store_title']; ?>" />

<!-- BOOTSTRAP -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">

<!-- Placed at the end of the document so the pages load faster -->
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<!-- JCAROUSEL -->
<script src="<?php echo DOMAIN; ?>/templates/default/javascript/jcarousel/jquery.jcarousel.min.js"></script>
<script src="<?php echo DOMAIN; ?>/templates/default/javascript/jcarousel/jcarousel.responsive.js"></script>
<!-- Go to www.addthis.com/dashboard to customize your tools -->

<!-- <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-58c44f7d6d5aadd2"></script> -->
<script src="<?php echo DOMAIN; ?>/templates/default/javascript/image-picker/image-picker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo DOMAIN; ?>/templates/default/javascript/image-picker/image-picker.css"/>

<!-- STYLESHEET -->
<link rel="stylesheet" type="text/css" href="<?php echo DOMAIN; ?>/templates/default/stores/stylesheet.css"/>

<!--VIEWPORT-->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
<?php
	function cssvalue($var, $property, $store) {
				
		//Switch Return
		switch($var) {
			case 'menu-color': {
				return $property.':#'.$store['store_menu_color'].';';
				break;	
			}
			case 'item-background-active': {
				return $property.':#'.$store['store_item_background_active'].';';
				break;
			}
			case 'item-font-color-active': {
				return $property.':#'.$store['store_item_font_color_active'].';';
				break;	
			}
			case 'item-font-color-normal': {
				return $property.':#'.$store['store_item_font_color_normal'].';';
				break;	
			}
		}
				
	}
?>
<style type="text/css">
	
	/* Navbar */
	.navbar-default .navbar-brand {
    	color: rgba(119, 119, 119, 1);
	}
	.navbar-default {
		font-size: 14px;
		<?php echo cssvalue('menu-color','background-color', $store); ?>
		background-image:none;
		border-width: 1px;
		border-radius: 4px;
	}
	.navbar-default .navbar-nav>li>a {
		<?php echo cssvalue('item-font-color-normal','color', $store); ?>
		background:none;
		background-image:none;
	}
	.navbar-default .navbar-nav>li>a:hover,
	.navbar-default .navbar-nav>li>a:focus {
		<?php echo cssvalue('item-font-color-active','color', $store); ?>
		<?php echo cssvalue('item-background-active','background-color', $store); ?>
		background-image:none;
	}
	.navbar-default .navbar-nav>.active>a,
	.navbar-default .navbar-nav>.active>a:hover,
	.navbar-default .navbar-nav>.active>a:focus {
		<?php echo cssvalue('item-font-color-active','color', $store); ?>
		<?php echo cssvalue('item-background-active','background-color', $store); ?>
		background-image:none;
		box-shadow: none;
	}
	.navbar-default .navbar-toggle {
		border-color: #ddd;
	}
	.navbar-default .navbar-toggle:hover,
	.navbar-default .navbar-toggle:focus {
		<?php echo cssvalue('item-background-active','background-color', $store); ?>
		background-image:none;
	}
	.navbar-default .navbar-toggle .icon-bar {
		background-color: #888;
		background-image:none;
	}
	.navbar-default .navbar-toggle:hover .icon-bar,
	.navbar-default .navbar-toggle:focus .icon-bar {
		<?php echo cssvalue('item-background-active','background-color', $store); ?>
		background-image:none;
	}
	
	/* Panel Heading */
	.panel-default>.panel-heading {
		background-image: none;
		background-color: rgba(248, 248, 248, 1);
	}
	
	/*Buttons*/
	.btn-default {
		text-shadow:none;
		background-image: none;
		border-color: #dbdbdb;
		box-shadow:none;
		<?php echo cssvalue('item-font-color-active','color', $store); ?>
		<?php echo cssvalue('item-background-active','background-color', $store); ?>
		<?php echo cssvalue('item-background-active','border-color', $store); ?>
	}
	
	/* Footer */
	#footer {
		<?php echo cssvalue('menu-color','background-color', $store); ?>	
	}
	
	/* Pagination (Inactive) */
	.pagination > li > a:link, li>a:active, li>a:visited {
		text-shadow:none;
		background-image: none;
		border-color: #dbdbdb;
		box-shadow:none;
		<?php echo cssvalue('item-font-color-active','color', $store); ?>
		<?php echo cssvalue('item-background-active','background-color', $store); ?>
		<?php echo cssvalue('item-background-active','border-color', $store); ?>
	}
	.pagination > li > a:hover {
		text-shadow:none;
		background-image: none;
		border-color: #dbdbdb;
		box-shadow:none;
		<?php echo cssvalue('item-font-color-active','color', $store); ?>
		<?php echo cssvalue('item-background-active','background-color', $store); ?>
		<?php echo cssvalue('item-background-active','border-color', $store); ?>
	}
	/* Pagination (Active) */
	.pagination .active>a:link, .active>a:active, .active>a:visited {
		text-shadow:none;
		background-image: none;
		border-color: #dbdbdb;
		box-shadow:none;
		<?php echo cssvalue('item-font-color-active','color', $store); ?>
		<?php echo cssvalue('item-background-active','background-color', $store); ?>
		<?php echo cssvalue('item-background-active','border-color', $store); ?>
	}
	.pagination .active > a:hover {
		text-shadow:none;
		background-image: none;
		border-color: #dbdbdb;
		box-shadow:none;
		<?php echo cssvalue('item-font-color-active','color', $store); ?>
		<?php echo cssvalue('item-background-active','background-color', $store); ?>
		<?php echo cssvalue('item-background-active','border-color', $store); ?>
	}
	
	.bs-wizard > .bs-wizard-step {
		padding: 0;
		position: relative;
	}
	.bs-wizard > .bs-wizard-step + .bs-wizard-step {
	}
	.bs-wizard > .bs-wizard-step .bs-wizard-stepnum {
		color: #595959;
		font-size: 16px;
		margin-bottom: 5px;
	}
	.bs-wizard > .bs-wizard-step .bs-wizard-info {
		color: #999;
		font-size: 14px;
	}
	.bs-wizard > .bs-wizard-step > .bs-wizard-dot {
		position: absolute;
		width: 30px;
		height: 30px;
		display: block;
		<?php echo cssvalue('menu-color','background-color', $store); ?>
		top: 45px;
		left: 50%;
		margin-top: -15px;
		margin-left: -15px;
		border-radius: 50%;
	}
	.bs-wizard > .bs-wizard-step > .bs-wizard-dot:after {
		content: ' ';
		width: 14px;
		height: 14px;
		background: #FFF;
		border-radius: 50px;
		position: absolute;
		top: 8px;
		left: 8px;
	}
	.bs-wizard > .bs-wizard-step > .progress {
		position: relative;
		border-radius: 0px;
		height: 8px;
		box-shadow: none;
		margin: 20px 0;
	}
	.bs-wizard > .bs-wizard-step > .progress > .progress-bar {
		width: 0px;
		box-shadow: none;
		background: #d65454;
	}
	.bs-wizard > .bs-wizard-step.complete > .progress > .progress-bar {
		width: 100%;
	}
	.bs-wizard > .bs-wizard-step.active > .progress > .progress-bar {
		width: 50%;
	}
	.bs-wizard > .bs-wizard-step:first-child.active > .progress > .progress-bar {
		width: 0%;
	}
	.bs-wizard > .bs-wizard-step:last-child.active > .progress > .progress-bar {
		width: 100%;
	}
	.bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot {
		background-color: #f5f5f5;
	}
	.bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot:after {
		opacity: 0;
	}
	.bs-wizard > .bs-wizard-step:first-child > .progress {
		left: 50%;
		width: 50%;
	}
	.bs-wizard > .bs-wizard-step:last-child > .progress {
		width: 50%;
	}
	.bs-wizard > .bs-wizard-step.disabled a.bs-wizard-dot {
		pointer-events: none;
	}
	
</style>

<!--CONTAINER-->
<div class="container">
  <div class="row" id="top">
    <div class="col-sm-12">
      <ul class="pull-right">
        <li><a href="#">Visit SaveMari.com</a></li>
        <?php if(session::active()) { ?>
        <li><a href="#">Add Products</a></li>
        <?php } else { ?>
        <li><a href="#">Login</a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="row" id="header">
    <div class="col-sm-6" id="header-logo">
      <?php
				if(isset($store['store_logo']) && $store['store_logo'] != '') {
					echo '<a href="'.DOMAIN.'/index.php?stores='.$store['store_username'].'"><img src="'.DOMAIN.'/uploads/store_images/'.@$store['store_logo'].'" alt="" style="max-height:150px;max-width:250px;"></a>';	
				} else {
					echo '<a href="#"><img src="'.DOMAIN.'/templates/default/images/stores/250x100defaultlogo.jpg" alt=""></a>';				
				}
			?>
    </div>
    <div class="col-sm-6">
      <div class="row" id="header-brand">
        <div class="col-sm-12">
          <p><a href="<?php echo DOMAIN; ?>"><img src="<?php echo DOMAIN; ?>/templates/default/images/stores/225x25brandlogo.png" alt=""></a></p>
        </div>
      </div>
      <div class="row" id="header-social">
        <div class="col-sm-12">
          <ul>
            <li><a href="<?php echo $store['store_sm_facebook']; ?>"><img src="<?php echo DOMAIN; ?>/templates/default/images/stores/Facebook.png" width="32" height="32" /></a></li>
            <li><a href="<?php echo $store['store_sm_google']; ?>"><img src="<?php echo DOMAIN; ?>/templates/default/images/stores/Google.png" width="32" height="32" /></a></li>
            <li><a href="<?php echo $store['store_sm_twitter']; ?>"><img src="<?php echo DOMAIN; ?>/templates/default/images/stores/Twitter.png" width="32" height="32" /></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- MENU -->
<div class="container" id="menu">
  <nav class="navbar navbar-default"> 
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
    </div>
    
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li <?php if(!lib::get('page')) { echo 'class="active"'; } ?>><a href="<?php echo DOMAIN; ?>/stores/<?php echo $store['store_username']; ?>">Homepage <span class="sr-only">(current)</span></a></li>
        <li <?php if(lib::get('page') == 'products') { echo 'class="active"'; } ?>><a href="<?php echo DOMAIN; ?>/index.php?stores=<?php echo $store['store_username']; ?>&page=products">Products</a></li>
        <li <?php if(lib::get('page') == 'products') { echo 'class="active"'; } ?>><a href="<?php echo DOMAIN; ?>/index.php?stores=<?php echo $store['store_username']; ?>&page=reviews">Reviews</a></li>
      </ul>
      <form class="navbar-form navbar-left" method="post" action="<?php echo STORE_URL; ?>&page=products">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search" name="search_query">
        </div>
        <div class="form-group">
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
        <input type="hidden" name="filter" value="1">
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li <?php if(lib::get('page') == 'aboutus') { echo 'class="active"'; } ?>><a href="<?php echo DOMAIN; ?>/index.php?stores=<?php echo $store['store_username']; ?>&page=aboutus">About Us</a></li>
        <li <?php if(lib::get('page') == 'contactus') { echo 'class="active"'; } ?>><a href="<?php echo DOMAIN; ?>/index.php?stores=<?php echo $store['store_username']; ?>&page=contactus">Contact Us</a></li>
      </ul>
    </div>
    <!-- /.navbar-collapse --> 
  </nav>
</div>
<!-- /.container-fluid -->