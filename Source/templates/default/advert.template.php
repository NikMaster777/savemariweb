<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/
if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
?>

<script type="text/javascript">
	$(document).ready(function() {
				  $('.jcarousel').jcarouselAutoscroll({
		  target: '+=3'
	  });
	});
</script>
          
<div class="container" id="advert">
  <div class="row">
  	<div class="col-sm-12">
    	<h4><?php echo lib::san($advertData['advert_title']); ?> (Advert ID: <?php echo $advertData['advert_id']; ?>)</h4>
        <hr />
    </div>
  </div>
  <div class="row">
    <div class="col-sm-4"> 
                        
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
    <div class="col-sm-5">
      <div class="table-reponsive">
          <table class="table table-borderless">
              <tr><td style="border-top:0px;">Listing Date: <?php echo date('Y-m-d h:i:s', strtotime($advertData['advert_datetime'])); ?></td></tr>
              <!-- <tr><td>Advert Views: <?php echo number_format($advert->getuniqueViews($advertData['advert_id'])); ?></td></tr> -->
              <tr><td>Advert Hits: <?php echo number_format($advert->gethitViews($advertData['advert_id'])); ?></td></tr>
              <tr><td>City/Town: <?php echo lib::getAdvertCity($advertData['advert_id']); ?></td></tr>
              <tr><td>Category: <?php echo $category['cat_name']; ?></td></tr>
              <tr><td>Price: <span class="label label-danger" id="advert-price"><?php echo lib::getDefaultCurrencySymbol(); ?><?php echo $advertData['advert_price']; ?></span></td></tr>
              <!-- <tr><td>Expires: <?php echo date('d-m-Y', strtotime($advertData['advert_expiredate'])); ?></td></tr> -->
              <tr><td><h4>Description</h4><p><?php echo lib::filterOutput($advertData['advert_html']); ?></p></td></tr>
              <tr><td>
			  
			  <?php if($advertData['advert_store'] == 1) { ?>
              <a href="<?php echo DOMAIN; ?>/index.php?stores=<?php echo lib::san($storeData['store_username']); ?>&page=purchase&stage=1&product_id=<?php echo $advertData['advert_id']; ?>" class="btn btn-default">Click and Collect</a> 
              <a href="<?php echo DOMAIN; ?>/stores/<?php echo lib::san($storeData['store_username']); ?>" class="btn btn-default">Visit Store</a>
			  <?php } else { ?>
              	
              <?php } ?>
              </td></tr>
              
          </table>
      </div>      
      <hr />
      <div class="form-group">
      	<!--  <a href="#" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-exclamation-sign"></span> Report a problem</a> -->
      </div>
    </div>
    <div class="col-sm-3">
    
      <div class="seller-information">
        <div class="row">
          <div class="col-sm-12">
          
          	<h4>Seller Information</h4>
            
            <!-- Trigger the modal with a button -->
            <button type="button" class="btn btn-sm btn-default" data-toggle="modal" data-target="#myModal">Email Seller</button>
            
            <!-- Modal -->
            <div id="myModal" class="modal fade" role="dialog">
              <div class="modal-dialog">
            	
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Email Seller</h4>
                  </div>
                  <div class="modal-body">
                  
                  	<script type="text/javascript">
                    	$(document).ready(function() {
							$('#contactBtn').click(function() {
								$.ajax({
									url: '<?php echo DOMAIN; ?>/index.php?advert=true&contactseller=true',
									type: 'POST',
									data: $('#contactForm').serialize(),
									success:function(data) {
										if(data.error) {
											$('.alert').hide();
											$('.contact-warning').show();
											$('.contact-warning').html(data.error);	
										} else {
											if(data.success) {
												$('.alert').hide();
												$('.contact-success').show();
												$('.contact-success').html('You sent an email to the seller, you may now close this window!');	
											}
										}
									}
								}, 'json');
							});
						});
                    </script>
                    
                    <div class="alert alert-danger contact-warning" style="display:none;"></div>
                    <div class="alert alert-success contact-success" style="display:none;"></div>
                                        
                    <form action="" method="post" id="contactForm">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" class="form-control input-sm" value="" placeholder="Peter Konoro" name="user_fullname">
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" class="form-control input-sm" value="" placeholder="+4487656787654" name="user_phonenumber">
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="text" class="form-control input-sm" value="" placeholder="you@domainname.com" name="user_emailaddress">
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea class="form-control input-sm" cols="" rows="8" name="user_message"></textarea>
                        </div>
                        <div class="form-group">
                        	<input type="hidden" name="bot_id" value="" class="btn btn-default">
                            <input type="hidden" name="advert_id" value="<?php echo $advertData['advert_id']; ?>" class="btn btn-default">
                            <input type="button" name="" value="Send Message" class="btn btn-default" id="contactBtn">
                        </div>
                    </form>
                    
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>
            
              </div>
            </div>
            
            <br />
            <br />
            
			<?php if($advertData['advert_store'] == 1) { ?>
                
                <p><a href="<?php echo DOMAIN; ?>/stores/<?php echo lib::san($storeData['store_username']); ?>"><?php echo lib::san($userData['user_username'],false,true,true); ?></a></p>
                <p><?php
                    if(isset($storeData['store_logo']) && $storeData['store_logo'] != '') {
                        echo '<a href="'.DOMAIN.'/index.php?stores='.$storeData['store_username'].'"><img src="'.DOMAIN.'/uploads/store_images/'.@$storeData['store_logo'].'" alt="" style="max-height:150px;max-width:250px;"></a>';	
                    } else {
                        echo '<a href="#"><img src="'.DOMAIN.'/templates/default/images/stores/250x100defaultlogo.jpg" alt=""></a>';				
                    }
                ?></p>
                
                <span class="spacer"></span>
                <p>Visit Store: <a href="<?php echo DOMAIN; ?>/stores/<?php echo lib::san($storeData['store_username']); ?>">Store Link</a></p>
                <p><a href="<?php echo DOMAIN; ?>/stores/<?php echo lib::san($storeData['store_username']); ?>">See more items from this seller.</a></p>
                <p>Reviews: <a href="<?php echo DOMAIN; ?>/index.php?stores=<?php echo lib::san($storeData['store_username']); ?>&page=reviews">(<?php echo $stores->getReviews($storeData['store_id']); ?>) See Reviews</a></p>
                <span class="spacer"></span>
                <h4>Contact Information</h4>
                <p>Email: <?php echo lib::san($storeData['store_email'],false,true,true); ?></p>
                <p>Address: <?php echo lib::san($storeData['store_address'],false,true,true); ?></p>
                <p>Phone: <?php echo lib::san($storeData['store_phone'],false,true,true); ?></p>
                <p>Whatsapp: <?php echo lib::san($storeData['store_whatsapp'],false,true,true); ?></p>
                
                <?php } else { ?>
                                
                <p><?php echo lib::san($userData['user_username'],false,true,true); ?></p>
                <span class="spacer"></span>
                <p>Email: <?php echo lib::san($userData['user_emailaddress'],false,true,true); ?></p>
                <p>Phone: <?php echo lib::san($userData['user_phone'],false,true,true); ?></p>
                <p>Mobile: <?php echo lib::san($userData['user_mobile'],false,true,true); ?></p>
                <p>Whatsapp: <?php echo lib::san($userData['user_whatsapp'],false,true,true); ?></p>
                
                
                <!-- Trigger the modal with a button -->
                <button type="button" class="btn btn-sm btn-default" data-toggle="modal" data-target="#myModal2">Report Ad</button>
                
                <!-- Modal -->
                <div id="myModal2" class="modal fade" role="dialog">
                  <div class="modal-dialog">
                    
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Report an Advert</h4>
                      </div>
                      <div class="modal-body">
                      
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $('#contactBtn2').click(function() {
                                    $.ajax({
                                        url: '<?php echo DOMAIN; ?>/index.php?advert=true&reportseller=true',
                                        type: 'POST',
                                        data: $('#contactForm2').serialize(),
                                        success:function(data) {
                                            if(data.error) {
                                                $('.alert').hide();
                                                $('.contact-warning').show();
                                                $('.contact-warning').html(data.error);	
                                            } else {
                                                if(data.success) {
                                                    $('.alert').hide();
                                                    $('.contact-success').show();
                                                    $('.contact-success').html('You have reported the advert, thanks!');	
                                                }
                                            }
                                        }
                                    }, 'json');
                                });
                            });
                        </script>
                        
                        <div class="alert alert-danger contact-warning" style="display:none;"></div>
                        <div class="alert alert-success contact-success" style="display:none;"></div>
                                            
                        <form action="" method="post" id="contactForm2">
                            <div class="form-group">
                                <label>Message</label>
                                <textarea class="form-control input-sm" cols="" rows="8" name="user_message"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="bot_id" value="" class="btn btn-default">
                                <input type="hidden" name="advert_id" value="<?php echo $advertData['advert_id']; ?>" class="btn btn-default">
                                <input type="button" name="" value="Report Advert" class="btn btn-default" id="contactBtn2">
                            </div>
                        </form>
                        
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                
                  </div>
                </div>
                
                
                <br />
                <br />
                
                
            <?php } ?>
            
            
            
          </div>
        </div>
      </div>
              
    </div> <!-- COL END -->
  </div> <!-- ROW END -->
  
  <?php if($advertData['advert_store'] == 1) { ?>
  <div class="row">
           <div class="col-sm-12 advert-html">           
      <?php if($re_SQLRows > 0) { ?>
      <?php while($reviewData = db::fetch($re_SQLQuery)) { ?>
      <!-- REVIEW -->
      <div class="panel panel-default">
      	  <div class="panel-heading">User Reviews</div>
          <div class="panel-body">
              <h4><?php echo lib::san($reviewData['review_fullname']); ?> <small> <?php for($i=1;$i<=$reviewData['review_rating'];$i++) { ?><span class="glyphicon glyphicon-star" style="color:#CC0;"></span><?php } ?></small></h4>
              <p><?php echo lib::san($reviewData['review_comment']); ?></p>
          </div>
      </div>
      <!-- REVIEW -->
      <?php } ?>
      <?php } else { ?>
      <div class="panel panel-default">
      	  <div class="panel-heading">Featured Ads</div>
          <div class="panel-body">
              <p>There are not yet any user reviews.</p>
          </div>
      </div>
      <?php } ?>
      </div>
  </div>
  <?php } ?>
  
  <!-- FEATURED ADS ROW -->
  <div class="row">
  	<div class="col-sm-12 advert-html">
    	<div class="panel panel-default featured-ads">
        <div class="panel-heading">Featured Ads</div>
        <div class="panel-body">
        
            <?php if($fa_SQLRows) { ?>
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
          <?php } ?>
            
            
        
        </div>
      </div>
      
    </div>
  </div>
  <div class="row">
  	<div class="col-sm-12">
    
   	  
      
    </div>
  </div>
</div> <!-- CONTAINER END -->
