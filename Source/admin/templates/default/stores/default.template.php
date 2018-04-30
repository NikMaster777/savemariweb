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
        	<h3>View Stores (<?php echo number_format($records); ?>)</h3>
        </div>
        <div class="col-sm-6 right">
        	<div class="form-group">
                
            </div>
        </div>
    </div>
    <div class="row button-row">
    	<div class="col-sm-4 left">
        	<div class="input-group">
                
            </div>
        </div>
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
            	<div class="panel-heading">Stores</div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td>Store Username</td>
                                    <td>Store Status</td>
                                    <td>Store Products</td>
                                    <td>Store Package</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                            <?php while($storeData = db::fetch($storeSQL)) { ?>
                                <tr>
                                    <td><?php echo lib::san($storeData['store_username'],false,true,true); ?></td>
                                    <td><?php if($storeData['store_activated']) { ?><div class="label label-success">Activated</div><?php } else { ?><div class="label label-danger">Deactivated</div><?php } ?></td>
                                    <td><?php echo db::nRows("SELECT `advert_id` FROM `".config::$db_prefix."adverts` WHERE `advert_storeid`='".$storeData['store_id']."'"); ?></td>
                                    <td><?php $storePack = db::fetchQuery("SELECT * FROM `".config::$db_prefix."stpacks` WHERE `pack_id`='".$storeData['store_packid']."'"); echo $storePack['pack_title'];  ?></td>
                                    <td>
                                    	<a href="<?php echo ADMINDOMAIN; ?>/?action=stores&method=delete_store&store_id=<?php echo $storeData['store_id']; ?>" id="" class="btn btn-xs btn-danger" tabindex="Remove Store"><span class="glyphicon glyphicon-remove"></span></a>
                                        <a href="<?php echo ADMINDOMAIN; ?>/?action=stores&method=edit_store&store_id=<?php echo $storeData['store_id']; ?>" class="btn btn-xs btn-default" title="Edit Store""><span class="glyphicon glyphicon-pencil"></span></a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
            </div>
            <?php } else { ?>
            	<div class="alert alert-warning">You have no stores to show, be the first to add a new client.</div>
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