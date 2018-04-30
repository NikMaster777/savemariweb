<?php

// classipress sidebar search widget
class CU_Select_Widget extends WP_Widget {
	
	function CU_Select_Widget() {
		$widget_ops = array( 'description' => __( 'Your sidebar city selector', APP_TD ) );
		$this->WP_Widget('cu_select_widget', __( 'CU City Select', APP_TD ), $widget_ops);
	}
	
	function widget( $args, $instance ) {
		
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? get_option( 'cu_menu_label' ) : $instance['title']);
		
		echo $before_widget;
		
		if ( $title ) echo $before_title . $title . $after_title;	

		?>
		<div>
			<?php
			
			cu_get_city_dropdown();
			$current_url_array = cu_get_current_url_array();
			?>
			<script type="text/javascript">
				jQuery('.widget_cu_select_widget select').change(function() {
					location.href = '<?php echo $current_url_array[0] . $current_url_array[1]; ?>set_cp_city='+jQuery(this).val();
				});
			</script>
		</div>
		<?php
		
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance) {
		$instance['title'] = strip_tags(stripslashes($new_instance['title']));
		return $instance;
	}
	
	function form($instance) {
	?>
    <p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', APP_TD ); ?></label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php if (isset ($instance['title'])) {echo esc_attr( $instance['title']);} ?>" />
	</p>
	<?php
	}
}

function cu_widgets_init() {
	if ( !is_blog_installed() )
	return;
	register_widget('CU_Select_Widget');
}
add_action('widgets_init', 'cu_widgets_init', 1);