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
	 <div class="row">
		<div class="col-sm-6">
        	<h4>System Logs</h4>
            <p>Almost everything in this system is logged, take a look below.</p>
        </div>
        <div class="col-sm-6 right">
        	<div class="pull-right"><?php echo $paginate->renderPages(); ?></div>
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
                <div class="table-responsive">
                    <table class="table table-striped table-borded">
                    	<thead>
                        	<tr>
                            	<td>Type</td>
                                <td>Message</td>
                                <td>User Agent</td>
                                <td>IP Address</td>
                                <td>Date/Time</td>
                                <td>Location</td>
                            </tr>
                        </thead>
                        
                        <tbody>
                        	<?php while($logData = db::fetch($l_sql)) { ?>
                        	<tr>
                            	<td>
                                	<?php $log_type = array(0 => 'Security', 1 => 'General', 2 => 'Form Errors', 3=> 'Update Log', 4 => 'General Errors', 5 => 'Critical Errors'); 
										  echo $log_type[$logData['log_type']]; 
									?>
                                </td>
                                <td><?php echo lib::san($logData['log_message'],false,true,true); ?></td>
                                <td><?php echo lib::san($logData['log_useragent'],false,true,true); ?></td>
                                <td><?php echo lib::san($logData['log_ipaddress'],false,true,true); ?></td>
                                <td><?php echo date(lib::getDateFormat(false).' H:i:s', $logData['log_timestamp']); ?></td>
                                <td><?php echo lib::san($logData['log_location'],false,true,true); ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                        
                    </table>
                </div>
            </div>
            <?php } else { ?>
            	<div class="alert alert-warning">There are no logs to show, check back later.</div>
            <?php } ?>
            
        </div>
    </div>  
</div>