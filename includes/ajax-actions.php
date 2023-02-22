<?php
/**
 * AJAX actions.
 *
 * @package astra-child-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPGenius_ajax_actions' ) ) {
	
	/**
	 * Class for AJAX hooks
	 */
	class WPGenius_ajax_actions {
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
				self::$instance = new WPGenius_ajax_actions();
			}
			return self::$instance;
		}
	
		/**
		 * Class constructor
		 */
		private function __construct() {
			// Enter hooks here
		}
	}
	WPGenius_ajax_actions::init();
	
}
