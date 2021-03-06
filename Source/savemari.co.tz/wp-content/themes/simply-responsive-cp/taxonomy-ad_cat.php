<?php
/**
 * Taxonomy Template.
 *
 * @package ClassiPress\Templates
 * @author  AppThemes
 * @since   ClassiPress 3.0
 */
?>


<div class="content">

	<div class="content_botbg">

		<div class="content_res">

			<div id="breadcrumb"><?php cp_breadcrumb(); ?></div>

			<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/includes/js/easing.js?ver=1.3"></script>
			<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/includes/js/jcarousellite.min.js?ver=1.9.2"></script>
			<?php
				if ( file_exists(STYLESHEETPATH . '/cat-featured.php') )
				include_once(STYLESHEETPATH . '/cat-featured.php');
			?>
			<!-- left block -->
			<div class="content_left">

				<?php $term = get_queried_object(); ?>

				<div class="shadowblock_top">

					<div class="shadowblock">

						<div id="catrss" class="catrss"><a class="dashicons-before catrss" href="<?php echo esc_url( get_term_feed_link( $term->term_id, $taxonomy ) ); ?>" title="<?php echo esc_url( sprintf( __( '%s RSS Feed', CPSR_TD ), $term->name ) ); ?>"></a></div>
						<h2 class="listing"><?php _e( 'Total Listings for', CPSR_TD ); ?> <?php echo $term->name; ?> (<?php echo $wp_query->found_posts; ?>)</h2>

						<p><?php echo $term->description; ?></p>

					</div><!-- /shadowblock -->

				</div><!-- /shadowblock_out -->

 				<?php wp_reset_query();?>

				<?php get_template_part( 'loop', 'ad_listing' ); ?>


			</div><!-- /content_left -->


			<?php get_sidebar(); ?>


			<div class="clr"></div>

		</div><!-- /content_res -->

	</div><!-- /content_botbg -->

</div><!-- /content -->
