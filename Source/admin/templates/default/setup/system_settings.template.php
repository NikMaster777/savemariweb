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
        <div class="col-sm-12">
        	
            <div class="panel with-nav-tabs panel-default">
            	<div class="panel-heading">
                
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab1default" data-toggle="tab">General</a></li>
                        <li><a href="#tab2default" data-toggle="tab">Localisation</a></li>
                        <li><a href="#tab3default" data-toggle="tab">Prices</a></li>
                        <li><a href="#tab4default" data-toggle="tab">Security</a></li>
                    </ul>
                    
                    <!-- DEV ONLY (REMOVE) -->
                    <script type="text/javascript">
					$(document).ready(function() {
                    	//$('.nav-tabs a[href="#tab3default"]').tab('show');
					});
                    </script>
                    
                </div>
                <div class="panel-body">
                	
                    <!--STATUS MESSAGE -->
                    <div class="alert alert-danger error"></div>
                	<div class="alert alert-success success"></div>
                
                    <div class="tab-content">
                                                
                        <!-- GENERAL -->
                        <div class="tab-pane fade in active" id="tab1default">
                        	<script type="text/javascript">
                            	$(document).ready(function() {
									$('#general_error').hide();
									$('#general_success').hide();
									$('#general_button').click(function() {
										$('#general_error').hide();
										$('#general_success').hide();
										$.ajax({
											url: '<?php echo ADMINDOMAIN; ?>/?action=ajax&class=setup&method=general',
											type: 'POST',
											data: $('#general_form :input').serialize(),
											success: function(data) {
												if(data.error) {
													$('#general_error').html(data.error);
													$('#general_error').show();
												} else {
													$('#general_success').show();
												}
											}
										},'json');
										return false;
									});
								});
                            </script>
                            
                            <div class="alert alert-danger" id="general_error"></div>
                            <div class="alert alert-success" id="general_success">Your general settings have been saved successfully.</div>
                        
                        	<form action="" method="post" id="general_form">
                        	<div class="row">
                            	<div class="col-sm-6">
                                	<div class="form-group">
                                    	<label>Company Name</label>
                                    	<input type="text" name="General_CompanyName" value="<?php echo lib::getSetting('General_CompanyName',false,true,true); ?>" placeholder="Creative Miles Ltd" class="form-control" disabled="disabled"/>
                                        <small><i>This will be displayed throughout the system.</i></small>
                                    </div>
                                    <div class="form-group">
                                    	<label>Default Sender</label>
                                    	<input type="text" name="General_DefaultSender" value="<?php echo lib::getSetting('General_DefaultSender',false,true,true); ?>" placeholder="you@domain.co.uk" class="form-control" disabled="disabled"/>
                                        <small><i>This will be used when the system needs to send out email's of any sort.</i></small>
                                    </div>
                                    <div class="form-group">
                                    	<label>Store Payout Percentage</label>
                                    	<input type="text" name="General_PayoutPercentage" value="<?php echo lib::getSetting('General_PayoutPercentage',false,true,true); ?>" placeholder="10" class="form-control"/>
                                        <small><i>This will be used to calculate the store payout.</i></small>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                    	<label>Logo URL</label>
                                    	<input type="text" name="General_LogoURL" value="<?php echo lib::getSetting('General_LogoURL',false,true,true); ?>" placeholder="https://www.creativemiles.co.uk/billing/templates/default/images/logo.png" class="form-control" disabled="disabled"/>
                                        <small><i>This will be displayed on Invoices, Quotes and many more features.</i></small>
                                    </div>
                                    <div class="form-group">
                                    	<label>Records to Display Per Page</label>
                                    	<select name="General_RecordsLimit" class="form-control" disabled="disabled">
                                        	<option value="25" <?php echo lib::selectedDefault('General_RecordsLimit', 25, true); ?>>25</option>
                                            <option value="75" <?php echo lib::selectedDefault('General_RecordsLimit', 75, true); ?>>75</option>
                                            <option value="100" <?php echo lib::selectedDefault('General_RecordsLimit', 100, true); ?>>100</option>
                                            <option value="150" <?php echo lib::selectedDefault('General_RecordsLimit', 150, true); ?>>150</option>
                                            <option value="200" <?php echo lib::selectedDefault('General_RecordsLimit', 200, true); ?>>200</option>
                                        </select>
                                        <small><i>This will control how many items will be listed at anyone time on a page.</i></small>
                                    </div>
                                    <div class="form-group">
                                    	<label>System URL</label>
                                    	<input type="text" name="General_SystemURL" value="<?php echo lib::getSetting('General_SystemURL',false,true,true); ?>" placeholder="https://www.creativemiles.co.uk/billing" class="form-control" disabled="disabled"/>
                                        <small><i>This should be the full URL of the system.</i></small>
                                    </div>
                                    <div class="form-group">
                                    	<label>Force SSL (HTTPS)</label>
                                    	<select name="General_SystemForceSSL" class="form-control" disabled="disabled">
                                        	<option value="1" <?php echo lib::selectedDefault('General_SystemForceSSL', 1, true); ?>>Yes</option>
                                            <option value="0" <?php echo lib::selectedDefault('General_SystemForceSSL', 0, true); ?>>No</option>
                                        </select>
                                        <small><i>We strongly recommend you enable this feature, an SSL Certificate is required.</i></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            	<div class="col-sm-12">
                                	<hr />
                                	<div class="form-group pull-right">
                                    	<input type="submit" name="" value="Save Settings" class="btn btn-default" id="general_button"/>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div> 
                        <!-- TAB END -->
                        
                        <!-- LOCALISATION -->
                        <div class="tab-pane fade" id="tab2default">
                        	<script type="text/javascript">
                            	$(document).ready(function() {
									$('#local_error').hide();
									$('#local_success').hide();
									$('#local_button').click(function() {
										$('#local_error').hide();
										$('#local_success').hide();
										$.ajax({
											url: '<?php echo ADMINDOMAIN; ?>/?action=ajax&class=setup&method=local',
											type: 'POST',
											data: $('#local_form :input').serialize(),
											success: function(data) {
												if(data.error) {
													$('#local_error').html(data.error);
													$('#local_error').show();
												} else {
													$('#local_success').show();
												}
											}
										},'json');
										return false;
									});
								});
                            </script>
                            
                            <div class="alert alert-danger" id="local_error"></div>
                            <div class="alert alert-success" id="local_success">Your localisation settings have been saved successfully.</div>
                        
                        	<form action="" method="post" id="local_form">
                        	<div class="row">
                            	<div class="col-sm-6">
                               		<div class="form-group">
                                    	<label>Date Format</label>
                                        <select name="Local_DefaultDateFormat" class="form-control">
                                        	<option value="DD/MM/YYYY" <?php echo lib::selectedDefault('Local_DefaultDateFormat', 'DD/MM/YYYY', true); ?>>DD/MM/YYYY</option>
                                            <option value="DD.MM.YYYY" <?php echo lib::selectedDefault('Local_DefaultDateFormat', 'DD.MM.YYYY', true); ?>>DD.MM.YYYY</option>
                                            <option value="DD-MM-YYYY" <?php echo lib::selectedDefault('Local_DefaultDateFormat', 'DD-MM-YYYY', true); ?>>DD-MM-YYYY</option>
                                            <option value="MM/DD/YYYY" <?php echo lib::selectedDefault('Local_DefaultDateFormat', 'MM/DD/YYYY', true); ?>>MM/DD/YYYY</option>
                                            <option value="YYYY/MM/DD" <?php echo lib::selectedDefault('Local_DefaultDateFormat', 'YYYY/MM/DD', true); ?>>YYYY/MM/DD</option>
                                            <option value="YYYY-MM-DD" <?php echo lib::selectedDefault('Local_DefaultDateFormat', 'DYYYY-MM-DD', true); ?>>YYYY-MM-DD</option>
                                        </select>
                                        <small><i>This is the default date format for the entire system.</i></small>
                                    </div>
                                    
                                    <div class="form-group">
                                    	<label>Client Date Format</label>
                                        <select name="Local_ClientDateFormat" class="form-control">
                                        	<option value="DD/MM/YYYY" <?php echo lib::selectedDefault('Local_ClientDateFormat', 'DD/MM/YYYY', true); ?>>DD/MM/YYYY</option>
                                            <option value="DD.MM.YYYY" <?php echo lib::selectedDefault('Local_ClientDateFormat', 'DD.MM.YYYY', true); ?>>DD.MM.YYYY</option>
                                            <option value="DD-MM-YYYY" <?php echo lib::selectedDefault('Local_ClientDateFormat', 'DD-MM-YYYY', true); ?>>DD-MM-YYYY</option>
                                            <option value="MM/DD/YYYY" <?php echo lib::selectedDefault('Local_ClientDateFormat', 'MM/DD/YYYY', true); ?>>MM/DD/YYYY</option>
                                            <option value="YYYY/MM/DD" <?php echo lib::selectedDefault('Local_ClientDateFormat', 'YYYY/MM/DD', true); ?>>YYYY/MM/DD</option>
                                            <option value="YYYY-MM-DD" <?php echo lib::selectedDefault('Local_ClientDateFormat', 'DYYYY-MM-DD', true); ?>>YYYY-MM-DD</option>
                                        </select>
                                        <small><i>This is the default date format for the client.</i></small>
                                    </div>
                                    
                                    <div class="form-group">
                                    	<label>Allow clients to choose Language</label>
                                        <select name="Local_ChooseLanguage" class="form-control">
                                        	<option value="1" <?php echo lib::selectedDefault('Local_ChooseLanguage', 1, true); ?>>Yes</option>
                                            <option value="0" <?php echo lib::selectedDefault('Local_ChooseLanguage', 0, true); ?>>No</option>
                                        </select>
                                        <small><i>You can allow clients to choose an alternative language.</i></small>
                                    </div>
                                    
                                    <div class="form-group">
                                    	<label>Default Currency</label>
                                        <select name="Local_DefaultCurrency" class="form-control">
                                        	<?php foreach(lib::getCurrencies() AS $currency_id => $currency_name) { ?>
                                            <?php if($currency_id == 2) { ?>
                                                <option value="<?php echo $currency_id; ?>" <?php echo lib::selectedDefault('Local_DefaultCurrency', $currency_id, true); ?>><?php echo lib::san($currency_name,false,true,true); ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                        <small><i>Choose a default currency you wish to use.</i></small>
                                    </div>                                 
                                </div>
                                <div class="col-sm-6">
                                
                                	<div class="form-group">
                                    	<label>Default Country</label>
                                        <select name="Local_DefaultCountry" class="form-control">
                                        	<?php foreach(lib::getCountries() AS $c_id => $c_name) { ?>
                                        		<option value="<?php echo $c_id; ?>" <?php echo lib::selectedDefault('Local_DefaultCountry', $c_id, true); ?>><?php echo $c_name; ?></option>
											<?php } ?>
                                        </select>
                                        <small><i>Select the default system country.</i></small>
                                    </div>
                                                                   
                                </div>
                            </div>
                            
                            <div class="row">
                            	<div class="col-sm-12">
                                	<hr />
                                	<div class="form-group pull-right">
                                    	<input type="submit" name="" value="Save Settings" class="btn btn-default" id="local_button"/>
                                    </div>
                                </div>
                            </div>
                            
                        	</form>
                        </div> 
                        <!-- TAB END -->
                         
                        <!-- PRICES -->
                        <div class="tab-pane fade" id="tab3default">
                        	                            
                            <script type="text/javascript">
                            	$(document).ready(function() {
									$('#price_error').hide();
									$('#price_success').hide();
									$('#price_button').click(function() {
										$('#price_error').hide();
										$('#price_success').hide();
										$.ajax({
											url: '<?php echo ADMINDOMAIN; ?>/?action=ajax&class=setup&method=prices',
											type: 'POST',
											data: $('#price_form :input').serialize(),
											success: function(data) {
												if(data.error) {
													$('#price_error').html(data.error);
													$('#price_error').show();
												} else {
													$('#price_success').show();
												}
											}
										},'json');
										return false;
									});
								});
                            </script>
                            
                        	<div class="alert alert-danger" id="price_error"></div>
                            <div class="alert alert-success" id="price_success">Your price settings have been saved successfully.</div>
                                                        
                            <?php
								//PayPal
								function PayPalFees($amount) {
									if($amount > 0) {
										$price = $amount;
										$amount += .20;
										$amount = $amount / (1 - .032);
										$fees = number_format($amount - $price,2);
										$receive = number_format($price - $fees,2);
										return 'PayPal Fees: £'.$fees.' '.'You Get: £'.$receive;
									} else {
										return 'PayPal Fees: £0.00 You Get: £0.00';	
									}
								}
								//PayNow
								function PayNowFees($amount) {
									if($amount > 0) {
										$price = $amount;
										$amount += .50;
										$amount = $amount / (1 - .015);
										$fees = number_format($amount - $price,2);
										$receive = number_format($price - $fees,2);
										return 'PayNow Fees: £'.$fees.' '.'You Get: £'.$receive;
									} else {
										return 'PayNow Fees: £0.00 You Get: £0.00';	
									}
								}
							?>
                            
                            
                            <form action="" method="post" id="price_form">
                        	<div class="row">
                            	<div class="col-sm-6">  
                                    
                                    <h4>Advert Prices</h4>  
                                    
                                    <?php
										$advertPackageSQL = db::query("SELECT * FROM `".config::$db_prefix."adpacks`");
										while($advertPackageData = db::fetch($advertPackageSQL)) {
									?>
                                    <div class="form-group">
                                        <label><?php echo $advertPackageData['pack_title']; ?></label>
                                        <input type="text" class="form-control" value="<?php echo $advertPackageData['pack_price']; ?>" name="ad_<?php echo $advertPackageData['pack_id']; ?>"/>
                                        <small><?php echo PayPalFees($advertPackageData['pack_price']); ?></small><br />
                                        <small><?php echo PayNowFees($advertPackageData['pack_price']); ?></small>
                                    </div> 
                                    <?php } ?>
                                                                      
                                </div>
                                <div class="col-sm-6">
                                	 
                                    <h4>Store Prices</h4>                                                                    
                                	
                                    <?php
										$storePackageSQL = db::query("SELECT * FROM `".config::$db_prefix."stpacks`");
										while($storePackageData = db::fetch($storePackageSQL)) {
									?>                          	
                                    <div class="form-group">
                                        <label><?php echo $storePackageData['pack_title']; ?></label>
                                        <input type="text" class="form-control" value="<?php echo $storePackageData['pack_price']; ?>" name="st_<?php echo $storePackageData['pack_id']; ?>"/>
                                        <small><?php echo PayPalFees($storePackageData['pack_price']); ?></small><br />
                                        <small><?php echo PayNowFees($storePackageData['pack_price']); ?></small>
                                    </div> 
                                    <?php } ?>
                                    
                                    <div class="form-group pull-right">
                                    	<input type="submit" name="" value="Save Settings" class="btn btn-default" id="price_button"/>
                                    </div>
                                    
                                </div>
                            </div>
                            </form>
                            
                        </div>
                                             
                        <!-- SECURITY -->       
                        <div class="tab-pane fade" id="tab4default">
                            <script type="text/javascript">
                            	$(document).ready(function() {
									$('#security_error').hide();
									$('#security_success').hide();
									$('#security_button').click(function() {
										$('#security_error').hide();
										$('#security_success').hide();
										$.ajax({
											url: '<?php echo ADMINDOMAIN; ?>/?action=ajax&class=setup&method=security',
											type: 'POST',
											data: $('#security_form :input').serialize(),
											success: function(data) {
												if(data.error) {
													$('#security_error').html(data.error);
													$('#security_error').show();
												} else {
													$('#security_success').show();
												}
											}
										},'json');
										return false;
									});
								});
                            </script>
                            
                            <div class="alert alert-danger" id="security_error"></div>
                            <div class="alert alert-success" id="security_success">Your security settings have been saved successfully.</div>
                            
                            <form action="" method="post" id="security_form">
                        	<div class="row">
                            	<div class="col-sm-6">                                	
                                    <div class="form-group">
                                        <label>Brute Force Attempts</label>
                                        <input type="text" class="form-control" value="<?php echo lib::getSetting('Security_AuthBruteForceAttempts',false,true,true); ?>" name="Security_AuthBruteForceAttempts" disabled/>
                                        <small><i>If the user exceeds this value, the users IP will be permanantly banned.</i></small>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Brute Force Attempts Reset</label>
                                        <input type="text" class="form-control" value="<?php echo lib::getSetting('Security_AuthBruteForceAttemptsReset',false,true,true); ?>" name="Security_AuthBruteForceAttemptsReset" disabled/>
                                        <small><i>Automatically removes the IP addresses from the ban list after X minutes.</i></small>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Account Lockout</label>
                                        <input type="text" class="form-control" value="<?php echo lib::getSetting('Security_AuthLockAttempts',false,true,true); ?>" name="Security_AuthLockAttempts" disabled/>
                                        <small><i>If the user exceeds this value, the users account will be locked.</i></small>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Account Lockout Reset</label>
                                        <input type="text" class="form-control" value="<?php echo lib::getSetting('Security_AuthLockAttemptsReset',false,true,true); ?>" name="Security_AuthLockAttemptsReset" disabled/>
                                        <small><i>Automatically unlocks the users account after X minutes.</i></small>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Fraud Protection</label>
                                        <select name="Security_FraudProtection" class="form-control" disabled>
                                        	<option value="1" <?php echo lib::selectedDefault('Security_FraudProtection', 1, true); ?>>Yes, Users require email activation.</option>
                                            <option value="0" <?php echo lib::selectedDefault('Security_FraudProtection', 0, true); ?>>No, Users do not require email activation</option>
                                        </select>
                                        <small><i>If enabled, will allow you to check a client against our database for know fraud reports.</i></small>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Require Email Activation</label>
                                        <select name="Security_EmailActivation" class="form-control" disabled>
                                        	<option value="1" <?php echo lib::selectedDefault('Security_EmailActivation', 1, true); ?>>Yes, Users require email activation.</option>
                                            <option value="0" <?php echo lib::selectedDefault('Security_EmailActivation', 0, true); ?>>No, Users do not require email activation</option>
                                        </select>
                                        <small><i>If enabled, client will need to activate their account via email.</i></small>
                                    </div>
                                    
                                </div>
                                <div class="col-sm-6">
                                	                                                                    
                                	<div class="form-group">
                                        <label>Block Blank User Agents (Prevents Bots/Malicious Users)</label>
                                        <select name="Security_BlockAgents" class="form-control" disabled>
                                        	<option value="1" <?php echo lib::selectedDefault('Security_BlockAgents', 1, true); ?>>Yes</option>
                                            <option value="0" <?php echo lib::selectedDefault('Security_BlockAgents', 0, true); ?>>No</option>
                                        </select>
                                        <small><i>Some bots and users set a blank user agent to avoid UserAgent block lists.</i></small>
                                    </div>
                                    <div class="form-group">
                                        <label>Enable Bot Traps (Prevents Bots/Malicious Users)</label>
                                        <select name="Security_BotTraps" class="form-control" disabled>
                                        	<option value="1" <?php echo lib::selectedDefault('Security_BotTraps', 1, true); ?>>Yes</option>
                                            <option value="0" <?php echo lib::selectedDefault('Security_BotTraps', 0, true); ?>>No</option>
                                        </select>
                                        <small><i>This will set random hidden on forms which will be used to trap bots.</i></small>
                                    </div>
                                    <br />
                                    <div class="form-group pull-right">
                                    	<input type="submit" name="" value="Save Settings" class="btn btn-default" id="security_button"/>
                                    </div>
                                    
                                </div>
                            </div>
                            </form>
                            
                            <hr />
                                                        
                            <?php /*  <div class="row">
                            	<div class="col-sm-12">
                                    
                                    <form action="" method="post" id="IPBan_Form">
                                    	<script type="text/javascript">
                                        	$(document).ready(function() {
												$('#IPBan_Add').click(function() { 
													$('#IPBan_Option').val(0);
													$('#IPBan_Form').submit();
												});
												$('#IPBan_Remove').click(function() { 
													$('#IPBan_Option').val(1); 
													$('#IPBan_Form').submit();
												});
												$('#IPBanList').change(function() {
													$('#IPBanText').val($('#IPBanList').val());
												});
											});
                                        </script>
                                        <div class="form-group">
                                            <label>IP Ban List</label>
                                            <select name="" multiple="multiple" class="form-control" id="IPBanList2">
                                            	<?php while($IPBanListData = db::fetch($IPBanListSQL)) { ?>
                                                	<option value="<?php echo lib::san($IPBanListData['ip_address'],false,true,true); ?>"><?php echo lib::san($IPBanListData['ip_address'],false,true,true); ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group form-inline">
                                        	<!--INPUTS-->
                                            <input type="text" class="form-control" name="ip_address" id="IPBanText"/> 
                                            <input type="hidden" value="0" name="ip_option" id="IPBan_Option"/>
                                            <input type="hidden" name="_IPBanWhiteList" value="1" />
                                            <!--BUTTONS-->
                                            <input type="button" value="Add IP" class="btn btn-default" id="IPBan_Add"/> 
                                            <input type="button" value="Remove IP" class="btn btn-default" id="IPBan_Remove"/>
                                        </div>
                                    </form>
                                    
                                    
                                    
                                    
                                    <!-- IP BAN WHITELIST -->
                                    <form action="" method="post" id="IPBan_Form">
                                    	<script type="text/javascript">
                                        	$(document).ready(function() {
												$('#IPBanWhite_Add').click(function() { 
													$('#IPBanWhite_Option').val(0);
													$('#IPBanWhite_Form').submit();
												});
												$('#IPBanWhite_Remove').click(function() { 
													$('#IPBanWhite_Option').val(1); 
													$('#IPBanWhite_Form').submit();
												});
												$('#IPBanWhiteList').change(function() {
													$('#IPBanWhiteText').val($('#IPBanWhiteList').val());
												});
											});
                                        </script>
                                        <div class="form-group">
                                            <label>IP Ban Whitelist</label>
                                            <select name="" multiple="multiple" class="form-control" id="IPBanWhiteList">
                                            	<?php while($IPBanData1 = db::fetch($IPBanSQL1)) { ?>
                                                	<option value="<?php echo lib::san($IPBanData1['ip_address'],false,true,true); ?>"><?php echo lib::san($IPBanData1['ip_address'],false,true,true); ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group form-inline">
                                        	<!--INPUTS-->
                                            <input type="text" class="form-control" name="ip_address" id="IPBanWhiteText"/> 
                                            <input type="hidden" value="0" name="ip_option" id="IPBanWhite_Option"/>
                                            <input type="hidden" name="_IPBanWhiteList" value="1" />
                                            <!--BUTTONS-->
                                            <input type="button" value="Add IP" class="btn btn-default" id="IPBanWhite_Add"/> 
                                            <input type="button" value="Remove IP" class="btn btn-default" id="IPBanWhite_Remove"/>
                                        </div>
                                    </form>
                                    
                                    <form action="" method="post" id="API_Form">
                                    <script type="text/javascript">
										$(document).ready(function() {
											$('#API_Add').click(function() { 
												$('#API_Option').val(0);
												$('#API_Form').submit();
											});
											$('#API_Remove').click(function() { 
												$('#API_Option').val(1); 
												$('#API_Form').submit();
											});
											$('#APIList').change(function() {
												$('#APIText').val($('#APIList').val());
											});
										});
									</script>
                                    <div class="form-group">
                                        <label>API IP Whitelist</label>
                                        <select name="" multiple="multiple" class="form-control" id="APIList">
                                        	<?php while($APIData = db::fetch($APISQL)) { ?>
                                                <option value="<?php echo lib::san($APIData['ip_address'],false,true,true); ?>"><?php echo lib::san($APIData['ip_address'],false,true,true); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group form-inline">
                                    	<!--INPUTS-->
                                    	<input type="text" class="form-control" id="APIText" name="ip_address"/> 
                                        <input type="hidden" name="ip_option" id="API_Option" />
                                        <input type="hidden" name="_apiwhitelist" value="1"/>
                                        <!--BUTTONS-->
                                        <input type="button" value="Add IP" class="btn btn-default" id="API_Add"/> 
                                        <input type="button" value="Remove IP" class="btn btn-default" id="API_Remove"/>
                                    </div>
                                    </form>                                
                                    
                                    <form action="" method="post" id="SQ_Form">
                                    <script type="text/javascript">
										$(document).ready(function() {
											$('#SQ_Add').click(function() { 
												$('#sq_option').val(0);
												$('#SQ_Form').submit();
											});
											$('#SQ_Remove').click(function() { 
												$('#sq_option').val(1); 
												$('#SQ_Form').submit();
											});
											$('#SQList').change(function() {
												$('#sq_text').val($('#SQList :selected').text());
												$('#sq_id').val($('#SQList').val());
											});
										});
									</script>
    								<div class="form-group">
                                        <label>Client Security Questions</label>
                                        <select name="" multiple="multiple" class="form-control" id="SQList">
                                        	<?php while($SQData = db::fetch($SQSQL)) { ?>
                                                <option value="<?php echo $SQData['question_id']; ?>"><?php echo lib::san($SQData['question_value'],false,true,true); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group form-inline">
                                    	<!--INPUT-->
                                    	<input type="text" class="form-control" name="sq_text" id="sq_text"/> 
                                        <input type="hidden" class="form-control" name="sq_id" id="sq_id"/> 
                                        <input type="hidden" name="sq_option" value="0" id="sq_option"/>
                                        <input type="hidden" name="_securityquestions" value="1"/>
                                        <!--BUTTONS-->
                                        <input type="button" value="Add Question" class="btn btn-default" id="SQ_Add"/> 
                                        <input type="button" value="Remove Question" class="btn btn-default" id="SQ_Remove"/>
                                    </div>
                                    </form>
                                    
                                    
                                </div>
                            </div> */ ?>  
                        </div> 
                        <!-- TAB END -->
                        
                        
                                               
                                                                        
                    </div>
                </div>
            </div>
        
        </div>
    </div>            
</div>