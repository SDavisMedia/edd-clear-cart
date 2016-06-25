<?php
/**
* Register Clear Cart settings section
*
* @return array
 * @since       1.0.1
*/
function eddcc_clear_cart_settings_section( $sections ) {
	$sections['eddcc-settings'] = __( 'Clear Cart', 'edd-clear-cart' );
	return $sections;
}
add_filter( 'edd_settings_sections_extensions', 'eddcc_clear_cart_settings_section' );


/**
 * Settings
 *
 * @package     EDD\Clear Cart\Settings
 * @since       1.0.0
 */
function eddcc_clear_cart_settings( $settings ) {
	$clear_cart_settings = array(
		array(
			'id'   => 'edd_clear_cart_settings',
			'name' => '<strong>' . __( 'Clear Cart Settings', 'edd-clear-cart' ) . '</strong>',
			'desc' => __( 'Configure Clear Cart Settings', 'edd-clear-cart' ),
			'type' => 'header',
		),
		array(
			'id'   => 'edd_clear_cart',
			'name' => __( 'Disable Clear Cart', 'edd-clear-cart' ),
			'desc' => __( 'Disable the Clear Cart link.', 'edd-clear-cart' ),
			'type' => 'checkbox',
			'size' => 'regular',
		),
		array(
			'id'          => 'edd_clear_cart_page',
			'name'        => __( 'Clear Cart URL', 'edd-clear-cart' ),
			'desc'        => __( 'Redirect to this page once the cart is cleared. If left blank, your default product archives will be used.', 'edd-clear-cart' ),
			'type'        => 'select',
			'options'     => edd_get_pages(),
			'placeholder' => __( 'Select a page', 'edd-clear-cart' )
		),
		array(
			'id'   => 'edd_clear_cart_text',
			'name' => __( 'Clear Cart Button Text', 'edd-clear-cart' ),
			'desc' => __( 'This text will show on the Clear Cart link. If left blank, \'Clear Cart\' will display.', 'edd-clear-cart' ),
			'type' => 'text',
			'size' => 'regular',
			'std'  => __( 'Clear Cart', 'edd-clear-cart' ),
		),
		array(
			'id'          => 'edd_clear_cart_link_type',
			'name'        => __( 'Clear Cart Link Type', 'edd-clear-cart' ),
			'desc'        => __( 'Should the link inherit EDD\'s button styles or display as a text link?', 'edd-clear-cart' ),
			'type'        => 'select',
			'options'     => array(
				'button'  => __( 'Button Link', 'edd-clear-cart' ),
				'text'    => __( 'Text Link', 'edd-clear-cart' ),
			),
		),
	);
	if ( version_compare( EDD_VERSION, 2.5, '>=' ) ) {
		$clear_cart_settings = array( 'eddcc-settings' => $clear_cart_settings );
	}
	return array_merge( $settings, $clear_cart_settings );
}
add_filter( 'edd_settings_extensions', 'eddcc_clear_cart_settings', 999, 1 );