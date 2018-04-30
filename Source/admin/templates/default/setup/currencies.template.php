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
        	<h4>Currencies</h4>
            <p>You can add and edit currencies below.</p>
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
			
            <div class="panel panel-default">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <td>Currency</td>
                                <td>Prefix</td>
                                <td>Prefix Position</td>
                                <td>Conversion Rate</td>
                                <td>Options</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($currData = db::fetch($currSQL)) { ?>
                            <tr>
                                <td><?php echo lib::san($currData['currency_name'],false,true,true); ?></td>
                                <td><?php echo lib::san($currData['currency_prefix'],false,true,true); ?></td>
                                <td><?php $curr = array(0 => 'Before Currency', 1 => 'After Currency'); echo $curr[$currData['currency_position']]; ?></td>
                                <td><?php echo lib::san($currData['currency_baserate'],false,true,true); ?></td>
                                <td>
                                	<script type="text/javascript">
										$(document).ready(function() {
											$('#Button_Delete<?php echo $currData['currency_id']; ?>').click(function() {
												var conf = confirm('Are you sure you want to delete this currency?');
												if(conf) {
													$('#Form_Delete<?php echo $currData['currency_id']; ?>').submit();
												} else {
													return false;
												}
											});
											$('#Button_Edit<?php echo $currData['currency_id']; ?>').click(function() {
												$('#currency_name').val('<?php echo lib::san($currData['currency_name'],false,true,false); ?>');
												$('#currency_prefix').val('<?php echo lib::san($currData['currency_prefix'],false,true,false); ?>');								
												$( "#currency_position" ).val('<?php echo lib::san($currData['currency_position'],false,true,false); ?>');
												$('#currency_baserate').val('<?php echo lib::san($currData['currency_baserate'],false,true,false); ?>');
												$('#currency_id').val('<?php echo $currData['currency_id']; ?>');
												$('#Edit_Update').show();
											});
										});
									</script>
                                	<form action="" method="post" id="Form_Delete<?php echo $currData['currency_id']; ?>">
                                    	<input type="hidden" name="currency_id" value="<?php echo $currData['currency_id']; ?>">
                                        <input type="hidden" name="_delete" value="1">
                                    </form>
                                    
                                	<a href="#" class="btn btn-default btn-sm" id="Button_Edit<?php echo $currData['currency_id']; ?>"><span class="glyphicon glyphicon-pencil"></span></a> 
                                	<a href="#" class="btn btn-default btn-sm" id="Button_Delete<?php echo $currData['currency_id']; ?>"><span class="glyphicon glyphicon-remove"></span></a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <form action="" method="post" class="form" id="Edit_Update" style="display:none;">
            	<h4>Edit Currency</h4>
                <p>Feel free to edit your currency below.</p>
                <div class="form-group">
                	<label>Currency Name:</label>
                    <input type="text" name="currency_name" value="<?php echo lib::post('currency_name',false,true,true); ?>" placeholder="e.g. GBP" class="form-control" id="currency_name">
                </div>
                <div class="form-group">
                	<label>Prefix:</label>
                    <input type="text" name="currency_prefix" value="<?php echo lib::post('currency_prefix',false,true,true); ?>" placeholder="e.g. £" class="form-control" id="currency_prefix">
                </div>
                <div class="form-group">
                	<label>Prefix Position:</label>
                    <select name="currency_position" class="form-control" id="currency_position">
                    	<option value="0" <?php if(lib::post('currency_position',false,true,true)== 0) { echo 'selected=selected'; } ?>>Before Currency</option>
                        <option value="1" <?php if(lib::post('currency_position',false,true,true)== 1) { echo 'selected=selected'; } ?>>After Currency</option>
                    </select>
                </div>
                <div class="form-group">
                	<label>Base Conversion Rate:</label>
                    <input type="text" name="currency_baserate" value="<?php echo lib::post('currency_baserate',false,true,true); ?>" placeholder="e.g. 1.00000" class="form-control" id="currency_baserate">
                </div>
                <div class="form-group">
                	<input type="hidden" name="currency_id" value="" id="currency_id">
                	<input type="submit" value="Edit Currency" class="btn btn-default" name="_edit">
                </div>
            </form>
            
            <form action="" method="post" class="form">
            	<h4>Add Currency</h4>
                <p>Add a new currency to the list above.</p>
            	<div class="form-group">
                	<label>Currency Name:</label>
                    <input type="text" name="currency_name" value="<?php echo lib::post('currency_name',false,true,true); ?>" placeholder="e.g. GBP" class="form-control">
                </div>
                <div class="form-group">
                	<label>Prefix:</label>
                    <input type="text" name="currency_prefix" value="<?php echo lib::post('currency_prefix',false,true,true); ?>" placeholder="e.g. £" class="form-control">
                </div>
                <div class="form-group">
                	<label>Prefix Position:</label>
                    <select name="currency_position" class="form-control">
                    	<option value="0" <?php if(lib::post('currency_position',false,true,true)== 0) { echo 'selected=selected'; } ?>>Before Currency</option>
                        <option value="1" <?php if(lib::post('currency_position',false,true,true)== 1) { echo 'selected=selected'; } ?>>After Currency</option>
                    </select>
                </div>
                <div class="form-group">
                	<label>Base Conversion Rate:</label>
                    <input type="text" name="currency_baserate" value="<?php echo lib::post('currency_baserate',false,true,true); ?>" placeholder="e.g. 1.00000" class="form-control">
                </div>
                <div class="form-group">
                	<input type="submit" value="Add Currency" class="btn btn-default" name="_submit">
                </div>
            </form>
			
        </div>
    </div>  
</div>