<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/
if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
?>

<!--HOMEPAGE BANNER TOP -->

<div class="container homepage-intro">
  <div class="row">
    <div class="col-sm-3 left-menu">
      <div class="panel panel-default">
        <div class="panel-heading">All Categories</div>
        <!-- LEFT MENU -->
        <ul class="nav nav-pills nav-stacked">
          <?php
			  $i = 1;
              $categories_sorted = array();
              foreach($categories AS $key => $parent) {
                  /* if(strlen($parent['cat_name']) < 30) {
                      $categories_sorted[] = array('cat_id' => $parent['cat_id'],
                            'cat_name' => $parent['cat_name'],
                            'cat_slug' => $parent['cat_slug'], 
                            'cat_child' => $parent['cat_child']);
					  if($i++ == 7) { break; }
                  } */
				  $categories_sorted[] = array('cat_id' => $parent['cat_id'],
                            'cat_name' => $parent['cat_name'],
                            'cat_slug' => $parent['cat_slug'], 
                            'cat_child' => $parent['cat_child']);
              }
			  shuffle($categories_sorted); //Let them be random.
            ?>
          <?php foreach($categories_sorted AS $cat_key => $cat_list) { ?>
          <li role="presentation"><a href="<?php echo DOMAIN; ?>/?page=search&city=1&category=<?php echo $cat_list['cat_id']; ?>"><?php echo $cat_list['cat_name']; ?></a></li>
          <?php if($i == 7) { break; } else { $i++; } } ?>
        </ul>
      </div>
    </div>
    <div class="col-sm-6 middle-banner"> 
      
      <!-- BANNER -->
      <?php if(count($banners->getImages(3)) > 0) { ?>
      <div id="myCarousel" class="carousel slide" data-ride="carousel"> 
        
        <!-- Indicators -->
        <ol class="carousel-indicators">
          <?php $active = 0; $counter = 0; foreach($banners->getImages(3) AS $imageName) { ?>
          <li data-target="#myCarousel" data-slide-to="<?php echo $counter; $counter++; ?>" class="<?php if($active == 0) { $active=1; echo 'active'; } ?>"></li>
          <?php } ?>
        </ol>
        
        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
          <?php $active = 0; foreach($banners->getImages(3) AS $imageName => $imageLink) { ?>
          <div class="item <?php if($active == 0) { $active=1; echo 'active'; } ?>"><a href="<?php echo $imageLink; ?>"><img src="<?php echo DOMAIN; ?>/uploads/banner_images/<?php echo $imageName; ?>" alt=""></a></div>
          <?php } ?>
        </div>
        
        <!-- Left and right controls --> 
        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next"> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> <span class="sr-only">Next</span> </a> </div>
      <?php } ?>
    </div>
    <div class="col-sm-3 right-menu">
      <div class="panel panel-default ">
        <div class="panel-heading">Our Services</div>
        <!-- LEFT MENU -->
        <ul class="nav nav-pills nav-stacked">
          <li role="presentation"><a href="<?php echo DOMAIN; ?>/?page=services&view=buyandsell">Buy &amp; Sell Online</a></li>
          <li role="presentation"><a href="<?php echo DOMAIN; ?>/?page=services&view=onlinestores">Online stores</a></li>
          <li role="presentation"><a href="<?php echo DOMAIN; ?>/?page=services&view=clickandcollect">Click and Collect</a></li>
          <li role="presentation"><a href="<?php echo DOMAIN; ?>/?page=services&view=sponsoredandfeaturedadverts">Sponsored & Featured  Adverts</a></li>
          <li role="presentation"><a href="<?php echo DOMAIN; ?>/?page=services&view=banneradverts">Banner adverts</a></li>
          <li role="presentation"><a href="<?php echo DOMAIN; ?>/?page=services">&nbsp;</a></li>
          <li role="presentation"><a href="<?php echo DOMAIN; ?>/?page=services">&nbsp;</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>

<?php if($fa_SQLRows) { ?>
<!-- FEATURED ADS -->
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default featured-ads">
        <div class="panel-heading">Featured Ads</div>
        <div class="panel-body">
        
          <div class="jcarousel-wrapper">
            <div class="jcarousel">
              <ul>
                <?php while($fa_SQLData = db::fetch($fa_SQLQuery)) { ?>
                <?php foreach($advert->getImages($fa_SQLData['advert_id'],1) AS $image_id => $image_name) { ?>
                <li><a href="<?php echo DOMAIN; ?>/advert/<?php echo lib::san($fa_SQLData['advert_seo_url'],false,true,true); ?>/advert-id/<?php echo lib::san($fa_SQLData['advert_id'],false,true,true); ?>"><img src="<?php echo DOMAIN.'/index.php?image=adverts&size=364&image_name='.$image_name; ?>" alt="Image 1"></a></li>
                <?php } } ?>
              </ul>
            </div>
            <a href="#" class="jcarousel-control-prev">&lsaquo;</a> <a href="#" class="jcarousel-control-next">&rsaquo;</a> 
            <!-- <p class="jcarousel-pagination"></p> --> 
          </div>
          
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>

<!-- CLICK & COLLECT -->
<div class="container">
  <div class="row">
  
  	<!-- LEFT BANNER -->
    <div class="col-sm-3">
      <div class="panel panel-default featured-ads">
         <div class="panel-body">
                         
           <script type="text/javascript" src="<?php echo DOMAIN; ?>/templates/default/javascript/fadeinslideshow/fadeSlideShow.js"></script>
			<script type="text/javascript">
            jQuery(document).ready(function(){
                jQuery('#slideshow').fadeSlideShow({
					width: 258, // default width of the slideshow
					height: 338, // default height of the slideshow
					speed: 'slow', // default animation transition speed
					interval: 3000, // default interval between image change
					PlayPauseElement: 'fssPlayPause', // default css id for the play / pause element
					PlayText: 'Play', // default play text
					PauseText: 'Pause', // default pause text
					NextElement: 'fssNext', // default id for next button
					NextElementText: 'Next >', // default text for next button
					PrevElement: 'fssPrev', // default id for prev button
					PrevElementText: '< Prev', // default text for prev button
					ListElement: 'fssList', // default id for image / content controll list
					ListLi: 'fssLi', // default class for li's in the image / content controll 
					ListLiActive: 'fssActive', // default class for active state in the controll list
					addListToId: false, // add the controll list to special id in your code - default false
					allowKeyboardCtrl: true, // allow keyboard controlls left / right / space
					autoplay: true // autoplay the slideshow	
				});
            });
            </script> 
            <style type="text/css">
            	ul#slideshow{list-style:none;margin:0px !important;padding:0px !important;}
				#fssPrev { display:none; }
				#fssNext { display:none; }
				#fssList { display:none; }
				#fssPlayPause { display:none; }
				#fssList{list-style:none;width:646px;margin:auto;padding:5px 0 0 45%;}
				#fssList li{display:inline;padding-right:10px;}
				#fssList li a{color:#999;text-decoration:none;}
				#fssList li.fssActive a{font-weight:bold;color:#333;}
				#ul img {
					max-width:258px;
					max-height:338px;
				}
            </style>                 
              <ul id="slideshow">
              	  <?php if(count($banners->getImages(1,10,0)) > 0) { ?>
                  <?php foreach($banners->getImages(1,10,0) AS $imageName => $imageLink) { ?>
                  	<li><a href="<?php echo $imageLink; ?>"><img src="<?php echo DOMAIN; ?>/uploads/banner_images/<?php echo $imageName; ?>" border="0" alt=""/></a></li> <!-- This is the last image in the slideshow -->
                  <?php } ?>
                  <?php } ?>
              </ul>
              
          
        </div> 
      </div>
    </div>
    
    <div class="col-sm-6">
      <div class="panel panel-default clickcollect-ads">
        <div class="panel-heading">Click &amp; Collect Stores</div>
        <div class="panel-body">
        
        <link rel="stylesheet" type="text/css" href="<?php echo DOMAIN; ?>/templates/default/javascript/slick/slick.css">
  		<link rel="stylesheet" type="text/css" href="<?php echo DOMAIN; ?>/templates/default/javascript/slick/slick-theme.css">
          
          <section class="regular slider">
                    
          <?php $stores_array = array(); ?>
		  <?php while($storeData = db::fetch($storeSQL)) { ?>
              
              <?php if($storeData['store_logo'] != '') { ?>
                  <?php $stores_array[] = '<li><a href="'.DOMAIN.'/stores/'.lib::san($storeData['store_username']).'">
                      <img src="'.DOMAIN.'/index.php?image=stores&size=logo&image_name='.$storeData['store_logo'].'" alt="">
                  </a></li>'; ?>										
              <?php } else { ?> 
                  <?php $stores_array[] = '<li><a href="'.DOMAIN.'/stores/'.lib::san($storeData['store_username']).'">
                      <img src="'.DOMAIN.'/templates/default/images/100x100nologo.jpg" alt="">
                  </a></li>'; ?>
              <?php } ?>
              
              <?php if(count($stores_array) >= 3) { ?>
              		<?php $output = ''; ?>
                    <?php foreach($stores_array AS $store_logo) { ?>
						<?php $output .= $store_logo; ?>                    
                    <?php } ?>
              		<?php echo '<div><ul class="store_logos">'.$output.'</ul></div>'; $stores_array = array(); ?>
              <?php } ?>              
                                                       
          <?php } ?>
          
          </section>
                    
          <script src="<?php echo DOMAIN; ?>/templates/default/javascript/slick/slick.js" type="text/javascript" charset="utf-8"></script>
		  <script type="text/javascript">
            $(document).on('ready', function() {
              $(".regular").slick({
				autoplay:true,
  				autoplaySpeed:1500,
                dots: false,
                infinite: true,
                //slidesToShow: 3,
                //slidesToScroll: 3,
				variableWidth: true
              });
            });
        </script>
                   
      </div>
    </div>
  </div>
  
  <!-- RIGHT BANNER -->
  <div class="col-sm-3">
    <div class="panel panel-default featured-ads">
      <div class="panel-body">
        
			<script type="text/javascript">
            jQuery(document).ready(function(){
                jQuery('#slideshow2').fadeSlideShow({
					width: 258, // default width of the slideshow
					height: 338, // default height of the slideshow
					speed: 'slow', // default animation transition speed
					interval: 3000, // default interval between image change
					PlayPauseElement: 'fssPlayPause', // default css id for the play / pause element
					PlayText: 'Play', // default play text
					PauseText: 'Pause', // default pause text
					NextElement: 'fssNext', // default id for next button
					NextElementText: 'Next >', // default text for next button
					PrevElement: 'fssPrev', // default id for prev button
					PrevElementText: '< Prev', // default text for prev button
					ListElement: 'fssList', // default id for image / content controll list
					ListLi: 'fssLi', // default class for li's in the image / content controll 
					ListLiActive: 'fssActive', // default class for active state in the controll list
					addListToId: false, // add the controll list to special id in your code - default false
					allowKeyboardCtrl: true, // allow keyboard controlls left / right / space
					autoplay: true // autoplay the slideshow	
				});
            });
            </script> 
            <style type="text/css">
            	ul#slideshow2{list-style:none;margin:0px !important;padding:0px !important;}
				#fssPrev { display:none; }
				#fssNext { display:none; }
				#fssList { display:none; }
				#fssPlayPause { display:none; }
				#fssList{list-style:none;width:646px;margin:auto;padding:5px 0 0 45%;}
				#fssList li{display:inline;padding-right:10px;}
				#fssList li a{color:#999;text-decoration:none;}
				#fssList li.fssActive a{font-weight:bold;color:#333;}
				#ul img {
					max-width:258px;
					max-height:338px;	
				}
            </style>                 
              <ul id="slideshow2">
              	  <?php if(count($banners->getImages(2,10,0)) > 0) { ?>
                  <?php foreach($banners->getImages(2,10,0) AS $imageName => $imageLink) { ?>
                  	<li><a href="<?php echo $imageLink; ?>"><img src="<?php echo DOMAIN; ?>/uploads/banner_images/<?php echo $imageName; ?>" border="0" alt="" /></a></li> <!-- This is the last image in the slideshow -->
                  <?php } ?>
                  <?php } ?>
              </ul>
        
        
      </div>
    </div>
  </div>
  
</div>
</div>

<!-- CLICK & COLLECT -->
<div class="container hp-buttons">
  <div class="row">
    <div class="col-sm-3"> <a href="<?php echo DOMAIN; ?>" class="btn btn-lg btn-default <?php if(lib::get('filter') == '' | lib::get('filter') == 'justlisted') { echo 'active'; } ?>">Just Listed</a> </div>
    <div class="col-sm-3"> <a href="<?php echo DOMAIN; ?>/?filter=clickandcollect" class="btn btn-lg btn-default <?php if(lib::get('filter') == 'clickandcollect') { echo 'active'; } ?>">Click &amp; Collect</a> </div>
    <div class="col-sm-3"> <a href="<?php echo DOMAIN; ?>/?filter=popularitems" class="btn btn-lg btn-default <?php if(lib::get('filter') == 'popularitems') { echo 'active'; } ?>">Popular Items</a> </div>
    <div class="col-sm-3"> <a href="<?php echo DOMAIN; ?>/?filter=topsellers" class="btn btn-lg btn-default <?php if(lib::get('filter') == 'topsellers') { echo 'active'; } ?>">Top Sellers</a> </div>
  </div>
</div>

<!-- ITEMS -->
<?php if($ml_SQLRows) { ?>
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <h4>More Listings <small>Take a look at the listings below!</small></h4>
    </div>
  </div>
  <div class="row">
    <?php $row_counter = 0; ?>
    <?php while($ml_SQLData = db::fetch($ml_SQLQuery)) { ?>
    <?php $row_counter++; ?>
    <div class="col-sm-3">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="product-wrapper">
            <div class="row">
              <div class="col-sm-12">
                <?php if(count($advert->getImages($ml_SQLData['advert_id'],true)) > 0) { ?>
                <?php foreach($advert->getImages($ml_SQLData['advert_id'],true) AS $image_id => $image_name) { ?>
                <a href="<?php echo DOMAIN; ?>/advert/<?php echo lib::san($ml_SQLData['advert_seo_url'],false,true,true); ?>/advert-id/<?php echo lib::san($ml_SQLData['advert_id'],false,true,true); ?>"><img id="" src="<?php echo DOMAIN.'/index.php?image=adverts&size=300&image_name='.$image_name; ?>" alt="" width="200" height="200" class="img-responsive"></a>
                <?php } ?>
                <?php } else { ?>
                <a href="<?php echo DOMAIN; ?>/advert/<?php echo lib::san($ml_SQLData['advert_seo_url'],false,true,true); ?>/advert-id/<?php echo lib::san($ml_SQLData['advert_id'],false,true,true); ?>"><img id="" src="<?php echo DOMAIN.'/templates/default/images/200x200noimage.png'; ?>" alt="" width="200" height="200" class="img-responsive"></a>
                <?php } ?>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="caption"> 
                  <!-- <h4><a href="<?php echo DOMAIN; ?>/advert/<?php echo lib::san($ml_SQLData['advert_seo_url'],false,true,true); ?>/advert-id/<?php echo lib::san($ml_SQLData['advert_id'],false,true,true); ?>"><?php echo lib::san($ml_SQLData['advert_title']); ?></a></h4> -->
                  <p><?php echo substr(htmlentities(strip_tags($ml_SQLData['advert_html'])),0,80); if(strlen($ml_SQLData['advert_html']) > 80) { echo '...'; } ?></p>
                  <!-- Go to www.addthis.com/dashboard to customize your tools  <div class="addthis_inline_share_toolbox"></div>--> 
                </div>
                <a href="<?php echo DOMAIN; ?>/advert/<?php echo lib::san($ml_SQLData['advert_seo_url'],false,true,true); ?>/advert-id/<?php echo lib::san($ml_SQLData['advert_id'],false,true,true); ?>" class="btn btn-default btn-block"><span class="glyphicon glyphicon-tag"></span> View Listing <span class="label label-danger" style="    font-size: 16px;"><?php echo lib::getDefaultCurrencySymbol(); ?><?php echo number_format($ml_SQLData['advert_price'],2); ?></span></a> </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php if($row_counter==4) { $row_counter=0; echo '</div><div class="row">'; } ?>
    <?php } ?>
  </div>
</div>
<?php } ?>
