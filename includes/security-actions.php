<?php

/**
 * Security actions
 *
 * @package astra-child-theme
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPGenius_security_action' ) ) {

	/**
	 * Security measurements for each project
	 */
	class WPGenius_security_action {
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
				self::$instance = new WPGenius_security_action();
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
		}
	}
	WPGenius_security_action::init();
}
