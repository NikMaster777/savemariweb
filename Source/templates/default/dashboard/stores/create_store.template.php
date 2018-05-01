<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
?>
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-body">
        
          <div class="bs-wizard">
            <div class="col-xs-3 bs-wizard-step" id="1"> <!-- complete -->
              <div class="text-center bs-wizard-stepnum">Step 1</div>
              <div class="progress">
                <div class="progress-bar"></div>
              </div>
              <a href="#" class="bs-wizard-dot"></a>
              <div class="bs-wizard-info text-center">Create Store</div>
            </div>
            
            <div class="col-xs-3 bs-wizard-step" id="2">
              <div class="text-center bs-wizard-stepnum">Step 2</div>
              <div class="progress">
                <div class="progress-bar"></div>
              </div>
              <a href="#" class="bs-wizard-dot"></a>
              <div class="bs-wizard-info text-center">Customize Store</div>
            </div>
            
            <div class="col-xs-3 bs-wizard-step" id="3"><!-- complete -->
              <div class="text-center bs-wizard-stepnum">Step 3</div>
              <div class="progress">
                <div class="progress-bar"></div>
              </div>
              <a href="#" class="bs-wizard-dot"></a>
              <div class="bs-wizard-info text-center">Select Package</div>
            </div>
            
            <div class="col-xs-3 bs-wizard-step" id="4"><!-- complete -->
              <div class="text-center bs-wizard-stepnum">Step 4</div>
              <div class="progress">
                <div class="progress-bar"></div>
              </div>
              <a href="#" class="bs-wizard-dot"></a>
              <div class="bs-wizard-info text-center">Make a Payment</div>
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
          	<div class="alert alert-danger" id="store-error"></div>
            
            <!--GENERAL JS-->
            <script type="text/javascript">
            	$(document).ready(function() {
					$('#store-error').hide();
					$('#stage-2').hide();
					$('#stage-3').hide();
					$('#stage-4').hide();
										
				});
            </script>
            
            <!--STAGE 4-->
            <div id="stage-4">
            	                
                <form action="#" method="post">
                	<input type="hidden" name="store_packid" id="store_packid" value="">
                    <div class="panel panel-default" id="payment-methods">
                        <div class="panel-heading">Choose a payment method</div>
                        <div class="panel-body">
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
                        <input type="submit" class="btn btn-default" value="Make a Payment" name="_stage-4-submit"/>
                    </div>
                </form>
                                
            </div>
            
            <!--STAGE 3 -->
            <div id="stage-3">
            	
                <h4>Choose Package <small>Choose the package that is right for you.</small></h4>
                
                <script type="text/javascript">
				
					//If click ad-pack
					function chooseSTPack(pack_id) {
						$(document).ready(function() {
							
							$('#store_packid').val(pack_id);
														
							//Hide 2, Show 3
							$('#stage-3').hide();
							$('#stage-4').show();
							
							//Complete 2,3
							$('#3').attr('class', 'col-xs-3 bs-wizard-step complete');
							$('#4').attr('class', 'col-xs-3 bs-wizard-step active');
							
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
                                                
                <?php  $packageSQL = db::query("SELECT * FROM `".config::$db_prefix."stpacks` ORDER BY `pack_id` DESC"); while($packageData = db::fetch($packageSQL)) { ?>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                  <div class="db-wrapper">
                    <div class="db-pricing-seven">
                    	<ul>
            				<li class="price"><?php echo $packageData['pack_title']; ?> (<?php echo lib::getDefaultCurrencySymbol(); ?><?php echo $packageData['pack_price']; ?> )</li>
                      		<?php echo $packageData['pack_features']; ?>
                      	</ul>
                      <div class="pricing-footer"> <a href="#" class="btn btn-default btn-lg stage-3-button" onclick="chooseSTPack('<?php echo $packageData['pack_id']; ?>')">CHOOSE <i class="glyphicon glyphicon-play-circle"></i></a> </div>
                    </div>
                  </div>
            	</div>
                <?php } ?>
            
            	<div class="pull-right">          
                	<input type="button" class="btn btn-default" name="" value="Next" id="stage-3-button"/>
              	</div>
                                                
            </div>
            
            <!--STAGE 2 -->
            <div id="stage-2">
            
                <h4>Customize Store <small>Customise the menu and header colours of your store.</small></h4>
                
                <hr />
                
                <!-- LOGO -->
                <div class="form-group"> 
                
                	<div class="alert alert-danger" id="logo-image-upload-alert"></div>
                
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
                                    url: "<?php echo DOMAIN; ?>/index.php?page=dashboard&view=store&action=ajax&request=logoupload",
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
                                                    document.getElementById('iframe-window').contentWindow.location.reload();
                                                }
                                            } 
                                        } else {
                                            alert('Sorry, something unexpected went wrong. Did you loose the internet connection?');	
                                        }
                                    },
                                    removedfile: function(file) {
                                        $.ajax({
                                            url: '<?php echo DOMAIN; ?>/index.php?page=dashboard&view=store&action=ajax&request=logoremove',
                                            type: 'POST',
                                            success: function(data) {
                                                
                                            }
                                        },'json');
										document.getElementById('iframe-window').contentWindow.location.reload();
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
                                
                <!-- SLIDESHOW -->
                <div class="form-group"> 
                	
                    <div class="alert alert-danger" id="banner-image-upload-alert"></div>
                    
                    <label>Slideshow Banners (1080px / 360px)</label>
                    <!-- <div class="alert alert-danger" id="image-upload-alert2"></div> -->
                    <div class="panel panel-default"> 
                      <!-- <div class="panel-heading">Select Images (Max 6)</div> -->
                      <div class="panel-body"> 
                        <script type="text/javascript">     									
                            $(document).ready(function() {
                                
                                //Hide Alert
                                $('#banner-image-upload-alert').hide();
                                
                                //Stop Autodiscover
                                Dropzone.autoDiscover = false;
                                
                                // jQuery
                                $("#slideshow-dropzone").dropzone({ 
                                    paramName: "store-banner", // The name that will be used to transfer the file
                                    url: "<?php echo DOMAIN; ?>/index.php?page=dashboard&view=store&action=ajax&request=bannerupload",
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
                                                     document.getElementById('iframe-window').contentWindow.location.reload();
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
										document.getElementById('iframe-window').contentWindow.location.reload();
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
                
                <!-- MENU COLOR -->
                <div class="panel panel-default">
                	<div class="panel-body">
                    		                        	
                            <h4>Customize Colors</h4>
                            <p>Use the color picker below to customize the colours of navigation bar and buttons.</p>
                            
                            <link rel="stylesheet" type="text/css" href="<?php echo DOMAIN; ?>/templates/default/javascript/spectrum.css">
                            <script src="<?php echo DOMAIN; ?>/templates/default/javascript/spectrum.js"></script>
                            
                            <div class="panel panel-default">
                                <div class="panel-body">
                        			                                                                                                            
                                    <!-- NAVIGATION MENU -->
                                    <div class="form-inline">
                                    	
                                        <!--MENU-BACKGROUND-->
                                        <div class="form-group">
                                            <label>Menu Background</label><br />
                                            <span>Set the background colour of the navigation bar.</span><br />
                                            <input type='text' id="menu-color" />
                                            <script type="text/javascript">
                                            $("#menu-color").spectrum({
                                                color: "#f8f8f8",
                                                change: function(color) {
                                                    var color = color.toHexString();
                                                        color = color.replace("#","");
                                                    $.ajax({
														url: '<?php echo DOMAIN; ?>/index.php?page=dashboard&view=store&action=ajax&request=colorchange',
														type: 'POST',
														data: 'store_color-type=menu-color&store_color-code=' + color,
														success: function(data) {
															if(data.success) {
																document.getElementById('iframe-window').contentWindow.location.reload();	
															}
														}
													},'json');
                                                }
                                            });
                                            </script>
                                        </div>
                                        
                                        <!--ACTIVE MENU ITEM-->
                                        <div class="form-group">
                                            <label>Button Background (Active)</label><br />
                                            <span>The colour of the menu item this is currently being viewed.</span><br />
                                            <input type='text' id="item-background-active" />
                                            <script>
                                            $("#item-background-active").spectrum({
                                                color: "#e7e7e7",
                                                change: function(color) {
                                                    var color = color.toHexString();
                                                        color = color.replace("#","");
                                                    $.ajax({
														url: '<?php echo DOMAIN; ?>/index.php?page=dashboard&view=store&action=ajax&request=colorchange',
														type: 'POST',
														data: 'store_color-type=item-background-active&store_color-code=' + color,
														success: function(data) {
															if(data.success) {
																document.getElementById('iframe-window').contentWindow.location.reload();	
															}
														}
													},'json');
                                                }
                                            });
                                            </script>
                                        </div>
                                        
                                        <!--ACTIVE MENU ITEM-->
                                        <div class="form-group">
                                            <label>Button Font Colour (Active) </label><br />
                                            <span>The font colour of the menu item this is currently being viewed.</span><br />
                                            <input type='text' id="item-font-color-active" />
                                            <script>
                                            $("#item-font-color-active").spectrum({
                                                color: "#555",
                                                change: function(color) {
                                                    var color = color.toHexString();
                                                        color = color.replace("#","");
                                                    $.ajax({
														url: '<?php echo DOMAIN; ?>/index.php?page=dashboard&view=store&action=ajax&request=colorchange',
														type: 'POST',
														data: 'store_color-type=item-font-color-active&store_color-code=' + color,
														success: function(data) {
															if(data.success) {
																document.getElementById('iframe-window').contentWindow.location.reload();	
															}
														}
													},'json');
                                                }
                                            });
                                            </script>
                                        </div>
                                        
                                        <!--ACTIVE MENU ITEM-->
                                        <div class="form-group">
                                            <label>Button Font Color (Normal)</label><br />
                                            <span>The font color of the menu item that is not active.</span><br />
                                            <input type='text' id="item-font-color-normal" />
                                            <script>
                                            $("#item-font-color-normal").spectrum({
                                                color: "#777",
                                                change: function(color) {
                                                    var color = color.toHexString();
                                                        color = color.replace("#","");
                                                    $.ajax({
														url: '<?php echo DOMAIN; ?>/index.php?page=dashboard&view=store&action=ajax&request=colorchange',
														type: 'POST',
														data: 'store_color-type=item-font-color-normal&store_color-code=' + color,
														success: function(data) {
															if(data.success) {
																document.getElementById('iframe-window').contentWindow.location.reload();	
															}
														}
													},'json');
                                                }
                                            });
                                            </script>
                                        </div>
                                    	
                                    </div>
                                
                                </div>
                            </div>
                        
                       		<!--IFRAME-->
                        	<iframe src="<?php echo DOMAIN; ?>/templates/default/dashboard/stores/navbarframe.template.php" width="100%" height="800" id="iframe-window"></iframe>  
                                        
                    </div>
                </div>
                
                <div class="form-group pull-right">
                  <input type="button" class="btn btn-default" name="" value="Next" id="stage-2-button"/>
                </div>
                
                <script type="text/javascript">
                    $(document).ready(function() {
                        $('#stage-2-button').click(function() {
                            //Hide 1, Show 2
                            $('#stage-3').show();
                            $('#stage-2').hide();
                            
                            //Complete Bar
                            $('#2').attr('class', 'col-xs-3 bs-wizard-step complete');
                            $('#3').attr('class', 'col-xs-3 bs-wizard-step active');
                                            
                        });
                    });
                </script>
                                 
            </div> 
            <!-- STAGE 2 END -->
            
            <!--STAGE 1 -->
            <div id="stage-1"> 
            	
                <h4>Store Information <small>This will be used on your store.</small></h4>
                
                <form action="" method="post" id="stage-1-form">
                	
                    <div class="form-group">
                      <label>Store Username: </label>
                      <input type="text" class="form-control" name="store_username" value="" placeholder="carstore"/> <small>URL Example: https://www.savemari.com/store/carstore</small>
                    </div>
                    
                    <div class="form-group">
                      <label>Store Title:</label>
                      <input type="text" class="form-control" name="store_title" value="" placeholder="Store Name"/>
                    </div>
                    
                    <div class="form-group">
                      <label>Store Description:</label>
                      <textarea type="text" class="form-control" name="store_description" rows="4" cols="0" placeholder="Store Description"/></textarea>
                    </div>
                    
                    <div class="form-group">
                      <label>Store Keywords:</label>
                      <textarea type="text" class="form-control" name="store_keywords" rows="4" cols="0" placeholder="e.g. cars, car parts, wheels"/></textarea>
                    </div>
                    
                    <div class="form-group">
                      <label>Store About Us:</label>
                      <textarea type="text" class="form-control" name="store_aboutus" rows="4" cols="0" placeholder="We started in early 2007 designing a fantastic range of clothing for all customers. We take provide in our products and want you to enjoy them as much as we enjoyed creating them."/></textarea>
                    </div>
                    
                    <h4>Contact Information <small>This will be used when customers need to contact you.</small></h4>
                    
                    <div class="form-group">
                      <label>Email:</label>
                      <input type="text" class="form-control" name="store_email" value="" placeholder="sales@domain.co.uk"/>
                    </div>
                    <div class="form-group">
                      <label>Address: (This will be displayed on the contact page)</label>
                      <textarea type="text" class="form-control" name="store_address" rows="4" cols="0" placeholder="My Company Name
        1234 Some Street
        Cool City, Somewhere 12345"/></textarea>
                    </div>
                    
                    <div class="form-group">
                      <label>Phone Number 1: (This will be displayed on the contact page)</label>
                      <input type="text" class="form-control" name="store_phone" value="" placeholder="+4407876567876"/>
                    </div>
                    
                    <div class="form-group">
                      <label>Phone Number 2: (This will be displayed on the contact page)</label>
                      <input type="text" class="form-control" name="store_phone1" value="" placeholder="+4407876567876"/>
                    </div>
                    
                    <div class="form-group">
                      <label>Phone Number 3: (This will be displayed on the contact page)</label>
                      <input type="text" class="form-control" name="store_phone2" value="" placeholder="+4407876567876"/>
                    </div>
                    
                    <div class="form-group">
                      <label>Whatsapp: (This will be displayed on the contact page)</label>
                      <input type="text" class="form-control" name="store_whatsapp" value="" placeholder="+4407876567876"/>
                    </div>
                    
                    <h4>Social Media <small>This will be displayed on the website header.</small></h4>
                    <div class="form-group">
                      <label>Twitter URL:</label>
                      <input type="text" class="form-control" name="store_twitter" value="" placeholder="https://www.twitter.com/name"/>
                    </div>                  
    
                    <div class="form-group">
                      <label>Facbeook URL:</label>
                      <input type="text" class="form-control" name="store_facebook" value="" placeholder="https://www.facebook.com/name"/>
                    </div>
                    <div class="form-group">
                      <label>Google URL:</label>
                      <input type="text" class="form-control" name="store_google" value="" placeholder="http://www.google.com/business/name"/>
                    </div>
                        
                    <div class="form-group">
                    	<label>Payment Details</label>
                        <textarea class="form-control" name="store_paymentmethod"></textarea>
                    </div>
                    
                    <div class="form-group">
                    	<label>EchoCash:</label>
                        <textarea class="form-control" name="store_echocash"></textarea>
                    </div>
                    
                    <div class="form-group pull-right">
                      <input type="button" class="btn btn-default" name="" value="Next" id="stage-1-button"/>
                    </div>
                
                </form>
                
                <script type="text/javascript">
                    $(document).ready(function() {
                        $('#stage-1-button').click(function() {
                            $.ajax({
                                url: '<?php echo DOMAIN; ?>/index.php?page=dashboard&view=store&action=ajax&request=stage-1-process',
                                type: 'POST',
                                data: $('#stage-1-form').serialize(),
                                success:function(data) {
                                    if(data.error) {
                                        $('#store-error').html(data.error);
                                        $('#store-error').show();
                                    } else {
                                        if(data.success) {
                                            
                                            //Hide Error
                                            $('#store-error').hide();
                                            
                                            //Hide 1, Show 2
                                            $('#stage-2').show();
                                            $('#stage-1').hide();
                                            
                                            //Complete Bar
                                            $('#1').attr('class', 'col-xs-3 bs-wizard-step complete');
                                            $('#2').attr('class', 'col-xs-3 bs-wizard-step active');
                                            
                                            
                                        }
                                    }
                                }
                            }, 'json');
                        });
                    });
                </script>
            
            </div> 
            <!-- STAGE 1 END-->
        
        </div>
      </div>
    </div>
  </div>
</div>

