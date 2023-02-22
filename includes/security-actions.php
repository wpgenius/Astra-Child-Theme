<?php
/**
 * Security actions
 *
 * @package astra-child-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPGenius_security_actions' ) ) {

	/**
	 * Security measurements for each project
	 */
	class WPGenius_security_actions {
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
				self::$instance = new WPGenius_security_actions();
			}
			return self::$instance;
		}

		/**
		 * Class constructor
		 */
		private function __construct() {			
			/**
			 * Remove WordPress Meta Generator Tag
			 */
			remove_action('wp_head', 'wp_generator');

			/**
			 * Disable XMLRPC
			 */
			add_filter('xmlrpc_enabled', '__return_false');

			/**
			 * Remove link to the Really Simple Discovery service endpoint.
			 */
			remove_action( 'wp_head', 'rsd_link' );

			/**
			 * Disable wlwmanifest link
			 */
			remove_action('wp_head', 'wlwmanifest_link');

		}
	}
	WPGenius_security_actions::init();
}
