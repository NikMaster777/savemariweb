<?php
/*
	Plugin Name: Advanced Custom Fields for ClassiPress
	Plugin URI: https://marketplace.appthemes.com/plugins/advanced-custom-fields-for-classipress/
	Description: Advanced Custom Fields Plugin For ClassiPress 3.2 - 3.5+
	Version: 2.3.12
	Release Date: 26/08/2015
	Author: Themebound (with help from Artem Frolov)
	Author URI: https://themebound.com/
	AppThemes ID: advanced-custom-fields-for-classipress
*/

//error_reporting(E_ALL);
// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	die( 'Direct script access not allowed' );
}

/*==================== DEFINE ACF SYSTEM INFO =======================*/
define( 'ACF_FILE', __FILE__ );
define( 'ACF_TD', 'acfcp' );
define( 'ACF_DIR', dirname(__FILE__) );
define( 'ACF_URL', WP_PLUGIN_URL . '/' . basename( ACF_DIR ) );
define( 'ACF_VER', '2.3.11' );
$acf_parent_vers = array( '3.2', '3.2.1', '3.3', '3.3.1', '3.3.2', '3.3.3', '3.4', '3.4.1', '3.4.2', '3.5', '3.5.1', '3.5.2', '3.5.3' );
/*=================== /DEFINE ACF SYSTEM INFO =======================*/

if ( is_admin() ) {
	/*==================== LOAD DNA FRAMEWORK =======================*/
	// Load DNA Framework main file
	require( ACF_DIR . '/framework/dna/dna.php' );
	// Load DNA configuration file
	require( ACF_DIR . '/admin/dna-config.php' );
	/*=================== /LOAD DNA FRAMEWORK =======================*/

	if ( isset( $pagenow ) && ( 'user-edit.php' === $pagenow || 'profile.php' === $pagenow ) ) {
		require( ACF_DIR . '/framework/acf/acf-filters.php' );
		require( ACF_DIR . '/includes/acf-profile-formbuilders.php' );
	}

} 

if( !is_admin() || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
	/*================= LOAD ACF FRONTEND FILES =====================*/
	require( ACF_DIR . '/framework/acf/acf-filters.php' );
	require( ACF_DIR . '/includes/acf-profile-formbuilders.php' );
	require( ACF_DIR . '/includes/acf-ad-formbuilders.php' );
    require( ACF_DIR . '/includes/acf-hooks.php' );
    require( ACF_DIR . '/includes/acf-enqueue.php' );
    require( ACF_DIR . '/includes/acf-content.php' );
	if( '3.2.1' === get_option( 'cp_version' ) || '3.2' === get_option( 'cp_version' ) )
		require( ACF_DIR . '/includes/deprecated/deprecated.php' );
	/*================ /LOAD ACF FRONTEND FILES =====================*/
}

/*====================== LOAD ACF COMMON FILES ======================*/
require( ACF_DIR . '/framework/acf/acf-helpers.php' );
/*===================== /LOAD ACF COMMON FILES ======================*/


/*===================== WPML COMPATIBILITY LAYER ====================*/
function acf_wpml_load() {
	if ( function_exists( 'icl_translate' ) )
		require( ACF_DIR . '/includes/acf-wpml.php' );
}
add_action( 'plugins_loaded', 'acf_wpml_load' );
/*==================== /WPML COMPATIBILITY LAYER ====================*/