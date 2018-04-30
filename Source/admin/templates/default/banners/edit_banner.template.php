<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Creative Miles
 *@Start: 12th June 2016
*/
if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
?>
<div class="container content-wrapper">
	<div class="row header-row">
    	<div class="col-sm-6 left">
        	<h3>Edit Banner (<?php echo lib::san($bannerData['banner_name']); ?>)</h3>
            <p>Height: <?php echo $bannerData['banner_height']; ?>px / Width: <?php echo $bannerData['banner_width']; ?>px</p>
        </div>
        <div class="col-sm-6 right">
        	<div class="form-group">
                
            </div>
        </div>
    </div>
    <div class="row button-row">
    	<div class="col-sm-8 right">
        	<?php echo $paginate->renderPages(); ?>
        </div>
    </div>
    <?php if(@$message) { ?>
    <div class="row">
    	<div class="col-sm-12">
            <div class="alert alert-danger">
                <span class="glyphicon glyphicon-exclamation-sign"></span> <?php echo $message; ?>
            </div> 
        </div>
    </div>
    <?php } ?>
    <div class="row">
    	<div class="col-sm-12">
        	
            <?php if($records) { ?>
            <div class="panel panel-default">
            	<div class="panel-heading">Images</div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td>Image Name</td>
                                    <td>Image Link</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                            <?php while($ImageData = db::fetch($ImageSQL)) { ?>
                                <tr>
                                    <td><?php echo lib::san($ImageData['image_name'],false,true,true); ?></td>
                                    <td><?php echo lib::san($ImageData['image_link'],false,true,true); ?></td>
                                    <td>
                                        <a href="<?php echo ADMINDOMAIN; ?>/?action=banners&method=delete_image&image_id=<?php echo $ImageData['image_id']; ?>&banner_id=<?php echo lib::get('banner_id'); ?>" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></span></a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
            </div>
            <?php } else { ?>
            	<div class="alert alert-warning">You have no images to show, be the first to add a new banner.</div>
            <?php } ?>
                        
        </div>
    </div>
    <div class="row">
    	<div class="col-sm-12">
        	
            <label>Image Link</label>
            <input type="text" class="form-control" name="" id="image_link" placeholder="http://www.example.com">
            
        	<!-- SPACER -->
            <label>Image Upload</label>
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
							paramName: "banner-images", // The name that will be used to transfer the file
							url: "<?php echo ADMINDOMAIN; ?>/index.php?action=ajax&class=banners&method=imageupload&banner_id=<?php echo lib::get('banner_id'); ?>",
							maxFilesize: 2, // MB,
							addRemoveLinks: false,
						    sending:function(file, xhr, formData){
								formData.append('image_link',$("#image_link").val() );
							},
							success: function(file) {
								if(file.xhr.status == 200) {
									var data = JSON.parse(file.xhr.responseText);
									console.log(data);
									if(data.error) {
										$('#image-upload-alert').html('<span class="glyphicon glyphicon-exclamation-sign"></span> '+data.error);
										$('#image-upload-alert').show();
									} else {
										if(data.success) {
											location.reload();
										}
									} 
								} else {
									alert('Sorry, something unexpected went wrong. Did you loose the internet connection?');	
								}
							}
						});
						
					});
                </script>
                <link rel="stylesheet" type="text/css" href="<?php echo DOMAIN; ?>/templates/default/javascript/dropzone/dropzone.css">
                <form action="<?php echo ADMINDOMAIN; ?>/index.php?action=ajax&class=banners&method=imageupload&banner_id=<?php echo lib::get('banner_id'); ?>" class="dropzone needsclick dz-clickable" id="my-awesome-dropzone">
                  <div class="dz-message needsclick">
                    <h4>Drop files here or click to upload.</h4>
                    <p>Drag the images into this window or click to select the photos to upload.</p>
                  </div>
                  <div class="fallback">
                    <input name="banner-images" type="file" multiple />
                  </div>
                </form>
              </div>
            </div>
        
        </div>
    </div>
    <div class="row footer-row">
    	<div class="col-sm-4 left"></div>
    	<div class="col-sm-8 right">
        	<?php echo $paginate->renderPages(); ?>
        </div>
    </div>
</div>