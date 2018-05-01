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
    	<h4>Edit Advert</h4>
        <p>Please use the form below to edit your advert.</p>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-body"> 
          <!-- PANEL START --> 
          
          <script type="text/javascript">
			  $(document).ready(function() {
				  $('#_editadvert').click(function() {
					  $.ajax({
						  url: '<?php echo DOMAIN; ?>/index.php?page=dashboard&view=adverts&action=ajax&request=edit-advert',
						  type: 'POST',
						  data: 'advert_subcatid=' + $('#subcat_id').val() + '&advert_catid=' + $('#cat_id').val() + '&advert_title='+$('#advert_title').val()+'&advert_price='+$('#advert_price').val()+'&advert_province='+$('#advert_province').val()+'&advert_country='+$('#advert_country').val()+'&advert_html='+CKEDITOR.instances.advert_html.getData()+'&advert_id=<?php echo $advertData['advert_id']; ?>',
						  success:function(data) {
							  if(data.error) {
								  $('#advert-error').html(data.error);
								  $('#advert-error').show();
							  } else {
								  if(data.success) {
									  $('#advert-error').hide(); 
									  window.location='<?php echo DOMAIN; ?>/index.php?page=dashboard&view=adverts&action=success';                                                   
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
									  if($advertData['advert_subcatid'] == $chiData['cat_id']) { 
								  	  	$chiResult = '<option value="'.$chiData['cat_id'].'" selected>'.$chiData['cat_name'].'</option>';
										echo str_replace("'", "\\'", $chiResult);
									  } else {
										$chiResult = '<option value="'.$chiData['cat_id'].'">'.$chiData['cat_name'].'</option>';  
										echo str_replace("'", "\\'", $chiResult);
									  }
								  } 
								  ?>';
								  $('#subcat_id').html(subcats);
								  $('.subcat-form').show();							
								  break;	
							  }
						  <?php } ?>
					  }
				  });
				  
				  /////////////////////////////////////////////////
				  //@ AUTOLOAD SUB CATS
				  /////////////////////////////////////////////////
				  var subcats2 = '<?php $chiSQL2 = db::query("SELECT * FROM `".config::$db_prefix."categories` WHERE `cat_parentid`='".$advertData['advert_catid']."'"); 
				  while($chiData2 = db::fetch($chiSQL2)) { echo '<option value="'.$chiData2['cat_id'].'">'.$chiData2['cat_name'].'</option>';} ?>';
				  $('#subcat_id').html(subcats2);
				  $('.subcat-form').show();
				  
			  });
		  </script>
                        
          <div class="form-group">
            <label>Title:</label>
            <input type="text" class="form-control" name="" value="<?php echo lib::san($advertData['advert_title']); ?>" placeholder="Advert Title" id="advert_title"/>
          </div>
          <div class="form-group">
            <label>Category</label>
            <select name="" class="form-control" id="cat_id">
              <option>-- Select a Category --</option>
              <?php foreach($categories AS $key => $parent) { ?>
              	<option value="<?php echo lib::san($parent['cat_id']); ?>" <?php if($advertData['advert_catid'] === $parent['cat_id']) { echo 'selected="selected"'; } ?>><?php echo lib::san($parent['cat_name']); ?></option>
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
              <input type="number" class="form-control" placeholder="0.00" aria-describedby="basic-addon1" id="advert_price" value="<?php echo $advertData['advert_price']; ?>">
            </div>
          </div>
          <div class="form-group">
            <label>City/Town:</label>
            <select name="" class="form-control" id="advert_province">
              <?php foreach($cities AS $city_id => $city_name) { ?>
              	<option value="<?php echo $city_id; ?>" <?php if($advertData['advert_cityid'] === $city_id) { echo 'selected="selected"'; } ?>><?php echo $city_name; ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Country:</label>
            <select name="" class="form-control" id="advert_country">
              <?php foreach(lib::getCountries() AS $country_id => $country_name) { ?>
              	<option value="<?php echo $country_id; ?>" <?php if($advertData['advert_countryid'] === $country_id) { echo 'selected="selected"'; } ?>><?php echo $country_name; ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group"> 
            <script src="<?php echo DOMAIN; ?>/templates/default/javascript/ckeditor/ckeditor.js"></script>
            <label>Description</label>
            <textarea cols="" rows="" class="form-control" name="" id="advert_html" placeholder="Please enter text here for your advert."><?php echo strip_tags($advertData['advert_html'], '<strong><ol><em><ul><li><p><br><br/>'); ?></textarea>
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
          <label>Image Upload</label>
          <small>Using this form will remove any existing images and replace them with new ones</small>
          
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
            <input type="submit" class="btn btn-default" value="Next" name="" id="_editadvert"/>
          </div>
          
          <!-- PANEL END --> 
        </div>
      </div>
    </div>
  </div>
</div>
