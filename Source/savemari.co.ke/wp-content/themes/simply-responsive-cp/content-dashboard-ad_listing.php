<?php
/**
 * Dashboard Listings loop content.
 *
 * @package ClassiPress\Templates
 * @author  AppThemes
 * @since   ClassiPress 3.4
 */
?>
<?php
$status = cp_get_listing_status_name( $post->ID );
$expire_time = strtotime( get_post_meta( $post->ID, 'cp_sys_expire_date', true ) );
$expire_date = appthemes_display_date( $expire_time );
?>

<tr class="even <?php echo $status; ?>">
	<td class="text-right dashnumb"><?php echo $i; ?>.</td>

	<td>
	
	<div class="showadthumb-left">
		<?php if ( $cp_options->ad_images ) cp_ad_loop_thumbnail(); ?>
	</div>

		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

		<div class="meta">
			<i class="fa fa-folder-open"></i> <?php echo get_the_term_list( get_the_id(), APP_TAX_CAT, '', ', ', '' ); ?>&nbsp;&nbsp;
			<i class="fa fa-clock-o"></i> <?php echo appthemes_display_date( $post->post_date, 'date' ); ?>
		</div>
	</td>

	<?php if ( current_theme_supports( 'app-stats' ) ): ?>
		<td class="text-center"><?php echo appthemes_get_stats_by( $post->ID, 'total' ); ?></td>
	<?php endif; ?>

	<td class="text-center">
		<span class="status"><?php echo cp_get_status_i18n( $status ); ?></span>
		<?php if ( in_array( $status, array( 'live', 'live_expired', 'ended' ) ) ): ?>
			<p class="small">(<?php echo $expire_date; ?>)</p>
		<?php endif; ?>
	</td>

	<td class="text-center"><?php cp_dashboard_listing_actions(); ?><?php sr_dashboard_listing_actions(); ?></td>

</tr>

