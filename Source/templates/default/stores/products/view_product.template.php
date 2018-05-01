<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/
if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
?>

<div class="container" id="content">
  <div class="row">
    <div class="col-sm-12">
      <h4 class="pull-left"><?php echo lib::san($advertData['advert_title']); ?></h4>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-6"> 
      
      <div id="main-image">
            
				<!-- CSS -->
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript"></script> 
				<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js" type="text/javascript"></script>

				<script src="<?php echo DOMAIN; ?>/templates/default/javascript/jquery.elevatezoom.min.js" type="text/javascript"></script>
                <script src="<?php echo DOMAIN; ?>/templates/default/javascript/jquery.fancybox.pack.js" type="text/javascript"></script>
                <link rel="stylesheet" type="text/css" href="<?php echo DOMAIN; ?>/templates/default/stylesheets/fancybox.css">
                				
                <script type="text/javascript">

					$(document).ready(function() {
									
						//initiate the plugin and pass the id of the div containing gallery images
						$("#img_01").elevateZoom({gallery:'gal1', cursor: 'pointer', galleryActiveClass: 'active', imageCrossfade: true,scrollZoom : true}); 
						
						//pass the images to Fancybox
						$("#img_01").bind("click", function(e) {  
						  var ez =   $('#img_01').data('elevateZoom');
						  	console.log($('#img_01').data('elevateZoom'));	
							$.fancybox(ez.getGalleryList());
						  return false;
						});
						
					});
					
                </script>
                
                <style type="text/css">
					.fancybox-image {
						width:100% !important;	
					}
				
                	/*set a border on the images to prevent shifting*/
				   #gal1 img{border:2px solid white;}
				   .gallery
					{
						display: inline-block;
						margin-top: 20px;
					}
				   /*Change the colour*/
				   .active img{border:2px solid #333 !important;}
				   #gal1 {
					   max-width:380px;   
				   }
                </style>
                                
                <?php foreach($advert->getImages($advertData['advert_id']) AS $image_id => $image_name) { ?>         
            	<img id="img_01" src="<?php echo DOMAIN.'/index.php?image=adverts&size=364&image_name='.$image_name; ?>" data-zoom-image="<?php echo DOMAIN.'/index.php?image=adverts&size=fullsize&image_name='.$image_name; ?>"/>
                <?php break; } ?>
                
                <div id="gal1">
                 
                 <?php foreach($advert->getImages($advertData['advert_id']) AS $image_id => $image_name) { ?>
                  <a href="#" data-image="<?php echo DOMAIN.'/index.php?image=adverts&size=364&image_name='.$image_name; ?>" data-zoom-image="<?php echo DOMAIN.'/index.php?image=adverts&size=fullsize&image_name='.$image_name; ?>">
                    <img id="img_01" src="<?php echo DOMAIN.'/index.php?image=adverts&size=100&image_name='.$image_name; ?>" />
                  </a>
                  <?php } ?>
                                
                </div>
                </div>      
      
    </div>
    <div class="col-sm-6">
    	
    	<h4>Information</h4>
      	<div class="table-reponsive">
        <table class="table table-borderless">
          <tr>
            <td>Advert Hits: <?php echo number_format($advert->gethitViews($advertData['advert_id'])); ?></td>
          </tr>
          <tr>
            <td>Price: <span class="label label-danger price"><?php echo lib::getDefaultCurrencySymbol(); ?><?php echo $advertData['advert_price']; ?></span></td>
          </tr>
          <?php 
			  $customFieldSQL = db::query("SELECT * FROM `".config::$db_prefix."store_fields` WHERE `field_storeid`='".$store['store_id']."'"); 
			  while($customFieldData = db::fetch($customFieldSQL)) {
				  $customValue = db::fetchQuery("SELECT * FROM `".config::$db_prefix."store_fields_values` WHERE `value_fieldid`='".$customFieldData['field_id']."'");
		  ?>
          <tr>
            <td><?php echo $customFieldData['field_name']; ?>: <?php echo lib::san($customValue['value_value']); ?></td>
          </tr>
          <?php } ?>
        </table>
      </div>
      
      	<h4>Description</h4>
    	<?php echo lib::san($advertData['advert_html']); ?>
      	
        <hr />
        <a href="<?php echo STORE_URL; ?>&page=purchase&stage=1&product_id=<?php echo $advertData['advert_id']; ?>" class="btn btn-default">Buy Now</a>
        
    </div>
    
  </div>
</div>
<!-- CONTAINER END --> 
