<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
?>
<!--CONTENT-->	
<div class="container grid" id="content">
	<div class="row">
    
    	<div class="col-sm-3">
            <?php require(ROOT.'/templates/default/stores/sidebar.template.php'); //Sidebar ?>
        </div>
        
        <div class="col-sm-9">
        
        	<div class="row">
            	<div class="col-sm-12">
                    <ul class="pagination pull-right">
                        <?php echo $paginate->renderPages(); ?>
                    </ul>
                </div>
            </div>
            
            <!--ROW OF PRODUCTS -->
            <div class="row">
                <?php				
                if($SQLRows > 0) { //Do we have records?
                    while($SQLData = db::fetch($SQLQuery)) { //Fetch 
                        require(ROOT.'/templates/default/stores/assets/product_template.template.php');
                    } 
                } else {
                    echo '<div class="alert alert-warning">You do not yet have any products for this store.</div>';
                } 
                ?>
            </div>
            <!-- END OF ROW OF PRODUCTS -->
     		
            <div class="row">
            	<div class="col-sm-12">
                    <ul class="pagination pull-right">
                        <?php echo $paginate->renderPages(); ?>
                    </ul>
                </div>
            </div>
                   
        </div>
    </div>
    
</div>