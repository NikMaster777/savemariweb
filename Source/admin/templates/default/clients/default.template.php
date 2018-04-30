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
        	<h3>View Clients (<?php echo number_format($records); ?>)</h3>
        </div>
        <div class="col-sm-6 right">
        	<div class="form-group">
                <a href="#" class="btn btn-danger" id="_delete">Delete Selected</a>  
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
            	<div class="panel-heading">Clients</div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                	<td><input type="checkbox" value="" name="select_all" id="select_all"/></td>
                                    <td>First Name</td>
                                    <td>Last Name</td>
                                    <td>Email Address</td>
                                    <td>Client Since</td>
                                    <td>Status</td>
                                </tr>
                            </thead>
                            <tbody>
                            <form action="" method="post" id="_delete-form">
                            <?php while($clientData = db::fetch($clientSQL)) { ?>
                                <tr>
                            <td><input type="checkbox" value="<?php echo $clientData['user_id']; ?>" name="<?php echo $clientData['user_id']; ?>" class="checkbox"/></td>
                            <td><a href="<?php echo ADMINDOMAIN; ?>/?action=clients&method=view&client_id=<?php echo $clientData['user_id']; ?>"><?php echo lib::san($clientData['user_firstname'],false,true,true); ?></a></td>
                            <td><a href="<?php echo ADMINDOMAIN; ?>/?action=clients&method=view&client_id=<?php echo $clientData['user_id']; ?>"><?php echo lib::san($clientData['user_lastname'],false,true,true); ?></a></td>
                            <td><a href="<?php echo ADMINDOMAIN; ?>/?action=clients&method=view&client_id=<?php echo $clientData['user_id']; ?>"><?php echo lib::san($clientData['user_emailaddress'],false,true,true); ?></a></td>
                            <td><?php echo date(lib::getDateFormat(false), strtotime($clientData['user_created'])); ?></td>
                            <td><span class="label label-success">Active</span></td>
                                </tr>
                            <?php } ?>
                            	<input type="hidden" value="_delete" name="_delete" />
                            </form>
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