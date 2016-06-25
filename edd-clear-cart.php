<?php
/*
 * Plugin Name: Easy Digital Downloads - Clear Cart
 * Plugin URI: https://wordpress.org/plugins/easy-digital-downloads-clear-cart/
 * Description: Adds a Clear Cart link to the Easy Digital Downloads checkout cart.
 * Version: 1.0.1
 * Author: Sean Davis
 * Author URI: http://sdavismedia.com
 * Text Domain: edd-clear-cart
 * Domain Path: /languages/
 *
 * @package         EDD\Clear Cart
 * @author          Sean Davis
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'EDD_Clear_Cart' ) ) {

	/**
	 * Main plugin class
	 *
	 * @since 1.0.0
	 */
	class EDD_Clear_Cart {

		/**
		 * @var         EDD_Clear_Cart $instance The one true EDD_Clear_Cart
		 * @since       1.0.0
		 */
		private static $instance;

		/**
		 * Get active instance
		 *
		 * @access      public
		 * @since       1.0.0
		 * @return      object self::$instance The one true EDD_Clear_Cart
		 */
		public static function instance() {
			if ( !self::$instance ) {
				self::$instance = new EDD_Clear_Cart();
				self::$instance->setup_constants();
				self::$instance->includes();
				self::$instance->load_textdomain();
			}
			return self::$instance;
		}

		/**
		 * Setup plugin constants
		 *
		 * @access      private
		 * @since       1.0.0
		 * @return      void
		 */
		private function setup_constants() {

			// Plugin version
			define( 'EDD_CLEAR_CART_VER', '1.0.1' );

			// Plugin path
			define( 'EDD_CLEAR_CART_DIR', plugin_dir_path( __FILE__ ) );

			// Plugin URL
			define( 'EDD_CLEAR_CART_URL', plugin_dir_url( __FILE__ ) );
		}

		/**
		 * Include necessary files
		 *
		 * @access      private
		 * @since       1.0.0
		 * @return      void
		 */
		private function includes() {

			// Include functions
			require_once EDD_CLEAR_CART_DIR . 'includes/functions.php';
			if ( is_admin() ) {
				require_once EDD_CLEAR_CART_DIR . 'includes/settings.php';
			}
		}

		/**
		 * Internationalization
		 *
		 * @access      public
		 * @since       1.0.0
		 * @return      void
		 */
		public function load_textdomain() {

			// Set filter for language directory
			$lang_dir = EDD_CLEAR_CART_DIR . '/languages/';
			$lang_dir = apply_filters( 'edd_clear_cart_languages_directory', $lang_dir );

			// Traditional WordPress plugin locale filter
			$locale = apply_filters( 'plugin_locale', get_locale(), 'edd-clear-cart' );
			$mofile = sprintf( '%1$s-%2$s.mo', 'edd-clear-cart', $locale );

			// Setup paths to current locale file
			$mofile_local   = $lang_dir . $mofile;
			$mofile_global  = WP_LANG_DIR . '/edd-clear-cart/' . $mofile;

			if ( file_exists( $mofile_global ) ) {

				// Look in global /wp-content/languages/edd-clear-cart/ folder
				load_textdomain( 'edd-clear-cart', $mofile_global );
			} elseif ( file_exists( $mofile_local ) ) {

				// Look in local /wp-content/plugins/edd-clear-cart/languages/ folder
				load_textdomain( 'edd-clear-cart', $mofile_local );
			} else {

				// Load the default language files
				load_plugin_textdomain( 'edd-clear-cart', false, $lang_dir );
			}
		}
	}
}

/**
 * The main function responsible for returning the one true EDD_Clear_Cart
 * instance to functions everywhere
 *
 * @since       1.0.0
 * @return      \EDD_Clear_Cart The one true EDD_Clear_Cart
 */
function EDD_Clear_Cart_load() {
	if ( !class_exists( 'Easy_Digital_Downloads' ) ) {
		if ( !class_exists( 'EDD_Clear_Cart_Activation' ) ) {
			require_once 'includes/class.edd-clear-cart-activation.php';
		}
		$activation = new EDD_Clear_Cart_Activation( plugin_dir_path( __FILE__ ), basename( __FILE__ ) );
		$activation = $activation->run();
		return EDD_Clear_Cart::instance();
	} else {
		return EDD_Clear_Cart::instance();
	}
}
add_action( 'plugins_loaded', 'EDD_Clear_Cart_load' );