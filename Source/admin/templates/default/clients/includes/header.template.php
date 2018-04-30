<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Creative Miles
 *@Start: 12th June 2016
*/
if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
require(ADMINROOT.'/templates/default/header.template.php');
?>
<div class="container content-wrapper">
	<div class="row header-row">
    	<div class="col-sm-6 left">
        	<h3>Viewing Client - <?php echo lib::san($user['user_firstname']).' '.lib::san($user['user_lastname']); ?></h3>
        </div>
        <div class="col-sm-6 right">
        	<script type="text/javascript">
             	$(document).ready(function() {
					$('#_delete').click(function() {
						var conf = confirm('WARNING: Are you sure you wish to delete this client?');
						if(conf) {
							$('#_delete-form').submit();
						}
					});
				});
             </script>
             <form action="" method="post" id="_delete-form">
             	<input type="hidden" value="<?php echo lib::get('client_id',false,true,true); ?>" name="<?php echo lib::get('client_id',false,true,true); ?>"/>
             	<input type="hidden" value="_delete" name="_delete" />
             </form>
             <a href="<?php echo ADMINDOMAIN; ?>/?action=clients&method=view" class="btn btn-default">Back</a>
        	<a href="#" class="btn btn-danger" id="_delete">Delete Client</a>
        </div>
    </div>
    <div class="row">
    	<div class="col-sm-12">
        
        	<div class="panel with-nav-tabs panel-default">
        
            	<div class="panel-heading">
                    <ul class="nav nav-tabs">
                        <li <?php if(lib::get('tab') == 'overview' | lib::get('tab') == '') { echo 'class="active"'; } ?>>
                            <a href="<?php echo ADMINDOMAIN.'/?action=clients&method=view&client_id='.lib::get('client_id').'&tab=overview'; ?>">Overview</a>
                        </li>
                        <li <?php if(lib::get('tab') == 'edit_profile') { echo 'class="active"'; } ?>>
                            <a href="<?php echo ADMINDOMAIN.'/?action=clients&method=view&client_id='.lib::get('client_id').'&tab=edit_profile'; ?>">Edit Profile</a>
                        </li> 
                    </ul>    
                </div>
                   
            