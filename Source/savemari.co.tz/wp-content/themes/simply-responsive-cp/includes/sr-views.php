<?php

class SR_User_Dashboard extends APP_View_Page {

	private static $_template;

	function __construct() {
		self::$_template = 'tpl-dashboard.php';
		parent::__construct( self::$_template, __( 'Dashboard', CPSR_TD ) );
	}

	static function get_id() {
		return self::_get_page_id( self::$_template );
	}

	function template_redirect() {
		appthemes_auth_redirect_login(); // if not logged in, redirect to login page
		nocache_headers();

		// process actions if needed
		self::process_actions();
	}

	static function process_actions() {
		global $current_user;

		$allowed_actions = array( 'setPick', 'unsetPick' );

		if ( ! isset( $_GET['action'] ) || ! in_array( $_GET['action'], $allowed_actions ) ) {
			return;
		}

		if ( ! isset( $_GET['aid'] ) || ! is_numeric( $_GET['aid'] ) ) {
			return;
		}

		$d = trim( $_GET['action'] );
		$post_id = appthemes_numbers_only( $_GET['aid'] );

		// make sure ad exist
		$post = get_post( $post_id );
		if ( ! $post || $post->post_type != APP_POST_TYPE ) {
			return;
		}

		// make sure author matches
		if ( $post->post_author != $current_user->ID ) {
			return;
		}

		$expire_time = strtotime( get_post_meta( $post->ID, 'cp_sys_expire_date', true ) );
		$is_expired = ( current_time( 'timestamp' ) > $expire_time && $post->post_status == 'draft' );
		$is_pending = ( $post->post_status == 'pending' );

		if ( $d == 'setPick' ) {
			update_post_meta( $post->ID, 'cp_ad_pick', 'yes' );
			appthemes_add_notice( 'marked-pick', __( 'Ad has been marked as pending pick up.', CPSR_TD ), 'success' );
			wp_redirect( CP_DASHBOARD_URL );
			exit();

		} elseif ( $d == 'unsetPick' ) {
			update_post_meta( $post->ID, 'cp_ad_pick', 'no' );
			appthemes_add_notice( 'unmarked-pick', __( 'Ad has been unmarked as pending pick up.', CPSR_TD ), 'success' );
			wp_redirect( CP_DASHBOARD_URL );
			exit();
		}

	}

}


/**
 * Listings Archive view.
 */

class SR_Ads_Archive extends APP_View {

	function condition() {
		return is_post_type_archive( APP_POST_TYPE ) && ! is_tax() && ! is_admin();
	}

	function parse_query( $wp_query ) {
		$wp_query->set( 'ignore_sticky_posts', 1 );
		$sort = ( ! empty( $_GET['sort'] ) ) ? $_GET['sort'] : '';
		if ( $sort == 'random' ) {
			$wp_query->set( 'orderby', 'rand' );
		} else if ( $sort == 'featured' ) {
			$wp_query->set( 'sticky_posts', true );
		} else if ( $sort == 'popular' ) {
			$wp_query->set( '_popular_posts_total', true );
		}
	}

	function breadcrumbs( $trail ) {
		$new_trail = array( $trail[0] );

		if ( ! empty( $_GET['sort'] ) && $_GET['sort'] == 'random' ) {
			$new_trail[] = __( 'Random Ads', CPSR_TD );
		} elseif ( ! empty( $_GET['sort'] ) && $_GET['sort'] == 'featured' ) {
			$new_trail[] = __( 'Featured Ads', CPSR_TD );
		} elseif ( ! empty( $_GET['sort'] ) && $_GET['sort'] == 'popular' ) {
			$new_trail[] = __( 'Popular Ads', CPSR_TD );
		} else {
			$new_trail[] = __( 'Latest Ads', CPSR_TD );
		}

		if ( is_paged() ) {
			$new_trail[] = array_pop( $trail );
		}
	
		return $new_trail;
	}

}