<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/
if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php $actual_link = (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>
	<?php if($actual_link=="https://www.savemari.com/"){ ?> 
	    <title>Zim Classifieds Cars, Flats to Rent and Houses for Sale in Harare  Zimbabwe</title>
        <meta name="description" content="Post Classified Ads in MANICALAND Harare Zimbabwe at savemari.com. The Largest online advertising platform where you can buy, sell and find cars flats to rent and houses for sale."/>
	<?php } ?>
	<?php if($actual_link=="https://www.savemari.com/index.php?page=search&category=110&subcat=114"){ ?> 
	    <title>Property, Flats and Houses for Sale in zimbabwe bulawayo Harare Online</title>
        <meta name="description" content="List your zambezi flats, houses and Property for Sale in Harare Online. At Save Mari you can easily find Houses For Sale In Harare Zimbabwe Bulawayo and buy online at best competitive market prices."/>
	<?php } ?>
	<?php if($actual_link=="https://www.savemari.com/index.php?page=search&category=92&subcat=95"){ ?> 
	    <title>Used Notepads sale, Tablets and  Ipads For Sale In Harare Zim</title>
        <meta name="description" content="Come browse our New and Used Notepads sale, Tablets in Zimbabwe. You can easily find ipads for sale in Harare online at savemari.com the largest portal of Harare Zimbabwe on free delivery to your door."/>
	<?php } ?>
	<?php if($actual_link=="https://www.savemari.com/index.php?page=search&category=92&subcat=94"){ ?> 
	    <title>Mobile Phones, Cell phones for Sale in MASHONALAND EAST Zimbabwe</title>
        <meta name="description" content="Mobile Phones For Sale Zimbabwe online at savemari.com a biggest online selling and buying portal of Zimbabwe. You can just browse Cell Phones For Sale in MASHONALAND EAST and buy at affordable prices with ease."/>
	<?php } ?>
	<?php if($actual_link=="https://www.savemari.com/index.php?page=search&category=92&subcat=96"){ ?> 
	    <title>Computer Sales in VICTORIA FALLS and Laptop Sales in Harare</title>
        <meta name="description" content="Come and browse new and used Computer Sales in VICTORIA FALLS at savemari.com the biggest advertising portal of Zimbabwe.  You can also find Laptop Sales in Harare to buy them online at the best competitive prices."/>
	<?php } ?>
	<?php if($actual_link=="https://www.savemari.com/index.php?page=search&category=72&subcat=81"){ ?> 
	    <title>Zimclassifieds Cars For Sale In Harare Zimbabwe at savemari.com</title>
        <meta name="description" content="Come and browse Zimclassifieds Cars For Sale In Harare Zimbabwe at savemari.com the largest online Ads posting Portal of the Nation. You can find New and Used cars for sale and rental with ease at best market prices."/>
	<?php } ?>
	<?php if($actual_link=="https://www.savemari.com/?page=search&city=1&category=343"){ ?> 
	    <title>Baby Boy Clothes Sale Online in Harare Zimbabwe</title>
        <meta name="description" content="Baby Girls and Baby Boys Clothes for sale online at savemari.com in Harare Zimbabwe. You can find baby toys and pushchairs for sale at the biggest online advertising platform of Zimbabwe for selling, buying, rentals. Post your Ad now."/>
	<?php } ?>
	
	
	<?php if($actual_link=="https://www.savemari.com/?page=search&category=64"){ ?> 
	    <title>Home Appliences & Furniture Sale and Buy Online | Zim Classified  ads | Ladies and Men Clothing</title>
        <meta name="description" content="Baby Girls and Baby Boys Clothes for sale online at savemari.com in Harare Zimbabwe. You can find baby toys and pushchairs for sale at the biggest online advertising platform of Zimbabwe for selling, buying, rentals. Post your Ad now."/>
	<?php } ?>
	
	
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-110159889-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'UA-110159889-1');
    </script>
    

    <!-- Global site tag (gtag.js) - Google Analytics -->
    
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-113505840-1"></script>
    
    <script>
    
      window.dataLayer = window.dataLayer || [];
    
      function gtag(){dataLayer.push(arguments);}
    
      gtag('js', new Date());
    
     
    
      gtag('config', 'UA-113505840-1');
    
    </script>
    <link rel="canonical" href="<?php echo DOMAIN; ?>" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?php echo lib::getSetting('General_MetaTitle'); ?>" />
    <meta property="og:description" content="<?php echo lib::getSetting('General_MetaDescription'); ?>" />
    <meta property="og:url" content="<?php echo DOMAIN; ?>" />
    <meta property="og:site_name" content="<?php echo lib::getSetting('General_CompanyName'); ?>" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:description" content="<?php echo lib::getSetting('General_MetaDescription'); ?>" />
    <meta name="twitter:title" content="<?php echo lib::getSetting('General_MetaTitle'); ?>" />
    <meta name="google-site-verification" content="<?php echo lib::getSetting('General_GoogleMeta'); ?>" />
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"> 
    <link rel="stylesheet" type="text/css" href="<?php echo DOMAIN; ?>/templates/default/stylesheets/stylesheet.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo DOMAIN; ?>/templates/default/stylesheets/font-awesome-4.7.0/css/font-awesome.min.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo DOMAIN; ?>/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo DOMAIN; ?>/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo DOMAIN; ?>/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo DOMAIN; ?>/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo DOMAIN; ?>/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo DOMAIN; ?>/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo DOMAIN; ?>/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo DOMAIN; ?>/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo DOMAIN; ?>/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo DOMAIN; ?>/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo DOMAIN; ?>/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo DOMAIN; ?>/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo DOMAIN; ?>/favicons/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    
    <!-- Placed at the end of the document so the pages load faster -->
	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    
    <!-- JCAROUSEL -->
    <script src="<?php echo DOMAIN; ?>/templates/default/javascript/jcarousel/jquery.jcarousel.min.js"></script>
    <script src="<?php echo DOMAIN; ?>/templates/default/javascript/jcarousel/jcarousel.responsive.js"></script>
    <!-- Go to www.addthis.com/dashboard to customize your tools --> 
	<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-58c44f7d6d5aadd2"></script> 
    
    <script src="<?php echo DOMAIN; ?>/templates/default/javascript/image-picker/image-picker.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo DOMAIN; ?>/templates/default/javascript/image-picker/image-picker.css"/>

    <!--NUMERAL-->
    <script src="<?php echo DOMAIN; ?>/templates/default/javascript/numeral.js"></script>
    
    <!--Start of Tawk.to Script-->
	<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/59c6d655c28eca75e4621d74/default';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
    <!--End of Tawk.to Script-->
    
    <script type="text/javascript">
		  $(document).ready(function() {
						$('.jcarousel').jcarouselAutoscroll({
				target: '+=3'
			});
		  });
          </script>
          
          
         
        <?php if(isset($advertData) && lib::get('advert'))  {?>
        <!-- Open Graph data -->
        <meta property="og:title" content="<?php echo lib::san($advertData['advert_title']); ?>" />
        <meta property="og:type" content="article" />
        <meta property="og:url" content="https://www.savemari.com/advert/<?php echo lib::san($advertData['advert_seo_url'],false,true,true); ?>/advert-id/<?php echo $advertData['advert_id']; ?>" />
        <meta property="og:image" content="<?php foreach($advert->getImages($advertData['advert_id']) AS $image_id => $image_name) { ?><?php echo DOMAIN.'/index.php?image=adverts&size=364&image_name='.$image_name; ?><?php break; } ?>" />
        <meta property="og:description" content="<?php echo strip_tags($advertData['advert_html'], '<strong><ol><em><ul><li><p><br><br/>'); ?>" />
    <?php } ?>
</head>
</body>



<!--BLACKTAPE-->
<div id="blacktape">
	<div class="container">
    	<div class="row">
        	<!-- <div class="col-sm-6 icons">
                <a href="https://www.facebook.com/savemari.peter" class="srvicon fa fa-facebook" target="_blank" title="Facebook"></a>
                <a href="https://twitter.com/savemari263?lang=en" class="srvicon fa fa-twitter" target="_blank" title="Twitter"></a>
            </div> -->
            <div class="col-sm-6">
            	<a href="<?php echo DOMAIN; ?>"><img src="<?php echo lib::getSetting('General_LogoURL'); ?>" alt="<?php echo lib::getSetting('General_CompanyName'); ?>" class="img-responsive"/></a>
            </div>
            <div class="col-sm-6 buttons">
            	<div class="form-inline pull-right">
                	<?php if(!session::active()) { ?>
                    	<a href="<?php echo DOMAIN; ?>/index.php?page=register" class="btn btn-xs btn-default">Register</a>
                    <?php } else { ?>
                    	<label>Hello <?php echo session::data('user_firstname',false,true,true); ?>!</label>
                    	<a href="<?php echo DOMAIN; ?>/index.php?page=logout" class="btn btn-xs btn-default">Logout</a>
                    <?php } ?>
                    <?php if(session::active()) { ?>
                    	<a href="<?php echo DOMAIN; ?>/index.php?page=dashboard" class="btn btn-xs btn-default">My Account</a>
                    <?php } else { ?>
                    	<a href="<?php echo DOMAIN; ?>/index.php?page=login" class="btn btn-xs btn-default">My Account</a>
                    <?php } ?>
                                  
                    <div class="dropdown" style="display:inline;">
                      <a href="<?php echo DOMAIN; ?>/index.php?page=contactus" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown">Need Help <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          <li><a href="<?php echo DOMAIN; ?>/index.php?page=needhelp&view=faq">FAQ</a></li>
                          <li><a href="<?php echo DOMAIN; ?>/index.php?page=needhelp&view=clickandcollect">What is Click &amp; Collect</a></li>
                          <li><a href="<?php echo DOMAIN; ?>/index.php?page=needhelp&view=postingadverts">Posting Adverts and Ad(s) management</a></li>
                        </ul>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- HEADER 
<div id="header">
	<div class="container">
    	<div class="row">
        	<div class="col-sm-6">
            	<a href="<?php echo DOMAIN; ?>"><img src="<?php echo lib::getSetting('General_LogoURL'); ?>" alt="<?php echo lib::getSetting('General_CompanyName'); ?>" class="img-responsive"/></a>
                <span class="logo-text">Zimbabwe Classified Ads | Buying and Selling Platform</span>
            </div>
        </div>
    </div>
</div>-->


<?php if(!in_array(lib::get('page'),array('dashboard'))) { ?>
<!--SEARCH & CAT BAR -->
<div class="container">
	<div class="row">
    	<div class="col-sm-12">
        	
            <form action="<?php echo DOMAIN; ?>" method="get">
            <input type="hidden" name="page" value="search" />
            <div class="search_bar">
                <div class="row">
                	<div class="col-sm-3">
                        <select name="city" id="user_city" class="form-control">
                            <option class="" value="">Select City/Town</option>
                            <?php foreach($cities AS $city_id => $city_name) { ?>
                            	<option value="<?php echo $city_id; ?>" <?php if(lib::get('city') == $city_id) { echo 'selected';} ?>><?php echo $city_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group"> 
                            <input type="text" value="<?php echo lib::get('query'); ?>" name="query" id="user_query" class="form-control" placeholder="What are you looking for?" />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group form-group">
                             <select name="category" id="user_cat" class="form-control">
                             		<option value="">All Categories</option>
                             		<?php foreach($categories AS $key => $parent) { ?>
                                    <option value="<?php echo lib::san($parent['cat_id']); ?>" <?php if(lib::get('category') == $parent['cat_id']) { echo 'selected';} ?>><?php echo lib::san($parent['cat_name']); ?></option>
                                    <!-- <?php foreach($parent['cat_child'] AS $child_key => $child) { ?>
									<option value="<?php echo lib::san($child['cat_id']); ?>" <?php if(lib::get('category') == $child['cat_id']) { echo 'selected';} ?>>- <?php echo lib::san($child['cat_name']); ?></option>	
									<?php } ?> -->
                                <?php } ?>
                            </select>
                            <!-- /input-group -->
                            <span class="input-group-btn">
                              <input class="btn btn-default" type="submit" id="search_button" value="Go!" name="">
                            </span>
                        </div>
                    </div>
                    <script type="text/javascript">
                    	$(document).ready(function() {
							
							$('#search_button').click(function() {
								if($('#user_city').val() == '') {
									return false;
								}
								if($('#user_query').val() == '') {
									return false;
								}
							});
						});
						
                    </script>
                </div>
            </div>
            </form>
            
        </div> 
    </div>
</div>

<script type="application/javascript">
	
</script>

<style type="text/css">
	
	.mega-dropdown .navbar-default {
		background-image: none !important;
		border-radius: 0px;
		-webkit-box-shadow: none !important;
		box-shadow: none !important;
		border: none !important;
		background:none;
		margin-bottom:20px;
		min-height:30px !important;
		background:#eaeaea;
		
	}
	
	.mega-dropdown .navbar-collapse {
		border-top:1px solid #eaeaea !important;
		border-bottom:1px solid #eaeaea !important;
	}
	
	.mega-dropdown .navbar-default .navbar-collapse, .navbar-default .navbar-form {
		border-color: none !important;
	}
	
	.mega-dropdown .navbar-nav>li>.dropdown-menu {
	  margin-top: 0px;
	  border-top-left-radius: 4px;
	  border-top-right-radius: 4px;
	}
	
	.mega-dropdown .navbar-default .navbar-nav>li>a {
	 /*  width: 200px; */
	  font-weight: normal;
	  font-size:12px;
	  padding-top:5px;
	  padding-bottom:5px;
	}
	
	.mega-dropdown {
	  position: static !important;
	  /* width: 100%; */
	}	
	.mega-dropdown-menu {
	  padding: 10px 0px;
	  width: 100%;
	  box-shadow: none;
	  -webkit-box-shadow: none;
	}
	
	.mega-dropdown-menu:before {
	  /* content: "";
	  border-bottom: 15px solid #fff;
	  border-right: 17px solid transparent;
	  border-left: 17px solid transparent;
	  position: absolute;
	  top: -15px;
	  left: 285px;
	  z-index: 10; */
	}
	
	.mega-dropdown-menu:after {
	  /* content: "";
	  border-bottom: 17px solid #ccc;
	  border-right: 19px solid transparent;
	  border-left: 19px solid transparent;
	  position: absolute;
	  top: -17px;
	  left: 283px;
	  z-index: 8; */
	}
	
	.mega-dropdown-menu > li > ul {
	  padding: 0;
	  margin: 0;
	}
	
	.mega-dropdown-menu > li > ul > li {
	  float:left;
	  list-style: none;
	}
	
	.mega-dropdown-menu > li > ul > li > a {
	  display: block;
	  padding: 3px 20px;
	  clear: both;
	  font-weight: normal;
	  line-height: 1.428571429;
	  color: #333;
	  white-space: normal;
	}
	
	.mega-dropdown-menu > li ul > li > a:hover,
	.mega-dropdown-menu > li ul > li > a:focus {
	  text-decoration: none;
	  color: #333;
	  background-color: #eaeaea;
	}
	
	.mega-dropdown-menu .dropdown-header {
	  color: #5e5e5e;
	  font-size: 18px;
	  font-weight: bold;
	}
	
	.mega-dropdown-menu form {
	  margin: 0px 20px;
	}
	
	.mega-dropdown-menu .form-group {
	  margin-bottom: 3px;
	}
	
	/* Show the dropdown menu on hover */
	.dropdown-toggle:hover .dropdown-content {
		display: block;
	}
	
	.dropdown-toggle:hover {
		background: #b22222 !important;
    	background-color: #b22222 !important;
    	background-image: linear-gradient(to bottom, #b22222 0, #a32121 100%) !important;
		color:#FFF !important;
	}
		
</style>
    
<div class="container mega-dropdown">
  <nav class="navbar navbar-default" style="overflow:scroll-x;">
    
    <div class="navbar-header">
      <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".js-navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <!-- <a class="navbar-brand" href="#">MegaMenu</a> --> 
    </div>
    
    <div class="collapse navbar-collapse js-navbar-collapse ">
      
      <ul class="nav navbar-nav">
        
        <?php $megaparentSQL = db::query("SELECT * FROM `".config::$db_prefix."categories` WHERE `cat_parentid`='0' LIMIT 0,8");
			  while($megaparentData = db::fetch($megaparentSQL)) { ?>
              
        <!-- MAINCAT -->
        <li class="dropdown mega-dropdown scroll">
         
          <a href="<?php echo DOMAIN; ?>/?page=search&category=<?php echo $megaparentData['cat_id']; ?>" class="dropdown-toggle" data-toggle="dropdown" style="display:inline-block;">
		  	<?php echo lib::san($megaparentData['cat_name']); ?>
          </a>
          <!--SUBCATS-->
          <ul class="dropdown-menu mega-dropdown-menu row">
            
                <!-- START -->
                <li class="col-sm-3">
                    <ul>
  
                    <!--  <li class="dropdown-header">Dresses</li> -->
                    <?php $childSQL = db::query("SELECT * FROM `".config::$db_prefix."categories` WHERE `cat_parentid`='".$megaparentData['cat_id']."' LIMIT 0,5"); while($childData = db::fetch($childSQL)) { ?>
                        <li><a href="<?php echo DOMAIN; ?>/?page=search&&category=<?php echo $megaparentData['cat_id']; ?>&subcat=<?php echo $childData['cat_id']; ?>"><?php echo lib::san(substr($childData['cat_name'],0,50)); ?></a></li>                
                    <?php } ?>
               
               
                   </ul>
               </li>
               <!-- END -->
                   
                <!-- START -->
                <li class="col-sm-3">
                    <ul>
    
                    <!--  <li class="dropdown-header">Dresses</li> -->
                    <?php $childSQL = db::query("SELECT * FROM `".config::$db_prefix."categories` WHERE `cat_parentid`='".$megaparentData['cat_id']."' LIMIT 5,5"); while($childData = db::fetch($childSQL)) { ?>
                        <li><a href="<?php echo DOMAIN; ?>/?page=search&&category=<?php echo $megaparentData['cat_id']; ?>&subcat=<?php echo $childData['cat_id']; ?>"><?php echo lib::san(substr($childData['cat_name'],0,50)); ?></a></li>                
                    <?php } ?>
               
               
                   </ul>
               </li>
               <!-- END -->
                   
                <!-- START -->
                <li class="col-sm-3">
                    <ul>

                    <!--  <li class="dropdown-header">Dresses</li> -->
                    <?php $childSQL = db::query("SELECT * FROM `".config::$db_prefix."categories` WHERE `cat_parentid`='".$megaparentData['cat_id']."' LIMIT 10,5"); while($childData = db::fetch($childSQL)) { ?>
                        <li><a href="<?php echo DOMAIN; ?>/?page=search&&category=<?php echo $megaparentData['cat_id']; ?>&subcat=<?php echo $childData['cat_id']; ?>"><?php echo lib::san(substr($childData['cat_name'],0,50)); ?></a></li>
                    <?php } ?>
               
               
                   </ul>
               </li>
               <!-- END -->
                   
                <li class="col-sm-6 pull-right">
				  <?php if(isset($megaparentData['cat_image']) && $megaparentData['cat_image'] != '' && @file_exists(ROOT.'/uploads/cat_images/'.$megaparentData['cat_image'])) { ?>
                        <a href="#"><img src="<?php echo DOMAIN; ?>/uploads/cat_images/<?php echo $megaparentData['cat_image']; ?>" alt="" class="img-responsive" style="max-width:554px;max-height:194px;"></a>
                    <?php } else { ?>
                       <a href="#"> <img src="<?php echo DOMAIN; ?>/templates/default/images/mega-demo-image.jpg" alt="" class="img-responsive" style="max-width:554px;max-height:194px;"></a>
                    <?php } ?>
                </li>
                
          	</ul>
            
        </li>
        
        <?php } ?>
        
        
      </ul>
      
    </div>
    <!-- /.nav-collapse -->
    
  </nav>
</div>

<?php } ?>