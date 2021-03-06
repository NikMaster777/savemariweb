<?php
/**
 * Search results template.
 *
 * @package ClassiPress\Templates
 * @author  AppThemes
 * @since   ClassiPress 1.0
 */

	$searchTxt = get_search_query();
	if ( empty( $searchTxt ) || $searchTxt == __( 'What are you looking for?', CPSR_TD ) ) {
		$searchTxt = '*';
	}
?>

	<div class="content">

		<div class="content_botbg">

			<div class="content_res">

				<div id="breadcrumb"><?php if ( function_exists('cp_breadcrumb') ) cp_breadcrumb(); ?></div>

				<!-- left block -->
				<div class="content_left">

					<div class="shadowblock_top">

						<div class="shadowblock">

							<h2 class="single"><?php printf( __( 'Search for \'%1$s\' returned %2$s results', CPSR_TD ), $searchTxt, $wp_query->found_posts ); ?></h2>

						</div><!-- /shadowblock -->

					</div><!-- /shadowblock_out -->

					<?php get_template_part( 'loop', 'ad_listing' ); ?>

				</div><!-- /content_left -->

				<?php get_sidebar(); ?>

				<div class="clr"></div>

			</div><!-- /content_res -->

		</div><!-- /content_botbg -->

	</div><!-- /content -->
