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

<?php if(isset($store['store_logo']) && $store['store_logo'] !='') { ?>
    <div class="image">
        <img src="<?php echo DOMAIN; ?>/uploads/store_images/<?php echo $store['store_logo']; ?>" alt="" style="max-height:150px;height:auto;">
    </div>
<?php } else { ?>
	<div class="alert alert-warning">Your store does not currently have a logo.</div>
<?php } ?>

<!-- SLIDESHOW -->
<div class="form-group"> 
    
    <div class="alert alert-danger" id="logo-image-upload-alert"></div>
    <br />
    <br />            
    <label>Logo Upload (250px / 100px)</label>
    <!-- <div class="alert alert-danger" id="image-upload-alert1"></div> -->
    <div class="panel panel-default"> 
      <!-- <div class="panel-heading">Select Images (Max 6)</div> -->
      <div class="panel-body"> 
        <script src="<?php echo DOMAIN; ?>/templates/default/javascript/dropzone/dropzone.js"></script> 
        <script type="text/javascript">     									
            $(document).ready(function() {
                
                //Hide Alert
                $('#logo-image-upload-alert').hide();
                
                //Stop Autodiscover
                Dropzone.autoDiscover = false;
                
                // jQuery
                $("#logo-dropzone").dropzone({ 
                    paramName: "store-logo", // The name that will be used to transfer the file
                    url: "<?php echo DOMAIN; ?>/index.php?page=dashboard&view=store&action=ajax&request=edit_uploadlogo",
                    maxFilesize: 2, // MB,
                    addRemoveLinks: true,
                    maxFiles: 1,
                    success: function(file) {
                        if(file.xhr.status == 200) {
                            var data = JSON.parse(file.xhr.responseText);
                            console.log(data);
                            if(data.error) {
                                $('#logo-image-upload-alert').html('<span class="glyphicon glyphicon-exclamation-sign"></span> '+data.error);
                                $('#logo-image-upload-alert').show();
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
                            url: '<?php echo DOMAIN; ?>/index.php?page=dashboard&view=store&action=ajax&request=edit_logoremove',
                            type: 'POST',
                            success: function(data) {
                                
                            }
                        },'json');
                        location.reload();
                        var _ref; return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
                    }
                });
                
            });
        </script>
        <link rel="stylesheet" type="text/css" href="<?php echo DOMAIN; ?>/templates/default/javascript/dropzone/dropzone.css">
        <form action="<?php echo DOMAIN; ?>/index.php?page=dashboard&view=adverts&action=ajax&request=imageupload" class="dropzone needsclick dz-clickable" id="logo-dropzone">
          <div class="dz-message needsclick">
            <h4>Store Logo</h4>
            <p>Drag the logo into this window or click to select the logo to upload.</p>
          </div>
          <div class="fallback">
            <input name="store-logo" type="file" multiple />
          </div>
        </form>
      </div>
    </div>
                    
</div>