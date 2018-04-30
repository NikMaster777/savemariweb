<?php
/**
 * Ad listings Archive template.
 *
 * @package ClassiPress\Templates
 * @author  AppThemes
 * @since   ClassiPress 1.0
 */
?>

<div class="content">

	<div class="content_botbg">

		<div class="content_res">

			<div id="breadcrumb"><?php cp_breadcrumb(); ?></div>

			<?php
			// Figure out what we are displaying
			$sort = 'latest';
			if ( ! empty( $_GET['sort'] ) && in_array( $_GET['sort'], array( 'popular', 'random', 'featured' ) ) ) {
				$sort = $_GET['sort'];
			}
		
			if ( $sort == 'featured' ) {
		
				// show all featured ads
				$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
				query_posts( array( 'post_type' => APP_POST_TYPE, 'post__in' => get_option( 'sticky_posts' ), 'paged' => $paged ) );
		
			}
			?>

			<!-- left block -->
			<div class="content_left">

				<?php get_template_part( 'loop', 'ad_listing' ); ?>

			</div><!-- /content_left -->

			<?php get_sidebar(); ?>

			<div class="clr"></div>

		</div><!-- /content_res -->

	</div><!-- /content_botbg -->

</div><!-- /content -->
