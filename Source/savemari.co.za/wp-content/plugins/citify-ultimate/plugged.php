<?php
/* This file overwrites default ClassiPress functions */

function cu_filter_get_terms($terms, $taxonomies, $args) {
	global $cu_city;
	if(is_admin() || !$cu_city || $taxonomies[0] != APP_TAX_CAT || $args['show_count'] != 1) return $terms;
	$cu_counts = get_transient('cu_counts_'.$cu_city);
	$cu_count_set = false;
	if(empty($cu_counts)) {
		$cu_counts = array();
		$cu_count_set = true;
	}
	foreach($terms as $key => $term) {
		if( !isset($cu_counts[$term->term_id]) ) {
			$args = array(
				'tax_query' => array(
					array(
						'taxonomy' => APP_TAX_CAT,
						'field' => 'id',
						'terms' => $term->term_id
					)
				)
			);
			$tax_query = new WP_Query( $args );
			$cu_counts[$term->term_id] = $tax_query->found_posts;
		}
		$terms[$key]->count = $cu_counts[$term->term_id];
	}
	if( $cu_count_set )
		set_transient('cu_counts_'.$cu_city, $cu_counts, 12 * HOUR_IN_SECONDS);
	return $terms;
}
add_filter('get_terms', 'cu_filter_get_terms', 40, 3);


/*function cu_get_popular_ads(){
    global $wpdb, $wp_query, $cp_has_next_page, $pageposts, $cu_city, $app_version;
	if(is_tax() || is_search()) return;
	
	if($cu_city && $app_version>='3.1.9') {
		
		$meta_key = 'cp_city';
		
		$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
		$posts_per_page = ( get_query_var('posts_per_page') ) ? get_query_var('posts_per_page') : 10;
		
		$start = ($paged * $posts_per_page) - $posts_per_page;
		$limit = $posts_per_page + 1; // Add an additional entry to test for a next page

		// give us the most popular ads based on page views
		$sql = $wpdb->prepare( "SELECT SQL_CALC_FOUND_ROWS p.* FROM $wpdb->cp_ad_pop_total a "
			. "INNER JOIN $wpdb->posts p ON p.ID = a.postnum "
			. "INNER JOIN $wpdb->postmeta pm on p.ID = pm.post_id  "
			. "WHERE postcount > 0 AND post_status = 'publish' AND post_type = %s "
			. "AND pm.meta_key = %s AND pm.meta_value = %s "
			. "ORDER BY postcount DESC LIMIT %d, %d", APP_POST_TYPE, $meta_key, $cu_city, $start, $limit );

		$count_sql = "SELECT FOUND_ROWS()";
		

		$pageposts = $wpdb->get_results( $sql );
		$pageposts_count = $wpdb->get_var( $count_sql );

		// set found posts and number of pages for correct pagination
		$wp_query->found_posts = $pageposts_count;
		$wp_query->max_num_pages = ceil($pageposts_count/$posts_per_page);

		if(count($pageposts) == ($posts_per_page + 1)){
			$cp_has_next_page = true;
		}else{
			$cp_has_next_page = false;
		}

		$pageposts = array_slice( $pageposts, 0, $posts_per_page);

		// create cache for post meta
		if( $pageposts ){
			update_meta_cache('post', wp_list_pluck($pageposts, 'ID'));
		}

		return $pageposts;
	}
}
add_action('appthemes_before_loop', 'cu_get_popular_ads');*/