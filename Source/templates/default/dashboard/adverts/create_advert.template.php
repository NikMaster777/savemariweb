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
		$('.stage-wrapper').hide();
		$('#stage-1').show();
		$('#advert-error').hide();
	});
</script>
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-body">
        
          <div class="bs-wizard">
            <div class="col-xs-4 bs-wizard-step" id="1"> <!-- complete -->
              <div class="text-center bs-wizard-stepnum">Step 1</div>
              <div class="progress">
                <div class="progress-bar"></div>
              </div>
              <a href="#" class="bs-wizard-dot"></a>
              <div class="bs-wizard-info text-center">Create Advert</div>
            </div>
            <div class="col-xs-4 bs-wizard-step" id="2">
              <div class="text-center bs-wizard-stepnum">Step 2</div>
              <div class="progress">
                <div class="progress-bar"></div>
              </div>
              <a href="#" class="bs-wizard-dot"></a>
              <div class="bs-wizard-info text-center">Select AdPack</div>
            </div>
            <div class="col-xs-4 bs-wizard-step" id="3"><!-- complete -->
              <div class="text-center bs-wizard-stepnum">Step 3</div>
              <div class="progress">
                <div class="progress-bar"></div>
              </div>
              <a href="#" class="bs-wizard-dot"></a>
              <div class="bs-wizard-info text-center">Preview</div>
            </div>        
          </div>
          
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-body">
          
          <!-- MESSAGES -->
          <div class="alert alert-danger" id="advert-error"></div>
                    
          <!-- STAGE 3-->
          <div id="stage-3" class="stage-wrapper">
            	            	
                <div class="panel panel-default">
                	<div class="panel-heading">Your Advert - Take a look at your advert below and make sure its correct.</div>
                    <div class="panel-body">
                    
                    	<table class="table table-striped table-borderless">
                        	<tr>
                            	<td>Title</td>
                                <td id="advert_title_preview"></td>
                            </tr>
                            <tr>
                            	<td>Advert Price</td>
                                <td id="adpack_price_preview"></td>
                            </tr>
                            <tr>
                            	<td>Province</td>
                                <td id="advert_province_preview"></td>
                            </tr>
                            <tr>
                            	<td>Description</td>
                                <td id="advert_html_preview"></td>
                            </tr>
                            <tr>
                            	<td>Country</td>
                                <td id="advert_country_preview"></td>
                            </tr>
                            <tr>
                            	<td>Primary Photo</td>
                                <td><img src="" id="preview_image" class="img-responsive"/></td>
                            </tr>
                        </table>
                        
                    </div>
                </div>
                
                
                <script type="text/javascript">
					$(document).ready(function() {
						
						//If they want to pay!
						/* $('#stage-3-button').click(function() {
							//Hide Back Button
							$('#stage-3-button-back').hide();
							$('#stage-3-form').submit();
							$('#stage-3-button').attr('disabled',true);
						});  */
						
						//If they want to go back!
						$('#stage-3-button-back').click(function() {
							$('#stage-2').show();
							$('#stage-3').hide();
						});
						
					});
				</script>
                
                <form action="<?php echo DOMAIN; ?>/index.php?page=dashboard&view=adverts&action=create" method="post" id="advert-payment-method">
                    <div class="panel panel-default" id="payment-methods">
                        <div class="panel-heading">Choose a payment method</div>
                        <div class="panel-body">                        
                            <h4 id="adpack_price"></h4>
                            <script type="text/javascript">$(document).ready(function() {$(".image-picker").imagepicker();});</script>
                            <select class="image-picker show-html" name="payment_method">
                              <option value=""></option>
                              <option data-img-src="<?php echo DOMAIN; ?>/templates/default/images/icons/paypal-logo.png" value="1"></option>
                              <option data-img-src="<?php echo DOMAIN; ?>/templates/default/images/icons/paynow-logo.png" value="2"></option>
                              <option data-img-src="<?php echo DOMAIN; ?>/templates/default/images/icons/bank-logo.png" value="3"></option>
                            </select>
                        </div>
                    </div>
                    <div class="pull-right">          
                        <input type="submit" class="btn btn-default" value="Go Back"/> 
                        <input type="submit" class="btn btn-default" value="Submit Advert" name="_stage3_submit"/>
                    </div>
                </form>
                
          </div>
          
          <!-- STAGE 2 -->
          <div id="stage-2" class="stage-wrapper">
          	
            <script type="text/javascript">
				
				//If click ad-pack
				function chooseAdPack(pack_id) {
					$(document).ready(function() {
						$('#advert_packid').val(pack_id);
						$.ajax({
							url: '<?php echo DOMAIN; ?>/index.php?page=dashboard&view=adverts&action=ajax&request=stage-2-process',
							type: 'POST',
							data: 'advert_packid='+$('#advert_packid').val(),
							success:function(data) {
								if(data.error) {
									$('#advert-error').html(data.error);
									$('#advert-error').show();
								} else {
									if(data.success) {
										
										//Hide Error
										$('#advert-error').hide();
										
										//Hide 2, Show 3
										$('#stage-2').hide();
										$('#stage-3').show();
										
										//Complete 2,3
										$('#2').attr('class', 'col-xs-3 bs-wizard-step complete');
										$('#3').attr('class', 'col-xs-3 bs-wizard-step complete');
																															
										//Which Ad-pack?
										switch(pack_id) {
											<?php  $packageSQL = db::query("SELECT * FROM `".config::$db_prefix."adpacks`"); while($packageData = db::fetch($packageSQL)) { ?>
											case '<?php echo $packageData['pack_id']; ?>': {
												
												//Setup Prices
												var adpack_price = numeral(<?php echo $packageData['pack_price']; ?>); //The Price
													adpack_price = adpack_price.value();
												var adprice = numeral($('#advert_price').val()); //The Price	
													adprice = adprice.value();
													console.log(adpack_price);
													
												//If the adprice is 0.00
												if(adpack_price === 0.00) {
													$('#adpack_price_preview').html('<span class="label label-success">FREE</span>');
													$('#payment-methods').hide();
													$('#adpack_price').html('0.00');	
												} else {
													
													//Adprice
													$('#adpack_price_preview').html('<?php echo lib::getDefaultCurrencySymbol(); ?>' + adprice);	
													$('#adpack_price').html('Listing Price: <?php echo lib::getDefaultCurrencySymbol(); ?>' + adpack_price);
													
													//Other Stuff
													$('#payment-methods').show();
												}
												
												break;
											}
											<?php } ?>
										}
										
									}
								}
							}
						}, 'json');
					});
				}
				
				//Hide Button
            	$(document).ready(function() {
					$('#stage-2-button-back').click(function() {
						$('#stage-1').show();
						$('#stage-2').hide();
					});
				});
				
            </script>
                
                <input type="hidden" name="" id="advert_packid" value="">
                
                <?php  $packageSQL = db::query("SELECT * FROM `".config::$db_prefix."adpacks`"); while($packageData = db::fetch($packageSQL)) { ?>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                  <div class="db-wrapper">
                    <div class="db-pricing-seven">
                    	<ul>
            				<li class="price"><?php echo $packageData['pack_title']; ?> (<?php echo lib::getDefaultCurrencySymbol(); ?><?php echo $packageData['pack_price']; ?> )</li>
                      		<?php echo $packageData['pack_features']; ?>
                      	</ul>
                      <div class="pricing-footer"> <a href="#" class="btn btn-default btn-lg stage-2-button" onclick="chooseAdPack('<?php echo $packageData['pack_id']; ?>')">CHOOSE <i class="glyphicon glyphicon-play-circle"></i></a> </div>
                    </div>
                  </div>
            	</div>
                <?php } ?>
            
            	<div class="pull-right">          
                	<input type="submit" class="btn btn-default" value="Go Back" id="stage-2-button-back"/>
              	</div>
            
            
          </div>
          
          <!-- STAGE 1 -->
          <div id="stage-1" class="stage-wrapper">
          
            <script type="text/javascript">
            	$(document).ready(function() {
					$('#stage-1-button').click(function() {
						$.ajax({
							url: '<?php echo DOMAIN; ?>/index.php?page=dashboard&view=adverts&action=ajax&request=stage-1-process',
							type: 'POST',
							data: 'advert_subcatid=' + $('#subcat_id').val() + '&advert_catid=' + $('#cat_id').val() + '&advert_title='+$('#advert_title').val()+'&advert_price='+$('#advert_price').val()+'&advert_province='+$('#advert_province').val()+'&advert_country='+$('#advert_country').val()+'&advert_html='+CKEDITOR.instances.advert_html.getData(),
							success:function(data) {
								if(data.error) {
									$('#advert-error').html(data.error);
									$('#advert-error').show();
								} else {
									if(data.success) {
										
										//Hide Error
										$('#advert-error').hide();
										
										//Hide 1, Show 2
										$('#stage-2').show();
										$('#stage-1').hide();
										
										//Complete Bar
										$('#1').attr('class', 'col-xs-3 bs-wizard-step complete');
										$('#2').attr('class', 'col-xs-3 bs-wizard-step active');
										
										//Prepare Step 4
										$('#advert_title_preview').html($('#advert_title').val());
										$('#advert_province_preview').html($("#advert_province option:selected").text());
										$('#advert_country_preview').html($("#advert_country option:selected").text());
										$('#advert_html_preview').html(CKEDITOR.instances.advert_html.getData());
										$('#preview_image').attr('src', $('.dz-image img').attr('src'));
										
									}
								}
							}
						}, 'json');
					});
					
					/////////////////////////////////////////////////
					//@ Primary Category Selection
					/////////////////////////////////////////////////
					$('.subcat-form').hide();
					$('#cat_id').change(function() {
						$('.subcat-form').hide();
						switch($('#cat_id').val()) {
							/////////////////////////////////////////////////
							//@ Secondary Category Selection
							/////////////////////////////////////////////////
							<?php //Load System Categories
								  $cat = array();
								  $parSQL = db::query("SELECT * FROM `".config::$db_prefix."categories` WHERE `cat_parentid`='0'");
								  while($parData = db::fetch($parSQL)) { ?>
								case '<?php echo $parData['cat_id']; ?>': {
									var subcats = '<?php $chiSQL = db::query("SELECT * FROM `".config::$db_prefix."categories` WHERE `cat_parentid`='".$parData['cat_id']."'"); 
								  while($chiData = db::fetch($chiSQL)) {
									$chiResult = '<option value="'.$chiData['cat_id'].'">'.$chiData['cat_name'].'</option>';  
									echo str_replace("'", "\\'", $chiResult);
								  } 
								  ?>';
									$('#subcat_id').html(subcats);
									$('.subcat-form').show();							
									break;	
								}
							<?php } ?>
						}
					});
					
					
				});
            </script>
            
            <div class="form-group">
              <label>Title:</label>
              <input type="text" class="form-control" name="" value="" placeholder="Advert Title" id="advert_title"/>
            </div>
                
            <div class="form-group">
              	<label>Category</label>
                <select name="" class="form-control" id="cat_id">
                  <option>-- Select a Category --</option>
                  <?php foreach($categories AS $key => $parent) { ?>
                  <option value="<?php echo lib::san($parent['cat_id']); ?>"><?php echo lib::san($parent['cat_name']); ?></option>
                  <?php } ?>
                </select>
            </div>
            
            <div class="form-group subcat-form">
              	<label>Sub Category</label>
                <select name="" class="form-control" id="subcat_id">
                
                </select>
            </div>
            
            <div class="form-group">
              <label>Price:</label>
              <div class="input-group"> <span class="input-group-addon" id="basic-addon1"><?php echo lib::getDefaultCurrencySymbol(); ?></span>
                <input type="number" class="form-control" placeholder="0.00" aria-describedby="basic-addon1" id="advert_price">
              </div>
            </div>
            <div class="form-group">
              <label>City/Town:</label>
              <select name="" class="form-control" id="advert_province">
                <?php foreach($cities AS $city_id => $city_name) { ?>
                <option value="<?php echo $city_id; ?>"><?php echo $city_name; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label>Country:</label>
              <select name="" class="form-control" id="advert_country">
                <?php foreach(lib::getCountries() AS $country_id => $country_name) { ?>
                <option value="<?php echo $country_id; ?>"><?php echo $country_name; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group"> 
              <script src="<?php echo DOMAIN; ?>/templates/default/javascript/ckeditor/ckeditor.js"></script>
              <label>Description</label>
              <textarea cols="" rows="" class="form-control" name="" id="advert_html" placeholder="Please enter text here for your advert."></textarea>
              <script>
				CKEDITOR.replace( 'advert_html', {
                                
                                // Define the toolbar groups as it is a more accessible solution.
                                toolbarGroups: [
                                    {"name":"basicstyles","groups":["basicstyles"]},
                                    {"name":"paragraph","groups":["list","blocks"]},
                                    {"name":"document","groups":["mode","document", "doctools"]},
                                    {"name":"styles","groups":["styles"]},
                                    {"name":"about","groups":["about"]}
                                ],
                                // Remove the redundant buttons from toolbar groups defined above.
                                removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar'
                            } );
			</script> 
            </div>
            
            <!-- SPACER -->
            <label>Image Upload (Recommended: 800x600px Minimum)</label>
            <div class="alert alert-danger" id="image-upload-alert"></div>
            <div class="panel panel-default"> 
              <!-- <div class="panel-heading">Select Images (Max 6)</div> -->
              <div class="panel-body"> 
                <script src="<?php echo DOMAIN; ?>/templates/default/javascript/dropzone/dropzone.js"></script> 
                <script type="text/javascript">     									
					$(document).ready(function() {
						
						//Hide Alert
						$('#image-upload-alert').hide();
						
						//Stop Autodiscover
						Dropzone.autoDiscover = false;
						
						// jQuery
						$("#my-awesome-dropzone").dropzone({ 
							paramName: "advert-images", // The name that will be used to transfer the file
							url: "<?php echo DOMAIN; ?>/index.php?page=dashboard&view=adverts&action=ajax&request=imageupload",
							maxFilesize: 2, // MB,
							addRemoveLinks: true,
							success: function(file) {
								if(file.xhr.status == 200) {
									var data = JSON.parse(file.xhr.responseText);
									console.log(data);
									if(data.error) {
										$('#image-upload-alert').html('<span class="glyphicon glyphicon-exclamation-sign"></span> '+data.error);
										$('#image-upload-alert').show();
									} else {
										if(data.success) {
											
										}
									} 
								} else {
									alert('Sorry, something unexpected went wrong. Did you loose the internet connection?');	
								}
							},
							removedfile: function(file) {
								$.ajax({
									url: '<?php echo DOMAIN; ?>/index.php?page=dashboard&view=adverts&action=ajax&request=imageremove',
									data: 'advert_image='+file.name,
									type: 'POST',
									success: function(data) {
										console.log(data);
									}
								},'json');
								var _ref;
    							return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
							}
						});
						
					});
                </script>
                <link rel="stylesheet" type="text/css" href="<?php echo DOMAIN; ?>/templates/default/javascript/dropzone/dropzone.css">
                <form action="<?php echo DOMAIN; ?>/index.php?page=dashboard&view=adverts&action=ajax&request=imageupload" class="dropzone needsclick dz-clickable" id="my-awesome-dropzone">
                  <div class="dz-message needsclick">
                    <h4>Drop files here or click to upload.</h4>
                    <p>Drag the images into this window or click to select the photos to upload.</p>
                  </div>
                  <div class="fallback">
                    <input name="advert-images" type="file" multiple />
                  </div>
                </form>
              </div>
            </div>
            
            <!-- SPACER -->
            <div class="form-group"></div>
            
            <div class="form-group pull-right">
              	<input type="submit" class="btn btn-default" value="Next" name="" id="stage-1-button"/>
            </div>
                                    
          </div>
          
        </div>
      </div>
    </div>
  </div>
</div>
