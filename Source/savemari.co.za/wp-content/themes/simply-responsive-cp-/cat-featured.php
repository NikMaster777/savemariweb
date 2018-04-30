<?php
/**
 * Featured ads slider template - Cat pages.
 *
 * @package ClassiPress\Templates
 * @author  AppThemes
 * @since   ClassiPress 3.0
 */

global $cp_options;
?>

<?php if ( $cp_options->enable_featured ) : ?>

	<script type="text/javascript">
		// <![CDATA[
		/* featured listings slider */
		jQuery(document).ready(function($) {
			$('.slider').jCarouselLite({
				btnNext: '.next',
				btnPrev: '.prev',
				visible: ( $(window).width() < 870 ) ? 4 : 5,
				pause: true,
				auto: true,
				timeout: 2800,
				speed: 1100,
				easing: 'easeOutQuint' // for different types of easing, see easing.js
			});
		});
		// ]]>
	</script>

	<?php appthemes_before_loop( 'featured' ); ?>

	<?php
		if (is_tax()) {
			$term = get_term_by( 'slug', get_query_var('term'), get_query_var( 'taxonomy' ) );
			query_posts( array( 'post__in' => get_option( 'sticky_posts' ), 'post_type' => APP_POST_TYPE, 'post_status' => 'publish', 'orderby' => 'rand', 'posts_per_page'=>'-1', 'ad_cat'=> $term->slug ) );
		}
		if ( have_posts() ) :
	?>

	<?php if ( $wp_query->found_posts >= 3 ) : ?>
		<!-- featured listings -->

			<div class="shadowblockdir">

				<span class="ftm_featured"><?php _e( 'Featured Listings', CPSR_TD ); ?></span>

				<div class="sliderblockdir">

					<div class="prev"></div>

					<div id="sliderlist">

						<div class="slider">

							<ul>

								<?php while ( have_posts() ) : the_post(); ?>

									<?php appthemes_before_post( 'featured' ); ?>

									<?php get_template_part( 'content-slider', get_post_type() ); ?>

									<?php appthemes_after_post( 'featured' ); ?>

								<?php endwhile; ?>

								<?php appthemes_after_endwhile( 'featured' ); ?>

							</ul>

						</div>

					</div><!-- /slider -->

					<div class="next"></div>

					<div class="clr"></div>

				</div><!-- /sliderblock -->

			</div><!-- /shadowblock -->

	<?php endif; ?>

	<?php endif; ?>

	<?php wp_reset_query(); ?>

	<?php appthemes_after_loop( 'featured' ); ?>

	<?php wp_reset_postdata(); ?>

<?php endif; // end feature ad slider check ?>
