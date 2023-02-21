<?php
/**
 * User actions.
 *
 * @package astra-child-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPGenius_user_action' ) ) {
	
	/**
	 * User actions for each class
	 */
	class WPGenius_user_action {
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
				self::$instance = new WPGenius_user_action();
			}
			return self::$instance;
		}
		
		/**
		 * Class constructor
		 */
		private function __construct() {
			add_filter( 'wp_is_application_passwords_available', '__return_false' );
		}
	}
	WPGenius_user_action::init();
	
}
