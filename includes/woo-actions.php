<?php
/**
 * Woocommerce actions from child theme
 *
 * @package astra-child-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPGenius_woo_actions' ) ) {
	
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
			// Add hooks here
		}
	}
	WPGenius_woo_actions::init();
}
