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
        	<h3>Staff</h3>
        </div>
        <div class="col-sm-6 right">
        	<div class="form-group">
            	<div class="btn-group">
                	<a href="<?php echo ADMINDOMAIN; ?>/?action=setup&option=staff&do=add_user" class="btn btn-default"><span class="glyphicon glyphicon-user"></span> Add User</a>
                </div>
            </div>
        </div>
    </div>    
    <div class="row">
        <div class="col-sm-12">
        	
            <!-- CATEGORY -->
            <?php if($g_records) { ?>
			<?php while($g_data = db::fetch($g_sql)) { ?>
            
                    <h4>
                    
                        <?php if(!$g_data['group_root']) { ?>
                        	<div class="btn-group">
                            <a href="<?php echo ADMINDOMAIN; ?>/?action=setup&option=staff&do=edit_group&group_id=<?php echo $g_data['group_id']; ?>" class="btn btn-default btn-sm">
                            	<span class="glyphicon glyphicon-pencil"></span>
                            </a> 						
                            <a href="<?php echo ADMINDOMAIN; ?>/?action=setup&option=staff&do=delete_group&group_id=<?php echo $g_data['group_id']; ?>" class="btn btn-default btn-sm">
                            	<span class="glyphicon glyphicon-remove"></span>
                            </a>
                            </div>
						<?php } ?>
						
						<?php echo lib::san($g_data['group_name'],false, true,true); ?> 
                    	<small><?php echo lib::san($g_data['group_description'],false, true,true); ?></small>
                    </h4>
                    
                	<?php
						$u_sql = db::query("SELECT * FROM `".config::$db_prefix."staff` WHERE `user_groupid`='".lib::san($g_data['group_id'],true)."' ORDER BY `user_root` DESC");
						$u_records = db::nRowsQuery($u_sql); ?>
                        
                    <?php if($u_records) { ?>
                    <div class="panel panel-default">
						
                    	<div class="table-responsive">
                        	<table class="table table-borded table-striped">
                            	<thead>
                                	<tr>
                                        <td>Full Name</td>
                                        <td>Username</td>
                                        <td>Email Address</td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
									<?php while($u_data = db::fetch($u_sql)) { ?>
                                	<tr>
                                        <td><?php echo lib::san($u_data['user_fullname'],false,true,true); ?> <?php if($u_data['user_root']) { echo '<font color="red">[Root]</font>';} ?></td>
                                        <td><?php echo lib::san($u_data['user_username'],false,true,true); ?></td>
                                        <td><?php echo lib::san($u_data['user_emailaddress'],false,true,true); ?></td>
                                        <td>
                                        	<div class="btn-group">
                                        		<a href="<?php echo ADMINDOMAIN; ?>/?action=setup&option=staff&do=edit_user&user_id=<?php echo $u_data['user_id']; ?>" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
                                                <?php if(!$u_data['user_root']) { ?><a href="<?php echo ADMINDOMAIN; ?>/?action=setup&option=staff&do=delete_user&user_id=<?php echo $u_data['user_id']; ?>" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-remove"></span></a><?php } ?>
                                            </div>
                                        </td>
                                    </tr>
									<?php } ?>
                                </tbody>
                            </table>
                            
                        </div>
						
                    </div>                                                       
                	<?php } else { ?>
                      <div class="alert alert-warning">There are no members of this group yet.</div>
                  	<?php } ?>
                    
            <?php } ?>
			<?php } else { ?>
            	<div class="alert alert-warning">You have not yet added any staff members.</div>
            <?php } ?>
            
           
        
        </div>
    </div>            
</div>