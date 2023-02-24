<?php
/**
 * Admin actions.
 *
 * @package astra-child-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPGenius_admin_actions' ) ) {
	
	/**
	 * Class for Admin hooks
	 */
	class WPGenius_admin_actions {
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
				self::$instance = new WPGenius_admin_actions();
			}
			return self::$instance;
		}
	
		/**
		 * Class constructor
		 */
		private function __construct() {
			
			/**
			 * Disable Gutenberg on the back end.
			 */
			add_filter( 'use_block_editor_for_post', '__return_false' );

			/**
			 * Disable Gutenberg for widgets.
			 */
			add_filter( 'use_widgets_block_editor', '__return_false' );

		}
	}
	WPGenius_admin_actions::init();
	
}
