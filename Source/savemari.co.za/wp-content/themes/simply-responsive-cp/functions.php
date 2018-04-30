<?php

// BEFORE USING: Move the classiPress-child theme into the /themes/ folder.
//
// You can add you own actions, filters and code below.


global $app_version;
$app_version = '';

define( 'CPSR_TD', 'simply-responsive' );

// load languages
function my_child_theme_setup() {
	load_child_theme_textdomain( CPSR_TD, get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'my_child_theme_setup' );

// execute theme actions on theme activation
function sr_first_run() {
	if ( isset($_GET['firstrun']) )
		do_action( 'sr_first_run' );
}
add_action( 'admin_notices', 'sr_first_run', 9999 );

// Set some things when the theme is activated
if ( ! function_exists( 'cpsr_activated' ) ) {
    function cpsr_activated() {
    // set thumbnail size in settings > media
	update_option( 'thumbnail_crop', true );
	update_option( 'thumbnail_size_w', 90 );
	update_option( 'thumbnail_size_h', 90 );
	update_option( 'medium_size_w', 250 );
	update_option( 'medium_size_h', 250 );
	update_option( 'large_size_w', 583 );
	update_option( 'large_size_h', 583 );
    }
    add_action( 'after_switch_theme', 'cpsr_activated' );
}

//  Create Special Size For The Ads
function simply_add_new_image_size() {
	add_image_size( 'ad-simply', 250, 250, true );
	add_image_size( 'featured-simply', 250, 250, true ); // sidebar blog thumbnail size, box crop mode
}
add_action( 'appthemes_init', 'simply_add_new_image_size' );

// setup image sizes
function child_theme_setup() {
    add_image_size( 'ad-small', 90, 90, true );
    add_image_size( 'ad-medium', 250, 250, true );
    add_image_size( 'ad-large', 583, 583, true );
}
add_action( 'after_setup_theme', 'child_theme_setup', 20 );

if (!isset($content_width))
	$content_width = 583;

// Image Size Update Notice
if ( isset( $_GET['activated'] ) && 'themes.php' == $GLOBALS['pagenow'] )
	add_option( 'simply_images_update', 'yes' );

function simply_display_image_size_notice() {
	if ( !current_user_can( 'manage_options' ) || !get_option( 'simply_images_update' ) )
		return;

	$ignore_url = ( version_compare( $GLOBALS['app_version'], '3.3', '<' ) ) ? 'admin.php?page=settings&simply_nag_ignore=1' : 'admin.php?page=app-settings&simply_nag_ignore=1';
	echo scb_admin_notice( sprintf( __( 'Image thumbnails need to be updated to use with Simply Responsive Child Theme. Please use the <a href="%1$s">Force Regenerate Thumbnails</a> plugin for this purpose.', CPSR_TD ), 'http://wordpress.org/plugins/force-regenerate-thumbnails/' ) . ' | <a href="' . admin_url( $ignore_url ) . '">' . __( 'Hide Notice', CPSR_TD ) . '</a>' );
}
add_action( 'admin_notices', 'simply_display_image_size_notice' );


function simply_ignore_image_size_notice() {
	if ( isset( $_GET['simply_nag_ignore'] ) )
		delete_option( 'simply_images_update' );
}
add_action( 'admin_init', 'simply_ignore_image_size_notice' );


//allow redirection, even if my theme starts to send output to the browser
add_action( 'init', 'do_output_buffer' );
function do_output_buffer() {
        ob_start();
}

// Setup New Child Views
function child_setup_new_views_template() {
	require_once dirname( __FILE__ ) . '/includes/sr-views.php';
	new SR_User_Dashboard;
	new SR_Ads_Archive;
	//new CP_Widget_Author_Search;
}
add_action( 'appthemes_init', 'child_setup_new_views_template' );


// ========== Change Featured Images Size ==========
// processes the entire ad thumbnail logic within the loop
if ( ! function_exists( 'cp_ad_loop_thumbnail' ) ) :
	function cp_ad_loop_thumbnail() {
		global $post, $cp_options;

		// go see if any images are associated with the ad
		$image_id = cp_get_featured_image_id($post->ID);

		// set the class based on if the hover preview option is set to "yes"
		$prevclass = ( $cp_options->ad_image_preview ) ? 'preview' : 'nopreview';

		if ( $image_id > 0 ) {

			// get 75x75 v3.0.5+ image size
			$adthumbarray = wp_get_attachment_image( $image_id, 'ad-simply' );

			// grab the large image for onhover preview
			$adlargearray = wp_get_attachment_image_src( $image_id, 'large' );
			$img_large_url_raw = $adlargearray[0];

			// must be a v3.0.5+ created ad
			if ( $adthumbarray ) {
				echo '<a href="'. get_permalink() .'" title="'. the_title_attribute( 'echo=0' ) .'" class="'.$prevclass.'" data-rel="'.$img_large_url_raw.'">'.$adthumbarray.'</a>';

			// maybe a v3.0 legacy ad
			} else {
				$adthumblegarray = wp_get_attachment_image_src($image_id, 'thumbnail' );
				$img_thumbleg_url_raw = $adthumblegarray[0];
				echo '<a href="'. get_permalink() .'" title="'. the_title_attribute( 'echo=0' ) .'" class="'.$prevclass.'" data-rel="'.$img_large_url_raw.'">'.$adthumblegarray.'</a>';
			}

		// no image so return the placeholder thumbnail
		} else {
			echo '<a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '"><img class="attachment-medium" alt="no-image" width="250" title="" src="' . appthemes_locate_template_uri( 'images/no-thumb-250.jpg' ) . '" /></a>';
		}
	}
endif;


// processes the entire ad thumbnail logic for featured ads
if ( ! function_exists( 'cp_ad_featured_thumbnail' ) ) :
	function cp_ad_featured_thumbnail() {
		global $post, $cp_options;

		// go see if any images are associated with the ad
		$image_id = cp_get_featured_image_id($post->ID);

		// set the class based on if the hover preview option is set to "yes"
		$prevclass = ( $cp_options->ad_image_preview ) ? 'preview' : 'nopreview';

		if ( $image_id > 0 ) {

			// get 50x50 v3.0.5+ image size
			$adthumbarray = wp_get_attachment_image($image_id, 'featured-simply' );

			// grab the large image for onhover preview
			$adlargearray = wp_get_attachment_image_src($image_id, 'large' );
			$img_large_url_raw = $adlargearray[0];

			// must be a v3.0.5+ created ad
			if($adthumbarray) {
				echo '<a href="'. get_permalink() .'" title="'. the_title_attribute( 'echo=0' ) .'" class="'.$prevclass.'" data-rel="'.$img_large_url_raw.'">'.$adthumbarray.'</a>';

			// maybe a v3.0 legacy ad
			} else {
				$adthumblegarray = wp_get_attachment_image_src($image_id, 'thumbnail' );
				$img_thumbleg_url_raw = $adthumblegarray[0];
				echo '<a href="'. get_permalink() .'" title="'. the_title_attribute( 'echo=0' ) .'" class="'.$prevclass.'" data-rel="'.$img_large_url_raw.'">'.$adthumblegarray.'</a>';
			}

		// no image so return the placeholder thumbnail
		} else {
			echo '<a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '"><img class="attachment-featured-simply" alt="no-image" width="250" title="" src="' . appthemes_locate_template_uri( 'images/no-thumb-250.jpg' ) . '" /></a>';
		}
	}
endif;


// get the main image associated to the ad used on the single page
if (!function_exists( 'cp_get_image_url' )) {
	function cp_get_image_url() {
		global $post, $wpdb;

		// go see if any images are associated with the ad
		$images = get_children( array( 'post_parent' => $post->ID, 'post_status' => 'inherit', 'numberposts' => 1, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'ID' ) );

		if ($images) {

			// move over bacon
			$image = array_shift($images);
			$alt = get_post_meta( $image->ID, '_wp_attachment_image_alt', true );

			// see if this v3.0.5+ image size exists
			$adthumbarray = wp_get_attachment_image_src($image->ID, 'large' );
			$img_medium_url_raw = $adthumbarray[0];

			// grab the large image for onhover preview
			$adlargearray = wp_get_attachment_image_src($image->ID, 'large' );
			$img_large_url_raw = $adlargearray[0];

			// must be a v3.0.5+ created ad
			if($adthumbarray)
				echo '<a href="'. $img_large_url_raw .'" class="img-main" data-rel="colorbox" title="'. the_title_attribute( 'echo=0' ) .'"><img src="'. $img_medium_url_raw .'" title="'. $alt .'" alt="'. $alt .'" /></a>';

		// no image so return the placeholder thumbnail
		} else {
			echo '<img class="attachment-medium" alt="no-image" width="250" height="250" title="" src="' . appthemes_locate_template_uri( 'images/no-thumb-250.jpg' ) . '" />';
		}
	}
}

// EXTRA FUNCTION USED FOR SHARING THE SINGLE AD IMAGE
// get the main image associated to the ad used on the single page
if (!function_exists( 'cp_get_single_image_url' )) {
	function cp_get_single_image_url() {
		global $post, $wpdb;

		// go see if any images are associated with the ad
		$images = get_children( array( 'post_parent' => $post->ID, 'post_status' => 'inherit', 'numberposts' => 1, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'ID' ) );

		if ($images) {

			// move over bacon
			$image = array_shift($images);
			$alt = get_post_meta( $image->ID, '_wp_attachment_image_alt', true );

			// see if this v3.0.5+ image size exists
			$adthumbarray = wp_get_attachment_image_src($image->ID, 'large' );
			$img_medium_url_raw = $adthumbarray[0];

			// grab the large image for onhover preview
			$adlargearray = wp_get_attachment_image_src($image->ID, 'large' );
			$img_large_url_raw = $adlargearray[0];

			// must be a v3.0.5+ created ad
			if($adthumbarray)
				echo ''. $img_large_url_raw .'';

		// no image so return the placeholder thumbnail
		} else {
			echo '';
		}
	}
}

add_filter( 'the_content', 'make_clickable' );
add_filter( 'the_excerpt', 'make_clickable' );

//fix for Artems Advanced Custom Fields double meta information showing in the loop - On main Page.
remove_action( 'init', 'acf_unhook_appthemes_functions' );
remove_action( 'appthemes_after_post_title', 'acf_ad_loop_meta_top' );

// Remove and replace cp actions
function sr_modify_actions() {
	remove_action( 'appthemes_after_post_title', 'cp_ad_loop_meta' );
	add_action( 'appthemes_after_post_title', 'sr_ad_loop_meta' );

	remove_action( 'appthemes_after_blog_post_title', 'cp_blog_post_meta' );
	add_action( 'appthemes_after_blog_post_title', 'sr_blog_post_meta' );

	//remove_action( 'appthemes_after_post_content', 'cp_report_listing_button' );
	//add_action( 'appthemes_after_post_content', 'sr_report_listing_button' );

	remove_action( 'appthemes_loop_else', 'cp_ad_loop_else' );
	add_action( 'appthemes_loop_else', 'sr_ad_loop_else' );

	remove_action( 'appthemes_loop_related_else', 'cp_ad_loop_related_else' );
	add_action( 'appthemes_loop_related_else', 'sr_ad_loop_related_else' );

}
add_action( 'appthemes_init', 'sr_modify_actions' );

/* Ad loop meta */
function sr_ad_loop_meta() {
	global $post, $cp_options;
	if ( is_singular( APP_POST_TYPE ) )
		return;
?>
	<p class="post-meta">
		<i class="fa fa-folder-open"></i> <?php if ( $post->post_type == 'post' ) the_category( ', ' ); else echo get_the_term_list( $post->ID, APP_TAX_CAT, '', ', ', '' ); ?>| <span class="fa fa-user owner"><?php if ( $cp_options->ad_gravatar_thumb ) appthemes_get_profile_pic( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_email' ), 16 ); ?><?php the_author_posts_link(); ?></span>
	</p>
<?php
}

/* Blog post meta */
function sr_blog_post_meta() {
	global $post;
	// don't do post-meta on pages
	if ( is_page() ) {
		return;
	}
?>
	<p class="meta dotted">
		<i class="fa fa-user"></i><?php the_author_posts_link(); ?>&nbsp;&nbsp;&nbsp; <i class="fa fa-folder-open"></i><?php the_category( ', ' ); ?>&nbsp;&nbsp;&nbsp; <i class="fa fa-clock-o"></i><?php echo appthemes_date_posted( $post->post_date ); ?>
	</p>
<?php
}


/*  Displays report listing form. */
function sr_report_listing_button() {
	global $post;

	if ( ! is_singular( array( APP_POST_TYPE ) ) ) {
		return;
	}

	$form = appthemes_get_reports_form( $post->ID, 'post' );
	if ( ! $form ) {
		return;
	}

	$content = '<p class="edit">';
	$content .= '<span class="fa fa-exclamation-circle"> <a href="#" class="reports_form_link">' . __( 'Report problem', CPSR_TD ) . '</a></span>';
	$content .= '</p>';
	$content .= '<div class="report-form">' . $form . '</div>';

	echo $content;
}


/* add the no ads found message */
function sr_ad_loop_else() {
?>
    <div class="shadowblock_none">
		<div class="shadowblock">

			<div class="pad10"></div>
			<p class="msg"><?php _e( 'Sorry, no listings were found.', CPSR_TD ); ?></p>
			<div class="pad10"></div>
			<span class="back"><a href="javascript:history.back()"><?php _e( '&larr; Go Back', CPSR_TD); ?></a></span>
			<div class="pad25"></div>

		</div><!-- /shadowblock -->
	</div><!-- /shadowblock_out -->
<?php
}

/* NEW loop related else Hook */
function appthemes_loop_related_else( $type = '' ) {
	if ( $type ) $type .= '_';
	do_action( 'appthemes_' . $type . 'loop_related_else' );
}

/* add the no ads found message after the related ads */
function cp_ad_loop_related_else() {
?>
    <div class="shadowblock_else">
		<div class="shadowblock">

			<div class="pad2"></div>
			<p class="msg"><?php _e( 'Sorry, there are no other related ads in this category at this time.', CPSR_TD); ?></p>

		</div><!-- /shadowblock -->
	</div><!-- /shadowblock_out -->

<?php
}
add_action( 'appthemes_loop_related_else', 'cp_ad_loop_related_else' );



// Displays the login message in the header */
if ( ! function_exists( 'cp_login_head' ) ) {
	function cp_login_head() {

		if ( is_user_logged_in() ) :
			$current_user = wp_get_current_user();
			$logout_url = cp_logout_url();
			?>
			<span class="welc"><?php _e( 'Welcome,', CPSR_TD ); ?> <strong><?php echo $current_user->display_name; ?></strong>&nbsp;&nbsp;</span> <a class="btn_orange lrbtn" href="<?php echo esc_url( CP_DASHBOARD_URL ); ?>"><?php _e( 'My Dashboard', CPSR_TD ); ?></a>&nbsp;&nbsp; <a class="btn_orange lrbtn" href="<?php echo esc_url( $logout_url ); ?>"><?php _e( 'Log Out', CPSR_TD ); ?></a>
		<?php else : ?>

			<span class="welc"><?php _e( 'Welcome,', CPSR_TD ); ?> <strong><?php _e( 'visitor!', CPSR_TD ); ?></strong>&nbsp;&nbsp;</span>

			<?php if ( get_option('users_can_register') ): ?>
				<a class="btn_orange lrbtn" href="<?php echo esc_url( appthemes_get_registration_url() ); ?>"><?php _e( 'Register', CPSR_TD ); ?></a>&nbsp;&nbsp;
			<?php endif; ?>

			<a class="btn_orange lrbtn" href="<?php echo wp_login_url(); ?>"><?php _e( 'Login', CPSR_TD ); ?></a>

		<?php endif;

	}
}


// Register the Responsive Video shortcode to wrap html around the content
function responsive_video_shortcode( $atts ) {
	extract( shortcode_atts( array (
		'identifier' => ''
	), $atts ) );
	return '<div class="video-container"><iframe src="//www.youtube.com/embed/' . $identifier . '?showinfo=0&rel=0&autoplay=0" frameborder="0" allowfullscreen></iframe></div><!--video-container-->';
}
add_shortcode ( 'responsive-video', 'responsive_video_shortcode' );



// Register the Responsive Video shortcode to wrap html around the content
function responsive_vimeo_shortcode( $atts ) {
	extract( shortcode_atts( array (
		'identifier' => ''
	), $atts ) );
	return '<div class="video-container"><iframe src="//player.vimeo.com/video/' . $identifier . '?autoplay=0" frameborder="0" allowfullscreen></iframe></div><!--video-container-->';
}
add_shortcode ( 'responsive-vimeo', 'responsive_vimeo_shortcode' );



// Add images to rss
function embed_rss_image($content) {
global $post, $cp_options;
	if( is_feed() ) {
		if( get_post_meta( $post->ID, 'images', true ) ) $thumb_image = cp_single_image_legacy( $post->ID, get_option( 'ad-small_size_w' ), get_option( 'ad-small_size_h' )); else $thumb_image = cp_get_image_url( $post->ID, 'ad-small', 1 );
		$content = $thumb_image . "<br />" . $content;
	}
	return $content;
}

//add_filter( 'the_excerpt_rss', 'embed_rss_image' );
add_filter( 'the_content', 'embed_rss_image' );



// TO DO
// Limit first 3 featured (Sticky) posts on top of category and search results
function sr_sticky_on_top( $sql ){
 	if ( is_tax ( APP_TAX_CAT) || is_search() ){
		global $wpdb;
		$sticky_posts = get_option ( 'sticky_posts' );
		 	rsort( $sticky_posts );
		 	$sticky_posts = array_slice( $sticky_posts, 0, 3 );

		if ( !$sticky_posts ) return $sql;
		$sql['fields'] = $sql['fields'].", IF( $wpdb->posts.ID IN ( ".implode ( ',',$sticky_posts )."), 1, 0) AS featured";
		$sql['orderby'] = "featured DESC, ". $sql['orderby'];
	}
	return $sql;
}
add_filter( 'posts_clauses_request', 'sr_sticky_on_top' );



// unregister the main cp price action, and add a new one
function sr_modify_price_action() {
	remove_action( 'appthemes_before_post_title', 'cp_ad_loop_price' );
	add_action( 'appthemes_before_post_title', 'sr_ad_loop_price' );
}
add_action( 'appthemes_init', 'sr_modify_price_action' );


// Remove cp_price from loop when no price is input (* price must NOT be set as required in the add new forms!)
function sr_ad_loop_price() {
	global $post, $cp_options;

	if ( $post->post_type == 'page' || $post->post_type == 'post' )
		return;
		$price = get_post_meta( $post->ID, 'cp_price', true );

	if ( !empty( $price) /* AND ( $price > 0 ) */ ) { // unless empty add the ad price field in the loop as usual
	?>

		<div class="price-wrap">
			<span class="tag-head">
				<p class="post-price"><i class="fa fa-tag"></i>  <?php if ( get_post_meta( $post->ID, 'price', true ) ) cp_get_price_legacy( $post->ID ); else cp_get_price( $post->ID, 'cp_price' ); ?></p>
			</span>
		</div>

	<?php } else {
		// do not display empty price field
	}
}

// choose when to display featured slider
function childtheme_control_when_to_display_featured_slider( $featured ) {
	if ( count( $featured->posts ) < 4 ) {
		return false;
	}
	return $featured;
}
add_filter( 'cp_featured_slider_ads', 'childtheme_control_when_to_display_featured_slider' );


// Allow shortcodes in widgets
add_filter( 'widget_text', 'do_shortcode' );


/**
 * enqueue font awesome icons from parent theme folder
 */
function sr_awesome_stylesheet() {
	wp_enqueue_style( 'font-awesome' );
}
add_action( 'wp_enqueue_scripts', 'sr_awesome_stylesheet', 100 );


/**
 * Returns user dashboard ad listing actions.
 */
function sr_get_dashboard_listing_actions( $listing_id = 0 ) {
	global $cp_options;

	$actions = array();
	$listing_id = $listing_id ? $listing_id : get_the_ID();
	$listing = get_post( $listing_id );
	$listing_status = cp_get_listing_status_name( $listing_id );

	// set/unset pending links
	if ( in_array( $listing_status, array( 'live', 'offline' ) ) ) {
		$pick = get_post_meta( $listing->ID, 'cp_ad_pick', true );
		if ( $pick != 'yes' ) {
			// set pending
			$actions['set_pick'] = array(
				'title' => __( 'Mark Pending', CPSR_TD ),
				'href' => add_query_arg( array( 'aid' => $listing->ID, 'action' => 'setPick' ), CP_DASHBOARD_URL ),
			);
		} else {
			// unset pending
			$actions['unset_pick'] = array(
				'title' => __( 'Unmark Pending', CPSR_TD ),
				'href' => add_query_arg( array( 'aid' => $listing->ID, 'action' => 'unsetPick' ), CP_DASHBOARD_URL ),
			);
		}
	}
	$actions = apply_filters( 'cp_dashboard_listing_actions', $actions, $listing );
	return apply_filters( 'sr_dashboard_listing_actions', $actions, $listing );
}

/**
 * Displays user dashboard ad listing actions.
 */
function sr_dashboard_listing_actions( $listing_id = 0 ) {
	$listing_id = $listing_id ? $listing_id : get_the_ID();

	$actions = sr_get_dashboard_listing_actions( $listing_id );
	$li = '';

	foreach ( $actions as $action => $attr ) {
		$a = html( 'a', $attr, $attr['title'] );
		$li .= html( 'li', array( 'class' => $action ), $a );
	}

	$ul = html( 'ul', array( 'id' => 'listing-actions-' . $listing_id, 'class' => 'listing-actions' ), $li );
	echo $ul;
}



//WP Content Filter plugin adjustsment - filter the content in the ad loop - remove the first two forward slashes // below if using that plugin
//add_filter( 'cp_get_content_preview', 'pccf_filter' );


// Show Parent Category in the Post an Ad process
function cp_get_category_parents($cat_id) {
	$chain = '';
	$delimiter = '/';
	$term = get_term_by( 'id', $cat_id, APP_TAX_CAT);
	$parent = $term->parent;

	while ( $parent ):
		$parents[] = $parent;
		$new_parent = get_term_by( 'id', $parent, APP_TAX_CAT);
		$parent = $new_parent->parent;
	endwhile;
	
	if ( ! empty( $parents ) ):
		$parents = array_reverse( $parents );

		foreach ( $parents as $parent ) :
			$item = get_term_by( 'id', $parent, APP_TAX_CAT);
			$chain .= $item->name.$delimiter.' ';
		endforeach;

	endif;

	$chain .= $term->name;
	return $chain;
}


// load alternative enqueue file and other files
//require_once( get_stylesheet_directory() . '/includes/sr-enqueue.php' );
require_once( get_stylesheet_directory() . '/includes/widgets.php' );
require_once( get_stylesheet_directory() . '/includes/nextprev.php' );

// correctly load all the jquery scripts so they don't conflict with plugins
if ( ! function_exists( 'sr_load_scripts' ) ) :
function sr_load_scripts() {
	global $cp_options;
	wp_enqueue_script( 'simply_responsive_js', get_stylesheet_directory_uri() . '/includes/js/respond.js', true );
	wp_enqueue_script( 'orientation_fix_js', get_stylesheet_directory_uri() . '/includes/js/ios-orientationchange-fix.js', true );
	wp_enqueue_script( 'theme-scripts', get_stylesheet_directory_uri() . '/includes/js/theme-scripts.js', array( 'jquery' ), '3.3.3' );
}
endif;
if ( !is_admin() ) {
add_action( 'wp_enqueue_scripts', 'sr_load_scripts' );
}

// make the password strength meter to work on login template page
function sr_enqueue_login_scripts() {
    if ( is_page_template( 'tpl-login.php' ) ) {
        wp_enqueue_script( 'utils' );
        wp_enqueue_script( 'user-profile' );
    }
}
add_action( 'wp_enqueue_scripts', 'sr_enqueue_login_scripts' );


// Sets customizer default colors based on the theme color scheme.
//require_once( get_stylesheet_directory() . '/includes/customizer.php' );

// Sets customizer default colors based on the child theme color scheme.
function _sr_colors( $colors ) {

	$colors = array(

		'style-default.css' => array(
			 // top nav
			'cp_top_nav_bgcolor' => '',
			'cp_top_nav_links_color' => '',
			'cp_top_nav_text_color' => '',
			// header
			'cp_header_bgcolor' => '',
			// main nav
			'cp_main_nav_bgcolor' => '',
			'cp_main_nav_links_color' => '',
			// other
			'cp_buttons_bgcolor' => '',
			'cp_buttons_text_color' => '',
			'cp_links_color' => '',
			// footer
			'cp_footer_bgcolor' => '',
			'cp_footer_text_color' => '',
			'cp_footer_links_color' => '',
			'cp_footer_titles_color' => '',
		),
	
		'aqua.css'	=> array(
			// top nav
			'cp_top_nav_bgcolor' => '#111111',
			'cp_top_nav_links_color' => '#ffffff',
			'cp_top_nav_text_color' => '#ffffff',
			// header
			'cp_header_bgcolor' => '#ffffff',
			// main nav
			'cp_main_nav_bgcolor' => '#3e9286',
			'cp_main_nav_links_color' => '#ffffff',
			// other
			'cp_buttons_bgcolor' => '#3e9286',
			'cp_buttons_text_color' => '#ffffff',
			'cp_links_color' => '#3e9286',
			// footer
			'cp_footer_bgcolor' => '#eeeeee',
			'cp_footer_text_color' => '#666666',
			'cp_footer_links_color' => '#3e9286',
			'cp_footer_titles_color' => '#666666',
		),
	
		'blue.css' => array(
			// top nav
			'cp_top_nav_bgcolor' => '#111111',
			'cp_top_nav_links_color' => '#ffffff',
			'cp_top_nav_text_color' => '#ffffff',
			// header
			'cp_header_bgcolor' => '#ffffff',
			// main nav
			'cp_main_nav_bgcolor' => '#3b5998',
			'cp_main_nav_links_color' => '#ffffff',
			// other
			'cp_buttons_bgcolor' => '#3b5998',
			'cp_buttons_text_color' => '#ffffff',
			'cp_links_color'	=> '#3b5998',
			// footer
			'cp_footer_bgcolor' => '#eeeeee',
			'cp_footer_text_color' => '#666666',
			'cp_footer_links_color' => '#3b5998',
			'cp_footer_titles_color' => '#666666',
		),
	
		'green.css'	=> array(
			// top nav
			'cp_top_nav_bgcolor' => '#111111',
			'cp_top_nav_links_color' => '#ffffff',
			'cp_top_nav_text_color' => '#ffffff',
			// header
			'cp_header_bgcolor' => '#ffffff',
			// main nav
			'cp_main_nav_bgcolor' => '#679325',
			'cp_main_nav_links_color' => '#ffffff',
			// other
			'cp_buttons_bgcolor' => '#536c2e',
			'cp_buttons_text_color' => '#ffffff',
			'cp_links_color'	=> '#679325',
			// footer
			'cp_footer_bgcolor' => '#eeeeee',
			'cp_footer_text_color' => '#666666',
			'cp_footer_links_color' => '#679325',
			'cp_footer_titles_color' => '#666666',
		),
	
		'red.css'	=> array(
			// top nav
			'cp_top_nav_bgcolor' => '#111111',
			'cp_top_nav_links_color' => '#ffffff',
			'cp_top_nav_text_color' => '#ffffff',
			// header
			'cp_header_bgcolor' => '#ffffff',
			// main nav
			'cp_main_nav_bgcolor' => '#b22222',
			'cp_main_nav_links_color' => '#ffffff',
			// other
			'cp_buttons_bgcolor' => '#b22222',
			'cp_buttons_text_color' => '#ffffff',
			'cp_links_color'	=> '#b22222',
			// footer
			'cp_footer_bgcolor' => '#eeeeee',
			'cp_footer_text_color' => '#666666',
			'cp_footer_links_color' => '#b22222',
			'cp_footer_titles_color' => '#666666',
		),
	
		'teal.css'	=> array(
			// top nav
			'cp_top_nav_bgcolor' => '#111111',
			'cp_top_nav_links_color' => '#ffffff',
			'cp_top_nav_text_color' => '#ffffff',
			// header
			'cp_header_bgcolor' => '#ffffff',
			// main nav
			'cp_main_nav_bgcolor' => '#186c95',
			'cp_main_nav_links_color' => '#ffffff',
			// other
			'cp_buttons_bgcolor' => '#186c95',
			'cp_buttons_text_color' => '#ffffff',
			'cp_links_color'	=> '#186c95',
			// footer
			'cp_footer_bgcolor' => '#eeeeee',
			'cp_footer_text_color' => '#666666',
			'cp_footer_links_color' => '#186c95',
			'cp_footer_titles_color' => '#666666',
		),
	);
	return $colors;
}
add_filter( 'cp_customizer_color_defaults', '_sr_colors' );

remove_action( 'customize_register', '_cp_customize_color_scheme' );
remove_action( 'customize_register', '_cp_customize_footer' );
remove_action( 'wp_head', '_cp_customize_css', 999 );
add_action( 'wp_head', '_sr_colors', 9999 );
