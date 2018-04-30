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
        	<h3>Categories (<?php echo number_format($records); ?>)</h3>
        </div>
        <div class="col-sm-6 right">
        	<div class="form-group">
                <a href="<?php echo ADMINDOMAIN; ?>/?action=categories&method=create_cat" class="btn btn-default">Create Category</a>
            </div>
        </div>
    </div>
    <div class="row button-row">
    	<div class="col-sm-6 left">
        
        </div>
    	<div class="col-sm-6 right">
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
            	<div class="panel-heading">Adverts</div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td>Category Title</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                            <?php while($catData = db::fetch($catSQL)) { ?>
                                <tr>
                                    <td><b><?php echo lib::san($catData['cat_name'],false,true,true); ?></b></td>
                                    <td>                                   
                                        
                                        <a href="<?php echo ADMINDOMAIN; ?>/?action=categories&method=edit_cat&cat_id=<?php echo $catData['cat_id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
                                        <a href="<?php echo ADMINDOMAIN; ?>/?action=categories&method=delete_cat&cat_id=<?php echo $catData['cat_id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove
"></span></a>     
                                    </td>
                                </tr>
                                <?php $childSQL = db::query("SELECT * FROM `".config::$db_prefix."categories` WHERE `cat_parentid`='".$catData['cat_id']."'"); while($childData = db::fetch($childSQL)) { ?>
                                <tr>
                                    <td>- <?php echo lib::san($childData['cat_name'],false,true,true); ?></td>
                                    <td>                                   
                                      <a href="<?php echo ADMINDOMAIN; ?>/?action=categories&method=edit_cat&cat_id=<?php echo $childData['cat_id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>     
                                       <a href="<?php echo ADMINDOMAIN; ?>/?action=categories&method=delete_cat&cat_id=<?php echo $childData['cat_id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove
"></span></a>     
                                    </td>
                                </tr>                                
                                <?php } ?>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
            </div>
            <?php } else { ?>
            	<div class="alert alert-warning">You have no clients to show, be the first to add a new client.</div>
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