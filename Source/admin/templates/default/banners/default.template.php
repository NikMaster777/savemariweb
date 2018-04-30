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
        	<h3>Banners</h3>
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
            	<div class="panel-heading">Banners</div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td>Banner Name</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                            <?php while($bannerData = db::fetch($bannerSQL)) { ?>
                                <tr>
                                    <td><?php echo lib::san($bannerData['banner_name'],false,true,true); ?></td>
                                    <td>
                                        <a href="<?php echo ADMINDOMAIN; ?>/?action=banners&method=edit_banner&banner_id=<?php echo $bannerData['banner_id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
            </div>
            <?php } else { ?>
            	<div class="alert alert-warning">You have no banners to show, be the first to add a new client.</div>
            <?php } ?>
                        
        </div>
    </div>
    <div class="row footer-row">
    	<div class="col-sm-4 left"></div>
    	<div class="col-sm-8 right">
        	<?php echo $paginate->renderPages(); ?>
        </div>
    </div>
</div>