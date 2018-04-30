<?php
/**
 * Slider Listings loop content.
 *
 * @package ClassiPress\Templates
 * @author  AppThemes
 * @since   ClassiPress 3.4
 */
global $cp_options;
?>

<li>

	<span class="feat_left">
		<?php if ( $post->post_type == 'page' || $post->post_type == 'post' )
			return;
			$price = get_post_meta( $post->ID, 'cp_price', true );
			if ( !empty( $price) /* AND ( $price > 0 ) */ ) { // unless empty add the ad price field in the loop as usual
		?>
			<!-- New style price tag -->
			<!-- <div class="tagslide price-wrap"><span class="tag-head"><p class="post-price"><?php cp_get_price($post->ID, 'cp_price'); ?></p></span></div> -->

			<!-- Old style price tag -->
			<span class="price_sm"><?php cp_get_price($post->ID, 'cp_price'); ?></span>

		<?php } else { ?>
			<div class="pad13"></div>
		<?php } ?>

		<div class="feat_image">
			<?php if (get_post_meta($post->ID, 'cp_ad_sold', true) == 'yes') : ?>
				<span class="sr_sold"><?php _e('Sold', CPSR_TD); ?></span>
			<?php endif; ?>
			<?php if (get_post_meta($post->ID, 'cp_ad_pick', true) == 'yes') : ?>
				<span class="sr_pick"><?php _e('Sale Pending', CPSR_TD); ?></span>
			<?php endif; ?>

			<?php if ( $cp_options->ad_images ) cp_ad_featured_thumbnail(); ?>
		</div>
	</span>

	<div class="clr"></div>

	<?php appthemes_before_post_title( 'featured' ); ?>

	<p><a href="<?php the_permalink(); ?>"><?php if ( mb_strlen( get_the_title() ) >= $cp_options->featured_trim ) echo mb_substr( get_the_title(), 0, $cp_options->featured_trim ) . '...'; else the_title(); ?></a></p>

	<?php appthemes_after_post_title( 'featured' ); ?>

	<span class="owner">by <?php the_author_posts_link(); ?></span>

</li>
