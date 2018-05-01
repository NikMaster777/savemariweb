<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
?>

  <div class="row">
    <div class="col-sm-12">
          
          <!-- MESSAGES -->
          <div class="alert alert-danger" id="advert-error"></div>
                     
          <!-- STAGE 1 -->
          <div id="stage-1" class="stage-wrapper">
          
            <script type="text/javascript">
            	$(document).ready(function() {
					
					//Hide Error
					$('#advert-error').hide();
										
					//Create Product
					$('#add-product').click(function() {
						$.ajax({
							url: '<?php echo DOMAIN; ?>/index.php?page=dashboard&view=store&action=ajax&request=edit-product',
							type: 'POST',
							data: 'advert_catid='+ $('#product_catid').val() +'&advert_id=<?php echo lib::get('product_id'); ?>&advert_title='+$('#advert_title').val()+'&advert_price='+$('#advert_price').val()+'&advert_html='+CKEDITOR.instances.advert_html.getData() + '&' + $('#customFields').serialize(),
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
										window.location='<?php echo DOMAIN; ?>/index.php?page=dashboard&view=store&action=manage&option=manage-products';
										
									}
								}
							}
						}, 'json');
					});
					
				});
            </script>
            
            <div class="form-group">
              <label>Title:</label>
              <input type="text" class="form-control" name="" value="<?php echo lib::san($prodData['advert_title'],false,true,true); ?>" placeholder="Advert Title" id="advert_title"/>
            </div>
                        
            <div class="form-group">
              <label>Price:</label>
              <div class="input-group"> <span class="input-group-addon" id="basic-addon1"><?php echo lib::getDefaultCurrencySymbol(); ?></span>
                <input type="number" class="form-control" placeholder="0.00" aria-describedby="basic-addon1" id="advert_price" value="<?php echo lib::san($prodData['advert_price'],false,true,true); ?>">
              </div>
            </div>
                                    
            <div class="form-group"> 
              <script src="<?php echo DOMAIN; ?>/templates/default/javascript/ckeditor/ckeditor.js"></script>
              <label>Description</label>
              <textarea cols="" rows="" class="form-control" name="" id="advert_html" placeholder="Please enter text here for your advert."><?php echo lib::san($prodData['advert_html'],false,true,true); ?></textarea>
              <script>
				CKEDITOR.replace( 'advert_html', {
					
					// Define the toolbar groups as it is a more accessible solution.
					toolbarGroups: [
						
					],
					// Remove the redundant buttons from toolbar groups defined above.
					removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar'
				} );
			</script> 
            </div>
            
            <div class="form-group">
            	<label>Category</label>
                <select name="product_catid" id="product_catid" class="form-control">
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
            
            <?php
				echo '<form action="" method="" id="customFields">';
				//Field List
				$fieldSQL = db::query("SELECT * FROM `".config::$db_prefix."store_fields` WHERE `field_storeid`='".$store['store_id']."'");
				while($fieldData = db::fetch($fieldSQL)) {
						//Load Field Data
						$fieldDataValue = db::fetchQuery("SELECT * FROM `".config::$db_prefix."store_fields_values` WHERE `value_storeid`='".$store['store_id']."' AND `value_fieldid`='".$fieldData['field_id']."'");
						switch($fieldData['field_type']) {
							case 1: { //Textbox
								echo '<div class="form-group">';
								echo '<label>'.lib::san($fieldData['field_name']).'</label>';
								echo '<input type="text" name="'.$fieldData['field_id'].'" class="form-control" placeholder="'.lib::san($fieldData['field_placeholder']).'" value="'.lib::san($fieldDataValue['value_value'],false,true,true).'"/>';
								echo '</div>';
								break;	
							}
							case 2: { //Textarea
								echo '<div class="form-group">';
								echo '<label>'.lib::san($fieldData['field_name']).'</label>';
								echo '<textarea cols="" rows="8" name="'.$fieldData['field_id'].'" class="form-control" placeholder="'.lib::san($fieldData['field_placeholder']).'">'.lib::san($fieldDataValue['value_value'],false,true,true).'</textarea>';
								echo '</div>';
								break;	
							}
							case 3: { //Dropdown
								echo '<div class="form-group">';
								echo '<label>'.lib::san($fieldData['field_name']).'</label>';
								echo '<select name="'.$fieldData['field_id'].'" class="form-control">';
									//Find Options
									$optionSQL = db::query("SELECT * FROM `".config::$db_prefix."store_fields_options` WHERE `option_fieldid`='".$fieldData['field_id']."'");
									while($optionData = db::fetch($optionSQL)) {
										$optionValue = db::fetchQuery("SELECT * FROM `".config::$db_prefix."store_fields_values` 
										WHERE `value_storeid`='".$store['store_id']."' AND `value_fieldid`='".$fieldData['field_id']."' AND `value_advertid`='".lib::get('product_id',true)."'");
										if($optionValue['value_value'] == $optionData['option_id']) {
											echo '<option value="'.lib::san($optionData['option_id']).'" selected="selected">'.lib::san($optionData['option_name']).'</option>';
										} else {
											echo '<option value="'.lib::san($optionData['option_id']).'">'.lib::san($optionData['option_name']).'</option>';
										}
									}
								echo '</select>';
								echo '</div>';
								break;	
							}
							case 4: { //Checkbox
									echo '<div class="form-group">';
									echo '<label>'.lib::san($fieldData['field_name']).'</label>';
									$optionSQL = db::query("SELECT * FROM `".config::$db_prefix."store_fields_options` WHERE `option_fieldid`='".$fieldData['field_id']."'");
									while($optionData = db::fetch($optionSQL)) {
										
									$optionValue = db::fetchQuery("SELECT * FROM `".config::$db_prefix."store_fields_values` 
										WHERE `value_storeid`='".$store['store_id']."' AND `value_optionid`='".$optionData['option_id']."' AND `value_advertid`='".lib::get('product_id',true)."'");
																																		
									if($optionValue['value_value'] == 1) {	
										echo '<div class="form-check form-check-inline">
										<label class="form-check-label">
										  <input class="form-check-input" type="checkbox" value="1" name="'.$optionData['option_id'].'" checked="checked"> '.lib::san($optionData['option_name']).'
										</label>
									  </div>';
									} else {
										echo '<div class="form-check form-check-inline">
										<label class="form-check-label">
										  <input class="form-check-input" type="checkbox" value="1" name="'.$optionData['option_id'].'"> '.lib::san($optionData['option_name']).'
										</label>
									  </div>';
									}
									
									}
									echo '</div>';
								break;	
							}
						}
					
           		} 
				echo '</form>';
			?>
            
            <!-- SPACER -->
            <label>Image Upload</label>
            <p>If you upload new images, the existing images will be deleted.</p>
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
              	<input type="submit" class="btn btn-default" value="Edit Product" name="" id="add-product"/>
            </div>
                                    
          </div>
          
    </div>
  </div>
