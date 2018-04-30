<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
class template {
	public function __construct() {
		
		/*************************************/
		// GLOBAL DATA - Prevents Duplicate Data Being Loaded
		/*************************************/
		
		//Load System Categories
		$categories = array();
		$parentSQL = db::query("SELECT * FROM `".config::$db_prefix."categories` WHERE `cat_parentid`='0'");
		while($parentData = db::fetch($parentSQL)) {
			
			//A place to store child-cats.
			$childCats = array();
			
			//Load Child-Categories
			$childSQL = db::query("SELECT * FROM `".config::$db_prefix."categories` WHERE `cat_parentid`='".$parentData['cat_id']."'");
			while($childData = db::fetch($childSQL)) {
				$childCats[] = array('cat_id' => $childData['cat_id'], 'cat_name' => $childData['cat_name'], 'cat_slug' => $childData['cat_slug']);
			}
			
			//Build Categories
			$categories[] = array('cat_id' => $parentData['cat_id'],'cat_name' => $parentData['cat_name'],'cat_slug' => $parentData['cat_slug'], 'cat_child' => $childCats) ;
		}
		
		//Load System Cities
		$cities = array();
		$citySQL = db::query("SELECT * FROM `".config::$db_prefix."cities`");
		while($cityData = db::fetch($citySQL)) {					
			$cities[$cityData['city_id']] = $cityData['city_name'];
		}
		
		//ACTIVE SESSION
		if(session::active()) {
								
			//@Main Menu
			//If we are loading the main menu
			switch(lib::get('action')) {
				case 'logout': {
					session::kill();
					@header("Location:".ADMINDOMAIN);
					break;	
				}
				case 'ajax': {
					//Set Headers
					header("Content-type: application/json");
					switch(lib::get('class')) {
						case 'banners': {
							require(ADMINROOT.'/classes/banners.class.php');
							switch(lib::get('method')) {
								//Ajax Image Upload
								case 'imageupload': {
									$banners=new banners;
									echo $banners->ImageUpload();
									break;
								}
								//Ajax Image Remove
								case 'imageremove': {
									$banners=new banners;
									echo $banners->ImageUpload();
									break;
								}
							}
							break;	
						}
						case 'setup': {
							require(ADMINROOT.'/classes/setup.class.php');
							switch(lib::get('method')) {
								case 'general': {
									$setup=new setup;
									echo $setup->generalSettings();
									break;
								}
								case 'local': {
									$setup=new setup;
									echo $setup->localSettings();
									break;
								}
								case 'security': {
									$setup=new setup;
									echo $setup->securitySettings();
									break;
								}
								case 'prices': {
									$setup=new setup;
									echo $setup->priceSettings();
									break;
								}
							}
							break;
						}
						
						case 'adverts': {
							require(ROOT.'/classes/advert.class.php');	
							switch(lib::get('method')) {
								case 'approve': {
									$advert= new advert();
									echo $advert->approveAdvert(lib::post('advert_id'));
									break;
								}
								case 'reject': {
									$advert= new advert();
									echo $advert->rejectAdvert(lib::post('advert_id'));
									break;
								}
							}
							break;
						}
					}
					break;
					@header("Location:".ADMINDOMAIN);
				}
				case 'banners': {
					require(ADMINROOT.'/classes/banners.class.php');	
					switch(lib::get('method')) {
						case 'delete_image': {
							$banners=new banners;
							$banners->deleteImage();
							@header("Location:".ADMINDOMAIN.'/index.php?action=banners&method=edit_banner&banner_id='.lib::get('banner_id'));
							die();
							break;	
						}
						case 'edit_banner': {
							if(db::nRows("SELECT `banner_id` FROM `".config::$db_prefix."banners` WHERE `banner_id`='".lib::get('banner_id',true)."'") > 0) {
								
								//Reset Advert Session
								unset($_SESSION[config::$db_prefix.'banner']);
								$_SESSION[config::$db_prefix.'banner'] = array();
								
								//Load
								$bannerData = db::fetchQuery("SELECT * FROM `".config::$db_prefix."banners` WHERE `banner_id`='".lib::get('banner_id',true)."'");
								
								//SQL
								$SQL = "SELECT * FROM `".config::$db_prefix."banners_images` WHERE `image_bannerid`='".lib::get('banner_id',true)."'";
																														
								//Get Total Clients
								$records = db::nRows($SQL);
								
								//Pagingate
								$paginate=new paginate($SQL);
																					
								//Query Customers
								$ImageSQL = db::query($paginate->returnSQL());
																
								//Load Template
								require(ADMINROOT.'/templates/default/header.template.php');	
								require(ADMINROOT.'/templates/default/banners/edit_banner.template.php');
								require(ADMINROOT.'/templates/default/footer.template.php');
							
							} else {
								@header("Location:".ADMINDOMAIN);
								die();
							}
							break;
						}
						default: {
							
							//SQL
							$SQL = "SELECT * FROM `".config::$db_prefix."banners`";
																													
							//Get Total Clients
							$records = db::nRows($SQL);
							
							//Pagingate
							$paginate=new paginate($SQL);
																				
							//Query Customers
							$bannerSQL = db::query($paginate->returnSQL());
							
							//Load Template
							require(ADMINROOT.'/templates/default/header.template.php');	
							require(ADMINROOT.'/templates/default/banners/default.template.php');
							require(ADMINROOT.'/templates/default/footer.template.php');
							break;
						}
					}
					break;
				}
				case 'products': {
					require(ADMINROOT.'/classes/stores.class.php');	
					switch(lib::get('method')) {
						case 'view_paymentdetails': {
							if(db::nRows("SELECT `advert_id` FROM `".config::$db_prefix."adverts` WHERE `advert_id`='".lib::get('advert_id',true)."' AND `advert_store`='1'") > 0) {
								
								//Load
								$advertData = db::fetchQuery("SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_id`='".lib::get('advert_id',true)."'");
								
								//Store Data
								$storeData = db::fetchQuery("SELECT * FROM `".config::$db_prefix."stores` WHERE `store_id`='".db::mss($advertData['advert_storeid'])."'");
								
								//Edit Store
								if(lib::post('_mark-paid')) {
									$stores=new stores;
									$message = $stores->markPaid();
									if(!$message) {
										@header("Location:".ADMINDOMAIN.'/index.php?action=products');
										die();	
									}
								}
								
								//Load Template
								require(ADMINROOT.'/templates/default/header.template.php');	
								require(ADMINROOT.'/templates/default/products/paymentdetails.template.php');
								require(ADMINROOT.'/templates/default/footer.template.php');
							
							} else {
								@header("Location:".ADMINDOMAIN);
								die();
							}
							break;
						}
						default: {
							
							//SQL
							$SQL = "SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_store`='1'";
														
							//Filter Advert
							if(lib::get('filter')) {
								switch(lib::get('filter')) {
									case 1: {
										$SQL .= " AND `advert_paidout`='1'"; //Pending
										break;	
									}
									case 2: {
										$SQL .= " AND `advert_paidout`='0'"; //Active
										break;	
									}
									case 3: {
										if(db::nRows("SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_storeid`='".lib::post('store_id',true)."'") > 0) {
											$SQL .= " AND `advert_storeid`='".lib::post('store_id',true)."'"; 
										}
										break;	
									}
								}
							}
																						
							//Get Total Clients
							$records = db::nRows($SQL);
							
							//Pagingate
							$paginate=new paginate($SQL);
																				
							//Query Customers
							$advertSQL = db::query($paginate->returnSQL());
							
							//Load Template
							require(ADMINROOT.'/templates/default/header.template.php');	
							require(ADMINROOT.'/templates/default/products/default.template.php');
							require(ADMINROOT.'/templates/default/footer.template.php');
							break;	
						}
					}
					break;	
				}
				case 'stores': {
					require(ADMINROOT.'/classes/stores.class.php');	
					switch(lib::get('method')) {
						case 'delete_store': {
							
							//Does the store exist?
							if(db::nRows("SELECT `store_id` FROM `".config::$db_prefix."stores` WHERE `store_id`='".lib::get('store_id',true)."'") > 0) {
																								
								//Edit Store
								if(lib::post('_delete-store')) {
									$stores=new stores;
									$message = $stores->deleteStore();
									if(!$message) {
										@header("Location:".ADMINDOMAIN.'/index.php?action=stores');
										die();	
									}
								}
								
								//Load Template
								require(ADMINROOT.'/templates/default/header.template.php');	
								require(ADMINROOT.'/templates/default/stores/includes/delete_store.template.php');
								require(ADMINROOT.'/templates/default/footer.template.php');
							
							} else {
								@header("Location:".ADMINDOMAIN);
								die();
							}
							
							break;	
						}
						case 'edit_store': {
							
							//Does the store exist?
							if(db::nRows("SELECT `store_id` FROM `".config::$db_prefix."stores` WHERE `store_id`='".lib::get('store_id',true)."'") > 0) {
								
								//Load Store
								$store = db::fetchQuery("SELECT * FROM `".config::$db_prefix."stores` WHERE `store_id`='".lib::get('store_id',true)."'");
								
								//Remember Function
								function rememberMe($store, $fieldname, $columname) {
									if(lib::post($fieldname)) {
										return lib::post($fieldname);	
									} else {
										if(isset($store[$columname]) && $store[$columname] != '') {
											return $store[$columname];
										}
									}
								}
								
								//Edit Store
								if(lib::post('_edit-store')) {
									$stores=new stores;
									$message = $stores->editStore();
									if(!$message) { $success=true; }
								}
								
								//Load Template
								require(ADMINROOT.'/templates/default/header.template.php');	
								require(ADMINROOT.'/templates/default/stores/includes/edit_store.template.php');
								require(ADMINROOT.'/templates/default/footer.template.php');
							
							} else {
								@header("Location:".ADMINDOMAIN);
								die();
							}
							
							break;	
						}
						default: {
							
							//SQL
							$SQL = "SELECT * FROM `".config::$db_prefix."stores`";
																															
							//Get Total Stores
							$records = db::nRows($SQL);
							
							//Pagingate
							$paginate=new paginate($SQL);
																				
							//Query Customers
							$storeSQL = db::query($paginate->returnSQL());
														
							//Load Template
							require(ADMINROOT.'/templates/default/header.template.php');	
							require(ADMINROOT.'/templates/default/stores/default.template.php');
							require(ADMINROOT.'/templates/default/footer.template.php');
							break;
						}
					}
					break;
				}
				case 'adverts': {
					require(ADMINROOT.'/classes/advert.class.php');	
					switch(lib::get('method')) {
						case 'ajax': {
							@header("Content-type: application/json");
							switch(lib::get('request')) {
								//Allows us to edit an Advert
								case 'multicat': {
									//Load Class
									$advert=new advert;
									echo $advert->multiCat();	
									break;
								}
								//Allows us to edit an Advert
								case 'edit-advert': {
									//Load Class
									$advert=new advert;
									echo $advert->editAdvert();	
									break;
								}
								//Allows us to remove an Advert
								case 'delete-advert': {
									//Load Class
									$advert=new advert;
									echo $advert->deleteAdvert();	
									break;
								}
							}
							break;	
						}
						case 'edit_advert': {
									
							//Reset Advert Session
							unset($_SESSION[config::$db_prefix.'advert']);
							$_SESSION[config::$db_prefix.'advert'] = array();
							
							//A place to store errors
							$this->errorsArray = array();
																
							//Does the advert exist?
							if(db::nRows("SELECT `advert_id` FROM `".config::$db_prefix."adverts` WHERE (`advert_id`='".lib::get('advert_id',true)."')") < 1) {
								$this->errorsArray[] = 'That advert either does not exist or you don\'t own it!';
							}
																
							//Do we have any issues?
							if(count($this->errorsArray)) {
								header("Location:".ADMINDOMAIN);
								exit();
							} else {
								
								//Advert Data
								$advertData = db::fetchQuery("SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_id`='".lib::get('advert_id',true)."'");																				
								//Load Template
								require(ADMINROOT.'/templates/default/header.template.php');	
								require(ADMINROOT.'/templates/default/adverts/edit_advert.template.php');
								require(ADMINROOT.'/templates/default/footer.template.php');
								
								break;
							}
						}	
						case 'view_advert': {
							if(db::nRows("SELECT `advert_id` FROM `".config::$db_prefix."adverts` WHERE `advert_id`='".lib::get('advert_id',true)."' AND `advert_store`='0'") > 0) {
								
								//Load
								$advertData = db::fetchQuery("SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_id`='".lib::get('advert_id',true)."'");
								
								//Load Category
								$category = db::fetchQuery("SELECT `cat_name` FROM `".config::$db_prefix."categories` WHERE `cat_id`='".$advertData['advert_id']."'");
								
								//User Data
								$userData = db::fetchQuery("SELECT * FROM `".config::$db_prefix."clients` WHERE `user_id`='".$advertData['advert_userid']."'");
								
								//Country
								$country = lib::getCountry($userData['user_country']);
								
								//City
								$city = lib::getCity($userData['user_city']);
																
								//Load Template
								require(ADMINROOT.'/templates/default/header.template.php');	
								require(ADMINROOT.'/templates/default/adverts/view_advert.template.php');
								require(ADMINROOT.'/templates/default/footer.template.php');
								
							} else {
								header("Location:".ADMINDOMAIN);
								exit();	
							}
							break;	
						}
						default: {
							
							//SQL
							$SQL = "SELECT * FROM `".config::$db_prefix."adverts`";
														
							//Filter Advert
							if(lib::get('filter')) {
								switch(lib::get('filter')) {
									case 1: {
										$SQL .= " ORDER BY `advert_status`='0' DESC"; //Pending
										break;	
									}
									case 2: {
										$SQL .= " ORDER BY `advert_status`='1' DESC"; //Active
										break;	
									}
									case 3: {
										$SQL .= " ORDER BY `advert_status`='2' DESC"; //Expired
										break;	
									}
									case 4: {
										$SQL .= " ORDER BY `advert_status`='3' DESC"; //Rejected
										break;	
									}
									case 5: {
										if(db::nRows("SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_id`='".lib::post('advert_id',true)."'") > 0) {
											$SQL .= " WHERE `advert_id` LIKE '%".lib::post('advert_id',true)."%'"; //Rejected
										}
										break;	
									}
									default: {
										$SQL .= " WHERE `advert_store`='0'";	
									}
								}
							}
							
							//$SQL .= 'ORDER BY `advert_id` DESC';
																						
							//Get Total Clients
							$records = db::nRows($SQL);
							
							//Pagingate
							$paginate=new paginate($SQL);
																				
							//Query Customers
							$advertSQL = db::query($paginate->returnSQL());
							
							//Load Template
							require(ADMINROOT.'/templates/default/header.template.php');	
							require(ADMINROOT.'/templates/default/adverts/default.template.php');
							require(ADMINROOT.'/templates/default/footer.template.php');
							break;	
						}
					}
					break;
				}
				
				case 'categories': {
					require(ADMINROOT.'/classes/categories.class.php');	
					switch(lib::get('method')) {
						case 'ajax': {
							@header("Content-type: application/json");
							switch(lib::get('request')) {
								//Allows us to remove an Advert
								case 'delete-advert': {
									//Load Class
									$advert=new advert;
									echo $advert->deleteAdvert();	
									break;
								}
							}
							break;	
						}
						case 'create_cat': {
							
							//Login Function
							if(lib::post('_submit')) {
								$categories= new categories();
								$message = $categories->createCategory();
								if($message == '') {
									@header("Location:".ADMINDOMAIN.'/?action=categories');	
								}
							}
																										
							//Load Template
							require(ADMINROOT.'/templates/default/header.template.php');	
							require(ADMINROOT.'/templates/default/categories/create_cat.template.php');
							require(ADMINROOT.'/templates/default/footer.template.php');
							
							break;
						}
						case 'delete_cat': {
							$categories= new categories();
							$message = $categories->deleteCategory();
							if($message == '') {
								@header("Location:".ADMINDOMAIN.'/?action=categories');	
							}
							//Load Template
							require(ADMINROOT.'/templates/default/header.template.php');	
							require(ADMINROOT.'/templates/default/categories/delete_cat.template.php');
							require(ADMINROOT.'/templates/default/footer.template.php');
							break;	
						}
						case 'edit_cat': {
														
							//A place to store errors
							$this->errorsArray = array();
																
							//Does the category exist?
							if(db::nRows("SELECT `cat_id` FROM `".config::$db_prefix."categories` WHERE `cat_id`='".lib::get('cat_id',true)."'") < 1) {
								$this->errorsArray[] = 'That cat either does not exist or you don\'t own it!';
							}
																
							//Do we have any issues?
							if(count($this->errorsArray)) {
								header("Location:".ADMINDOMAIN);
								exit();
							} else {
								
								//Advert Data
								$catData = db::fetchQuery("SELECT * FROM `".config::$db_prefix."categories` WHERE `cat_id`='".lib::get('cat_id',true)."'");
								
								//Login Function
								if(lib::post('_submit')) {
									$categories= new categories();
									$message = $categories->editCategory();
									if($message == '') {
										@header("Location:".ADMINDOMAIN.'/?action=categories&method=edit_cat&cat_id='.$catData['cat_id']);	
									}
								}
																											
								//Load Template
								require(ADMINROOT.'/templates/default/header.template.php');	
								require(ADMINROOT.'/templates/default/categories/edit_cat.template.php');
								require(ADMINROOT.'/templates/default/footer.template.php');
								
								break;
							}
						}
						default: {
							
							//SQL
							$SQL = "SELECT * FROM `".config::$db_prefix."categories` WHERE `cat_parentid`='0'";
																																	
							//Get Total Clients
							$records = db::nRows($SQL);
							
							//Pagingate
							$paginate=new paginate($SQL);
																				
							//Query Customers
							$catSQL = db::query($paginate->returnSQL());
							
							//Load Template
							require(ADMINROOT.'/templates/default/header.template.php');	
							require(ADMINROOT.'/templates/default/categories/default.template.php');
							require(ADMINROOT.'/templates/default/footer.template.php');
							break;	
						}
					}
					break;
				}
				
				case 'clients': {
					require(ADMINROOT.'/classes/client.class.php');
					switch(lib::get('method')) {
						case 'add': {
																					
							//Login Function
							if(lib::post('_submit')) {
								require(ADMINROOT.'/classes/client.class.php');
								$client= new client();
								$message = $client->add();
								if($message == '') {
									@header("Location:".ADMINDOMAIN.'/?action=clients');	
								}
							}
							
							//Load Files
							require(ADMINROOT.'/templates/default/header.template.php');	
							require(ADMINROOT.'/templates/default/clients/add.template.php');
							require(ADMINROOT.'/templates/default/footer.template.php');
							break;	
						}
						case 'view': {
									
							//Does the client exist?
							if(db::nRows("SELECT `user_id` FROM `".config::$db_prefix."clients` WHERE `user_id`='".lib::get('client_id',true)."'") > 0) {
								$user = db::fetchQuery("SELECT * FROM `".config::$db_prefix."clients` WHERE `user_id`='".lib::get('client_id',true)."'");
							} else {
								@header("Location:".ADMINDOMAIN.'/?action=clients');
								exit();	
							}
							
							//Remember Me
							function rememberMe($user, $field, $field_type, $expected_value = '', $mss = false, $tags = true, $html = true) {							
								switch($field_type) {
									case 'text': {
										if(lib::post($field, $mss, $tags, $html)) {
											return lib::post($field, $mss, $tags, $html);
										} else {
											if(isset($user[$field]) && $user[$field] != '') {
												return lib::san($user[$field], $mss, $tags, $html);	
											}
										}
										break;
									}
									case 'checkbox': {
										if(lib::post($field, $mss, $tags, $html)) {
											if(lib::post($field, $mss, $tags, $html) == $expected_value) {
												return 'checked';	
											}
										} else {
											if($user[$field] == $expected_value) {
												return 'checked';	
											}
										}
										break;
									}
									case 'selected': {
										if(lib::post($field, $mss, $tags, $html)) {
											if(lib::post($field, $mss, $tags, $html) == $expected_value) {
												return 'selected';	
											}
										} else {
											if($user[$field] == $expected_value) {
												return 'selected';	
											}
										}
										break;	
									}
								}
							}
							
							//Client Delete
							if(lib::post('_delete')) {
								$client= new client();
								$message = $client->delete();
								if($message == '') {
									@header("Location:".ADMINDOMAIN.'/?action=clients');	
								}
							}
							
							//Update Profile
							if(lib::post('_profile')) {
								$client= new client();
								$message = $client->update();
								if($message == '') {
									@header("Location:".ADMINDOMAIN.'/?action=clients&method=view&client_id='.lib::post('user_id').'&tab_show=2');	
								}
							}
									
							//Tabs		
							switch(lib::get('tab')) {
								case 'contracts_agreements': {
									require(ADMINROOT.'/templates/default/clients/includes/header.template.php');	
									require(ADMINROOT.'/templates/default/clients/includes/contracts_agreements.template.php');
									require(ADMINROOT.'/templates/default/clients/includes/footer.template.php');
									break;
								}
								case 'invoices': {
									
									//SQL
									$SQL = "SELECT * FROM `".config::$db_prefix."invoices` WHERE `invoice_userid`='".lib::get('client_id',true)."'";
									
									//Get Total Clients
									$records = db::nRows($SQL);
									
									//Pagingate
									$paginate=new paginate($records, $SQL);
																						
									//Query Customers
									$invoiceSQL = db::query($paginate->returnSQL());
									
									require(ADMINROOT.'/templates/default/clients/includes/header.template.php');	
									require(ADMINROOT.'/templates/default/clients/includes/invoices.template.php');
									require(ADMINROOT.'/templates/default/clients/includes/footer.template.php');
									break;
								}
								case 'quotes': {
									require(ADMINROOT.'/templates/default/clients/includes/header.template.php');	
									require(ADMINROOT.'/templates/default/clients/includes/quotes.template.php');
									require(ADMINROOT.'/templates/default/clients/includes/footer.template.php');
									break;
								}
								case 'domain_names': {
									require(ADMINROOT.'/templates/default/clients/includes/header.template.php');	
									require(ADMINROOT.'/templates/default/clients/includes/domain_names.template.php');
									require(ADMINROOT.'/templates/default/clients/includes/footer.template.php');
									break;
								}
								case 'product_services': {
									require(ADMINROOT.'/templates/default/clients/includes/header.template.php');	
									require(ADMINROOT.'/templates/default/clients/includes/product_services.template.php');
									require(ADMINROOT.'/templates/default/clients/includes/footer.template.php');
									break;
								}
								case 'edit_profile': {
									
									//Query Security Questions
									$q_sql = db::query("SELECT * FROM `".config::$db_prefix."questions`");
									
									//Load Country
									$c_data = db::fetchQuery("SELECT `country_name` FROM `".config::$db_prefix."countries` WHERE `id`='".$user['user_country']."'");
									
									require(ADMINROOT.'/templates/default/clients/includes/header.template.php');	
									require(ADMINROOT.'/templates/default/clients/includes/edit_profile.template.php');
									require(ADMINROOT.'/templates/default/clients/includes/footer.template.php');
									break;	
								}
								default: {			
									require(ADMINROOT.'/templates/default/clients/includes/header.template.php');	
									require(ADMINROOT.'/templates/default/clients/includes/overview.template.php');
									require(ADMINROOT.'/templates/default/clients/includes/footer.template.php');
									break;
								}
							}
							break;								
						}
						default: {
							//SQL
							$SQL = "SELECT * FROM `".config::$db_prefix."clients`";
							
							//Client Delete
							if(lib::post('_delete')) {
								require(ADMINROOT.'/classes/client.class.php');
								$client= new client();
								$message = $client->delete();
								if($message == '') {
									@header("Location:".ADMINDOMAIN.'/?action=clients');	
								}
							}
																					
							//Get Total Clients
							$records = db::nRows($SQL);
							
							//Pagingate
							$paginate=new paginate($SQL);
																				
							//Query Customers
							$clientSQL = db::query($paginate->returnSQL());
							
							require(ADMINROOT.'/templates/default/header.template.php');	
							require(ADMINROOT.'/templates/default/clients/default.template.php');
							require(ADMINROOT.'/templates/default/footer.template.php');
							break;
						}
					}
					@header("Location:".ADMINDOMAIN);
					exit();
					break;
				}
				case 'setup': {				
					switch(lib::get('option')) {
						case 'logs': {
							switch(lib::get('do')) {
								default: {
								
								  //SQL
								  $SQL = "SELECT * FROM `".config::$db_prefix."logs` ORDER BY `log_id` DESC";
								  
								  //Get Total Clients
								  $records = db::nRows($SQL);
								  
								  //Pagingate
								  $paginate=new paginate($SQL);
																					  
								  //Query Customers
								  $l_sql = db::query($paginate->returnSQL());
								
								  //Load Template
								  require(ADMINROOT.'/templates/default/header.template.php');	
								  require(ADMINROOT.'/templates/default/setup/logs.template.php');
								  require(ADMINROOT.'/templates/default/footer.template.php');
								  break;
								}
							}
							break;
						}
						case 'email_templates': {
							switch(lib::get('do')) {
								case 'preview': {
									require(ADMINROOT.'/classes/email.class.php');
									$email= new email();
									echo $email->previewWindow();
									break;	
								}
								case 'delete_template': {
									
									//Does the template exist?
									if(db::nRows("SELECT `template_id` FROM `".config::$db_prefix."email_templates` WHERE `template_id`='".lib::get('template_id',true)."'") < 1) {
										$this->errorsArray[] = 'Sorry, we could not find an email template matching the ID you provided.';	
									} else {
										$template = db::fetchQuery("SELECT * FROM `".config::$db_prefix."email_templates` WHERE `template_id`='".lib::get('template_id',true)."'");
									}
									
									//Delete..
									require(ADMINROOT.'/classes/email.class.php');
									$email= new email();
									$message = $email->deleteTemplate();
									
									//Load Template
									require(ADMINROOT.'/templates/default/header.template.php');	
									require(ADMINROOT.'/templates/default/setup/email/delete_template.template.php');
									require(ADMINROOT.'/templates/default/footer.template.php');									
									break;	
								}
								case 'edit_template': {
									
									//Does the template exist?
									if(db::nRows("SELECT `template_id` FROM `".config::$db_prefix."email_templates` WHERE `template_id`='".lib::get('template_id',true)."'") < 1) {
										$this->errorsArray[] = 'Sorry, we could not find an email template matching the ID you provided.';	
									} else {
										$template = db::fetchQuery("SELECT * FROM `".config::$db_prefix."email_templates` WHERE `template_id`='".lib::get('template_id',true)."'");
									}
									
									//Add Template
									if(lib::post('_submit')) {
										require(ADMINROOT.'/classes/email.class.php');
										$email= new email();
										$message = $email->editTemplate();
										if($message == '') {
											@header("Location:".ADMINDOMAIN.'/?action=setup&option=email_templates');	
										}
									}
									
									//Remember Me
									function rememberMe($template, $field, $html = true, $tags = true) {
										if(lib::post($field)) {
											return lib::post($field,false,$html,$tags);
										} else {
											return lib::san($template[$field],false,$html,$tags);
										}
									}
									
									//Load Template
									require(ADMINROOT.'/templates/default/header.template.php');	
									require(ADMINROOT.'/templates/default/setup/email/edit_template.template.php');
									require(ADMINROOT.'/templates/default/footer.template.php');									
									break;	
								}
								case 'add_template': {
									
									//Add Template
									if(lib::post('_submit')) {
										require(ADMINROOT.'/classes/email.class.php');
										$email= new email();
										$message = $email->addTemplate();
										if($message == '') {
											@header("Location:".ADMINDOMAIN.'/?action=setup&option=email_templates');	
										}
									}
									
									//Load Template
									require(ADMINROOT.'/templates/default/header.template.php');	
									require(ADMINROOT.'/templates/default/setup/email/add_template.template.php');
									require(ADMINROOT.'/templates/default/footer.template.php');									
									break;	
								}
								default: {
									
									//Currencies SQL
									$SQL = "SELECT * FROM `".config::$db_prefix."email_templates`";
									
									//Get Total Clients
									$t_records = db::nRows($SQL);
									
									//Pagingate
									$paginate=new paginate($SQL);
																						
									//Query Customers
									$t_sql = db::query($paginate->returnSQL());
									
									//Client Delete
									if(lib::post('_submit')) {
										require(ADMINROOT.'/classes/email.class.php');
										$email= new email();
										$message = $email->updateHeaderFooter();
										if($message == '') {
											@header("Location:".ADMINDOMAIN.'/?action=setup&option=email_templates');	
										}
									}
									
									//Remember Me
									function rememberMe($field) {
										if(lib::post($field)) {
											return lib::post($field);
										} else {
											switch($field) {
												case 'email_footer': {
													return lib::getSetting('General_EmailFooter');
													break;
												}
												case 'email_header': {
													return lib::getSetting('General_EmailHeader');
													break;	
												}
											}
											
										}
									}
									
									//Load Template
									require(ADMINROOT.'/templates/default/header.template.php');	
									require(ADMINROOT.'/templates/default/setup/email/default.template.php');
									require(ADMINROOT.'/templates/default/footer.template.php');
									break;	
								}
							}
							break;
						}
						case 'staff': {
							switch(lib::get('do')) {
								case 'delete_user': {
									
									//Does the user exist?
									if(db::nRows("SELECT `user_id` FROM `".config::$db_prefix."staff` WHERE `user_id`='".lib::get('user_id',true)."'") < 1) {
										@header("Location:".ADMINDOMAIN.'/?action=setup&option=staff');	
									} else {
										$user = db::fetchQuery("SELECT * FROM `".config::$db_prefix."staff` WHERE `user_id`='".lib::get('user_id',true)."'");	
									}
									 
									//Delete User
									$auth= new auth();
									$message = $auth->deleteUser();
									
									//Load Template
									require(ADMINROOT.'/templates/default/header.template.php');	
									require(ADMINROOT.'/templates/default/setup/staff/delete_user.template.php');
									require(ADMINROOT.'/templates/default/footer.template.php');
									
									break;
								}
								case 'add_user': { 
								
									//Add User
									if(lib::post('_submit')) {
										$auth= new auth();
										$message = $auth->addUser();
										if($message == '') {
											@header("Location:".ADMINDOMAIN.'/?action=setup&option=staff');	
										}
									}
								
									//Load Template
									require(ADMINROOT.'/templates/default/header.template.php');	
									require(ADMINROOT.'/templates/default/setup/staff/add_user.template.php');
									require(ADMINROOT.'/templates/default/footer.template.php');
									break;
									 
								}
								case 'edit_user': {
									
									//Does the user exist?
									if(db::nRows("SELECT `user_id` FROM `".config::$db_prefix."staff` WHERE `user_id`='".lib::get('user_id',true)."'") < 1) {
										@header("Location:".ADMINDOMAIN.'/?action=setup&option=staff');	
									} else {
										$user = db::fetchQuery("SELECT * FROM `".config::$db_prefix."staff` WHERE `user_id`='".lib::get('user_id',true)."'");	
									}
									 
									//Edit User
									if(lib::post('_submit')) {
										$auth= new auth();
										$message = $auth->editUser();
										if($message == '') {
											@header("Location:".ADMINDOMAIN.'/?action=setup&option=staff');	
										}
									}
									
									//Remember Me
									function rememberMe($user, $field, $type, $expected = '') {
										switch($type) {
											case 'text': {
												if(lib::post($field)) {
													return lib::post($field,false,true,true);
												} else {
													return lib::san($user[$field],false,true,true);
												}
												break;	
											}
											case 'select': {
												if(lib::post($field) == $expected) {
													return 'selected';	
												} else {
													if($user[$field] == $expected) {
														return 'selected';	
													}
												}
												break;	
											}
										}
									}
								
									//Load Template
									require(ADMINROOT.'/templates/default/header.template.php');	
									require(ADMINROOT.'/templates/default/setup/staff/edit_user.template.php');
									require(ADMINROOT.'/templates/default/footer.template.php');
									break; 
								}
								case 'delete_group': { 
									
									//Does the group exist?
									if(db::nRows("SELECT `group_id` FROM `".config::$db_prefix."groups` WHERE `group_id`='".lib::get('group_id',true)."'") < 1) {
										@header("Location:".ADMINDOMAIN.'/?action=setup&option=staff');
									}
									
									//Edit User
									$auth= new auth();
									$message = $auth->deleteGroup(); 
									
									//Load Template
									require(ADMINROOT.'/templates/default/header.template.php');	
									require(ADMINROOT.'/templates/default/setup/staff/delete_group.template.php');
									require(ADMINROOT.'/templates/default/footer.template.php');
									break; 
								}
								case 'add_group': { 
									
									//Edit User
									if(lib::post('_submit')) {
										$auth= new auth();
										$message = $auth->addGroup();
										if($message == '') {
											@header("Location:".ADMINDOMAIN.'/?action=setup&option=staff');	
										}
									}
																											
									//Load Template
									require(ADMINROOT.'/templates/default/header.template.php');	
									require(ADMINROOT.'/templates/default/setup/staff/add_group.template.php');
									require(ADMINROOT.'/templates/default/footer.template.php');
									break; 
								}
								case 'edit_group': { 
									
									//Does the group exist?
									if(db::nRows("SELECT `group_id` FROM `".config::$db_prefix."groups` WHERE `group_id`='".lib::get('group_id',true)."'") < 1) {
										@header("Location:".ADMINDOMAIN.'/?action=setup&option=staff');
									} else {
										$group = db::fetchQuery("SELECT * FROM `".config::$db_prefix."groups` WHERE `group_id`='".lib::get('group_id',true)."'");
									}	
									
									//Remember Me
									function rememberMe($group, $field, $type) {
										switch($type) {
											case 'text': {
												if(lib::post($field)) {
													return lib::post($field,false,true,true);
												} else {
													return lib::san($group[$field],false,true,true);
												}
												break;	
											}
										}
									}
									
									//Edit User
									if(lib::post('_submit')) {
										$auth= new auth();
										$message = $auth->editGroup();
										if($message == '') {
											@header("Location:".ADMINDOMAIN.'/?action=setup&option=staff');	
										}
									}
									
									//Load Template
									require(ADMINROOT.'/templates/default/header.template.php');	
									require(ADMINROOT.'/templates/default/setup/staff/edit_group.template.php');
									require(ADMINROOT.'/templates/default/footer.template.php');
									break; 
								}	
								default: {
									
									//Currencies SQL
									$SQL = "SELECT * FROM `".config::$db_prefix."groups`";
									
									//Get Total Clients
									$g_records = db::nRows($SQL);
									
									//Pagingate
									$paginate=new paginate($SQL);
																						
									//Query Customers
									$g_sql = db::query($paginate->returnSQL());
																	
									//Load Template
									require(ADMINROOT.'/templates/default/header.template.php');	
									require(ADMINROOT.'/templates/default/setup/staff/default.template.php');
									require(ADMINROOT.'/templates/default/footer.template.php');
									break;	
								}
							}
							break;	
						}
						case 'system_settings': {
														
							$IPBanSQL2 = db::query("SELECT * FROM `".config::$db_prefix."ipban`");
							$IPBanSQL1 = db::query("SELECT `ip_address` FROM `".config::$db_prefix."ipban_whitelist`");
							
							//Load Template
							require(ADMINROOT.'/templates/default/header.template.php');	
							require(ADMINROOT.'/templates/default/setup/system_settings.template.php');
							require(ADMINROOT.'/templates/default/footer.template.php');
							break;	
						}
					}
					@header("Location:".ADMINDOMAIN);
					break;
				}
				default: {					
					//Load Template
					require(ADMINROOT.'/templates/default/header.template.php');	
					require(ADMINROOT.'/templates/default/default.template.php');
					require(ADMINROOT.'/templates/default/footer.template.php');		
					break;
				}
			}
			
		//NO SESSION
		} else {
									
			//Login Function
			if(lib::post('_submit')) {
				$auth= new auth();
				$message = $auth->login();
				if($message == '') {
					@header("Location:".ADMINDOMAIN);	
				}
			}
										
			//Load Template
			require(ADMINROOT.'/templates/default/login.template.php');
			
		}
		
	}	
}