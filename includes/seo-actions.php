<?php
/**
 * SEO actions.
 *
 * @package astra-child-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPGenius_seo_actions' ) ) {
	
	/**
	 * SEO actions needed for every project
	 */
	class WPGenius_seo_actions {
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
				self::$instance = new WPGenius_seo_actions();
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
	WPGenius_seo_actions::init();
	
}
