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
        	<h3>Delete Group</h3>
        </div>
        <div class="col-sm-6 right">
        	<div class="form-group">
            	<div class="btn-group">
                	<a href="<?php echo ADMINDOMAIN; ?>/?action=setup&option=staff" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"></span> Go Back</a>
                </div>
            </div>
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
    <?php } else { ?>
    <div class="row">
    	<div class="col-sm-12">
            <div class="alert alert-success">
                <span class="glyphicon glyphicon-exclamation-sign"></span>This group has been deleted.
            </div> 
        </div>
    </div>
    <?php } ?>
</div>