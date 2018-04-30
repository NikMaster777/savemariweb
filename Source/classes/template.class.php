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
		
		
		/*************************************/
		// PAYMENTS API NOTIFICATIONS
		/*************************************/
		if(lib::get('payments-api')) {
			switch(lib::get('payments-api')) {
				case 1: {
					require(ROOT.'/classes/paypal/paypal.class.php');
					$paypal = new paypal();
					$paypal->paypalIPNR();
					break;	
				}
				case 2: {
					require(ROOT.'/classes/paynow/paynow.class.php');
					$paynow = new paynow;
					$paynow->paynowIPN();
					break;	
				}
			}
			die();
		}
		
		/*************************************/
		// IMAGE ENHANCEMENTS
		/*************************************/
		if(lib::get('image')) {
			switch(lib::get('image')) {
				case 'stores': {
					require(ROOT.'/classes/advert.class.php');
					switch(lib::get('size')) {
						case 'logo': {
							if(db::nRows("SELECT `store_logo` FROM `".config::$db_prefix."stores` WHERE `store_logo`='".lib::get('image_name',true)."'") > 0) {
								require(ROOT.'/classes/simpleimage.class.php');
								try {
									$image = new \claviska\SimpleImage();
									@$image->fromFile(ROOT.'/uploads/store_images/'.lib::get('image_name',true))->bestFit(75,75)->toScreen('image/jpg', 100);
								} catch(Exception $err) {
									echo $err->getMessage();	
								}
							}
							break; 
						}
					}
					break;
				}
				case 'adverts': {
					require(ROOT.'/classes/advert.class.php');	
					switch(lib::get('size')) {
						case 'fullsize': { //Advert Page Display Photo (Mini)
							if(db::nRows("SELECT `image_name` FROM `".config::$db_prefix."advertimages` WHERE `image_name`='".lib::get('image_name',true)."'") > 0) {
								require(ROOT.'/classes/simpleimage.class.php');
								try {
									$image = new \claviska\SimpleImage();
									@$image->fromFile(ROOT.'/uploads/advert_images/'.lib::get('image_name',true))->toScreen('image/jpg', 100);
								} catch(Exception $err) {
									echo $err->getMessage();	
								}
							} else {
								echo 'No image';	
							}
							break; 
						}
						case '300': { //Advert Page Display Photo (Mini)
							if(db::nRows("SELECT `image_name` FROM `".config::$db_prefix."advertimages` WHERE `image_name`='".lib::get('image_name',true)."'") > 0) {
								require(ROOT.'/classes/simpleimage.class.php');
								try {
									$cached_file = ROOT.'/cache/advert_images/300-'.lib::get('image_name');
									if(file_exists($cached_file)) {
										@header("Content-type: image/jpg");	
										@header('Content-Length: ' . filesize($cached_file));
										@readfile($cached_file);
									} else {
										$image = new \claviska\SimpleImage();
										@$image->fromFile(ROOT.'/uploads/advert_images/'.lib::get('image_name'))->resize(200,200)->toScreen('image/jpg', 100);
										@$image->fromFile(ROOT.'/uploads/advert_images/'.lib::get('image_name'))->resize(200,200)->toFile($cached_file, 'image/jpg', 100);
									}
								} catch(Exception $err) {
									echo $err->getMessage();	
								}
							} else {
								echo 'No image';	
							}
							break; 
						}
						case '100': { //Advert Page Display Photo (Mini)
							if(lib::get('image_name') != '') {
								if(db::nRows("SELECT `image_name` FROM `".config::$db_prefix."advertimages` WHERE `image_name`='".lib::get('image_name',true)."'") > 0) {
									require(ROOT.'/classes/simpleimage.class.php');
									try {
										if(@file_exists(ROOT.'/uploads/advert_images/'.lib::get('image_name',true))) {
											$image = new \claviska\SimpleImage();
											@$image->fromFile(ROOT.'/uploads/advert_images/'.lib::get('image_name',true))->resize(100)->toScreen('image/jpg', 100);
										} else {		
											$image = new \claviska\SimpleImage();
											@$image->fromFile('https://www.savemari.com/templates/default/images/75x75noimage.png')->resize(100)->toScreen('image/jpg', 100);
										}
									} catch(Exception $err) {
										echo $err->getMessage();	
									}
								} 
							} else {
								require(ROOT.'/classes/simpleimage.class.php');
								try {		
									$image = new \claviska\SimpleImage();
									@$image->fromFile('https://www.savemari.com/templates/default/images/75x75noimage.png')->resize(100)->toScreen('image/jpg', 100);
								} catch(Exception $err) {
									echo $err->getMessage();	
								}	
							}
							break; 
						}
						case '364': { //Advert Page Display Photo / Admin Control Panel
							if(db::nRows("SELECT `image_name` FROM `".config::$db_prefix."advertimages` WHERE `image_name`='".lib::get('image_name',true)."'") > 0) {
								require(ROOT.'/classes/simpleimage.class.php');
								try {
									$image = new \claviska\SimpleImage();
									@$image->fromFile(ROOT.'/uploads/advert_images/'.lib::get('image_name',true))->resize(364,400)->toScreen('image/jpg', 100);
								} catch(Exception $err) {
									echo $err->getMessage();	
								}
						  	} else {
								echo 'No image';	
							}
							break; 
						}
					}
					break;
				}
			}
			die();
		}
		
		/*************************************/
		// HEADER SEARCH
		/*************************************/
		if(lib::post('search')) {
			$city = lib::post('user_city');
			$query = lib::post('user_query');
			$cat = lib::post('user_cat');
			header("Location:".DOMAIN."/index.php?page=search&query=".urlencode($query)."&city=".urlencode($city)."&category=".$cat);						
			die();	
		}
				
		/*************************************/
		// VIEW ADVERTS - GLOBAL
		/*************************************/
		if(lib::get('advert')) {
						
			require(ROOT.'/classes/advert.class.php');
			require(ROOT.'/classes/stores.class.php');
			
			//Contact Form
			if(lib::get('contactseller')) {
				@header("Content-type: application/json");
				$advert=new advert;
				echo $advert->contactSeller();
				die();
			}
			
			//Contact Form
			if(lib::get('reportseller')) {
				@header("Content-type: application/json");
				$advert=new advert;
				echo $advert->reportSeller();
				die();
			}
			
			//A place to store errors
			$this->errorsArray = array();
			
			if(db::nRows("SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_id`='".lib::get('advert-id',true)."' AND `advert_seo_url`='".lib::get('advert',true)."'") > 0) {
															
				//Advert Data
				$advertData = db::fetchQuery("SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_id`='".lib::get('advert-id',true)."' AND `advert_seo_url`='".lib::get('advert',true)."'");
				
				//User Data
				$userData = db::fetchQuery("SELECT * FROM `".config::$db_prefix."clients` WHERE `user_id`='".$advertData['advert_userid']."'");
				
				//Load Category
				$category = db::fetchQuery("SELECT `cat_name` FROM `".config::$db_prefix."categories` WHERE `cat_id`='".$advertData['advert_id']."'");
				
				//Advert Store
				if($advertData['advert_store']) {
					$storeData = db::fetchQuery("SELECT * FROM `".config::$db_prefix."stores` WHERE `store_id`='".db::mss($advertData['advert_storeid'])."'");		
				}
				
				//Spawn Class
				$advert=new advert;
				
				//Spawn Store Class
				$stores=new stores;
				
				//Unique Views Stats
				$advert->uniqueViews($advertData['advert_id']);
				$advert->hitViews($advertData['advert_id']);
				
				//////////////////////////////////////////////////////////////////////
				// FEATURED ADS
				//////////////////////////////////////////////////////////////////////
				$fa_paginate=new paginate("SELECT * FROM `".config::$db_prefix."adverts` WHERE (`advert_store`='0' AND `advert_packid`='2' AND `advert_status`='1') AND (`advert_catid`='".$advertData['advert_catid']."' OR `advert_subcatid`='".$advertData['advert_subcatid']."')", 15);
				$fa_SQLQuery = db::query($fa_paginate->returnSQL());
				$fa_SQLRows = db::nRowsQuery($fa_SQLQuery);
				
				//////////////////////////////////////////////////////////////////////
				//Store Reviews
				//////////////////////////////////////////////////////////////////////
				if($advertData['advert_store']) {
					$re_paginate=new paginate("SELECT * FROM `".config::$db_prefix."reviews` WHERE `review_storeid`='".db::mss($advertData['advert_storeid'])."' ORDER BY RAND()", 25);
					$re_SQLQuery = db::query($re_paginate->returnSQL());
					@$re_SQLRows = db::nRowsQuery($re_SQLQuery);
				}
				
				//Guest or User
				if(session::active()) {
					//If the advert is active
					if($advertData['advert_status'] == 1) {
						require(ROOT.'/templates/default/header.template.php');
						require(ROOT.'/templates/default/advert.template.php');
						require(ROOT.'/templates/default/footer.template.php');
					} else {
						//If the user owns the advert, he can still see it.
						if(session::data('user_id') == $advertData['advert_userid']) {
							require(ROOT.'/templates/default/header.template.php');
							require(ROOT.'/templates/default/advert.template.php');
							require(ROOT.'/templates/default/footer.template.php');
						} else {
							header("Location:".DOMAIN);
							exit();	
						}
					}
				} else {
					//If the advert is active
					if($advertData['advert_status'] == 1) {
						require(ROOT.'/templates/default/header.template.php');
						require(ROOT.'/templates/default/advert.template.php');
						require(ROOT.'/templates/default/footer.template.php');
					//If not active, redirect.
					} else {
						header("Location:".DOMAIN);
						exit();	
					}
				}
			
			//If the advert is not found	
			} else {
				header("Location:".DOMAIN);
				exit();	
			}
			
			//Stop Script
			die();
		}
		
		/*************************************/
		// VIEW STORES - GLOBAL
		/*************************************/
		if(lib::get('stores')) {
			require(ROOT.'/classes/stores.class.php');
			
			//A place to store errors
			$this->errorsArray = array();
			
			if(db::nRows("SELECT * FROM `".config::$db_prefix."stores` WHERE `store_username`='".lib::get('stores',true)."' AND `store_activated`='1'") > 0) {
				
				//Advert Class
				require(ROOT.'/classes/advert.class.php');
													
				//Load Store
				$store = db::fetchQuery("SELECT * FROM `".config::$db_prefix."stores` WHERE `store_username`='".lib::get('stores',true)."' AND `store_activated`='1'");
								
				//User Data
				$userData = db::fetchQuery("SELECT * FROM `".config::$db_prefix."clients` WHERE `user_id`='".$store['store_userid']."'");
				
				//Store URL
				define('STORE_URL', DOMAIN.'/index.php?stores='.$store['store_username']);
								
				//Spawn Class
				$advert=new advert;
				
				//Page Switching
				switch(lib::get('page')) {
					case 'thankyou': {
						require(ROOT.'/templates/default/stores/header.template.php');
						require(ROOT.'/templates/default/stores/thankyou.template.php');
						require(ROOT.'/templates/default/stores/footer.template.php');
						break;	
					}
					case 'reviews': {
									
						//Paginate
						$paginate=new paginate("SELECT * FROM `".config::$db_prefix."reviews` WHERE `review_storeid`='".$store['store_id']."'", 25);
						$SQLQuery = db::query($paginate->returnSQL());
						@$SQLRows = db::nRowsQuery($SQLQuery);
						
						//Do we have a review code?
						if(lib::get('review_code',true)) {
							if(db::nRows("SELECT * FROM `".config::$db_prefix."reviewcodes` WHERE `code_value`='".lib::get('review_code',true)."' AND `code_storeid`='".$store['store_id']."'") > 0) {
								$review_allowed = true;	
							} else {
								$review_allowed = false;	
							}
						} else {
							$review_allowed = false;	
						}
						
						//Next Stage
						if(lib::post('_submit')) {
							$stores=new stores;
							$message = $stores->leaveReview($store);
							if(!$message) {
								@header("Location: ".STORE_URL);
								die();										
							}
						}
						
						require(ROOT.'/templates/default/stores/header.template.php');
						require(ROOT.'/templates/default/stores/reviews.template.php');
						require(ROOT.'/templates/default/stores/footer.template.php');
						break;	
					}
					case 'aboutus': {
						require(ROOT.'/templates/default/stores/header.template.php');
						require(ROOT.'/templates/default/stores/aboutus.template.php');
						require(ROOT.'/templates/default/stores/footer.template.php');
						break;	
					}
					case 'purchase': {
						switch(lib::get('stage')) {
							case 1: {
								
								//Next Stage
								if(lib::post('_stage-1-submit')) {
									$stores=new stores;
									$message = $stores->purchase_stage1($store);
									if(!$message) {
										die();										
									}
								}
								
								//Template
								require(ROOT.'/templates/default/stores/header.template.php');
								require(ROOT.'/templates/default/stores/buy/stage-1.template.php');
								require(ROOT.'/templates/default/stores/footer.template.php');
								break;	
							}
						}
						break;	
					}
					case 'products': {
						switch(lib::get('option')) {
							case 'view_product': {
								
								//Does the advert exist huh?
								if(db::nRows("SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_id`='".lib::get('product_id',true)."' AND `advert_store`='1'") > 0) {					
									
									//Advert Data
									$advertData = db::fetchQuery("SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_id`='".lib::get('product_id',true)."' AND `advert_store`='1'");
									
									//Unique Views Stats
									$advert->uniqueViews($advertData['advert_id']);
									$advert->hitViews($advertData['advert_id']);
									
									//Load Template
									require(ROOT.'/templates/default/stores/header.template.php');
									require(ROOT.'/templates/default/stores/products/view_product.template.php');
									require(ROOT.'/templates/default/stores/footer.template.php');
									
								} else { 
									@header("Location:".DOMAIN);
									die();
								}
								
								break;	
							}
							default: {
								
								//Filter
								if(lib::post('filter')) {
									
									//Do we have a cat?
									if(db::nRows("SELECT `cat_id` FROM `".config::$db_prefix."store_categories` WHERE `cat_id`='".lib::post('product_catid',true)."' AND `cat_storeid`='".$store['store_id']."'") > 0) {
										$SQLExtend = " AND `advert_store_catid`='".lib::post('product_catid',true)."'";	
									} else {
										$SQLExtend = '';	
									}
									
									$SQLFilter = "SELECT * FROM `".config::$db_prefix."adverts` WHERE 
									
									(`advert_store`='1' AND `advert_storeid`='".$store['store_id']."'".$SQLExtend.")
									
									AND 
									
									(`advert_title` LIKE '%".lib::post('search_query',true)."%' OR `advert_html` LIKE '%".lib::post('search_query',true)."%')";
									
																		
								} else {
									$SQLFilter = "SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_store`='1' AND `advert_storeid`='".$store['store_id']."'";
								}
								
								//Paginate
								$paginate=new paginate($SQLFilter, 12);
								$SQLQuery = db::query($paginate->returnSQL());
								$SQLRows = db::nRowsQuery($SQLQuery);
								
								require(ROOT.'/templates/default/stores/header.template.php');
								require(ROOT.'/templates/default/stores/products.template.php');
								require(ROOT.'/templates/default/stores/footer.template.php');
								break;
							}
						}
						break;
					}
					case 'contactus': {
						require(ROOT.'/templates/default/stores/header.template.php');
						require(ROOT.'/templates/default/stores/contactus.template.php');
						require(ROOT.'/templates/default/stores/footer.template.php');
						break;	
					}
					default: {
						require(ROOT.'/templates/default/stores/header.template.php');
						require(ROOT.'/templates/default/stores/default.template.php');
						require(ROOT.'/templates/default/stores/footer.template.php');
						break;	
					}
				}				
				
			}
			
			//Stop Script
			die();
		}
					
		/*************************************/
		// ACTIVE SESSION
		/*************************************/
		if(session::active()) {
			
			//@Main Menu
			//If we are loading the main menu
			switch(lib::get('page')) {
				case 'dashboard': {					
					switch(lib::get('view')) {
						case 'store': {
							require(ROOT.'/classes/stores.class.php');
							require(ROOT.'/classes/advert.class.php');
							switch(lib::get('action')) {
								case 'ajax': {
									@header("Content-type: application/json");
									switch(lib::get('request')) {
										case 'edit_deletecategory': {
											//Load Class
											$stores=new stores;
											echo $stores->edit_deletecategory();	
											break;
										}
										case 'edit_addcategory': {
											//Load Class
											$stores=new stores;
											echo $stores->edit_addcategory();	
											break;
										}
										case 'edit-product': {
											//Load Class
											$stores=new stores;
											echo $stores->EditProduct();	
											break;
										}	
										case 'add-product': {
											//Load Class
											$stores=new stores;
											echo $stores->AddProduct();	
											break;
										}										
										//Delete Custom Field
										case 'edit_deletecustomfield': {
											$stores=new stores;
											echo $stores->edit_DeleteCustomField();
											break;
										}
										//Edit Add Field
										case 'edit_addcustomfield': {
											$stores=new stores;
											echo $stores->edit_AddCustomField();
											break;
										}
										//Edit-Store Change Color
										case 'edit_changecolor': {
											$stores=new stores;
											echo $stores->edit_ChangeColors();
											break;
										}
										//Edit-Store Upload Logo
										case 'edit_uploadlogo': {
											$stores=new stores;
											echo $stores->edit_LogoUpload();
											break;
										}
										//Edit-Store Upload Banner
										case 'edit_uploadbanner': {
											$stores=new stores;
											echo $stores->edit_uploadBanner();
											break;
										}
										//Ajax Color Change
										case 'colorchange': {
											$stores=new stores;
											echo $stores->createStore_ChangeColor();
											break;
										}
										//Ajax Logo Upload
										case 'bannerupload': {
											$stores=new stores;
											echo $stores->createStore_BannerUpload();
											break;
										}
										//Ajax Logo Upload
										case 'bannerremove': {
											$stores=new stores;
											echo $stores->createStore_BannerRemove();
											break;
										}
										//Ajax Logo Upload
										case 'logoremove': {
											$stores=new stores;
											echo $stores->createStore_LogoRemove();
											break;
										}
										//Ajax Logo Upload
										case 'logoupload': {
											$stores=new stores;
											echo $stores->createStore_LogoUpload();
											break;
										}
										//Stage 1 - Form
										case 'stage-1-process': {
											//Load Class
											$stores=new stores;
											echo $stores->createStore_Stage1();	
											break;
										}							
									}
									break;
								}
								case 'success': {
									require(ROOT.'/templates/default/header.template.php');
									require(ROOT.'/templates/default/dashboard/stores/create_success.template.php');
									require(ROOT.'/templates/default/footer.template.php');	
									break;
								}
								case 'manage': {
									if(db::nRows("SELECT `store_id` FROM `".config::$db_prefix."stores` WHERE `store_userid`='".session::data('user_id')."' AND `store_activated`='1'") > 0) {
										
										//Load Advert Class
										$advert=new advert;
										
										//Load Store
										$store = db::fetchQuery("SELECT * FROM `".config::$db_prefix."stores` WHERE `store_userid`='".session::data('user_id')."'");
										
										//Reset Store Session
										unset($_SESSION[config::$db_prefix.'store']);
										@$_SESSION[config::$db_prefix.'store'] = array();
												
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
										
										//Delete Banners
										if(lib::post('_deletebanner')) {
											$stores=new stores;
											$message = $stores->edit_deleteBanners();
											if(!$message) { $success=true; }	
										}
										
										//Redeem Voucher
										if(lib::post('_redeem-voucher')) {
											$stores=new stores;
											$message = $stores->redeemVoucher();
											if(!$message) { $success=true; }
										}
										
										//Manage Products
										switch(lib::get('option')) {
											case 'manage-products': {
												
												//Reset Advert Session (For Images)
												unset($_SESSION[config::$db_prefix.'advert']);
												$_SESSION[config::$db_prefix.'advert'] = array();
												
												switch(lib::get('do')) {
													//Edit Product
													case 'edit_product': {
														//Does the product exist?
														if(db::nRows("SELECT `advert_id` FROM `".config::$db_prefix."adverts` WHERE 
															`advert_id`='".lib::get('product_id',true)."' AND `advert_userid`='".session::data('user_id')."'") > 0) {
															$prodData = db::fetchQuery("SELECT * FROM `".config::$db_prefix."adverts` WHERE 
															`advert_id`='".lib::get('product_id',true)."' AND `advert_userid`='".session::data('user_id')."'");
														} else {
															header("Location:".DOMAIN);
															exit();	
														}
														break;	
													}
													//List Products (Default)
													default: {
														//Paginate
														switch(lib::get('filter')) {
															case 'sold_products': {
																$paginate=new paginate("SELECT * FROM `".config::$db_prefix."adverts` WHERE 
																`advert_store`='1' AND `advert_userid`='".session::data('user_id')."' AND `advert_store_sold`='1'", 15);
																break;	
															}
															default: {
																$paginate=new paginate("SELECT * FROM `".config::$db_prefix."adverts` WHERE 
																`advert_store`='1' AND `advert_userid`='".session::data('user_id')."'", 15);
															break;	
															}
														}
														
														$SQLQuery = db::query($paginate->returnSQL());
														$SQLRows = db::nRowsQuery($SQLQuery);	
													}
												}
												break;
											}
										}
																													
										//Load Template
										require(ROOT.'/templates/default/header.template.php');
										require(ROOT.'/templates/default/dashboard/stores/manage_store.template.php');
										require(ROOT.'/templates/default/footer.template.php');
									} else {
										header("Location:".DOMAIN);
										exit();	
									}
									break;									
								}
								case 'create': {
									
									//Stage-4-Submit
									if(lib::post('_stage-4-submit')) {
										$stores=new stores;
										echo $stores->createStore_Stage4();
										die();
									} else {
																		
										//Reset Store Session
										unset($_SESSION[config::$db_prefix.'store']);
										@$_SESSION[config::$db_prefix.'store'] = array();
									
										//Set Store Colors
										@$_SESSION[config::$db_prefix.'store']['store-colors'] = array('item-background-active' => 'e7e7e7',
										'menu-color' => 'f8f8f8','item-font-color-active' => '555','item-font-color-normal' => '777');
																								  
									}
																							
									//Load Template
									require(ROOT.'/templates/default/header.template.php');
									require(ROOT.'/templates/default/dashboard/stores/create_store.template.php');
									require(ROOT.'/templates/default/footer.template.php');
									
									break;	
								}
							}
							break;
						}
						case 'adverts': {
							require(ROOT.'/classes/advert.class.php');
							switch(lib::get('action')) {
								case 'ajax': {
									@header("Content-type: application/json");
									switch(lib::get('request')) {
										//Ajax Image Upload
										case 'imageupload': {
											$advert=new advert;
											echo $advert->createAdvert_ImageUpload();
											break;
										}
										//Ajax Image Remove
										case 'imageremove': {
											$advert=new advert;
											echo $advert->createAdvert_ImageRemove();
											break;
										}
										//Stage 2 Validation
										case 'stage-2-process': {
											//Load Class
											$advert=new advert;
											echo $advert->createAvert_Stage2();	
											break;
										}
										//Stage 1 Validation
										case 'stage-1-process': {
											//Load Class
											$advert=new advert;
											echo $advert->createAvert_Stage1();	
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
								case 'success': {
									require(ROOT.'/templates/default/header.template.php');
									require(ROOT.'/templates/default/dashboard/adverts/create_success.template.php');
									require(ROOT.'/templates/default/footer.template.php');	
									break;
								}
								case 'edit': {
									
									//Reset Advert Session
									unset($_SESSION[config::$db_prefix.'advert']);
									$_SESSION[config::$db_prefix.'advert'] = array();
									
									//A place to store errors
									$this->errorsArray = array();
																		
									//Does the advert exist?
									if(db::nRows("SELECT `advert_id` FROM `".config::$db_prefix."adverts` WHERE (`advert_id`='".lib::get('advert-id',true)."' AND 
									`advert_userid`='".session::data('user_id')."' AND `advert_store`='0')") < 1) {
										$this->errorsArray[] = 'That advert either does not exist or you don\'t own it!';
									}
																		
									//Do we have any issues?
									if(count($this->errorsArray)) {
										header("Location:".DOMAIN);
										exit();
									} else {
										
										//Advert Data
										$advertData = db::fetchQuery("SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_id`='".lib::get('advert-id',true)."' AND 
																															    `advert_userid`='".session::data('user_id')."'");																				
										//Load Template
										require(ROOT.'/templates/default/header.template.php');
										require(ROOT.'/templates/default/dashboard/adverts/edit_advert.template.php');
										require(ROOT.'/templates/default/footer.template.php');	
										
									}
									
									break;
								}
								case 'create': {
									
									//Lets do our bit here!
									if(lib::post('_stage3_submit')) {
										$advert=new advert;
										echo $advert->createAdvert_Stage3();
										die();
									}
									
									//Reset Advert Session
									unset($_SESSION[config::$db_prefix.'advert']);
									$_SESSION[config::$db_prefix.'advert'] = array();
																								
									//Load Template
									require(ROOT.'/templates/default/header.template.php');
									require(ROOT.'/templates/default/dashboard/adverts/create_advert.template.php');
									require(ROOT.'/templates/default/footer.template.php');	
									break;
								}
							}
							break;
						}
						default: {
							
							//Do we have a store
							if(db::nRows("SELECT `store_id` FROM `".config::$db_prefix."stores` WHERE `store_userid`='".session::data('user_id')."' AND `store_activated`='1'") > 0) {
								$storeData = db::fetchQuery("SELECT * FROM `".config::$db_prefix."stores` WHERE `store_userid`='".session::data('user_id')."' AND `store_activated`='1'");
								$store = true;
							} else {
								$store = false;
							}
								
							//@Which page are we viewing?
							switch(lib::get('option')) {
								//Edit Profile
								case 'edit-profile': { 
									if(lib::post('_submit')) {
										$users=new users;
										$message = $users->editprofile();	
										if(!$message) {
											$success=true;	
										}
									}
									//Remember Me
									function rememberMe($fieldname,$html) {
										if(lib::post($fieldname)) {
											if($html) {
												return lib::post($fieldname,false,true,true);
											} else {
												return lib::post($fieldname);
											}
										} else {
											if($html) {
												return session::data($fieldname,false,true,true);
											} else {
												return session::data($fieldname);	
											}
										}
									}
									break; 
								}
								//Change Password
								case 'change-password': { 
									if(lib::post('_submit')) {
										$users=new users;
										$message = $users->changepassword();	
										if(!$message) {
											$success=true;
										}
									}
									break; 
								}
								//Sponsored Ads
								case 'sponsered-listings': { 
								
									//Class
									require(ROOT.'/classes/advert.class.php');
								
									//Paginate
									$paginate=new paginate("SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_userid`='".session::data('user_id')."' AND `advert_store`='0' AND `advert_packid`='1'", 15);
									$SQLQuery = db::query($paginate->returnSQL());
									$SQLRows = db::nRowsQuery($SQLQuery);
									
									//Spawn Advert Class
									$advert=new advert;																	
									break; 
								}
								//Featured-Listings
								case 'featured-listings': { 
									
									//Class
									require(ROOT.'/classes/advert.class.php');
								
									//Paginate
									$paginate=new paginate("SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_userid`='".session::data('user_id')."' AND `advert_store`='0' AND `advert_packid`='2'", 15);
									$SQLQuery = db::query($paginate->returnSQL());
									$SQLRows = db::nRowsQuery($SQLQuery);
									
									//Spawn Advert Class
									$advert=new advert;																	
									break; 
								}
								//All Selling
								default: {
									
									//Class
									require(ROOT.'/classes/advert.class.php');
									
									//Paginate
									$paginate=new paginate("SELECT * FROM `".config::$db_prefix."adverts` WHERE (`advert_userid`='".session::data('user_id')."' AND `advert_store`='0')", 15);
									$SQLQuery = db::query($paginate->returnSQL());
									$SQLRows = db::nRowsQuery($SQLQuery);
									
									//Spawn Advert Class
									$advert=new advert;																	
									break;	
								}
							}
							
							//Load Template
							require(ROOT.'/templates/default/header.template.php');	
							require(ROOT.'/templates/default/dashboard/default.template.php');	
							require(ROOT.'/templates/default/footer.template.php');	
							break;
						}
					}
					break;
				}
				case 'search': {
					//Class
					require(ROOT.'/classes/advert.class.php');
					
					//Complete Query
					$SQLQuery = "SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_status`='1'";
					
					//City/Town Filter
					if(lib::get('city')) {
						$city = urldecode(lib::get('city'));
						if(db::nRows("SELECT * FROM `".config::$db_prefix."cities` WHERE `city_id`='".db::mss($city)."'") > 0) {
							$SQLQuery .= " AND (`advert_cityid`='".db::mss($city)."')";
						}
					}
					
					//Category Filter
					if(lib::get('category')) {
						$cat_id = urldecode(lib::get('category'));
						if(db::nRows("SELECT * FROM `".config::$db_prefix."categories` WHERE `cat_id`='".db::mss($cat_id)."'") > 0) {
							$SQLQuery .= " AND `advert_catid`='".db::mss($cat_id)."'";	
						}
						//Sub Category Filter
						if(lib::get('subcat')) {
							$subcat_id = urldecode(lib::get('subcat'));
							if(db::nRows("SELECT * FROM `".config::$db_prefix."categories` WHERE `cat_id`='".db::mss($subcat_id)."' AND `cat_parentid`='".db::mss($cat_id)."'") > 0) {
								$SQLQuery .= " AND `advert_subcatid`='".db::mss($subcat_id)."'";	
							}
						}
					}
					
					//Query Filter
					if(lib::get('query')) {
						$query = urldecode(lib::get('query'));
						$SQLQuery .= " AND (`advert_title` LIKE '%".db::mss($query)."%' OR `advert_html` LIKE '%".db::mss($query)."%')";
					}
					
					//Order by Sponsered Ads
					$SQLQuery .= "  AND `advert_packid`='3' ORDER BY `advert_datetime` DESC"; // DESC, 
					
					$paginate=new paginate($SQLQuery, 15);
					$SQLQuery = db::query($paginate->returnSQL());
					$SQLRows = db::nRowsQuery($SQLQuery);				
					
					//Spawn Advert Class
					$advert=new advert;
					
					//Load Template
					require(ROOT.'/templates/default/header.template.php');	
					require(ROOT.'/templates/default/search.template.php');	
					require(ROOT.'/templates/default/footer.template.php');
					
					break;
				}
				default: {	
				
					//Class
					require(ROOT.'/classes/advert.class.php');
					
					//Banners
					require(ROOT.'/classes/banners.class.php');
					
					//Spawn Banners
					$banners=new banners();
					
					//////////////////////////////////////////////////////////////////////
					// FEATURED ADS
					//////////////////////////////////////////////////////////////////////
					$fa_paginate=new paginate("SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_packid`='2'", 25);
					$fa_SQLQuery = db::query($fa_paginate->returnSQL());
					$fa_SQLRows = db::nRowsQuery($fa_SQLQuery);
					
					//////////////////////////////////////////////////////////////////////
					// MORE LISTINGS
					//////////////////////////////////////////////////////////////////////
					switch(lib::get('filter')) {
						case 'justlisted': {
							$ml_paginate=new paginate("SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_status`='1' ORDER BY `advert_id` DESC, RAND()", 8);
							break;	
						}
						case 'clickandcollect': {
							$ml_paginate=new paginate("SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_store`='1' AND `advert_status`='1' ORDER BY `advert_hits`, RAND()", 8);
							break;	
						}
						case 'popularitems': {
							$ml_paginate=new paginate("SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_store`='0' AND `advert_status`='1' ORDER BY `advert_hits`, RAND()", 8);
							break;		
						}
						case 'topsellers': {
							$ml_paginate=new paginate("SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_store`='1' AND `advert_status`='1' ORDER BY `advert_hits`, RAND()", 8);
							break;	
						}
						default: {
							$ml_paginate=new paginate("SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_status`='1' ORDER BY `advert_id` DESC, RAND()", 8);
							break;	
						}
					}
					
					$ml_SQLQuery = db::query($ml_paginate->returnSQL());
					$ml_SQLRows = db::nRowsQuery($ml_SQLQuery);
					
					//////////////////////////////////////////////////////////////////////
					// CLICK AND COLLECT
					//////////////////////////////////////////////////////////////////////
					$storeIDs = array();
					
					//Find all stores with products.
					$storeSQL = db::query("SELECT * FROM `".config::$db_prefix."stores` WHERE `store_activated`='1' ORDER BY RAND() LIMIT 154");
														
					//Spawn Advert Class
					$advert=new advert;
							
					//Load Template
					require(ROOT.'/templates/default/header.template.php');	
					require(ROOT.'/templates/default/default.template.php');	
					require(ROOT.'/templates/default/footer.template.php');	
					break;
				}
				case 'contactus': {
					//Load Template
					require(ROOT.'/templates/default/header.template.php');	
					require(ROOT.'/templates/default/contactus.template.php');	
					require(ROOT.'/templates/default/footer.template.php');	
					break;
				}
				case 'aboutus': {
					//Load Template
					require(ROOT.'/templates/default/header.template.php');	
					require(ROOT.'/templates/default/aboutus.template.php');	
					require(ROOT.'/templates/default/footer.template.php');	
					break;
				}
				case 'needhelp': {
					switch(lib::get('view')) {
						case 'postingadverts': {
							//Load Template
							require(ROOT.'/templates/default/header.template.php');	
							require(ROOT.'/templates/default/needhelp/postingadverts.template.php');	
							require(ROOT.'/templates/default/footer.template.php');
							break;	
						}
						case 'clickandcollect': {
							//Load Template
							require(ROOT.'/templates/default/header.template.php');	
							require(ROOT.'/templates/default/needhelp/clickandcollect.template.php');	
							require(ROOT.'/templates/default/footer.template.php');
							break;	
						}
						default: {
							//Load Template
							require(ROOT.'/templates/default/header.template.php');	
							require(ROOT.'/templates/default/needhelp/faq.template.php');	
							require(ROOT.'/templates/default/footer.template.php');
						}
						break;
					}
					break;
				}
				case 'services': {
					
					switch(lib::get('view')) {
						case 'buyandsell': {
							//Load Template
							require(ROOT.'/templates/default/header.template.php');	
							require(ROOT.'/templates/default/services/buyandsell.template.php');	
							require(ROOT.'/templates/default/footer.template.php');
							break;	
						}
						case 'onlinestores': {
							//Load Template
							require(ROOT.'/templates/default/header.template.php');	
							require(ROOT.'/templates/default/services/onlinestores.template.php');	
							require(ROOT.'/templates/default/footer.template.php');
							break;	
						}
						case 'clickandcollect': {
							//Load Template
							require(ROOT.'/templates/default/header.template.php');	
							require(ROOT.'/templates/default/services/clickandcollect.template.php');	
							require(ROOT.'/templates/default/footer.template.php');
							break;	
						}
						case 'customerbenefits': {
							//Load Template
							require(ROOT.'/templates/default/header.template.php');	
							require(ROOT.'/templates/default/services/customerbenefits.template.php');	
							require(ROOT.'/templates/default/footer.template.php');
							break;	
						}
						case 'sponsoredandfeaturedadverts': {
							//Load Template
							require(ROOT.'/templates/default/header.template.php');	
							require(ROOT.'/templates/default/services/sponsoredandfeaturedadverts.template.php');	
							require(ROOT.'/templates/default/footer.template.php');
							break;	
						}
						case 'banneradverts': {
							//Load Template
							require(ROOT.'/templates/default/header.template.php');	
							require(ROOT.'/templates/default/services/banneradverts.template.php');	
							require(ROOT.'/templates/default/footer.template.php');
							break;	
						}
						default: {
							//Load Template
							require(ROOT.'/templates/default/header.template.php');	
							require(ROOT.'/templates/default/services.template.php');	
							require(ROOT.'/templates/default/footer.template.php');
							break;
						}
					}
					break;
				}
				case 'logout': {
					session::kill();
					header("Location:".DOMAIN);
					die();	
				}
			}
			
		/*************************************/
		// NO SESSION
		/*************************************/
		} else {
			
			//@Main Menu
			//If we are loading the main menu
			switch(lib::get('page')) {
				case 'services': {
					
					switch(lib::get('view')) {
						case 'buyandsell': {
							//Load Template
							require(ROOT.'/templates/default/header.template.php');	
							require(ROOT.'/templates/default/services/buyandsell.template.php');	
							require(ROOT.'/templates/default/footer.template.php');
							break;	
						}
						case 'onlinestores': {
							//Load Template
							require(ROOT.'/templates/default/header.template.php');	
							require(ROOT.'/templates/default/services/onlinestores.template.php');	
							require(ROOT.'/templates/default/footer.template.php');
							break;	
						}
						case 'clickandcollect': {
							//Load Template
							require(ROOT.'/templates/default/header.template.php');	
							require(ROOT.'/templates/default/services/clickandcollect.template.php');	
							require(ROOT.'/templates/default/footer.template.php');
							break;	
						}
						case 'customerbenefits': {
							//Load Template
							require(ROOT.'/templates/default/header.template.php');	
							require(ROOT.'/templates/default/services/customerbenefits.template.php');	
							require(ROOT.'/templates/default/footer.template.php');
							break;	
						}
						case 'sponsoredandfeaturedadverts': {
							//Load Template
							require(ROOT.'/templates/default/header.template.php');	
							require(ROOT.'/templates/default/services/sponsoredandfeaturedadverts.template.php');	
							require(ROOT.'/templates/default/footer.template.php');
							break;	
						}
						case 'banneradverts': {
							//Load Template
							require(ROOT.'/templates/default/header.template.php');	
							require(ROOT.'/templates/default/services/banneradverts.template.php');	
							require(ROOT.'/templates/default/footer.template.php');
							break;	
						}
						default: {
							//Load Template
							require(ROOT.'/templates/default/header.template.php');	
							require(ROOT.'/templates/default/services.template.php');	
							require(ROOT.'/templates/default/footer.template.php');
							break;
						}
					}
					break;
				}
				case 'needhelp': {
					switch(lib::get('view')) {
						case 'postingadverts': {
							//Load Template
							require(ROOT.'/templates/default/header.template.php');	
							require(ROOT.'/templates/default/needhelp/postingadverts.template.php');	
							require(ROOT.'/templates/default/footer.template.php');
							break;	
						}
						case 'clickandcollect': {
							//Load Template
							require(ROOT.'/templates/default/header.template.php');	
							require(ROOT.'/templates/default/needhelp/clickandcollect.template.php');	
							require(ROOT.'/templates/default/footer.template.php');
							break;	
						}
						default: {
							//Load Template
							require(ROOT.'/templates/default/header.template.php');	
							require(ROOT.'/templates/default/needhelp/faq.template.php');	
							require(ROOT.'/templates/default/footer.template.php');
						}
						break;
					}
					break;
				}
				case 'contactus': {
					//Load Template
					require(ROOT.'/templates/default/header.template.php');	
					require(ROOT.'/templates/default/contactus.template.php');	
					require(ROOT.'/templates/default/footer.template.php');	
					break;
				}
				case 'aboutus': {
					//Load Template
					require(ROOT.'/templates/default/header.template.php');	
					require(ROOT.'/templates/default/aboutus.template.php');	
					require(ROOT.'/templates/default/footer.template.php');	
					break;
				}
				case 'search': {
					//Class
					require(ROOT.'/classes/advert.class.php');
					
					//Complete Query
					$SQLQuery = "SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_status`='1'";
					
					//City/Town Filter
					if(lib::get('city')) {
						$city = urldecode(lib::get('city'));
						if(db::nRows("SELECT * FROM `".config::$db_prefix."cities` WHERE `city_id`='".db::mss($city)."'") > 0) {
							$SQLQuery .= " AND (`advert_cityid`='".db::mss($city)."')";
						}
					}
					
					//Category Filter
					if(lib::get('category')) {
						$cat_id = urldecode(lib::get('category'));
						if(db::nRows("SELECT * FROM `".config::$db_prefix."categories` WHERE `cat_id`='".db::mss($cat_id)."'") > 0) {
							$SQLQuery .= " AND `advert_catid`='".db::mss($cat_id)."'";	
						}
						//Sub Category Filter
						if(lib::get('subcat')) {
							$subcat_id = urldecode(lib::get('subcat'));
							if(db::nRows("SELECT * FROM `".config::$db_prefix."categories` WHERE `cat_id`='".db::mss($subcat_id)."' AND `cat_parentid`='".db::mss($cat_id)."'") > 0) {
								$SQLQuery .= " AND `advert_subcatid`='".db::mss($subcat_id)."'";	
							}
						}
					}
					
					//Query Filter
					if(lib::get('query')) {
						$query = urldecode(lib::get('query'));
						$SQLQuery .= " AND (`advert_title` LIKE '%".db::mss($query)."%' OR `advert_html` LIKE '%".db::mss($query)."%')";
					}
					
					//Order by Sponsered Ads
					$SQLQuery .= "  AND `advert_packid`='3' ORDER BY `advert_datetime` DESC"; // DESC, 
					
					$paginate=new paginate($SQLQuery, 15);
					$SQLQuery = db::query($paginate->returnSQL());
					$SQLRows = db::nRowsQuery($SQLQuery);				
					
					//Spawn Advert Class
					$advert=new advert;
					
					//Load Template
					require(ROOT.'/templates/default/header.template.php');	
					require(ROOT.'/templates/default/search.template.php');	
					require(ROOT.'/templates/default/footer.template.php');
					
					break;						
				}
				case 'forgotpassword': {
					//If we are attempting to reset the password.
					if(lib::post('_resetpassword')) {
						$auth=new auth;
						$message = $auth->forgot();	
						if(!$message) {
							@header("Location:".DOMAIN.'/index.php?page=forgotpassword&confirm=confirm-email');
							exit();	
						}
					}
					
					//If we are attempting to reset the password.
					if(lib::post('_changepassword')) {
						$auth=new auth;
						$message = $auth->forgot_changepassword();	
						if(!$message) {
							@header("Location:".DOMAIN.'/index.php?page=forgotpassword&confirm=password-changed');
							exit();	
						}
					}
										
					//Load Template
					require(ROOT.'/templates/default/header.template.php');	
					require(ROOT.'/templates/default/forgot.template.php');	
					require(ROOT.'/templates/default/footer.template.php');	
					break;
				}
				case 'login': {
					//Submitting?
					if(lib::post('_submit')) {
						$auth=new auth;
						$message = $auth->login();	
						if(!$message) {
							@header("Location:".DOMAIN);
							exit();	
						}
					}
					
					//Load Template
					require(ROOT.'/templates/default/header.template.php');	
					require(ROOT.'/templates/default/login.template.php');	
					require(ROOT.'/templates/default/footer.template.php');	
					break;
				}
				case 'activation': {
					//Activating Account
					$auth=new auth;
					$message = $auth->activate();	
					
					//Load Template
					require(ROOT.'/templates/default/header.template.php');	
					require(ROOT.'/templates/default/activation.template.php');	
					require(ROOT.'/templates/default/footer.template.php');	
					break;
				}
				case 'register': {
					//Submitting?
					if(lib::post('_submit')) {
						$auth=new auth;
						$message = $auth->register();	
						if(!$message) {
							@header("Location:".DOMAIN.'/index.php?page=register&confirm=activation-required');
							exit();	
						}
					}
					
					//Load Template
					require(ROOT.'/templates/default/header.template.php');	
					require(ROOT.'/templates/default/register.template.php');	
					require(ROOT.'/templates/default/footer.template.php');	
					break;		
				}
				default: {
					
					//Class
					require(ROOT.'/classes/advert.class.php');
					
					//Banners
					require(ROOT.'/classes/banners.class.php');
					
					//Spawn Banners
					$banners=new banners();
					
					//////////////////////////////////////////////////////////////////////
					// FEATURED ADS
					//////////////////////////////////////////////////////////////////////
					$fa_paginate=new paginate("SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_packid`='2'", 25);
					$fa_SQLQuery = db::query($fa_paginate->returnSQL());
					$fa_SQLRows = db::nRowsQuery($fa_SQLQuery);
					
					//////////////////////////////////////////////////////////////////////
					// MORE LISTINGS
					//////////////////////////////////////////////////////////////////////
					switch(lib::get('filter')) {
						case 'justlisted': {
							$ml_paginate=new paginate("SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_status`='1' ORDER BY `advert_id` DESC, RAND()", 8);
							break;	
						}
						case 'clickandcollect': {
							$ml_paginate=new paginate("SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_store`='1' AND `advert_status`='1' ORDER BY `advert_hits`, RAND()", 8);
							break;	
						}
						case 'popularitems': {
							$ml_paginate=new paginate("SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_status`='1' ORDER BY `advert_hits`, RAND()", 8);
							break;		
						}
						case 'topsellers': {
							$ml_paginate=new paginate("SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_store`='1' AND `advert_status`='1' ORDER BY `advert_hits`, RAND()", 8);
							break;	
						}
						default: {
							$ml_paginate=new paginate("SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_status`='1' ORDER BY `advert_id` DESC, RAND()", 8);
							break;	
						}
					}
					
					$ml_SQLQuery = db::query($ml_paginate->returnSQL());
					$ml_SQLRows = db::nRowsQuery($ml_SQLQuery);
					
					//////////////////////////////////////////////////////////////////////
					// CLICK AND COLLECT
					//////////////////////////////////////////////////////////////////////
					$storeIDs = array();
					
					//Find all stores with products.
					$storeSQL = db::query("SELECT * FROM `".config::$db_prefix."stores` WHERE `store_activated`='1' ORDER BY RAND() LIMIT 154");
														
					//Spawn Advert Class
					$advert=new advert;
							
					//Load Template
					require(ROOT.'/templates/default/header.template.php');	
					require(ROOT.'/templates/default/default.template.php');	
					require(ROOT.'/templates/default/footer.template.php');	
					break;
				}
			}
			
		}
		
	}	
}