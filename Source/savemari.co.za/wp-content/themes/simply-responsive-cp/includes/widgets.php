<?php
/**
 * Theme specific widgets.
 *
 * @package SimplyResponsive\Widgets
 * @author  FabTalent Media
 * @since   Simply Responsive 3.5
 */


// custom sidebar 300x250 ads widget
class AppThemes_Widget_300_Ads extends WP_Widget {

	function AppThemes_Widget_300_Ads() {
		$widget_ops = array( 'description' => __( 'Places an ad space in the sidebar for 300x250 ads', CPSR_TD ) );
		$control_ops = array( 'width' => 500, 'height' => 350 );
		parent::__construct( 'cp_300_ads', __( 'CP 300x250 Ads', CPSR_TD ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract($args);

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Sponsored Ads', CPSR_TD ) : $instance['title'] );
		//$title = apply_filters( 'widget_title', $instance['title'] );
		$newin = isset( $instance['newin'] ) ? $instance['newin'] : false;

		if (isset($instance['ads'])) :

			// separate the ad line items into an array
			$ads = explode("\n", $instance['ads']);

			if (sizeof($ads)>0) :

				echo $before_widget;


				if ($title) echo $before_title . $title . $after_title;
				if ($newin) $newin = 'target="_blank"';
			?>

				<ul class="ads300">
				<?php
					$alt = 1;
					foreach ( $ads as $ad ) :
						if ( $ad && strstr( $ad, '|' ) ) {
							$alt = $alt*-1;
							$this_ad = explode( '|', $ad );
							echo '<li class="';
							if ($alt==1) echo 'alt';
							echo '"><a href="'.$this_ad[0].'" rel="'.$this_ad[3].'" '.$newin.'><img src="'.$this_ad[1].'" width="300" height="250" alt="'.$this_ad[2].'" /></a></li>';
						}
					endforeach;
				?>
				</ul>

				<?php
				echo $after_widget;

			endif;

		endif;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['ads'] = strip_tags( $new_instance['ads'] );
		$instance['newin'] = $new_instance['newin'];

		return $instance;
	}

	function form( $instance ) {
		// load up the default values
		$default_ads = get_bloginfo( 'url' )."|".get_bloginfo( 'stylesheet_directory' )."/images/ad300a.gif|Ad 1|nofollow\n";
		$defaults = array( 'title' => __( 'Sponsored Ads', CPSR_TD ), 'ads' => $default_ads, 'rel' => true, 'newin' => '' );
		$instance = wp_parse_args( (array) $instance, $defaults );
	?>
		<p>
			<label><?php _e( 'Title:', CPSR_TD ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		<p>
			<label><?php _e( 'Ads:', CPSR_TD ); ?></label>
			<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'ads' ); ?>" cols="5" rows="5"><?php echo $instance['ads']; ?></textarea>
			<?php _e( 'Enter one ad entry per line in the following format:', CPSR_TD ); ?><br />
			<code><?php _e( 'URL|Image URL|Image Alt Text|rel', CPSR_TD ); ?></code><br />
			<?php _e( '<strong>Note:</strong> You must hit your &quot;enter/return&quot; key after each ad entry otherwise the ads will not display properly.', CPSR_TD ); ?>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['newin'], 'on' ); ?> id="<?php echo $this->get_field_id( 'newin' ); ?>" name="<?php echo $this->get_field_name( 'newin' ); ?>" />
			<label><?php _e( 'Open ads in a new window?', CPSR_TD ); ?></label>
		</p>
<?php
	}
}



// register the custom sidebar widgets for 300x250 ads
function sr_widgetsnew_init() {
	register_widget( 'AppThemes_Widget_300_Ads' );
}
add_action( 'widgets_init', 'sr_widgetsnew_init' );

