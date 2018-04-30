<?php
/**
 * Featured ads slider template.
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

	<?php if ( $featured = cp_get_featured_slider_ads() ) : ?>


		<!-- featured listings -->
		<?php if ( $wp_query->found_posts >= 1 ) : ?>
			<div class="shadowblockdir">

				<span class="ftm_featured"><?php _e( 'Featured Listings', CPSR_TD ); ?></span>

				<div class="sliderblockdir">

					<div class="prev"></div>

					<div id="sliderlist">

						<div class="slider">

							<ul>

								<?php while ( $featured->have_posts() ) : $featured->the_post(); ?>

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

	<?php appthemes_after_loop( 'featured' ); ?>

	<?php wp_reset_postdata(); ?>

<?php endif; // end feature ad slider check ?>

