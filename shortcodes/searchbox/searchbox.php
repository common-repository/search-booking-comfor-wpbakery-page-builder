<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'BCSB_Searchbox' ) ) {
	class BCSB_Searchbox {

		/**
		 * Shortcode name
		 * @var string
		 */
		protected $name = '';

		/**
		 * Shortcode description
		 * @var string
		 */
		protected $description = '';

		/**
		 * Shortcode base
		 * @var string
		 */
		protected $base = '';

		public function __construct() {

			//======================== CONFIG ========================
			$this->name        = esc_attr__( 'Booking.com Search', 'bcsb' );
			$this->description = esc_attr__( 'Display a search box', 'bcsb' );
			$this->base        = 'searchbox';
			//====================== END: CONFIG =====================


			$this->map();
			add_shortcode( 'bcsb-' . $this->base, array( $this, 'shortcode' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'assets' ) );
		}

		/**
		 * Load assets
		 */
		public function assets() {
		}

		/**
		 * vc map shortcode
		 */
		public function map() {
			vc_map( array(
				'name'        => $this->name,
				'base'        => 'bcsb-' . $this->base,
				'category'    => esc_html__( 'Tomiup Shortcodes', 'bcsb' ),
				'description' => $this->description,
				'icon'        => BCSB_SC_URL . $this->base . '/assets/images/icon/icon.png',
				'params'      => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Destination', 'bcsb' ),
						'param_name'  => 'destination',
						'value'       => '',
						'description' => esc_html__( 'You can pre-fill this field with a specific destination ( e.g. Amsterdam )', 'bcsb' ),
					),

					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Title', 'bcsb' ),
						'param_name'  => 'title',
						'value'       => esc_html__( 'Find deals for any season', 'bcsb' ),
						'description' => esc_html__( '( e.g. Find deals for any season)', 'bcsb' ),
					),

					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Sub title', 'bcsb' ),
						'param_name'  => 'subtitle',
						'value'       => esc_html__( 'From cosy country homes to funky city flats', 'bcsb' ),
						'description' => esc_html__( '( e.g. From cosy country homes to funky city flats)', 'bcsb' ),
					),

					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Placeholder Destination', 'bcsb' ),
						'param_name'  => 'placeholder_destination',
						'value'       => esc_html__( 'Where are you going?', 'bcsb' ),
						'description' => esc_html__( '( e.g. Where are you going?)', 'bcsb' ),
						"group"       => esc_attr__( "Design", 'bcsb' ),
					),

					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Placeholder Check-in', 'bcsb' ),
						'param_name'  => 'placeholder_checkin',
						'value'       => esc_html__( 'Checkin', 'bcsb' ),
						'description' => esc_html__( '( e.g. Check-in)', 'bcsb' ),
						"group"       => esc_attr__( "Design", 'bcsb' ),
					),

					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Placeholder Check-out', 'bcsb' ),
						'param_name'  => 'placeholder_checkout',
						'value'       => esc_html__( 'Checkout', 'bcsb' ),
						'description' => esc_html__( '( e.g. Check-out)', 'bcsb' ),
						"group"       => esc_attr__( "Design", 'bcsb' ),
					),

					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Submit button', 'bcsb' ),
						'param_name'  => 'submit',
						'value'       => esc_html__( 'Search', 'bcsb' ),
						'description' => esc_html__( 'Submit button text, eg: Search', 'bcsb' ),
						"group"       => esc_attr__( "Design", 'bcsb' ),
					),

					array(
						"type"       => "dropdown",
						"heading"    => esc_attr__( "Layout", 'bcsb' ),
						"param_name" => "layout",
						"value"      => array(
							esc_attr__( "Horizontal", 'bcsb' ) => 'horizontal',
							esc_attr__( "Vertical", 'bcsb' )   => 'vertical',
						),
						'std'        => 'horizontal',
						"group"      => esc_attr__( "Design", 'bcsb' ),
					),

					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Your affiliate ID', 'bcsb' ),
						'param_name'  => 'aid',
						'value'       => '',
						'group'       => esc_html__( 'Affiliate', 'bcsb' ),
						'description' => esc_html__( 'Your affiliate ID is a unique number that allows Booking.com to track commission. ', 'bcsb' ),
					),

					// Extra class
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class', 'bcsb' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'Add extra class name that will be applied to the icon box, and you can use this class for your customizations.', 'bcsb' ),
					),

				)
			) );
		}

		/**
		 * Add shortcode
		 *
		 * @param $atts
		 */
		public function shortcode( $atts, $content = null ) {
			$params = shortcode_atts( array(
				'aid'                     => '',
				'destination'             => '',
				'title'                   => esc_html__( 'Find deals for any season', 'bcsb' ),
				'subtitle'                => esc_html__( 'From cosy country homes to funky city flats', 'bcsb' ),
				'placeholder_destination' => esc_html__( 'Where are you going?', 'bcsb' ),
				'placeholder_checkin'     => esc_html__( 'Checkin', 'bcsb' ),
				'placeholder_checkout'    => esc_html__( 'Checkout', 'bcsb' ),
				'layout'                  => 'horizontal',
				'submit'                  => esc_html__( 'Search', 'bcsb' ),
				'el_class'                => '',
			), $atts );

			$params['content'] = wpb_js_remove_wpautop( $content, false ); // fix unclosed/unwanted paragraph tags in $content

			ob_start();
			bcsb_get_template( 'default', array( 'params' => $params ), $this->base . '/tpl/' );
			$html = ob_get_contents();
			ob_end_clean();

			return $html;

		}

	}

	new BCSB_Searchbox();
}