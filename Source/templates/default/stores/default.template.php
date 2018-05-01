<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
?>

<!--CAROUSEL-->
<div class="container" id="homepage-carousel">
 	
    <!--CAROUSEL-->
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      
      <!-- Indicators
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol> -->
      
      <!-- Wrapper for slides -->
      <div class="carousel-inner">
      	<?php 
			$image_active = 0;
			$bannerSQL = "SELECT * FROM `".config::$db_prefix."store_banners` WHERE `banner_storeid`='".$store['store_id']."'"; 
			if(db::nRows($bannerSQL) > 0)  {
				$bannerSQL = db::query("SELECT * FROM `".config::$db_prefix."store_banners` WHERE `banner_storeid`='".$store['store_id']."'");
				while($bannerData = db::fetch($bannerSQL)) { 
		?>
            <div class="item <?php if(!$image_active) { echo 'active'; $image_active=1;} ?>" style="max-height:360px;background-position:center;">
              <img src="<?php echo DOMAIN; ?>/uploads/store_images/<?php echo $bannerData['banner_image']; ?>" alt="">
            </div>
        <?php } } else { ?>
            <div class="item active">
              <img src="<?php echo DOMAIN; ?>/templates/default/images/stores/960x350defaultbanner.jpg" alt="">
            </div>
        <?php } ?>
        
      </div>
      
      <!-- Left and right controls -->
      <a class="left carousel-control" href="#myCarousel" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#myCarousel" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
    
</div>

<!--CONTENT-->	
<div class="container" id="content">
	<div class="row">
    	
    	<div class="col-sm-3">
            <?php require(ROOT.'/templates/default/stores/sidebar.template.php'); //Sidebar ?>
        </div>
                
        <div class="col-sm-9">
        	
            <!--ROW OF PRODUCTS -->
                <div class="row">
                
                    <?php 
					$SQLStatement = "SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_store`='1' AND `advert_storeid`='".$store['store_id']."' LIMIT 0,12";
					if(db::nRows($SQLStatement) > 0) { //Do we have records?
						$SQLQuery = db::query($SQLStatement); //Do we have query?
						while($SQLData = db::fetch($SQLQuery)) { //Fetch 
							require(ROOT.'/templates/default/stores/assets/product_template.template.php');
						} 
					} else {
                    	echo '<div class="alert alert-warning">You do not yet have any products for this store.</div>';
                    } 
					?>
                    
                </div>
            <!-- END OF ROW OF PRODUCTS -->
            
        </div>
    </div>
</div>

