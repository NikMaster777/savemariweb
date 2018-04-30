<?php
/*
Plugin Name: Citify Ultimate
Plugin URI: http://themebound.com/
Description: Browse your ClassiPress website by cities.
Version: 1.5.9
Author: Themebound
Author URI: http://themebound.com/
*/
@session_start();
global $cu_city;
if($_COOKIE['cu_city']) {
	$cu_city = $_COOKIE['cu_city'];
}
cu_set_city();

include_once('plugged.php');
include_once('widget.php');

register_activation_hook(__FILE__,'cu_initiate_options');

function cu_initiate_options() {
	add_option('cu_auto_popup', 1);
	add_option('cu_selector_popup_title', __('Please Select Your City'));
	add_option('cu_selector_popup_message', __('Closing the popup will show you listings from everywhere.'));
	add_option('cu_menu_label', __('Select City'));
	add_option('cu_city_list', __('New York,Los Angeles,Chicago,Houston,Philadelphia,Phoenix,Dallas'));
}

add_action('init','cu_statify_init');
function cu_statify_init() {
	
	global $cu_city;
	if(isset($_GET['s'])) {
		$_GET['cp_city'] = $cu_city;
		$_GET['refine_search'] = 'yes';
	}
	add_action('admin_menu', 'cu_menu');
}

function cu_menu() {
	add_submenu_page('app-dashboard', __('Citify Ultimate Options', APP_TD), __('CU Plugin Options', APP_TD), 'manage_options', 'citify-ultimate', 'cu_admin_page_callback');
}

function cu_admin_page_callback()
{
	include_once('citify-ultimate-settings.php');
}


function cu_enqueue_style() {
	wp_enqueue_style('cu-css', plugin_dir_url(__FILE__).'/style.css');
}
add_action('init','cu_enqueue_style');


function cu_pre_get_posts( $query ) {
	global $wpdb, $cu_city;
	
	$post_types=get_post_types(''); 
	
	//$count = 0;
	unset($post_types['ad_listing']);
	
	$is_other_block = 0;
	if( $query->get( 'post_type' ) && is_array( $query->get('post_type') ) ) {
		$is_other_block = 1;
	} 
	if( isset( $query->query['connected_type'] ) ) {
		$is_other_block = 1;
	} 

	
	if(!$cu_city || is_home() || is_admin() || $query->is_attachment == 1 || $query->is_singular == 1 || $is_other_block || in_array($query->query['post_type'], $post_types) || $query->is_category == 1 || $query->is_tag == 1 || $query->is_author == 1) return $query;
	
	$meta_query = $query->get('meta_query');
	
	//if ( $query->is_archive && isset( $query->query_vars['ad_cat'] ) ) {
	
	$meta_query[] = array(
		'key'   => 'cp_city',
		'value' => $cu_city,
		'compare' => '='
	);
	$query->set( 'meta_query', $meta_query );
	
	
	return $query;
}
add_filter( 'pre_get_posts', 'cu_pre_get_posts', 20 );

function cu_show_city_menu() {
	global $cu_city;
	$current_url_array = cu_get_current_url_array();
	if(!empty($cu_city)) {
		$_SESSION['cu_popup_alert'] = 1;
	}
	?>
	<ul id="city_nav" class="city_nav menu">
		<li class="mega"><?php echo ($cu_city ? '<a class="city_highlight" href="#"><strong>'.$cu_city.'</strong></a>' : '<a href="#">'.stripslashes(get_option('cu_menu_label')).'</a>'); ?></a>
			<div class="adv_cities" id="adv_cities">
			<?php cu_get_city_links(); ?>

			</div><!-- /adv_cities -->
		</li>
	</ul>
	<?php if(get_option('cu_auto_popup') && (is_home() || is_front_page()) && empty($cu_city)) {
			wp_enqueue_script('jquery-colorbox', plugin_dir_url(__FILE__).'/colorbox/jquery.colorbox.js', array('jquery'), '1.8.1');
			wp_enqueue_style('jquery-colorbox-css', plugin_dir_url(__FILE__).'/colorbox/colorbox.css');
	?>
		<a id="cu_popup_trigger" href="#cu_popup" class="obtn btn_orange"><?php echo stripslashes(get_option(''));?> </a>
		<div style="display: none;">
			<div id="cu_popup">

				<div class="clr"></div>
				<form method="post" action="#" class="form_contact" id="cu_popup_form" name="cu_popup_form">

					<h2 class="dotted"><?php echo stripslashes(get_option('cu_selector_popup_title'));?></h2>
					<p><strong><?php echo stripslashes(get_option('cu_selector_popup_message'));?></strong></p>
					<ol>
						<li>
							<?php cu_get_city_dropdown(); ?>
							<div class="clr"></div>
						</li>
					</ol>
					<div class="clr"></div>
				
				
				</form>
			</div>
		</div>
	<?php } ?>
	
	<script type="text/javascript">
		
		jQuery(document).ready(function() {		
			if(jQuery(window).width() > 940) {
				sfHover = function() {
				  var linksReady = '';
				  var sfEls = '';
				  linksReady = document.getElementById("#city_nav");
				  if (linksReady) {
					sfEld = document.getElementById("##city_nav").getElementsByTagName("li.page_item");
					if (sfEls) {
					  for (var i=0; i<sfEls.length; i++) {
						sfEls[i].onmouseover=function() {
						  this.className+=" sfhover";
						}
						sfEls[i].onmouseout=function() {
						  this.className=this.className.replace(new RegExp(" sfhover\\b"), "");
						}
					  }
					}
				  }
				}
				if (window.attachEvent) window.attachEvent("onload", sfHover);
			} else {
				jQuery('#city_nav').removeClass('menu');
				jQuery('#city_nav li.mega').hover(function() {
					return false;
				});
				jQuery('#city_nav li.mega>a').click(function() {
					jQuery('#city_nav li.mega ul').slideToggle();
					return false;
				});
			}
			
			<?php if(get_option('cu_auto_popup') && (is_home() || is_front_page()) && empty($cu_city)){ ?>
				var inner_width = '360px';
				if(jQuery(window).width() < 400)
					inner_width = '260px';
				jQuery('#cu_popup_trigger').colorbox({inline:true, innerWidth:inner_width});
				
				jQuery('#cu_popup_form select').change(function() {
					location.href = '<?php echo $current_url_array[0] . $current_url_array[1]; ?>set_cp_city='+jQuery(this).val();
				});
			
				<?php if(!$_SESSION['cu_popup_alert']){
						$_SESSION['cu_popup_alert'] = 1;
				?>
					jQuery('#cu_popup_trigger').click();
				<?php }
			}
			?>
			
		});

	</script>
	<?php
}
add_action('cu_show_city_menu', 'cu_show_city_menu');

function cu_get_city_links() {
	global $cu_city;
	$current_url_array = cu_get_current_url_array();
	$cu_city_list = stripslashes(get_option('cu_city_list'));
	
	echo '<ul>';
	if($cu_city) : ?>
		<li><a style="color:#ff0000;" href="<?php echo $current_url_array[0] . $current_url_array[1]; ?>remove_cp_city=1"/><?php _e('(Cancel Selection x)', APP_TD) ?></a></li>
	 <?php endif;
	global $wpdb;
	 
	  $options = explode(',', $cu_city_list);
	  $count = 0;
	   foreach ($options as $option) :
	   $count++;
	   if($cu_city == trim(esc_attr($option))) :
	 ?>
			
	 <?php
		else :
			?>
			<li><a href="<?php echo $current_url_array[0] . $current_url_array[1]; ?>set_cp_city=<?php echo trim(esc_attr($option)); ?>"/><?php echo trim(esc_attr($option)); ?></a></li>
		<?php endif;
	 endforeach;
	 echo '</ul>';
}

function cu_get_city_dropdown() {
	global $cu_city;
	$current_url_array = cu_get_current_url_array();
	$cu_city_list = stripslashes(get_option('cu_city_list'));
	?>
	<select id="cu_city_select" name="cu_city_select">
		<option value=""><?php _e('Select'); ?></option>
	<?php
	global $wpdb;
	 
	  $options = explode(',', $cu_city_list);
	  $count = 0;
	   foreach ($options as $option) :
	   $selected = '';
	   if( $option == $cu_city ) {
			$selected = ' selected="selected"';
	   }
	   $count++; ?>
			<option <?php echo $selected; ?> value="<?php echo trim(esc_attr($option)); ?>"><?php echo trim(esc_attr($option)); ?></option>
			
	   <?php
	 endforeach;
	 
	echo '</select>';
}

function cu_set_city() {
	global $cu_city;
	if(isset($_GET['remove_cp_city'])) {
		setcookie('cu_city', '', time() - 3600, '/');
		unset($_COOKIE['cu_city']);
		$cu_city = '';
		return;
	}
	if(!isset($_GET['set_cp_city'])) return;
	
	$cu_city = $_GET['set_cp_city'];
	$expire=time()+60*60*24*30;
	setcookie('cu_city', $cu_city, $expire, '/');
	unset($_GET['set_cp_city']);
}

function cu_get_current_url_array() {
	global $cu_city;
	global $su_state;
	$script_uri = $_SERVER['SCRIPT_URI'];
	$query_string = urldecode($_SERVER['QUERY_STRING']);
	
	$query_string = str_replace('&set_cp_city=' . $cu_city, '', $query_string);
	$query_string = str_replace('set_cp_city=' . $cu_city, '', $query_string);
	$query_string = str_replace('&set_cp_state=' . $su_state, '', $query_string);
	$query_string = str_replace('set_cp_state=' . $su_state, '', $query_string);
	$query_string = str_replace('&remove_cp_city=1', '', $query_string);
	$query_string = str_replace('remove_cp_city=1', '', $query_string);
	$query_string = str_replace('&remove_cp_state=1', '', $query_string);
	$query_string = str_replace('remove_cp_state=1', '', $query_string);
	$query_string = str_replace('&msg=subscription_success', '', $query_string);
	$query_string = str_replace('msg=subscription_success', '', $query_string);
	if($query_string) {
		$url_array[] = $script_uri . '?' . $query_string;
		$url_array[] = '&';
	} else {
		$url_array[] = $script_uri;
		$url_array[] = '?';
	}
	return $url_array;
}
?>