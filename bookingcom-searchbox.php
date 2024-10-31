<?php
/**
 * Plugin Name: Search Box Booking.com for WPBakery Page Builder
 * Plugin URI: https://wordpress.org/plugins/search-booking-comfor-wpbakery-page-builder/
 * Description: Create Search Box for Booking.com in WPBakery Page Builder
 * Author: Tomiup
 * Author URI: https://profiles.wordpress.org/tomiup
 * Version: 1.0.2
 * Requires at least: 4.9
 * Tested up to: 5.2
 * License: GPLv2 or later
 *
 * Text Domain: bcsb
 * Domain Path: /languages/
 **/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'BCSB' ) ) {

	class BCSB {

		/**
		 * constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			// We safely integrate with VC with this hook
			add_action( 'init', array( $this, 'integrate_with_wpb' ) );
			add_action( 'init', array( $this, 'load_textdomain' ) );

			// Defined
			if ( ! defined( 'BCSB_PATH' ) ) {
				define( 'BCSB_PATH', plugin_dir_path( __FILE__ ) );
			}
			if ( ! defined( 'BCSB_URL' ) ) {
				define( 'BCSB_URL', plugin_dir_url( __FILE__ ) );
			}
			if ( ! defined( 'BCSB_SC_PATH' ) ) {
				define( 'BCSB_SC_PATH', BCSB_PATH . 'shortcodes/' );
			}
			if ( ! defined( 'BCSB_SC_URL' ) ) {
				define( 'BCSB_SC_URL', BCSB_URL . 'shortcodes/' );
			}


			add_action( 'init', array( $this, 'init' ) );
			add_action( 'init', array( $this, 'register_assets' ) );
			add_action( 'init', array( $this, 'load_shortcodes' ), 30 );

		}

		function load_textdomain() {
			load_plugin_textdomain( 'bcsb', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		}


		public function integrate_with_wpb() {
			// Check if WPB is installed
			if ( ! defined( 'WPB_VC_VERSION' ) ) {
				// Display notice that WPB is required
				add_action( 'admin_notices', array( $this, 'show_wpb_version_notice' ) );

				return;
			}
		}


		/**
		 * Show notice if your plugin is activated but Visual Composer is not
		 */
		public function show_wpb_version_notice() {
			$plugin_data = get_plugin_data( __FILE__ );
			echo '
        <div class="updated">
          <p>' . sprintf( __( '<strong>%s</strong> requires <strong><a href="http://bit.ly/vc-plugin" target="_blank">WPBakery Page Builder</a></strong> plugin to be installed and activated on your site.', 'temport' ), $plugin_data['Name'] ) . '</p>
        </div>';
		}


		/**
		 * Register assets
		 * @author Khoapq
		 */
		public function register_assets() {
			wp_register_style( 'bcsb-main', BCSB_URL . 'assets/css/main.css' );
			wp_register_style( 'bcsb-font', BCSB_URL . 'assets/fonts/bcsb/style.css' );
			wp_register_script( 'bcsb-main', BCSB_URL . 'assets/js/main.js', array( 'jquery-ui-datepicker' ), null, true );
		}

		/**
		 * Register shortcodes.
		 *
		 * @since 1.0.0
		 */
		public function load_shortcodes() {
			include_once( BCSB_SC_PATH . 'searchbox/searchbox.php' );
		}

		/**
		 * Load functions.
		 *
		 * @since 1.0.0
		 */
		public function init() {
			//CUSTOM PARAMS
			vc_add_shortcode_param( 'number', array( $this, 'param_number' ) );
			vc_add_shortcode_param( 'radio_image', array( $this, 'param_radioimage' ) );

			require_once( BCSB_PATH . 'inc/functions.php' );
		}

		/**
		 * Create custom param number
		 *
		 * @param $settings
		 * @param $value
		 *
		 * @since 1.0.0
		 * @return string
		 */
		public function param_number( $settings, $value ) {
			$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
			$type       = isset( $settings['type'] ) ? $settings['type'] : '';
			$min        = isset( $settings['min'] ) ? $settings['min'] : '';
			$max        = isset( $settings['max'] ) ? $settings['max'] : '';
			$suffix     = isset( $settings['suffix'] ) ? $settings['suffix'] : '';
			$class      = isset( $settings['class'] ) ? $settings['class'] : '';
			$output     = '<input type="number" min="' . $min . '" max="' . $max . '" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="' . $value . '" style="height: auto;line-height: 22px;" />' . $suffix;

			return $output;
		}

		/**
		 * Generate param type "radioimage"
		 *
		 * @param $settings
		 * @param $value
		 *
		 * @return string
		 */
		public function param_radioimage( $settings, $value ) {
			$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
			$type       = isset( $settings['type'] ) ? $settings['type'] : '';
			$radios     = isset( $settings['options'] ) ? $settings['options'] : '';
			$class      = isset( $settings['class'] ) ? $settings['class'] : '';
			$output     = '<input type="hidden" name="' . $param_name . '" id="' . $param_name . '" class="wpb_vc_param_value ' . $param_name . ' ' . $type . '_field ' . $class . '" value="' . $value . '" />';
			$output     .= '<div id="' . $param_name . '_wrap" class="icon_style_wrap ' . $class . '" >';
			if ( $radios != '' && is_array( $radios ) ) {
				$i = 0;
				foreach ( $radios as $key => $image_url ) {
					$class   = ( $key == $value ) ? ' class="selected" ' : '';
					$image   = '<img id="' . $param_name . $i . '_img' . $key . '" src="' . $image_url . '" ' . $class . '/>';
					$checked = ( $key == $value ) ? ' checked="checked" ' : '';
					$output  .= '<input name="' . $param_name . '_option" id="' . $param_name . $i . '" value="' . $key . '" type="radio" '
					            . 'onchange="document.getElementById(\'' . $param_name . '\').value=this.value;'
					            . 'jQuery(\'#' . $param_name . '_wrap img\').removeClass(\'selected\');'
					            . 'jQuery(\'#' . $param_name . $i . '_img' . $key . '\').addClass(\'selected\');'
					            . 'jQuery(\'#' . $param_name . '\').trigger(\'change\');" '
					            . $checked . ' style="display:none;" />';
					$output  .= '<label for="' . $param_name . $i . '">' . $image . '</label>';
					$i ++;
				}
			}
			$output .= '</div>';

			return $output;
		}
	}

	$BCSB = new BCSB();
}