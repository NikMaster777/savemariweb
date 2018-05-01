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
    	<div class="col-sm-6">
        	<span class="align-middle">
            	<h4>My Dashboard</h4>
                <p>This is your dashboard, you can manage your adverts, store and account settings here.</p>
            </span>
        </div>
        <div class="col-sm-6">
        	<div class="clearfix">
                <div class="pull-right">
                	<?php if($store) { ?>
                    	<a href="<?php echo DOMAIN; ?>/index.php?page=dashboard&view=store&action=manage" class="btn btn-default">Manage Store</a>
                        <a href="<?php echo DOMAIN; ?>/stores/<?php echo lib::san($storeData['store_username'],false,true,true); ?>" class="btn btn-default" target="_blank">Visit Store</a>
                    <?php } else { ?>
                    	<a href="<?php echo DOMAIN; ?>/index.php?page=dashboard&view=store&action=create" class="btn btn-default">Create Store</a> 
                    <?php } ?>
                    <a href="<?php echo DOMAIN; ?>/index.php?page=dashboard&view=adverts&action=create" class="btn btn-default">Create Advert</a>   
                </div>
            </div>
            <div class="clearfix">
            	
                <!--PAGINATE-->
            	<?php if(in_array(lib::get('option'), array('featured-listings','sponsered-listings')) | lib::get('option') == '') { ?>
                <ul class="pagination pull-right">
                    <?php echo $paginate->renderPages(); ?>
                </ul>
                <?php } ?>
                
            </div>
        </div>
    </div>
        
    <div class="row">
    	<div class="col-sm-3">
        	 <?php require(ROOT.'/templates/default/dashboard/sidemenu.template.php'); ?>
        </div>
        <div class="col-sm-9">
        
        	<!--CONTENT-->
            <div class="panel panel-default">
              <div class="panel-body">
  			  	<?php 
				switch(lib::get('option')) {
					case 'edit-profile': {
						require(ROOT.'/templates/default/dashboard/editprofile.template.php');
						break;	 
					}
					case 'change-password': {
						require(ROOT.'/templates/default/dashboard/changepassword.template.php');
						break;	
					}
					case 'featured-listings': {
						require(ROOT.'/templates/default/dashboard/listingtemplate.template.php'); 
						break;
					}
					case 'sponsered-listings': {
						require(ROOT.'/templates/default/dashboard/listingtemplate.template.php'); 
						break;
					}
					default: {
						require(ROOT.'/templates/default/dashboard/listingtemplate.template.php'); 
						break;
					}
				}
				?>
              </div>
            </div>
            
            <!--PAGINATE-->
            <?php if(in_array(lib::get('option'), array('featured-listings','sponsered-listings')) | lib::get('option') == '') { ?>
            <ul class="pagination pull-right">
				<?php echo $paginate->renderPages(); ?>
            </ul>
            <?php } ?>
            
        </div>
        
        
    </div>
    
</div>

