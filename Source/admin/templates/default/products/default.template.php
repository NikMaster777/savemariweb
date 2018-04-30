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
        	<h3>View Products (<?php echo number_format($records); ?>)</h3>
        </div>
        <div class="col-sm-6 right">
        	<div class="form-group">
                
            </div>
        </div>
    </div>
    <div class="row button-row">
    	<div class="col-sm-4 left">
        <script type="application/javascript">
        	$(document).ready(function() {
				$('#_filtervar').change(function() {
					if($('#_filtervar').val() == '') {
						window.location='<?php echo ADMINDOMAIN; ?>/?action=products';
					} else {
						window.location='<?php echo ADMINDOMAIN; ?>/?action=products&filter='+$('#_filtervar').val();
					}
				});
			});
        </script>
        	<div class="input-group">
                <select name="" class="form-control" id="_filtervar">
                    <option value="">Display All</option>
                    <option value="1" <?php if(lib::get('filter') == '1') { echo 'selected'; } ?>>Paid Out</option>
                    <option value="2" <?php if(lib::get('filter') == '2') { echo 'selected'; } ?>>Waiting for Payout</option>
                </select>
            </div>
        </div>
    	<div class="col-sm-8 right">
        	<div class="row">
            	<div class="col-sm-12">
                	<?php echo $paginate->renderPages(); ?>
                </div>
            </div>
            <br />
        	<div class="row">
            	<div class="col-sm-12">
                	<div class="form-inline">
                        <form action="<?php echo ADMINDOMAIN; ?>/?action=products&filter=3" method="post">
                            <select name="store_id" class="form-control">
                            	<?php $storeSQL = db::query("SELECT * FROM `".config::$db_prefix."stores`"); ?>
                                <?php while($storeData = db::fetch($storeSQL)) { ?>
                                	<option value="<?php echo $storeData['store_id']; ?>"><?php echo lib::san($storeData['store_username']); ?></option>
                                <?php } ?>
                            </select>
                            <div class="form-group">
                            	<input type="submit" name="" value="Filter" class="btn btn-default">
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
            	<div class="panel-heading">Products</div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td>Product Title</td>
                                    <td>Price</td>
                                    <td>Gateway Fees</td>
                                    <td>Payout</td>
                                    <td>Profit</td>
                                    <td>Redeemed</td>
                                    <td>Sold</td>
                                    <td>Paid Out</td>
                                    <td>Store</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                            <?php while($advertData = db::fetch($advertSQL)) { ?>
                            <?php $storeData = db::fetchQuery("SELECT * FROM `".config::$db_prefix."stores` WHERE `store_id`='".db::mss($advertData['advert_storeid'])."'"); ?>
                            <?php $invoice = db::fetchQuery("SELECT * FROM `".config::$db_prefix."invoices` WHERE `invoice_type`='3' AND `invoice_typeid`='".$advertData['advert_id']."'"); ?>
                            <?php $redeem = db::fetchQuery("SELECT `redeem_redeemed` FROM `".config::$db_prefix."redeem` WHERE `redeem_productid`='".$advertData['advert_id']."'"); ?>
                                <tr>
                                    <td><?php echo lib::san($advertData['advert_title'],false,true,true); ?></td>
                                    <td><?php echo lib::getDefaultCurrencySymbol(); ?><?php echo number_format($advertData['advert_price'],2); ?></a></td>
                                    <td><?php echo lib::getDefaultCurrencySymbol(); ?><?php if(isset($invoice['invoice_gatewayfees'])) { echo number_format($invoice['invoice_gatewayfees'],2); } else { echo '0.00'; }?></td> 
                                    <td><?php echo lib::getDefaultCurrencySymbol(); ?><?php
                                    	
										//Advert Price
										$total = $advertData['advert_price'];
										
										//Remove Gateway Charges
										if(isset($invoice['invoice_gatewayfees'])) {
											$total = $total - $invoice['invoice_gatewayfees'];
										}
										
										//Do we have a price?
										if($total > 0) {
											
											//Add VAT
											$TaxTotal = lib::getSetting('General_PayoutPercentage') / 100;
											$TaxTotal = $TaxTotal * $total;
											
											//Display the VAT
											echo number_format($total - $TaxTotal,2);
										
										}
										
									?></td>
                                    <td>$<?php if(isset($TaxTotal)) { echo number_format($TaxTotal,2); } else { echo '0.00'; }?></td> 
                                    <td>
                                    	<?php										
											if(isset($redeem['redeem_redeemed']) && $redeem['redeem_redeemed'] == 1) {
												echo '<span class="label label-success">Yes</span>';
											} else {
												echo '<span class="label label-danger">No</span>';
											}
										?> 
                                    </td>
                                    <td>
									<?php 
											switch($invoice['invoice_status']) { 
												case 0: {
													echo '<span class="label label-danger">No</span>'; 
													break;
												}
												case 1: {
													echo '<span class="label label-success">Yes</span>';
													break;
												}
											}
									?></td>
                                    <td>
									<?php 
											switch($advertData['advert_paidout']) { 
												case 0: {
													echo '<span class="label label-danger">No</span>'; 
													break;
												}
												case 1: {
													echo '<span class="label label-success">Yes</span>';
													break;
												}
											}
									?></td>
                                    <td><?php echo lib::san($storeData['store_username']); ?></td>
                                    
                                    <td>
                                        <a href="<?php echo ADMINDOMAIN; ?>/?action=products&method=view_paymentdetails&advert_id=<?php echo $advertData['advert_id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-eye-open"></span></a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
            </div>
            <?php } else { ?>
            	<div class="alert alert-warning">You have no products to show, be the first to add a new client.</div>
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