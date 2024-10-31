<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get template.
 *
 * Search for the template and include the file.
 *
 * @since 1.0.0
 *
 * @see   wcpt_locate_template()
 *
 * @param string $template_name Template to load.
 * @param array $args Args passed for the template file.
 * @param string $string $template_path    Path to templates.
 * @param string $default_path Default path to template files.
 */
if ( ! function_exists( 'bcsb_get_template' ) ) {
	function bcsb_get_template( $template_name, $args = array(), $tempate_path = '', $default_path = '' ) {
		if ( is_array( $args ) && isset( $args ) ) :
			extract( $args );
		endif;

		$template_name = $template_name . '.php';
		$posts         = isset( $args['posts'] ) ? $args['posts'] : array();
		$params        = isset( $args['params'] ) ? $args['params'] : array();

		$template_file = bcsb_locate_template( $template_name, $tempate_path, $default_path );

		if ( ! file_exists( $template_file ) ) :
			_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $template_file ), '1.0.0' );

			return;
		endif;

		include $template_file;
	}
}

/**
 * Locate template.
 *
 * Locate the called template.
 * Search Order:
 * 1. /themes/theme/woocommerce-plugin-templates/$template_name
 * 2. /themes/theme/$template_name
 * 3. /plugins/woocommerce-plugin-templates/templates/$template_name.
 *
 * @since 1.0.0
 *
 * @param    string $template_name Template to load.
 * @param    string $string $template_path    Path to templates.
 * @param    string $default_path Default path to template files.
 *
 * @return    string                            Path to the template file.
 */
if ( ! function_exists( 'bcsb_locate_template' ) ) {
	function bcsb_locate_template( $template_name, $template_path = '', $default_path = '' ) {
		// Set variable to search in woocommerce-plugin-templates folder of theme.
		if ( ! $template_path ) :
			$template_path = 'templates/';
		endif;

		// Set default plugin templates path.
		if ( ! $default_path ) :
			$default_path = BCSB_SC_PATH . $template_path; // Path to the template folder
		endif;

		// Search template file in theme folder.
		$template = locate_template( array(
			$template_path . $template_name,
			$template_name
		) );

		// Get plugins template file.
		if ( ! $template ) :
			$template = $default_path . $template_name;
		endif;

		return apply_filters( 'bcsb_locate_template', $template, $template_name, $template_path, $default_path );
	}
}