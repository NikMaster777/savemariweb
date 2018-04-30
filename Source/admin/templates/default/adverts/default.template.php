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
        	<h3>View Adverts (<?php echo number_format($records); ?>)</h3>
        </div>
        <div class="col-sm-6 right">
        	<div class="form-group">
                
            </div>
        </div>
    </div>
    <div class="row button-row">
    	<div class="col-sm-6 left">
			<script type="application/javascript">
                $(document).ready(function() {
                    $('#_filtervar').change(function() {
                        if($('#_filtervar').val() == '') {
                            window.location='<?php echo ADMINDOMAIN; ?>/?action=adverts';
                        } else {
                            window.location='<?php echo ADMINDOMAIN; ?>/?action=adverts&filter='+$('#_filtervar').val();
                        }
                    });
                });
            </script>
            
            <div class="input-group">
                <select name="" class="form-control" id="_filtervar">
                    <option value="">Display All</option>
                    <option value="1" <?php if(lib::post('_filtervar') == 1) { echo 'selected'; } ?>>Order by Pending</option>
                    <option value="2" <?php if(lib::post('_filtervar') == 2) { echo 'selected'; } ?>>Order by Active</option>
                    <option value="3" <?php if(lib::post('_filtervar') == 3) { echo 'selected'; } ?>>Order by Expired</option>
                    <option value="4" <?php if(lib::post('_filtervar') == 4) { echo 'selected'; } ?>>Order by Rejected</option>
                </select>
                </div>
                <br />
                <br />
                <div class="input-group">
                	<script type="text/javascript">
                    	$(document).ready(function() {
							$('#multiButton').click(function() {
								
								//Get Checkbox Values
								var checkValues = $('input[name=checkboxlist]:checked').map(function() { return $(this).val(); }).get();
								
								//Get CatID
								if($('cat_id').val() == '') { 
									alert('Choose a category!'); 
									return false;
								}
								
								//Get Checkbox Values
								if(checkValues == '') {
									alert('Select a checkbox!');
									return false;
								}
								
								//Ajax
								$.ajax({
									url: '<?php echo ADMINDOMAIN; ?>/index.php?action=adverts&method=ajax&request=multicat',
									type: 'POST',
									data: 'advert_catid=' + $('#advert_catid').val() + '&advertids=' + checkValues,
									success: function(data) {
										location.reload();
									},
								}, 'json');
								
							});
						});
                    </script>
                    <select name="" class="form-control" id="advert_catid">
                      <option disabled selected>-- Select a Category --</option>
                      <?php foreach($categories AS $key => $parent) { ?>
                      	<optgroup label="<?php echo lib::san($parent['cat_name']); ?>">
                        <?php $chiSQL2 = db::query("SELECT * FROM `".config::$db_prefix."categories` WHERE `cat_parentid`='".$parent['cat_id']."'"); 
                              while($chiData2 = db::fetch($chiSQL2)) { 
                                echo '<option value="'.$chiData2['cat_id'].'">- '.$chiData2['cat_name'].'</option>';  
                              } 
                        ?>
                      <?php } ?>
                      </optgroup>
                    </select> 
                    <span class="input-group-btn">
                        <input type="button" name="" value="Mass Group" class="btn btn-default" id="multiButton">
                    </span>
                </div>
                
            	
        </div>
    	<div class="col-sm-6 right">
        	<div class="row">
            	<div class="col-sm-12">
                	<?php echo $paginate->renderPages(); ?>
                </div>
            </div>
            <br />
        	<div class="row">
            	<div class="col-sm-12">
                	<div class="form-inline">
                        <form action="<?php echo ADMINDOMAIN; ?>/?action=adverts&filter=5" method="post">
                            <div class="form-group">
                                <input type="text" class="form-control" name="advert_id" value="" placeholder="Advert ID">
                            </div>
                            <div class="form-group">
                            	<input type="submit" name="" value="Search" class="btn btn-default">
                            </div>
                        </form>
                    </div>
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
    	<div class="col-sm-12">
        	
            <?php if($records) { ?>
            <div class="panel panel-default">
            	<div class="panel-heading">Adverts</div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                	<td>#</td>
                                    <td>ID</td>
                                    <td>Advert Title</td>
                                    <td>Advert Price</td>
                                    <td>Username</td>
                                    <td>Submitted</td>
                                    <td>City</td>
                                    <td>Advert</td>
                                    <td>Category</td>
                                    
                                    <td>AdPack</td>
                                    <td>Paid</td>
                                    
                                    <td>Expires</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                            <?php while($advertData = db::fetch($advertSQL)) { ?>
                            <?php $userData = db::fetchQuery("SELECT `user_username`,`user_city` FROM `".config::$db_prefix."clients` WHERE `user_id`='".db::mss($advertData['advert_userid'])."'"); ?>
                            <?php $userCity = db::fetchQuery("SELECT `city_name` FROM `".config::$db_prefix."cities` WHERE `city_id`='".$userData['user_city']."'"); ?>
                            <?php $adpack = db::fetchQuery("SELECT `pack_title`,`pack_id` FROM `".config::$db_prefix."adpacks` WHERE `pack_id`='".$advertData['advert_packid']."'"); ?>
                            <?php $invoice = db::fetchQuery("SELECT `invoice_status` FROM `".config::$db_prefix."invoices` WHERE `invoice_type`='1' AND `invoice_typeid`='".$advertData['advert_id']."'"); ?>
                            <?php $mancat = db::fetchQuery("SELECT `cat_name` FROM `".config::$db_prefix."categories` WHERE `cat_id`='".$advertData['advert_catid']."'"); ?>
							<?php $subcat = db::fetchQuery("SELECT `cat_name` FROM `".config::$db_prefix."categories` WHERE `cat_id`='".$advertData['advert_subcatid']."'"); ?>
                                <tr>
                                	<td><input type="checkbox" name="checkboxlist" value="<?php echo lib::san($advertData['advert_id']); ?>" class="messageCheckbox"></td>
                                    <td><?php echo lib::san($advertData['advert_id'],false,true,true); ?></td>
                                    <td><?php echo lib::san($advertData['advert_title'],false,true,true); ?></td>
                                    <td><?php echo lib::getDefaultCurrencySymbol(); ?><?php echo number_format($advertData['advert_price'],2); ?></a></td>
                                    <td><?php echo lib::san($userData['user_username']); ?></td> 
                                    <td><?php echo date(lib::getDateFormat(false), strtotime($advertData['advert_datetime'])); ?></td>
                                    <td><?php echo $userCity['city_name']; ?></td>
                                    <td><?php 
										switch($advertData['advert_status']) { 
											case 0: {
												echo '<span class="label label-danger">Pending</span>'; 
												break;
											}
											case 1: {
												echo '<span class="label label-success">Active</span>';
												break;
											}
											case 2: {
												echo '<span class="label label-warning">Expired</span>';
												break;
											}
											case 3: {
												echo '<span class="label label-warning">Rejected</span>';
												break;
											}
										}
									?></td>
                                    <td><?php echo $subcat['cat_name']; ?></td>
                                    <td><?php echo $adpack['pack_title']; ?></td>
                                    <td><?php 
										if($adpack['pack_id'] == 3) {
											echo 'N/A';
										} else {
											switch($invoice['invoice_status']) { 
												case 0: {
													echo '<span class="label label-danger">Unpaid</span>'; 
													break;
												}
												case 1: {
													echo '<span class="label label-success">Paid</span>';
													break;
												}
												case 2: {
													echo '<span class="label label-warning">Refunded</span>';
													break;
												}
											}
										}
									?></td>
                                    <td><?php echo date(lib::getDateFormat(false), strtotime($advertData['advert_expiredate'])); ?></td>
                                    <td>
                                    	<script type="text/javascript">
                                        	$(document).ready(function() {
												//Approve
												$('#approve<?php echo $advertData['advert_id']; ?>').click(function() {
													$.ajax({
														url: '<?php echo ADMINDOMAIN; ?>/index.php?action=ajax&class=adverts&method=approve',
														type: 'post',
														data: '&advert_id=<?php echo $advertData['advert_id']; ?>',
														success: function(data) {
															if(data.error) { alert(data.error); } else { location.reload(); }	
														}
													}, 'json');
												});
												//Reject
												$('#reject<?php echo $advertData['advert_id']; ?>').click(function() {
													$.ajax({
														url: '<?php echo ADMINDOMAIN; ?>/index.php?action=ajax&class=adverts&method=reject',
														type: 'post',
														data: '&advert_id=<?php echo $advertData['advert_id']; ?>',
														success: function(data) {
															if(data.error) { alert(data.error); } else { location.reload(); }	
														}
													}, 'json');
												});
											});
                                        </script>
                                        <?php if(in_array($advertData['advert_status'], array(0,2,3))) { ?>
                                    	<a href="#" id="approve<?php echo $advertData['advert_id']; ?>" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-ok"></span></a> 
                                        <?php } ?>
                                        <?php if(in_array($advertData['advert_status'], array(0,1,2))) { ?>
                                    	<a href="#" id="reject<?php echo $advertData['advert_id']; ?>" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></span></a>
                                        <?php } ?>
                                        <a href="<?php echo ADMINDOMAIN; ?>/?action=adverts&method=view_advert&advert_id=<?php echo $advertData['advert_id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-eye-open"></span></a>
                                        <a href="<?php echo ADMINDOMAIN; ?>/?action=adverts&method=edit_advert&advert_id=<?php echo $advertData['advert_id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
                                    </td>
                                </tr>
                            <?php } ?>
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