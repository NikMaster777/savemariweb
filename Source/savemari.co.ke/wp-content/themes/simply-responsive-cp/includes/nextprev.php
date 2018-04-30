<?php

// Vienna's mod to create Navigation NEXT & PREV links for single ads pages within the same category
function get_adjacent_post_plus($r, $previous = true ) {
	global $post, $wpdb;

	extract( $r, EXTR_SKIP );

	if ( empty( $post ) )
		return null;

//	Sanitize $order_by, since we are going to use it in the SQL query. Default to 'post_date'.
	if ( in_array($order_by, array( 'post_date', 'post_title', 'post_excerpt', 'post_name', 'post_modified' )) ) {
		$order_format = '%s';
	} elseif ( in_array($order_by, array( 'ID', 'post_author', 'post_parent', 'menu_order', 'comment_count' )) ) {
		$order_format = '%d';
	} elseif ( $order_by == 'custom' && !empty($meta_key) ) { // Don't allow a custom sort if meta_key is empty.
		$order_format = '%s';
	} else {
		$order_by = 'post_date';
		$order_format = '%s';
	}

//	Sanitize $order_2nd. Only columns containing unique values are allowed here. Default to 'post_date'.
	if ( in_array($order_2nd, array( 'post_date', 'post_title', 'post_modified' )) ) {
		$order_format2 = '%s';
	} elseif ( in_array($order_2nd, array( 'ID' )) ) {
		$order_format2 = '%d';
	} else {
		$order_2nd = 'post_date';
		$order_format2 = '%s';
	}

//	Sanitize num_results (non-integer or negative values trigger SQL errors)
	$num_results = intval($num_results) < 2 ? 1 : intval($num_results);

//	Sorting on custom fields requires an extra table join
	if ( $order_by == 'custom' ) {
		$current_post = get_post_meta($post->ID, $meta_key, true );
		$order_by = 'm.meta_value';
		$meta_join = $wpdb->prepare(" INNER JOIN $wpdb->postmeta AS m ON p.ID = m.post_id AND m.meta_key = %s", $meta_key );
	} else {
		$current_post = $post->$order_by;
		$order_by = 'p.' . $order_by;
		$meta_join = '';
	}

//	Get the current post value for the second sort column
	$current_post2 = $post->$order_2nd;
	$order_2nd = 'p.' . $order_2nd;

//	Get the list of post types. Default to current post type
	if ( empty($post_type) )
		$post_type = "'$post->post_type'";

//	Put this section in a do-while loop to enable the loop-to-first-post option
	do {
		$join = $meta_join;
		$excluded_categories = $ex_cats;
		$excluded_posts = $ex_posts;
		$included_posts = $in_posts;
		$in_same_term_sql = $in_same_author_sql = $ex_cats_sql = $ex_posts_sql = $in_posts_sql = '';

//		Get the list of hierarchical taxonomies, including customs (don't assume taxonomy = 'category')
		$taxonomies = array_filter( get_post_taxonomies($post->ID), "is_taxonomy_hierarchical" );

		if ( ($in_same_cat || $in_same_tax || $in_same_format || !empty($excluded_categories)) && !empty($taxonomies) ) {
			$cat_array = $tax_array = $format_array = array();

			if ( $in_same_cat ) {
				$cat_array = wp_get_object_terms($post->ID, $taxonomies, array( 'fields' => 'ids' ));
			}
			if ( $in_same_tax && !$in_same_cat ) {
				if ( $in_same_tax === true ) {
					if ( $taxonomies != array( 'category' ) )
						$taxonomies = array_diff($taxonomies, array( 'category' ));
				} else
					$taxonomies = (array) $in_same_tax;
				$tax_array = wp_get_object_terms($post->ID, $taxonomies, array( 'fields' => 'ids' ));
			}
			if ( $in_same_format ) {
				$taxonomies[] = 'post_format';
				$format_array = wp_get_object_terms($post->ID, 'post_format', array( 'fields' => 'ids' ));
			}

			$join .= " INNER JOIN $wpdb->term_relationships AS tr ON p.ID = tr.object_id INNER JOIN $wpdb->term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id AND tt.taxonomy IN (\"" . implode( '", "', $taxonomies) . "\")";

			$term_array = array_unique( array_merge( $cat_array, $tax_array, $format_array ) );
			if ( !empty($term_array) )
				$in_same_term_sql = "AND tt.term_id IN (" . implode( ',', $term_array) . ")";

			if ( !empty($excluded_categories) ) {
				$delimiter = ( strpos($excluded_categories, ',' ) !== false ) ? ',' : 'and';
				$excluded_categories = array_map( 'intval', explode($delimiter, $excluded_categories) );
				if ( $ex_cats_method === 'strong' ) {
					$taxonomies = array_filter( get_post_taxonomies($post->ID), "is_taxonomy_hierarchical" );
					if ( function_exists( 'get_post_format' ) )
						$taxonomies[] = 'post_format';
					$ex_cats_posts = get_objects_in_term( $excluded_categories, $taxonomies );
					if ( !empty($ex_cats_posts) )
						$ex_cats_sql = "AND p.ID NOT IN (" . implode($ex_cats_posts, ',' ) . ")";
				} else {
					if ( !empty($term_array) && !in_array($ex_cats_method, array( 'diff', 'differential' )) )
						$excluded_categories = array_diff($excluded_categories, $term_array);
					if ( !empty($excluded_categories) )
						$ex_cats_sql = "AND tt.term_id NOT IN (" . implode($excluded_categories, ',' ) . ' )';
				}
			}
		}

//		Optionally restrict next/previous links to same author
		if ( $in_same_author )
			$in_same_author_sql = $wpdb->prepare("AND p.post_author = %d", $post->post_author );

//		Optionally exclude individual post IDs
		if ( !empty($excluded_posts) ) {
			$excluded_posts = array_map( 'intval', explode( ',', $excluded_posts) );
			$ex_posts_sql = " AND p.ID NOT IN (" . implode( ',', $excluded_posts) . ")";
		}

//		Optionally include individual post IDs
		if ( !empty($included_posts) ) {
			$included_posts = array_map( 'intval', explode( ',', $included_posts) );
			$in_posts_sql = " AND p.ID IN (" . implode( ',', $included_posts) . ")";
		}

		$adjacent = $previous ? 'previous' : 'next';
		$order = $previous ? 'DESC' : 'ASC';
		$op = $previous ? '<' : '>';

//		Optionally get the first/last post. Disable looping and return only one result.
		if ( $end_post ) {
			$order = $previous ? 'ASC' : 'DESC';
			$num_results = 1;
			$loop = false;
			if ( $end_post === 'fixed' ) // display the end post link even when it is the current post
				$op = $previous ? '<=' : '>=';
		}

//		If there is no next/previous post, loop back around to the first/last post.
		if ( $loop && isset($result) ) {
			$op = $previous ? '>=' : '<=';
			$loop = false; // prevent an infinite loop if no first/last post is found
		}
		$join  = apply_filters( "get_{$adjacent}_post_plus_join", $join, $r );

//		In case the value in the $order_by column is not unique, select posts based on the $order_2nd column as well.
//		This prevents posts from being skipped when they have, for example, the same menu_order.
		$where = apply_filters( "get_{$adjacent}_post_plus_where", $wpdb->prepare("WHERE ( $order_by $op $order_format OR $order_2nd $op $order_format2 AND $order_by = $order_format ) AND p.post_type IN ($post_type) AND p.post_status = 'publish' $in_same_term_sql $in_same_author_sql $ex_cats_sql $ex_posts_sql $in_posts_sql", $current_post, $current_post2, $current_post), $r );

		$sort  = apply_filters( "get_{$adjacent}_post_plus_sort", "ORDER BY $order_by $order, $order_2nd $order LIMIT $num_results", $r );

		$query = "SELECT DISTINCT p.* FROM $wpdb->posts AS p $join $where $sort";
		$query_key = 'adjacent_post_' . md5($query);
		$result = wp_cache_get($query_key);
		if ( false !== $result )
			return $result;

//		Use get_results instead of get_row, in order to retrieve multiple adjacent posts (when $num_results > 1)
//		Add DISTINCT keyword to prevent posts in multiple categories from appearing more than once
		$result = $wpdb->get_results("SELECT DISTINCT p.* FROM $wpdb->posts AS p $join $where $sort");
		if ( null === $result )
			$result = '';

	} while ( !$result && $loop );

	wp_cache_set($query_key, $result);
	return $result;
}

// Display previous post link that is adjacent to the current post.
function previous_post_link_plus( $args = '' ) {
	return adjacent_post_link_plus( $args, '%link', true );
}

// Display next post link that is adjacent to the current post.
function next_post_link_plus( $args = '' ) {
	return adjacent_post_link_plus( $args, '%link', false);
}

// Display adjacent post link. Can be either next post link or previous.
function adjacent_post_link_plus( $args = '', $format = '%link &raquo;', $previous = true ) {
	$defaults = array(
		'order_by' => 'post_date', 'order_2nd' => 'post_date', 'meta_key' => '', 'post_type' => '',
		'loop' => false, 'end_post' => false, 'thumb' => false, 'max_length' => 0,
		'format' => '', 'link' => '%title', 'tooltip' => '%title',
		'in_same_cat' => false, 'in_same_tax' => false, 'in_same_format' => false, 'in_same_author' => false,
		'ex_cats' => '', 'ex_cats_method' => 'weak', 'ex_posts' => '', 'in_posts' => '',
		'before' => '', 'after' => '', 'num_results' => 1, 'echo' => true
	);

	$r = wp_parse_args( $args, $defaults );
	if ( !$r['format'] )
		$r['format'] = $format;
	if ( ! function_exists( 'get_post_format' ) )
		$r['in_same_format'] = false;

	if ( $previous && is_attachment() ) {
		$posts = array();
		$posts[] = & get_post($GLOBALS['post']->post_parent);
	} else
		$posts = get_adjacent_post_plus($r, $previous);

//	If there is no next/previous post, return false so themes may conditionally display inactive link text.
	if ( !$posts )
		return false;

	$output = $r['before'];

//	When num_results > 1, multiple adjacent posts may be returned. Use foreach to display each adjacent post.
//	If sorting by date, display posts in reverse chronological order. Otherwise display in alpha/numeric order.
	if ( ($previous && $r['order_by'] != 'post_date' ) || (!$previous && $r['order_by'] == 'post_date' ) )
		$posts = array_reverse( $posts, true );

	foreach ( $posts as $post ) {
		$title = $post->post_title;
		if ( empty($post->post_title) )
			$title = $previous ? __( 'Previous Post' ) : __( 'Next Post' );

		$title = apply_filters( 'the_title', $title, $post->ID);
		$date = mysql2date(get_option( 'date_format' ), $post->post_date);
		$author = get_the_author_meta( 'display_name', $post->post_author);

//		Set anchor title attribute to long post title or custom tooltip text. Supports variable replacement in custom tooltip.
		if ( $r['tooltip'] ) {
			$tooltip = str_replace( '%title', $title, $r['tooltip']);
			$tooltip = str_replace( '%date', $date, $tooltip);
			$tooltip = str_replace( '%author', $author, $tooltip);
			$tooltip = ' title="' . esc_attr($tooltip) . '"';
		} else
			$tooltip = '';

//		Truncate the link title to nearest whole word under the length specified.
		$max_length = intval($r['max_length']) < 1 ? 9999 : intval($r['max_length']);
		if ( strlen($title) > $max_length )
			$title = substr( $title, 0, strrpos(substr($title, 0, $max_length), ' ' ) ) . '...';

		$rel = $previous ? 'prev' : 'next';

		$anchor = '<a href="'.get_permalink($post).'" rel="'.$rel.'"'.$tooltip.'>';
		$link = str_replace( '%title', $title, $r['link']);
		$link = str_replace( '%date', $date, $link);
		$link = $anchor . $link . '</a>';

		$format = str_replace( '%link', $link, $r['format']);
		$format = str_replace( '%date', $date, $format);
		$format = str_replace( '%author', $author, $format);
		if ( $r['order_by'] == 'custom' && !empty($r['meta_key']) ) {
			$meta = get_post_meta($post->ID, $r['meta_key'], true );
			$format = str_replace( '%meta', $meta, $format);
		}

//		Get the category list, including custom taxonomies (only if the %category variable has been used).
		if ( (strpos($format, '%category' ) !== false) && version_compare(PHP_VERSION, '5.0.0', '>=' ) ) {
			$term_list = '';
			$taxonomies = array_filter( get_post_taxonomies($post->ID), "is_taxonomy_hierarchical" );
			if ( $r['in_same_format'] && get_post_format($post->ID) )
				$taxonomies[] = 'post_format';
			foreach ( $taxonomies as &$taxonomy ) {
				if ( $next_term = get_the_term_list($post->ID, $taxonomy, '', ', ', '' ) ) {
					$term_list .= $next_term;
					if ( current($taxonomies) ) $term_list .= ', ';
				}
			}
			$format = str_replace( '%category', $term_list, $format);
		}

//		Optionally add the post thumbnail to the link. Wrap the link in a span to aid CSS styling.
		if ( $r['thumb'] && has_post_thumbnail($post->ID) ) {
			if ( $r['thumb'] === true ) // use 'post-thumbnail' as the default size
				$r['thumb'] = 'post-thumbnail';
			$thumbnail = '<a class="post-thumbnail" href="'.get_permalink($post).'" rel="'.$rel.'"'.$tooltip.'>' . get_the_post_thumbnail( $post->ID, $r['thumb'] ) . '</a>';
			$format = $thumbnail . '<span class="post-link">' . $format . '</span>';
		}

//		If more than one link is returned, wrap them in <li> tags
		if ( intval($r['num_results']) > 1 )
			$format = '<li>' . $format . '</li>';

		$output .= $format;
	}

	$output .= $r['after'];

	//	If echo is false, don't display anything. Return the link as a PHP string.
	if ( !$r['echo'] )
		return $output;

	$adjacent = $previous ? 'previous' : 'next';
	echo apply_filters( "{$adjacent}_post_link_plus", $output, $r );

	return true;

}

function sr_vienna_mod($postID) {
$thispost = $postID;
	function sr_get_category_count($input = '' ) {
    global $wpdb;
    if($input == '' ) {
        $category = get_the_category();
        return $category[0]->category_count;
    } elseif(is_numeric($input)) {
        $SQL = "SELECT $wpdb->term_taxonomy.count FROM $wpdb->terms, $wpdb->term_taxonomy WHERE $wpdb->terms.term_id=$wpdb->term_taxonomy.term_id AND $wpdb->term_taxonomy.term_id=$input";
        return $wpdb->get_var($SQL);
    } else {
        $SQL = "SELECT $wpdb->term_taxonomy.count FROM $wpdb->terms, $wpdb->term_taxonomy WHERE $wpdb->terms.term_id=$wpdb->term_taxonomy.term_id AND $wpdb->terms.slug='$input'";
        return $wpdb->get_var($SQL);
    }
} ?>


<div class="nav-category">
<?php
$cat_id = appthemes_get_custom_taxonomy( $thispost, APP_TAX_CAT, 'term_id' );
$catname = appthemes_get_custom_taxonomy( $thispost, APP_TAX_CAT, 'name' );
	if (isset($cat_id)) {
	if (sr_get_category_count($cat_id)> 1) {
		//echo "";
		echo "<span class='tabview'>" . __( 'There are ', CPSR_TD ) . sr_get_category_count($cat_id) . __( ' ads listed under ', CPSR_TD) . $catname . "</span>";
		} else {
		echo "<span class='tabview'>" . __( 'Sorry, there is only ', CPSR_TD ) . sr_get_category_count($cat_id) . __( ' ad listed under ', CPSR_TD) . $catname . __( ' at this time.', CPSR_TD) . "</span>";
		}
	}
?>
</div>
<br />
<span class="nav-previous">
<?php
if (sr_get_category_count($cat_id)> 1)  {
	//previous_post_link_plus( array( 'order_by' => 'post_title','in_same_cat' => 'true&$cat_id', 'end_post' => true, 'link' => '<button class="btn_grey" type="submit">&laquo;</button>',) ); ?>&nbsp;
	<?php previous_post_link_plus( array( 'order_by' => 'post_title','in_same_cat' => 'true&$cat_id', 'end_post' => false, 'link' => '<button class="btn_link" type="submit">' . __( '&larr; PREV AD', CPSR_TD ) . '</button> ',) );
}
?>
</span>
<span class="nav-next">
<?php 
if (sr_get_category_count($cat_id)> 1)  {
	next_post_link_plus( array( 'order_by' => 'post_title','in_same_cat' => 'true&$cat_id', 'end_post' => true, 'link' => ' <button class="mbtn btn_link" type="submit">' . __( 'NEXT AD &rarr;', CPSR_TD ) . '</button>',) ); ?>&nbsp;
	<?php //next_post_link_plus( array( 'order_by' => 'post_title','in_same_cat' => 'true&$cat_id', 'end_post' => false, 'link' => '<button class="mbtn btn_grey" type="submit">&raquo;</button>',) );
}
else { }; ?>
</span>
<?php
}