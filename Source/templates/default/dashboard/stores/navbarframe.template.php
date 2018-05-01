<?php 

//Session Start
session_start();

//Define Domain
define('DOMAIN', 'https://www.creativemiles-labs.co.uk/savemari'); 

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
    <meta name="description" content=""/>
    <link rel="canonical" href="" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="" />
    <meta property="og:description" content="" />
    <meta property="og:url" content="" />
    <meta property="og:site_name" content="" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:description" content="" />
    <meta name="twitter:title" content="" />
    <meta name="google-site-verification" content="" />
    
    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"> 
    
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    
    <!-- JCAROUSEL -->
    <script src="<?php echo DOMAIN; ?>/templates/default/javascript/jcarousel/jquery.jcarousel.min.js"></script>
    <script src="<?php echo DOMAIN; ?>/templates/default/javascript/jcarousel/jcarousel.responsive.js"></script>
    <!-- Go to www.addthis.com/dashboard to customize your tools --> 
    
	<!-- <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-58c44f7d6d5aadd2"></script> --> 
    <script src="<?php echo DOMAIN; ?>/templates/default/javascript/image-picker/image-picker.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo DOMAIN; ?>/templates/default/javascript/image-picker/image-picker.css"/>
    
    <!-- STYLESHEET -->
    <link rel="stylesheet" type="text/css" href="<?php echo DOMAIN; ?>/templates/default/stores/stylesheet.css"/>
   
	<!--VIEWPORT-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
</head>

<body>

<!--CONTAINER-->
<div class="container">
	<div class="row" id="top">
    	<div class="col-sm-12">
       		<ul class="pull-right">
            	<li><a href="#">Visit SaveMari.com</a></li>
                <li><a href="#">Login</a></li>
            </ul>
        </div>
    </div>
    <div class="row" id="header">
    	<div class="col-sm-6" id="header-logo">
        	
			<?php
				if(isset($_SESSION['sa_store']['store-logo']) && @$_SESSION['sa_store']['store-logo'] != '') {
					echo '<a href="#"><img src="'.DOMAIN.'/uploads/store_images/temp_images/'.@$_SESSION['sa_store']['store-logo'].'" alt="" style="max-height:150px;max-width:250px;"></a>';	
				} else {
					echo '<a href="#"><img src="'.DOMAIN.'/templates/default/images/stores/250x100defaultlogo.jpg" alt=""></a>';				
				}
			?>
        	
        </div>
        <div class="col-sm-6">
        	<div class="row" id="header-brand">
            	<div class="col-sm-12">
                	<p><img src="<?php echo DOMAIN; ?>/templates/default/images/stores/225x25brandlogo.png" alt=""></p>
                </div>
            </div>
        	<div class="row" id="header-description">
            	<div class="col-sm-12">
                	<p></p>
                </div>
            </div>
            <div class="row" id="header-social">
            	<div class="col-sm-12">
                	<ul>
                    	<li><a href="#"><img src="<?php echo DOMAIN; ?>/templates/default/images/stores/Facebook.png" width="32" height="32" /></a></li>
                        <li><a href="#"><img src="<?php echo DOMAIN; ?>/templates/default/images/stores/Google.png" width="32" height="32" /></a></li>
                        <li><a href="#"><img src="<?php echo DOMAIN; ?>/templates/default/images/stores/Twitter.png" width="32" height="32" /></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
	function cssvalue($var, $property) {
		
		//Load Store Session
		$store_colors = @$_SESSION['sa_store']['store-colors'];	
		
		//Switch Return
		switch($var) {
			case 'menu-color': {
				return $property.':#'.$store_colors['menu-color'].';';
				break;	
			}
			case 'item-background-active': {
				return $property.':#'.$store_colors['item-background-active'].';';
				break;
			}
			case 'item-font-color-active': {
				return $property.':#'.$store_colors['item-font-color-active'].';';
				break;	
			}
			case 'item-font-color-normal': {
				return $property.':#'.$store_colors['item-font-color-normal'].';';
				break;	
			}
		}
				
	}
?>

<style type="text/css">
	
	/* Navbar */
	.navbar-default .navbar-brand {
    	color: rgba(119, 119, 119, 1);
	}
	.navbar-default {
		font-size: 14px;
		<?php echo cssvalue('menu-color','background-color'); ?>
		background-image:none;
		border-width: 1px;
		border-radius: 4px;
	}
	.navbar-default .navbar-nav>li>a {
		<?php echo cssvalue('item-font-color-normal','color'); ?>
		background:none;
		background-image:none;
	}
	.navbar-default .navbar-nav>li>a:hover,
	.navbar-default .navbar-nav>li>a:focus {
		<?php echo cssvalue('item-font-color-active','color'); ?>
		<?php echo cssvalue('item-background-active','background-color'); ?>
		background-image:none;
	}
	.navbar-default .navbar-nav>.active>a,
	.navbar-default .navbar-nav>.active>a:hover,
	.navbar-default .navbar-nav>.active>a:focus {
		<?php echo cssvalue('item-font-color-active','color'); ?>
		<?php echo cssvalue('item-background-active','background-color'); ?>
		background-image:none;
		box-shadow: none;
	}
	.navbar-default .navbar-toggle {
		border-color: #ddd;
	}
	.navbar-default .navbar-toggle:hover,
	.navbar-default .navbar-toggle:focus {
		<?php echo cssvalue('item-background-active','background-color'); ?>
		background-image:none;
	}
	.navbar-default .navbar-toggle .icon-bar {
		background-color: #888;
		background-image:none;
	}
	.navbar-default .navbar-toggle:hover .icon-bar,
	.navbar-default .navbar-toggle:focus .icon-bar {
		<?php echo cssvalue('item-background-active','background-color'); ?>
		background-image:none;
	}
	
	/* Panel Heading */
	.panel-default>.panel-heading {
		background-image: none;
		background-color: rgba(248, 248, 248, 1);
	}
	
	/*Buttons*/
	.btn-default {
		text-shadow:none;
		background-image: none;
		border-color: #dbdbdb;
		box-shadow:none;
		<?php echo cssvalue('item-font-color-active','color'); ?>
		<?php echo cssvalue('item-background-active','background-color'); ?>
		<?php echo cssvalue('item-background-active','border-color'); ?>
	}
	
	/* Footer */
	#footer {
		<?php echo cssvalue('menu-color','background-color'); ?>	
	}
		
	
</style>

<!-- MENU -->
<div class="container" id="menu">
    <nav class="navbar navbar-default">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
    
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Homepage <span class="sr-only">(current)</span></a></li>
            <li><a href="#">Products</a></li>
          </ul>
          
          <form class="navbar-form navbar-left">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Search">
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
          </form>
          
          <ul class="nav navbar-nav navbar-right">
          	<li><a href="#">About Us</a></li>
            <li><a href="#">Contact Us</a></li>
          </ul>
          
        </div><!-- /.navbar-collapse -->
    </nav>
</div><!-- /.container-fluid -->

<!--CAROUSEL-->
<div class="container" id="homepage-carousel">
 	
    <!--CAROUSEL-->
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      
      <!-- Indicators -->
      <ol class="carousel-indicators">
      	<?php if(isset($_SESSION['sa_store']['store-banners']) && is_array($_SESSION['sa_store']['store-banners']) && count($_SESSION['sa_store']['store-banners']) > 0) { ?>
       	<?php $active_trigger1 = 0; ?>
			<?php foreach($_SESSION['sa_store']['store-banners'] AS $ban_key => $ban_name) { ?>
                <li data-target="#myCarousel" data-slide-to="0" <?php if($active_trigger1==0) { echo 'class="active"'; $active_trigger1=1;} ?>></li>
            <?php } ?>
        <?php } ?>
      </ol>
      
      <!-- Wrapper for slides -->
      <div class="carousel-inner" style="overflow-y:hidden;max-height:360px;">
        	
      	<?php if(isset($_SESSION['sa_store']['store-banners']) && is_array($_SESSION['sa_store']['store-banners']) && count($_SESSION['sa_store']['store-banners']) > 0) { ?>
        	<?php $active_trigger2 = 0; ?>
            <?php foreach($_SESSION['sa_store']['store-banners'] AS $ban_key => $ban_name) { ?>
            <div class="item <?php if($active_trigger2==0) { echo 'active'; $active_trigger2=1;} ?>">
              <img src="<?php echo DOMAIN; ?>/uploads/store_images/temp_images/<?php echo $ban_name; ?>" alt="" style="height:auto;width:960px;">
            </div>
            <?php } ?>
        <?php } else { ?>
        <div class="item active">
          <img src="<?php echo DOMAIN; ?>/templates/default/images/stores/960x350defaultbanner.jpg" alt="">
        </div>
        <?php } ?>
        
      </div>
      
      <!-- Left and right controls -->
      <a class="left carousel-control" href="#myCarousel" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#myCarousel" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
    
</div>

<!--CONTENT-->	
<div class="container" id="content">
	<div class="row">
    	<div class="col-sm-3">
        	
            <div class="panel panel-default">
            	<div class="panel-heading"><span class="glyphicon glyphicon-search"></span> Search</div>
                <div class="panel-body">
                	
                	<div class="form-group">
                    	<label>Location:</label>
                        <select class="form-control">
                        	<option value="">Test</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                    	<input type="submit" name="" class="btn btn-default" value="search">
                    </div>
                </div>
            </div>
            
            
        </div>
        <div class="col-sm-9">
        	
            <?php for($c=1;$c<=3;$c++) { ?>
                <div class="row">
                    <?php for($i=1;$i<=3;$i++) { ?>
                    <div class="col-sm-4">
                        <div class="panel panel-default">
                            
                            <div class="panel-body">
                                <div class="product-wrapper">
                                    <div class="row">
                                        <div class="col-sm-12">
                                                                            
                                            <!-- Trigger the Modal -->
                                            <img id="myImg<?php echo $i; ?>" src="https://www.creativemiles-labs.co.uk/savemari/templates/default/images/cloths-200x200.jpg" alt="Trolltunga, Norway" width="300" height="200" class="img-responsive">
                                            
                                            <!-- The Modal -->
                                            <div id="myModal<?php echo $i; ?>" class="modal">
                                                <!-- The Close Button -->
                                                <span class="close" onclick="document.getElementById('myModal<?php echo $i; ?>').style.display='none'">&times;</span>
                                              
                                                <!-- Modal Content (The Image) -->
                                                <img class="modal-content" id="img01<?php echo $i; ?>">
                                                
                                                <!-- Modal Caption (Image Text) -->
                                                <div id="caption"></div>
                                            </div>
                                            
                                            <script type="text/javascript">
                                                // Get the modal
                                                var modal = document.getElementById('myModal<?php echo $i; ?>');
                                                
                                                // Get the image and insert it inside the modal - use its "alt" text as a caption
                                                var img = document.getElementById('myImg<?php echo $i; ?>');
                                                var modalImg = document.getElementById("img01<?php echo $i; ?>");
                                                var captionText = document.getElementById("caption");
                                                img.onclick = function(){
                                                    modal.style.display = "block";
                                                    modalImg.src = this.src;
                                                    captionText.innerHTML = this.alt;
                                                }
                                                
                                                // Get the <span> element that closes the modal
                                                var span = document.getElementsByClassName("close")[0];
                                                
                                                // When the user clicks on <span> (x), close the modal
                                                span.onclick = function() { 
                                                  modal.style.display = "none";
                                                }
                                            </script>
            
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="caption">
                                                <h4><a href="http://www.jmpprint.co.uk/index.php?route=product/product&amp;product_id=43">Personalized High Vis Vests</a></h4>
                                                <p>Intel Core 2 Duo processor Powered by an Intel Core 2 Duo.</p>
                                                <!-- Go to www.addthis.com/dashboard to customize your tools  <div class="addthis_inline_share_toolbox"></div>-->
                                            </div>
                                            <a href="#" class="btn btn-default btn-block"><span class="glyphicon glyphicon-tag"></span> View Listing <span class="label label-danger">$500.00</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <?php } ?>
                </div>
            <?php } ?>
            
        </div>
    </div>
</div>

<!--FOOTER-->
<div class="container" id="footer">
	<div class="row">
    	<div class="col-sm-6">
        	<p>&copy; Savemari.com</p>
        </div>
        <div class="col-sm-6"></div>
    </div>
</div>
   
</body>
</html>