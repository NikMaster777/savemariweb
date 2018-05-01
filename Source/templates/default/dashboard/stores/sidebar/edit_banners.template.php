<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/
if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
?>

<h4>Edit Banners <small>Use the form below to upload new banners to your store.</small></h4>

<?php if(db::nRows("SELECT `banner_id` FROM `".config::$db_prefix."store_banners` WHERE `banner_storeid`='".$store['store_id']."'") > 0) { ?>
<?php $bannerSQL = db::query("SELECT `banner_image`,`banner_id` FROM `".config::$db_prefix."store_banners` WHERE `banner_storeid`='".$store['store_id']."'"); ?>
<div class="row edit-banners-showcase">
	<?php while($bannerData = db::fetch($bannerSQL)) { ?>
		<div class="col-sm-4">
        	<div class="image">
            	<img src="<?php echo DOMAIN; ?>/uploads/store_images/<?php echo $bannerData['banner_image']; ?>" alt="">
            </div>
            <a href="#" class="delete-button" onClick="form<?php echo $bannerData['banner_id']; ?>.submit();">Delete Banner</a>
            <form action="" method="post" id="form<?php echo $bannerData['banner_id']; ?>">
            	<input type="hidden" name="banner_id" value="<?php echo $bannerData['banner_id']; ?>">
                <input type="hidden" name="_deletebanner" value="1">
            </form>
        </div>
    <?php } ?>
</div>
<?php } else { ?>
	<div class="alert alert-warning">Your store does not currently have any banners.</div>
<?php } ?>

<!-- SLIDESHOW -->
<div class="form-group"> 
    
    <div class="alert alert-danger" id="banner-image-upload-alert"></div>
   	<br />
    <br />         
    <label>Slideshow Banners (1080px / 360px)</label>
    
    <!-- <div class="alert alert-danger" id="image-upload-alert2"></div> -->
    <div class="panel panel-default"> 
      <!-- <div class="panel-heading">Select Images (Max 6)</div> -->
      <div class="panel-body"> 
      	<script src="<?php echo DOMAIN; ?>/templates/default/javascript/dropzone/dropzone.js"></script> 
        <script type="text/javascript">     									
            $(document).ready(function() {
                
                //Hide Alert
                $('#banner-image-upload-alert').hide();
                
                //Stop Autodiscover
                Dropzone.autoDiscover = false;
                
                // jQuery
                $("#slideshow-dropzone").dropzone({ 
                    paramName: "store-banner", // The name that will be used to transfer the file
                    url: "<?php echo DOMAIN; ?>/index.php?page=dashboard&view=store&action=ajax&request=edit_uploadbanner",
                    maxFilesize: 2, // MB,
                    addRemoveLinks: true,
                    success: function(file) {
                        if(file.xhr.status == 200) {
                            var data = JSON.parse(file.xhr.responseText);
                            console.log(data);
                            if(data.error) {
                                $('#banner-image-upload-alert').html('<span class="glyphicon glyphicon-exclamation-sign"></span> '+ data.error);
                                $('#banner-image-upload-alert').show();
                            } else {
                                if(data.success) {
                                 	location.reload();
                                }
                            } 
                        } else {
                            alert('Sorry, something unexpected went wrong. Did you loose the internet connection?');	
                        }
                    },
                    removedfile: function(file) {
                        $.ajax({
                            url: '<?php echo DOMAIN; ?>/index.php?page=dashboard&view=store&action=ajax&request=bannerremove',
                            data: 'banner_image='+file.name,
                            type: 'POST',
                            success: function(data) {}
                        },'json');
                        location.reload();
                        var _ref; return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
                    }
                });
                
            });
        </script>
        
        <link rel="stylesheet" type="text/css" href="<?php echo DOMAIN; ?>/templates/default/javascript/dropzone/dropzone.css">
        <form action="<?php echo DOMAIN; ?>/index.php?page=dashboard&view=adverts&action=ajax&request=bannerupload" class="dropzone needsclick dz-clickable" id="slideshow-dropzone">
          <div class="dz-message needsclick">
            <h4>Slideshow Images</h4>
            <p>Drag your slideshow images into this window or click to select the slideshow images.</p>
          </div>
          <div class="fallback">
            <input name="store-banner" type="file" multiple />
          </div>
        </form>
      </div>
    </div>
</div>