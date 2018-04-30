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
        	<h3>Edit Group</h3>
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
    <?php } ?>
    <div class="row">
    	<form action="" method="post">
        <div class="col-sm-6">
        	
            <div class="form-group">
            	<label>Group Name:</label>
                <input type="text" name="group_name" value="<?php echo rememberMe($group,'group_name','text'); ?>" placeholder="" class="form-control">
            </div> 
            
            <div class="form-group">
            	<label>Group Description:</label>
                <input type="text" name="group_description" value="<?php echo rememberMe($group,'group_description','text'); ?>" placeholder="" class="form-control">
            </div>
            
            <!-- <div class="form-group">
            	<label>Group Permissions:</label>
            </div>
            <div class="panel panel-default">
            <table class="table table-striped table-bordered">
            	<thead>
                	<tr>
                        <td style="width:10px;"></td>
                        <td>Permission</td>
                    <tr>
                </thead>
                <tbody>
                	<tr>
                    	<td><input type="checkbox" value="" name="" /></td>
                        <td>Can view other staff members.</td>
                    </tr>
                    <tr>
                    	<td><input type="checkbox" value="" name="" /></td>
                        <td>Can edit other staff members.</td>
                    </tr>
                    <tr>
                    	<td><input type="checkbox" value="" name="" /></td>
                        <td>Can delete other staff members.</td>
                    </tr>
                    <tr>
                    	<td><input type="checkbox" value="" name="" /></td>
                        <td>Can access support tickets.</td>
                    </tr>
                </tbody>
            </table>
            </div>  -->
                        
            <div class="form-group">
            	<input type="hidden" value="<?php echo $group['group_id']; ?>" name="group_id" />
            	<input type="submit" class="btn btn-default" value="Edit Group" name="_submit">
            </div>
            
        </div>
        <div class="col-sm-6">
    		
    	</div>
        </form>
    </div>       
</div>