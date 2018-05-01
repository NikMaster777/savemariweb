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
            	<h4>My Store</h4>
                <p>You can manage your store and all of it's settings here.</p>
            </span>
        </div>
        <div class="col-sm-6">
        	<div class="clearfix">
                <div class="pull-right">
                    <a href="<?php echo DOMAIN; ?>/index.php?page=dashboard" class="btn btn-default">Go Back</a>   
                </div>
            </div>
        </div>
    </div>
        
    <div class="row">
    	<div class="col-sm-3">
        	 <?php require(ROOT.'/templates/default/dashboard/stores/sidebar/sidemenu.template.php'); ?>
        </div>
        <div class="col-sm-9">
        
        	<!--CONTENT-->
            <div class="panel panel-default">
              <div class="panel-body">
  			  	<?php 
				switch(lib::get('option')) {
					case 'redeem': {
						require(ROOT.'/templates/default/dashboard/stores/sidebar/redeem.template.php'); 
						break;	
					}
					case 'categories': {
						require(ROOT.'/templates/default/dashboard/stores/sidebar/categories.template.php'); 
						break;	
					}
					case 'custom-fields': {
						require(ROOT.'/templates/default/dashboard/stores/sidebar/custom_fields.template.php'); 
						break;	
					}
					case 'manage-products': {
						switch(lib::get('do')) {
							default: {
								require(ROOT.'/templates/default/dashboard/stores/sidebar/products/default.template.php'); 
								break;	
							}
							case 'add_product': {
								require(ROOT.'/templates/default/dashboard/stores/sidebar/products/add_product.template.php'); 
								break;	
							}
							case 'edit_product': {
								require(ROOT.'/templates/default/dashboard/stores/sidebar/products/edit_product.template.php'); 
								break;
							}
							case 'delete_product': {
								require(ROOT.'/templates/default/dashboard/stores/sidebar/products/delete_product.template.php'); 
								break;	
							}
						}
						break;	
					}
					case 'edit-colors': {
						require(ROOT.'/templates/default/dashboard/stores/sidebar/edit_colors.template.php'); 
						break;	
					}
					case 'edit-logo': {
						require(ROOT.'/templates/default/dashboard/stores/sidebar/edit_logo.template.php'); 
						break;	
					}
					case 'edit-banners': {
						require(ROOT.'/templates/default/dashboard/stores/sidebar/edit_banners.template.php'); 
						break;	
					}
					case 'edit-store': {
						require(ROOT.'/templates/default/dashboard/stores/sidebar/edit_store.template.php'); 
						break;	
					}
					default: {
						require(ROOT.'/templates/default/dashboard/stores/sidebar/default.template.php'); 
						break;
					}
				}
				?>
              </div>
            </div>
                        
        </div>
        
        
    </div>
    
</div>

