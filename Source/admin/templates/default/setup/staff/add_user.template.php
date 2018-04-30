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
        	<h3>Add User</h3>
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
                <input type="text" name="user_fullname" value="<?php echo lib::post('user_fullname',false,true,true); ?>" placeholder="" class="form-control">
            </div> 
            
            <div class="form-group">
            	<label>Username:</label>
                <input type="text" name="user_username" value="<?php echo lib::post('user_username',false,true,true); ?>" placeholder="" class="form-control">
            </div>
            
            <div class="form-group">
            	<label>Email Address:</label>
                <input type="text" name="user_emailaddress" value="<?php echo lib::post('user_emailaddress',false,true,true); ?>" placeholder="" class="form-control">
            </div>
            
            <div class="form-group">
            	<label>User Group:</label>
                <select name="user_groupid" class="form-control">
                	<?php $g_sql = db::query("SELECT * FROM `".config::$db_prefix."groups`"); while($g_data = db::fetch($g_sql)) { ?>
                	<option value="<?php echo $g_data['group_id']; ?>"><?php echo lib::san($g_data['group_name'],false,true,true); ?></option>
                    <?php } ?>
                </select>
            </div>
             
            <div class="form-group">
            	<label>Password:</label>
                <input type="text" name="user_password" value="<?php echo lib::post('user_password',false,true,true); ?>" placeholder="Password" class="form-control">
            </div>
             
            <div class="form-group">
            	<input type="submit" class="btn btn-default" value="Add User" name="_submit">
            </div>
            
        </div>
        <div class="col-sm-6">
    		
    	</div>
        </form>
    </div>       
</div>