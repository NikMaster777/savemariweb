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
        	<h3>Edit User</h3>
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
            	<label>Full Name:</label>
                <input type="text" name="user_fullname" value="<?php echo rememberMe($user, 'user_fullname', 'text'); ?>" placeholder="" class="form-control">
            </div> 
            
            <div class="form-group">
            	<label>Username:</label>
                <input type="text" name="user_username" value="<?php echo rememberMe($user, 'user_username', 'text'); ?>" placeholder="" class="form-control">
            </div>
            
            <div class="form-group">
            	<label>Email Address:</label>
                <input type="text" name="user_emailaddress" value="<?php echo rememberMe($user, 'user_emailaddress', 'text'); ?>" placeholder="" class="form-control">
            </div>
            
            <div class="form-group">
            	<label>User Group:</label>
                <select name="user_groupid" class="form-control">
                	<?php $g_sql = db::query("SELECT * FROM `".config::$db_prefix."groups`"); while($g_data = db::fetch($g_sql)) { ?>
                	<option value="<?php echo $g_data['group_id']; ?>" <?php echo rememberMe($user, 'user_groupid', 'select', $g_data['group_id']); ?>><?php echo lib::san($g_data['group_name'],false,true,true); ?></option>
                    <?php } ?>
                </select>
            </div>
            
            <div class="form-group">
            	<label>New Password:</label>
                <input type="password" name="user_password" value="" placeholder="Password" class="form-control">
            </div>
             
            <div class="form-group">
            	<input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>" />
            	<input type="submit" class="btn btn-default" value="Edit User" name="_submit">
            </div>
            
        </div>
        <div class="col-sm-6">
    		
    	</div>
        </form>
    </div>       
</div>