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
			add_filter( 'woocommerce_package_rates', array( $this, 'hide_shipping_when_free_is_available' ), 100 );
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

		/**
		 * Hide shipping rates when free shipping is available.
		 * Updated to support WooCommerce 2.6 Shipping Zones.
		 *
		 * @param array $rates Array of rates found for the package.
		 * @return array
		 */
		function hide_shipping_when_free_is_available( $rates ) {
			$free = array();
			foreach ( $rates as $rate_id => $rate ) {
				if ( 'free_shipping' === $rate->method_id ) {
					$free[ $rate_id ] = $rate;
					break;
				}
			}
			return ! empty( $free ) ? $free : $rates;
		}
	}
	WPGenius_woo_actions::init();
}
