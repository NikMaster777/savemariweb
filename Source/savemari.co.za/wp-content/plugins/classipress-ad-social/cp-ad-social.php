<?php
/**
 * Plugin Name: ClassiPress Ad Social
 * Plugin URI: http://roidayan.com
 * Description: A plugin to add author's social details to author's page and ClassiPress ads
 * Version: 1.1.2
 * Author: Roi Dayan
 * Author URI: http://roidayan.com
 * AppThemes ID: classipress-ad-social
 * License: GPLv3
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

define( 'CPSOCIAL_TD', 'cpsocial' );


class CP_Ad_Social_Plugin {

	function __construct() {
		$this->options_group = 'cp_social_options';
		$this->options_page = 'cp_social_options_page';
		$this->default_options = array (
			'show_in_ad_details' => true,
			'show_after_ad_content' => false
		);

		/* actions & filters */
		add_action( 'plugins_loaded', array( $this, 'load_text_domain' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'cp_author_info', array( $this, 'author_info_show_social' ) );
		add_filter( 'user_contactmethods', array( $this, 'add_contact_methods' ), 20 );

		if ( $this->get_option( 'show_in_ad_details' ) ) {
			add_action( 'cp_action_after_ad_details', array( $this, 'ad_details_show_social' ), 10, 3 );
		}
		if ( $this->get_option( 'show_after_ad_content' ) ) {
			add_action( 'appthemes_after_post_content', array( $this, 'ad_content_show_social' ), 9 );
		}

		/* options */
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'appthemes_add_submenu_page', array( $this, 'admin_page' ) );
	}

	function load_text_domain() {
		load_plugin_textdomain( CPSOCIAL_TD, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	function enqueue_scripts() {
		wp_enqueue_script( 'cp-social-script', plugins_url( 'script.js', __FILE__ ), array( 'theme-scripts' ) );
		wp_enqueue_style( 'cp-social-style', plugins_url( 'style.css', __FILE__ ), array( 'at-main' ) );
	}

	/**
	 * Add contact methods to user profile
	 */
	function add_contact_methods( $methods ) {
		if ( ! isset( $methods['google_plus_id'] ) ) {
			$methods['google_plus_id'] = __( 'Google Plus', CPSOCIAL_TD );
		}
		if ( ! isset( $methods['pinterest_id'] ) ) {
			$methods['pinterest_id'] = __( 'Pinterest', CPSOCIAL_TD );
		}
		if ( ! isset( $methods['phone_number'] ) ) {
			$methods['phone_number'] = __( 'Phone', CPSOCIAL_TD );
		}
		return $methods;
	}

	function add_social_li_item( $url, $ico, $text, $target="_blank" ) {
		if ( $target ) {
			$target = 'target="' . $target . '"';
		}
		echo '<li><a rel="nofollow" href="' . esc_url( $url ) . '" ' . "{$target}>{$ico} {$text}" . '</a></li>';
	}

	function has_social_contact( $user ) {
		if ( ! empty( $user->phone_number ) ||
			 ! empty( $user->user_url ) ||
			 ! empty( $user->twitter_id ) ||
			 ! empty( $user->facebook_id ) ||
			 ! empty( $user->google_plus_id ) ||
			 ! empty( $user->pinterest_id )
			) {
			return true;
		}

		return false;
	}

	function show_social_contact( $user, $phone_direct=false ) {
		if ( ! empty( $user->phone_number ) ) {
			$tel = $user->phone_number;
			$ico = '<div class="social-icon phoneico"></div>';
			if ( $phone_direct ) {
				$this->add_social_li_item( "tel:{$tel}", $ico, $tel, '' );
			} else {
				echo '<li>' . $ico . '<span class="tel" data-replace="' . $tel . '">' .
					__('Click to show', CPSOCIAL_TD ) . '</span></li>';
			}
		}

		if ( ! empty( $user->user_url ) ) {
			$url = strip_tags( $user->user_url );
			$ico = '<div class="social-icon globeico"></div>';
			$text = $url;
			$this->add_social_li_item( $url, $ico, $text );
		}

		if ( ! empty( $user->twitter_id ) ) {
			$url = 'http://twitter.com/' . urlencode( $user->twitter_id );
			$ico = '<div class="social-icon twitterico"></div>';
			$text = __( 'Twitter', CPSOCIAL_TD );
			$this->add_social_li_item( $url, $ico, $text );
		}

		if ( ! empty( $user->facebook_id ) ) {
			$url = appthemes_make_fb_profile_url( $user->facebook_id );
			$ico = '<div class="social-icon facebookico"></div>';
			$text = __( 'Facebook', CPSOCIAL_TD );
			$this->add_social_li_item( $url, $ico, $text );
		}

		if ( ! empty( $user->google_plus_id ) ) {
			$url = $this->make_gplus_profile_url( $user->google_plus_id );
			$ico = '<div class="social-icon googleplusico"></div>';
			$text = __( 'Google Plus', CPSOCIAL_TD );
			$this->add_social_li_item( $url, $ico, $text );
		}

		if ( ! empty( $user->pinterest_id ) ) {
			$url = 'http://www.pinterest.com/' . urlencode( $user->pinterest_id );
			$ico = '<div class="social-icon pinterestico"></div>';
			$text = __( 'Pinterest', CPSOCIAL_TD );
			$this->add_social_li_item( $url, $ico, $text );
		}
	}

	/**
	 * Show social links in ad details
	 */
	function ad_details_show_social( $results, $post, $location ) {
		$aid = $post->post_author;
		$user = get_userdata( $aid );

		if ( 'list' == $location ) {
			$this->show_social_contact( $user );
		}
	}

	function is_singular_ad() {
		return defined( 'APP_POST_TYPE' ) && is_singular( APP_POST_TYPE );
	}

	function ad_content_show_social() {
		global $post;

		if ( ! $this->is_singular_ad() ) {
			return;
		}

		$aid = $post->post_author;
		$user = get_userdata( $aid );

		if ( ! $this->has_social_contact( $user ) ) {
			return;
		}

		echo '<div class="pad5" style="clear: both;"></div>';
		echo '<div><h3 class="description-area">' . __( 'Contact Information', CPSOCIAL_TD ) . '</h3><br>';
		echo '<ul class="contact-info">';
		$this->show_social_contact( $user );
		echo '</ul></div>';
		echo '<div class="pad5" style="clear: both;"></div>';
	}

	function author_info_show_social( $location ) {
		$curauth = get_queried_object();
		$user = get_userdata( $curauth->ID );

		if ( 'page' == $location ) {
			echo '<ul class="author-info">';
			$user2 = clone $user;
			// Remove fields already displayed by ClassiPress.
			$user2->facebook_id = '';
			$user2->twitter_id = '';
			$user2->user_url = '';
			$this->show_social_contact( $user2 );
			echo '</ul>';
		}
	}

	function make_gplus_profile_url( $id, $context = 'display' ) {

		$base_url = 'http://plus.google.com/';

		if ( empty( $id ) ) {
			$url = $base_url;
		} elseif ( is_numeric( $id ) ) {
			$url = $base_url . $id;
		} elseif ( preg_match( '/^(http|https):\/\/(.*?)$/i', $id ) ) {
			$url = $id;
		} else {
			$url = $base_url . '+' . $id;
		}

		return esc_url( $url, null, $context );
	}

	function admin_page() {
		$title = __( 'Ad Social Settings', CPSOCIAL_TD );
		$slug = 'cp-ad-social';
		add_submenu_page(
			'app-dashboard',
			$title,
			$title,
			'manage_options',
			$slug,
			array( $this, 'show_options_page' )
		);
	}

	function show_options_page() {
		settings_errors();
		?>
		<div class="wrap">
			<h2><?php _e( 'Ad Social', CPSOCIAL_TD ); ?></h2>
			<form action="options.php" method="post">
			<?php
				settings_fields( $this->options_group );
				do_settings_sections( $this->options_page );
				submit_button();
			?>
			</form>
		</div>
		<?php
	}

	function admin_menu() {
		register_setting( $this->options_group, $this->options_group );
		$section = 'cp-social';
		add_settings_section( $section,
							  __( 'Ad Social Settings', CPSOCIAL_TD ),
							  false,
							  $this->options_page );

		$fields = array(
			'show_in_ad_details' => array(
				'title' => __( 'Show in ad details', CPSOCIAL_TD ),
				'extra' => array(
					'type' => 'checkbox'
				)
			),
			'show_after_ad_content' => array(
				'title' => __( 'Show after ad content', CPSOCIAL_TD ),
				'extra' => array(
					'type' => 'checkbox'
				)
			)
		);

		foreach ( $fields as $field => $meta ) {
			$args = array_merge( array( 'label_for' => $field ), $meta['extra'] );
			add_settings_field( $field,
								$meta['title'],
								array( $this, 'show_field' ),
								$this->options_page,
								$section,
								$args
			);
		}
	}

	function show_field( $args ) {
		$id = $args['label_for'];
		$val = $this->get_option( $id );
		$type = empty( $args['type'] ) ? 'text' : $args['type'];
		$extra = empty( $args['extra'] ) ? '' : $args['extra'];

		if ( $type == 'checkbox' || $type == 'radio' ) {
			$checked = checked( 1, $val, false );
			$val = 1;
		} else {
			$checked = '';
		}

		if ( $type == 'checkbox' ) {
			echo '<input name="' . "{$this->options_group}[{$id}]" . '" type="hidden" value="0">';
		}

		echo '<input id="' . $id . '" name="' . "{$this->options_group}[{$id}]" . '" type="' . $type
			. '" value="' . esc_attr( $val ) . '" ' . $checked . ' ' . $extra . '>';

		if ( ! empty( $args['description'] ) ) {
			echo '<p class="description">' . $args['description'] . '</p>';
		}
	}

	function get_option( $opt ) {
		$options = get_option( $this->options_group );

		if ( isset( $options[ $opt ] ) ) {
			$val = $options[ $opt ];
		} else if ( isset( $this->default_options[ $opt ] ) ) {
			$val = $this->default_options[ $opt ];
		} else {
			$val = '';
		}

		return $val;
	}
}


new CP_Ad_Social_Plugin;