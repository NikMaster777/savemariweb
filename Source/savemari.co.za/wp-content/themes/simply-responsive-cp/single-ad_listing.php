<?php
/**
 * The Template for displaying all single ads.
 *
 * @package ClassiPress\Templates
 * @author  AppThemes
 * @since   ClassiPress 3.0
 */

global $gmap_active, $cp_options;
?>



<div class="content">

	<div class="content_botbg">

		<div class="content_res">

			<div id="breadcrumb"><?php cp_breadcrumb(); ?></div>

			<div class="clr"></div>

			<div class="content_left">

				<?php do_action( 'appthemes_notices' ); ?>

				<?php appthemes_before_loop(); ?>

				<?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : the_post(); ?>

						<?php appthemes_before_post(); ?>

						<?php appthemes_stats_update( $post->ID ); //records the page hit ?>

						<div id="single_images" class="shadowblock_out <?php cp_display_style( 'featured' ); ?>">

							<div class="shadowblock">

								<?php appthemes_before_post_title(); ?>

								<?php if ( get_post_meta( $post->ID, 'cp_price_negotiable', true ) ) echo '<span class="negotiable-single-text">' . __( 'Price Negotiable', CPSR_TD ) . '</span> '; else echo ''; ?>

								<h1 class="single-listing"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
								<div class="clr"></div>

								<?php appthemes_after_post_title(); ?>
							    <div class="dotted"></div>
							    <div class="pad2"></div>

								<?php if ( $cp_options->ad_images ) { ?>
									<div id="single_images" class="bigleft">

										<div class="bigimg">
											<?php if (in_array($post->ID, get_option('sticky_posts'))) { ?>
												<span class="sr_featured"><?php _e('Featured', CPSR_TD); ?></span>
											<?php } ?>
											<?php if ( get_post_meta( $post->ID, 'cp_ad_sold', true ) == 'yes' ) : ?>
												<span class="sr_sold"><?php _e('Sold', CPSR_TD); ?></span>
											<?php endif; ?>
											<?php if (get_post_meta($post->ID, 'cp_ad_pick', true) == 'yes') : ?>
												<span class="sr_pick"><?php _e('Sale Pending', CPSR_TD); ?></span>
											<?php endif; ?>
	
											<div id="main-pic">
												<?php cp_get_image_url(); ?>
												<div class="clr"></div>
											</div>
										</div><!-- /bigimg -->

										<div id="thumbs-pic">
											<?php cp_get_image_url_single( $post->ID, 'thumbnail', $post->post_title, -1 ); ?>
											<div class="clr"></div>
										</div>

									<div class="pad7"></div>
										<span class="back"><a href="javascript:history.back()"><?php _e( '&larr; Go Back', CPSR_TD); ?></a></span>
							    	<div class="clr"></div>

									</div><!-- /bigleft -->

								<?php } ?>

								<div class="bigright <?php cp_display_style( 'ad_single_images' ); ?>">

                                    <h3 class="detail-area"><?php _e( 'Item Details:', CPSR_TD ); ?></h3>
									<ul>
										<?php
											// grab the category id for the functions below
											$cat_id = appthemes_get_custom_taxonomy( $post->ID, APP_TAX_CAT, 'term_id' );

											if ( get_post_meta( $post->ID, 'cp_ad_sold', true ) == 'yes' ) { ?>
											<li id="cp_sold"><span><?php _e( 'This item has been sold', CPSR_TD ); ?></span></li>
										<?php }
											if ( get_post_meta( $post->ID, 'cp_ad_pick', true ) == 'yes' ) { ?>
											<li id="cp_sold"><span><?php _e( 'Sold, pending pick up', CPSR_TD ); ?></span></li>
										<?php }
											// 3.0+ display the custom fields instead (but not text areas)
											cp_get_ad_details( $post->ID, $cat_id );
										?>
											<!-- <li id="cp_listed"><span><?php _e( 'Listed:', CPSR_TD ); ?></span> <?php echo appthemes_display_date( $post->post_date ); ?></li> -->
										<?php if ( $expire_date = get_post_meta( $post->ID, 'cp_sys_expire_date', true ) ) { ?>
											<li id="cp_expires"><span><?php _e( 'Expires:', CPSR_TD ); ?></span> <span class=""><?php echo cp_timeleft( $expire_date ); ?></span></li>
										<?php } ?>

									</ul>

									<p><div class="fa fa-envelope emailico"></div><a href="mailto:?subject=<?php the_title(); ?>&amp;body=<?php _e( 'Thought you might like this:', CPSR_TD ); ?> <?php the_permalink(); ?>" title="Opens your email client"><div><?php _e( 'Email to a friend', CPSR_TD ); ?></div></a></p>
									<?php if (function_exists('cpfp_link')) { cpfp_link(); } ?>
									<div class="clr"></div>
									<?php if (function_exists('cpfp_count_favorites')) { echo cpfp_count_favorites(); } ?>

								</div><!-- /bigright -->
								<div class="clr"></div>

								<?php appthemes_before_post_content(); ?>

									<div class="sr-author">
										<li class="fa fa-user"></li> <?php if ( get_option('cp_ad_gravatar_thumb') == 'yes' ) appthemes_get_profile_pic( get_the_author_meta('ID'), get_the_author_meta('user_email'), 16 ); ?><?php _e('Item listed by:', CPSR_TD); ?> <?php the_author_posts_link(); ?></span>
										<?php _e('on', CPSR_TD); ?> <?php the_time( get_option( 'date_format' ) ); ?>
										<div class="clr"></div>
									</div>

								<div class="single-main">

									<?php
										// 3.0+ display text areas in content area before content.
										cp_get_ad_details( $post->ID, $cat_id, 'content' );
									?>

									<?php
									// If only Video ID is entered
										$identifier = get_post_meta ( $post->ID, 'cp_youtube_id', true );
										if ($identifier) {
											echo '<h3>' . __( "YouTube Video:", CPSR_TD ) . '</h3>';
											echo  do_shortcode('[responsive-video identifier="' . $identifier . '"]');
											echo '<p class="dotted"></p>';
										}
									?>
									<?php
									// If only Video ID is entered
										$identifier = get_post_meta ( $post->ID, 'cp_vimeo_id', true );
										if ($identifier) {
											echo '<h3>' . __( "Vimeo Video:", CPSR_TD ) . '</h3>';
											echo  do_shortcode('[responsive-vimeo identifier="' . $identifier . '"]');
											echo '<p class="dotted"></p>';
										}
									?>

									<h3 class="description-area"><?php _e( 'Item Description:', CPSR_TD ); ?></h3>
									<?php the_content(); ?>

									<div class="clr"></div>
								</div>
								<nav id="nav-single">
									<?php if (function_exists( 'sr_vienna_mod' )) { sr_vienna_mod($post->ID); } ?>
								</nav>

								<!-- map -->
								<?php
								global $current_user, $gmap_active, $cp_options;
								// make sure google maps has a valid address field before showing tab
								$gmap_active = false;
								$location_fields = get_post_custom();
								$_fields = array( 'cp_zipcode', 'cp_country', 'cp_state', 'cp_street', 'cp_city' );
								foreach ( $_fields as $i ) {
									if ( ! empty( $location_fields[$i] ) && ! empty( $location_fields[$i][0] ) ) {
										$gmap_active = true;
										break;
									}
								}
								?>
								<?php if ( $gmap_active ) { ?>

									<div id="priceblock1">
										<div class="clr"></div>
										<div class="singlemap">
											<?php get_template_part( 'includes/sidebar', 'gmap' ); ?>
										</div><!-- /singletab -->
									</div>

								<?php } ?>

								<?php appthemes_after_post_content(); ?>

							</div><!-- /shadowblock -->

						</div><!-- /shadowblock_out -->

						<?php appthemes_after_post(); ?>

					<?php endwhile; ?>

					<?php appthemes_after_endwhile(); ?>

				<?php else: ?>

					<?php appthemes_loop_else(); ?>

				<?php endif; ?>

				<div class="clr"></div>

				<?php appthemes_after_loop(); ?>

                    <?php wp_reset_query(); ?>

					<div class="shadowblock_top">

						<div class="shadowblock">

							<h2 class="dotted"><?php _e( 'Related Ads', CPSR_TD ); ?></h2>

							<?php if (is_sticky()){ ?>
								<p class="blockhead"><?php _e( 'Some other ads listed under ', CPSR_TD ); ?><?php if ( get_the_category() ) the_category( ', ' ); else echo get_the_term_list( $post->ID, APP_TAX_CAT, '',', ','' ); ?><?php _e( ' that you might be interested in...', CPSR_TD ); ?></p>
							<?php } else { ?>
								<p class="blockhead"><?php _e( 'Some other ', CPSR_TD ); ?><?php if ( get_the_category() ) the_category( ', ' ); else echo get_the_term_list( $post->ID, APP_TAX_CAT, '',', ','' ); ?><?php _e( ' ads that you might be interested in...', CPSR_TD ); ?></p>
							<?php } ?>

						</div><!-- /shadowblock -->

					</div><!-- /shadowblock_out_rlt -->

					<?php
						global $post;
						$terms = get_the_terms( $post->ID , 'ad_cat', 'string' );
						$do_not_duplicate[] = $post->ID;
					?>

					<?php if(!empty($terms)){
						foreach ($terms as $term) {
							query_posts( array(
							'ad_cat' => $term->slug,
							'showposts' => 3,
							'ignore_sticky_posts' => 1,
							'post__not_in' => $do_not_duplicate,
							'orderby' => 'rand') );
							}
						}
					?>

					<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); $do_not_duplicate[] = $post->ID; ?>

					<?php if ( is_sticky() ) { ?>
						<div class="post-block-out-sticky <?php cp_display_style( 'featured' ); ?>">
					<?php } else { ?>
						<div class="post-block-out <?php cp_display_style( 'featured' ); ?>">
					<?php } ?>

						<div class="post-block">

							<div class="post-left">

							<?php if ( in_array( $post->ID, get_option( 'sticky_posts' ) ) ) { ?>
								<span class="sr_featured"><?php _e( 'Featured', CPSR_TD ); ?></span>
							<?php } ?>
							<?php if ( get_post_meta( $post->ID, 'cp_ad_sold', true ) == 'yes' ) : ?>
								<span class="sr_sold"><?php _e('Sold', CPSR_TD); ?></span>
							<?php endif; ?>
							<?php if ( get_post_meta( $post->ID, 'cp_ad_pick', true ) == 'yes' ) : ?>
								<span class="sr_pick"><?php _e('Sale Pending', CPSR_TD); ?></span>
							<?php endif; ?>

								<?php if ( $cp_options->ad_images ) cp_ad_loop_thumbnail(); ?>

							</div>

							<div class="<?php cp_display_style( array( 'ad_images', 'ad_class' ) ); ?>">

								<?php appthemes_before_post_title(); ?>

								<h3><a href="<?php the_permalink(); ?>"><?php if ( mb_strlen( get_the_title() ) >= 75 ) echo mb_substr( get_the_title(), 0, 75 ).'...'; else the_title(); ?></a></h3>

								<div class="clr"></div>

								<?php appthemes_after_post_title(); ?>

								<div class="clr"></div>

								<?php appthemes_before_post_content(); ?>

								<p class="post-desc"><?php echo cp_get_content_preview( 160 ); ?></p>

								<span class="clock"><span><?php echo appthemes_date_posted($post->post_date); ?></span></span>

								<?php appthemes_after_post_content(); ?>

								<div class="clr"></div>

								</div>

								<div class="clr"></div>

							</div><!-- /post-block -->

						</div><!-- /post-block-out -->

                       <?php appthemes_after_post(); ?>

			        <?php endwhile; ?>

			        <?php else: ?>

			            <?php appthemes_loop_related_else(); ?>

				<?php endif; ?>

				<div class="clr"></div>

				<div class="pad10"></div>

				<?php appthemes_after_loop(); ?>

				<?php wp_reset_query(); ?>

				<div class="clr"></div>

				 <?php if ( function_exists( 'display_critic_reviews' ) ) display_critic_reviews(); ?> 

				<?php comments_template( '/comments-ad_listing.php' ); ?>

			</div><!-- /content_left -->

			<?php get_sidebar( 'ad' ); ?>

			<div class="clr"></div>

		</div><!-- /content_res -->

	</div><!-- /content_botbg -->

</div><!-- /content -->
