<?php

class FTM_User_Dashboard extends APP_View_Page {

	function __construct() {

		parent::__construct( 'tpl-dashboard.php', __( 'Dashboard', CPSR_TD ) );
	}

	static function get_id() {
		return parent::_get_id( __CLASS__ );
	}

	function template_redirect() {
		appthemes_auth_redirect_login(); // if not logged in, redirect to login page
		nocache_headers();

		// process actions if needed
		self::process_actions();

		add_action( 'appthemes_notices', array( $this, 'show_notice' ) );
	}

	function process_actions() {
		global $wpdb, $current_user;

		$allowed_actions = array( 'pause', 'restart', 'delete', 'setSold', 'unsetSold', 'setPick', 'unsetPick' );

		if ( ! isset( $_GET['action'] ) || ! in_array( $_GET['action'], $allowed_actions ) )
			return;

		if ( ! isset( $_GET['aid'] ) || ! is_numeric( $_GET['aid'] ) )
			return;

		$d = trim( $_GET['action'] );
		$aid = appthemes_numbers_only( $_GET['aid'] );

		// make sure author matches ad, and ad exist
		$sql = $wpdb->prepare( "SELECT * FROM $wpdb->posts WHERE ID = %d AND post_author = %d AND post_type = %s", $aid, $current_user->ID, APP_POST_TYPE );
		$post = $wpdb->get_row( $sql );
		if ( $post == null )
			return;

		$expire_time = strtotime( get_post_meta( $post->ID, 'cp_sys_expire_date', true ) );
		$is_expired = ( current_time( 'timestamp' ) > $expire_time && $post->post_status == 'draft' );
		$is_pending = ( $post->post_status == 'pending' );

		if ( $d == 'setPick' ) {
			update_post_meta( $post->ID, 'cp_ad_pick', 'yes' );
			$redirect_url = add_query_arg( array( 'markedpick' => 'true' ), CP_DASHBOARD_URL );
			wp_redirect( $redirect_url );
			exit();

		} elseif ( $d == 'unsetPick' ) {
			update_post_meta( $post->ID, 'cp_ad_pick', 'no' );
			$redirect_url = add_query_arg( array( 'unmarkedpick' => 'true' ), CP_DASHBOARD_URL );
			wp_redirect( $redirect_url );
			exit();

		}
		
	}

	function show_notice() {
		if ( isset( $_GET['markedpick'] ) ) {
			appthemes_display_notice( 'success', __( 'Ad has been marked as pending pick up.', CPSR_TD ) );
		} elseif ( isset( $_GET['unmarkedpick'] ) ) {
			appthemes_display_notice( 'success', __( 'Ad has been unmarked as pending pick up.', CPSR_TD ) );
		}
	}


}


/**
 * Listings Archive view.
 */

class FTM_Ads_Archive extends APP_View {

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

	/*function posts_clauses( $clauses, $wp_query ) {
		global $wpdb;

		if ( $wp_query->get( '_popular_posts_total' ) ) {
			$clauses['join'] .= " INNER JOIN $wpdb->cp_ad_pop_total ON ($wpdb->posts.ID = $wpdb->cp_ad_pop_total.postnum) ";
			$clauses['where'] .= " AND $wpdb->cp_ad_pop_total.postcount > 0 ";
			$clauses['orderby'] = "$wpdb->cp_ad_pop_total.postcount DESC";
		}

		return $clauses;
	}*/

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