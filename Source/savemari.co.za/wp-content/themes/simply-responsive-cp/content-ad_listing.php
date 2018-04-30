<?php
/**
 * Listing loop content template.
 *
 * @package ClassiPress\Templates
 * @author  AppThemes
 * @since   ClassiPress 3.4
 */
global $cp_options;
?>

	<?php if ( is_sticky() ){ ?>

	<div id="sticky" class="post-block-out-sticky <?php cp_display_style( 'featured' ); ?>">

	<?php } else { ?>

	<div class="post-block-out <?php cp_display_style( 'featured' ); ?>">

	<?php } ?>

	<div class="post-block">
 		<?php if ( get_post_meta( $post->ID, 'cp_price_negotiable', true ) ) echo '<span class="negotiable-text">' . __( 'Negotiable', CPSR_TD ) . '</span> '; else echo ''; ?>
		<div class="post-left">

					<?php if(in_array($post->ID, get_option('sticky_posts'))) { ?>
						<span class="sr_featured"><?php _e('Featured', CPSR_TD); ?></span>
					<?php } ?>
					<?php if (get_post_meta($post->ID, 'cp_ad_sold', true) == 'yes') : ?>
						<span class="sr_sold"><?php _e('Sold', CPSR_TD); ?></span>
					<?php endif; ?>
					<?php if (get_post_meta($post->ID, 'cp_ad_pick', true) == 'yes') : ?>
						<span class="sr_pick"><?php _e('Sale Pending', CPSR_TD); ?></span>
					<?php endif; ?>

			<?php if ( $cp_options->ad_images ) cp_ad_loop_thumbnail(); ?>

			<div class="clr"></div>

		</div>

		<div class="<?php cp_display_style( array( 'ad_images', 'ad_class' ) ); ?>">

			<?php appthemes_before_post_title(); ?>

			<h3><a href="<?php the_permalink(); ?>"><?php if ( mb_strlen( get_the_title() ) >= 75 ) echo mb_substr( get_the_title(), 0, 75 ) . '...'; else the_title(); ?></a></h3>

			<div class="clr"></div>

			<?php appthemes_after_post_title(); ?>

			<div class="clr"></div>

			<?php appthemes_before_post_content(); ?>

			<p class="post-desc"><?php echo cp_get_content_preview(); ?></p>

			<span class="clock"><?php echo appthemes_date_posted( $post->post_date ); ?></span>

			<?php appthemes_after_post_content(); ?>

			<div class="clr"></div>

		</div>
			<?php if (function_exists('cpfp_link')) { cpfp_link(); } ?>
		<div class="clr"></div>

	</div><!-- /post-block -->

</div><!-- /post-block-out -->
