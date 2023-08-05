<?php
/**
 * Woocommerce actions from child theme
 *
 * @package forestsecrets
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPGenius_woo_actions' ) && class_exists( 'WooCommerce' ) ) {

	/**
	 * WooCommerce hooks
	 */
	class WPGenius_woo_actions {
		/**
		 * instance of class
		 *
		 * @var object
		 */
		protected static $instance;

		/**
		 * Initialise class
		 *
		 * @return void
		 */
		public static function init() {

			if ( is_null( self::$instance ) ) {
				self::$instance = new WPGenius_woo_actions();
			}
			return self::$instance;
		}

		/**
		 * Class constructor
		 */
		private function __construct() {
			add_filter( 'gettext', array( $this, 'woo_email' ), 10, 3 );
			// Add hooks here
		}

		/**
		 * Rename VAT to GST in Woocommerce emails and checkout page
		 *
		 * @param array $translation
		 * @param array $text
		 * @param array $domain
		 * @return void
		 */
		function woo_email( $translation, $text, $domain ) {
			if ( $domain == 'woocommerce' ) {
				if ( $text == 'VAT' ) {
					$translation = 'GST'; }
			}
			return $translation;
		}
	}
	WPGenius_woo_actions::init();
}
