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
        	<h4>Tax Rules</h4>
            <p>You can add and edit the tax rates below.</p>
        </div>
        <div class="col-sm-6 right"></div>
    </div>
    <div class="row">
        <div class="col-sm-12">
			
            <div class="panel with-nav-tabs panel-default">
            	
                <div class="panel-heading">
                
                    <ul class="nav nav-tabs">
                      <li class="active"><a data-toggle="tab" href="#level1">Level 1</a></li>
                      <li><a data-toggle="tab" href="#level2">Level 2</a></li>
                      <li><a data-toggle="tab" href="#level3">Level 3</a></li>
                    </ul>
                
                </div>
                
                <div class="panel-body">
                  <div class="tab-content">
                  
                    <!-- LEVEL 1-->
                    <div id="level1" class="tab-pane fade in active">
                    	
						<?php if($t1Rows) { ?>
                        <div class="panel panel-default">
                        	<div class="table-responsive">
                            	<table class="table table-striped" id="level1-table">
                                	<thead>
                                    	<tr>
                                        	<td>Tax Name</td>
                                            <td>Tax Description</td>
                                            <td>Tax Type</td>
                                            <td>Tax Group</td>
                                            <td>Tax Country</td>
                                            <td>Tax Rate</td>
                                            <td>Options</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<?php while($t1Data = db::fetch($t1SQL)) { ?>
                                    	<tr>
                                        	<td><?php echo lib::san($t1Data['tax_name']); ?></td>
                                            <td><?php echo lib::san($t1Data['tax_description']); ?></td>
                                            <td><?php $taxType = array(1 => 'Exclusive', 2 => 'Inclusive'); echo $taxType[$t1Data['tax_type']]; ?></td>
                                            <td><?php if($t1Data['tax_groupid'] != 0) { echo lib::getGroup($t1Data['tax_groupid']); } else { echo 'All Groups'; } ?></td>
                                            <td><?php if($t1Data['tax_countryid'] != 0) { echo lib::getCountry($t1Data['tax_countryid']); } else { echo 'All Countries'; } ?></td>
                                            <td><?php echo lib::san($t1Data['tax_rate']); ?>%</td>
                                            <script type="text/javascript">
                                            	$(document).ready(function() {
													$('#delete_button<?php echo $t1Data['tax_id']; ?>').click(function() {
														$('#delete_form<?php echo $t1Data['tax_id']; ?>').submit();
													});
												});
                                            </script>
                                            <form action="" method="post" id="delete_form<?php echo $t1Data['tax_id']; ?>">
                                            	<input type="hidden" name="tax_id" value="<?php echo $t1Data['tax_id']; ?>"/>
                                                <input type="hidden" name="tax_level" value="<?php echo $t1Data['tax_level']; ?>" />
                                                <input type="hidden" name="_delete" value="1"/>
                                            </form>
                                            <td><a href="#" class="btn btn-default btn-xs" id="delete_button<?php echo $t1Data['tax_id']; ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php } else { ?>
                    		<div class="alert alert-warning">You do not yet have any level 1 tax rules set.</div>
                        <?php } ?>
                        
                    </div>
                    
                    <!-- LEVEL 2-->
                    <div id="level2" class="tab-pane fade in">
                    	<?php if($t2Rows) { ?>
                        <div class="panel panel-default">
                        	<div class="table-responsive">
                            	<table class="table table-striped" id="level1-table">
                                	<thead>
                                    	<tr>
                                        	<td>Tax Name</td>
                                            <td>Tax Description</td>
                                            <td>Tax Type</td>
                                            <td>Tax Group</td>
                                            <td>Tax Country</td>
                                            <td>Tax Rate</td>
                                            <td>Options</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<?php while($t2Data = db::fetch($t2SQL)) { ?>
                                    	<tr>
                                        	<td><?php echo lib::san($t2Data['tax_name']); ?></td>
                                            <td><?php echo lib::san($t2Data['tax_description']); ?></td>
                                            <td><?php $taxType = array(1 => 'Exclusive', 2 => 'Inclusive'); echo $taxType[$t2Data['tax_type']]; ?></td>
                                            <td><?php if($t2Data['tax_groupid'] != 0) { echo lib::getGroup($t2Data['tax_groupid']); } else { echo 'All Groups'; } ?></td>
                                            <td><?php if($t2Data['tax_countryid'] != 0) { echo lib::getCountry($t2Data['tax_countryid']); } else { echo 'All Countries'; } ?></td>
                                            <td><?php echo lib::san($t2Data['tax_rate']); ?>%</td>
                                            <script type="text/javascript">
                                            	$(document).ready(function() {
													$('#delete_button<?php echo $t2Data['tax_id']; ?>').click(function() {
														$('#delete_form<?php echo $t2Data['tax_id']; ?>').submit();
													});
												});
                                            </script>
                                            <form action="" method="post" id="delete_form<?php echo $t2Data['tax_id']; ?>">
                                            	<input type="hidden" name="tax_id" value="<?php echo $t2Data['tax_id']; ?>"/>
                                                <input type="hidden" name="tax_level" value="<?php echo $t2Data['tax_level']; ?>" />
                                                <input type="hidden" name="_delete" value="1"/>
                                            </form>
                                            <td><a href="#" class="btn btn-default btn-xs" id="delete_button<?php echo $t2Data['tax_id']; ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php } else { ?>
                    		<div class="alert alert-warning">You do not yet have any level 2 tax rules set.</div>
                        <?php } ?>
                    </div>
                    
                    <!-- LEVEL 3-->
                    <div id="level3" class="tab-pane fade in">
                    	<?php if($t3Rows) { ?>
                        <div class="panel panel-default">
                        	<div class="table-responsive">
                            	<table class="table table-striped" id="level1-table">
                                	<thead>
                                    	<tr>
                                        	<td>Tax Name</td>
                                            <td>Tax Description</td>
                                            <td>Tax Type</td>
                                            <td>Tax Group</td>
                                            <td>Tax Country</td>
                                            <td>Tax Rate</td>
                                            <td>Options</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<?php while($t3Data = db::fetch($t3SQL)) { ?>
                                    	<tr>
                                        	<td><?php echo lib::san($t3Data['tax_name']); ?></td>
                                            <td><?php echo lib::san($t3Data['tax_description']); ?></td>
                                            <td><?php $taxType = array(1 => 'Exclusive', 2 => 'Inclusive'); echo $taxType[$t3Data['tax_type']]; ?></td>
                                            <td><?php if($t3Data['tax_groupid'] != 0) { echo lib::getGroup($t3Data['tax_groupid']); } else { echo 'All Groups'; } ?></td>
                                            <td><?php if($t3Data['tax_countryid'] != 0) { echo lib::getCountry($t3Data['tax_countryid']); } else { echo 'All Countries'; } ?></td>
                                            <td><?php echo lib::san($t3Data['tax_rate']); ?>%</td>
                                            <script type="text/javascript">
                                            	$(document).ready(function() {
													$('#delete_button<?php echo $t3Data['tax_id']; ?>').click(function() {
														$('#delete_form<?php echo $t3Data['tax_id']; ?>').submit();
													});
												});
                                            </script>
                                            <form action="" method="post" id="delete_form<?php echo $t3Data['tax_id']; ?>">
                                            	<input type="hidden" name="tax_id" value="<?php echo $t3Data['tax_id']; ?>"/>
                                                <input type="hidden" name="tax_level" value="<?php echo $t3Data['tax_level']; ?>" />
                                                <input type="hidden" name="_delete" value="1"/>
                                            </form>
                                            <td><a href="#" class="btn btn-default btn-xs" id="delete_button<?php echo $t3Data['tax_id']; ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php } else { ?>
                    		<div class="alert alert-warning">You do not yet have any level 3 tax rules set.</div>
                        <?php } ?>
                    </div>
                    
                 </div>
                </div>
                
            </div>
            
            <!-- ADD RULE FORM -->
            <div class="panel panel-default">
            	<div class="panel-heading">Add Tax Rule</div>
                <div class="panel-body">
                	
                    <div class="alert alert-danger" id="error" style="display:none;"></div>
                    <div class="alert alert-success" id="success" style="display:none;"></div>
                    
                    <script type="text/javascript">
                    	$(document).ready(function() {
							
							//Show Tab
							<?php if(lib::get('level') && is_numeric(lib::get('level'))) { ?>
							$('.nav-tabs a[href="#level<?php echo lib::get('level'); ?>"]').tab('show');
							<?php } ?>
							
							//Add Tax Rule
							$('#add_button').click(function() {
								
								//Ajax
								$.ajax({
									url:'<?php echo ADMINDOMAIN; ?>/?action=ajax&class=tax&method=add_rule',
									type: 'post',
									data: $('#add_form :input').serialize(),
									success:function(data) {
										if(data.error) {
											$('.alert').hide();
											$('#error').html(data.error);	
											$('#error').show();
										} else {
											if(data.success) {
												
												//Hide All Alerts, Display Success
												$('.alert').hide();
												$('#success').html('Your level '+ data.level + ' tax rate has been added successfully!');
												$('#success').show();
												
												//Refresh Page
												window.location='<?php echo ADMINDOMAIN; ?>/?action=setup&option=taxrules&level=' + data.level;
												
											} else {
												$('.alert').hide();
												$('#error').html('Did we loose connection? Something went wrong!');	
												$('#error').show();
											}
										}
									}
								},'json');
								
								//Prevent From Submitting
								return false;
							});
						});
                    </script>
                    
                    <form action="" method="post" id="add_form">
                    <div class="row">
                        <div class="col-sm-6">
                        	
                            <div class="form-group">
                            	<label>Name</label>
                                <input type="text" value="" name="tax_name" class="form-control" placeholder="Tax Rule Name"/>
                            </div>
                            
                            <div class="form-group">
                            	<label>Tax Level</label>
                                <select name="tax_level" class="form-control">
                                	<option value="1">Level 1</option>
                                    <option value="2">Level 2</option>
                                    <option value="3">Level 3</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                            	<label>Apply tax to Client Group</label>
                                <select name="tax_groupid" class="form-control">
                                	<option value="">-- All Groups --</option>
                                    <?php foreach(lib::getGroups() AS $group_id => $group_name) { ?>
                                    	<option value="<?php echo lib::san($group_id); ?>"><?php echo lib::san($group_name); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                                                    
                        </div>
                        <div class="col-sm-6">
                        	
                            <div class="form-group">
                            	<label>Description</label>
                                <input type="text" value="" name="tax_description" class="form-control" placeholder="Tax Rule Description"/>
                            </div>
                            
                            <div class="form-group">
                            	<label>Tax Type</label>
                                <select name="tax_type" class="form-control">
                                	<option value="1">Exclusive</option>
                                    <option value="2">Inclusive</option>
                                </select>
                            </div>                                                    
                        
                            <div class="form-group">
                            	<label>Apply tax to Country</label>
                                <select name="tax_countryid" class="form-control">
                                		<option value="">-- All Countries --</option>
                                	<?php foreach(lib::getCountries() AS $c_code => $c_name) { ?>
                                  		<option value="<?php echo $c_code; ?>"><?php echo $c_name; ?></option>
                                  	<?php } ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                            	<label>Tax Rate</label>
                                <input type="text" value="10.0%" name="tax_rate" class="form-control" placeholder="10.0%"/>
                            </div>
                                                        
                            <div class="form-group">
                            	<input type="submit" name="" value="Add Rule" class="btn btn-default pull-right" id="add_button"/>
                            </div>
                                               
                        </div>             
                    </div>
                    </form>
                    
                </div>
            </div>
            
        </div>
    </div>  
</div>