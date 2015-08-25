<?php
/**
 * Helper Functions
 *
 * @package     EDD\Clear Cart\Functions
 * @since       1.0.0
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;


/**
 * Add Clear Cart link to the checkout cart.
 *
 * @since       1.0.0
 */
function eddcc_clear_cart_link() {
	if ( class_exists( 'Easy_Digital_Downloads' ) && !edd_get_option( 'edd_clear_cart' ) ) {
		$cc_link           = add_query_arg( 'edd_action', 'empty_cart' );
		$cc_text           = edd_get_option( 'edd_clear_cart_text' );
		$cc_link_type      = edd_get_option( 'edd_clear_cart_link_type' );
		$color             = edd_get_option( 'checkout_color', 'blue' );
		$color             = ( $color == 'inherit' ) ? '' : $color;
		?>
		<a href="<?php echo esc_url( $cc_link ); ?>" class="edd-clear-cart-button <?php echo 'text' == $cc_link_type ? '' : 'edd-submit button ' . $color; ?>" style="<?php echo 'text' == $cc_link_type ? 'font-size: inherit; font-weight: 400; margin-right: 4px;' : 'text-decoration: none;'; ?>"><?php if ( false === $cc_text ) { _e( 'Clear Cart', 'edd-clear-cart' ); } elseif ( !empty( $cc_text ) ) { echo $cc_text; } ?></a>
		<?php
	}
}
add_action( 'edd_cart_footer_buttons', 'eddcc_clear_cart_link' );


/**
 * Clear the cart.
 *
 * @since       1.0.0
 */
function eddcc_process_clear_cart() {

	// Remove cart contents
	EDD()->session->set( 'edd_cart', NULL );

	// Remove all cart fees
	EDD()->session->set( 'edd_cart_fees', NULL );

	// Remove any active discounts
	edd_unset_all_cart_discounts();

	// Redirect after a job well done
	$cc_redirect_page = edd_get_option( 'edd_clear_cart_page' );
	$cc_redirect = $cc_redirect_page ? get_permalink( $cc_redirect_page ) : home_url( '/' . strtolower( edd_get_label_plural() ) ) ;
	wp_redirect( $cc_redirect ); exit;
}
add_action( 'edd_empty_cart', 'eddcc_process_clear_cart' );