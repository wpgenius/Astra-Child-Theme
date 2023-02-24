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

			/**
			 * 1. Close comments on the front-end
			 * 2. Hide existing comments
			 */
			if ( DISABLE_COMMENTS ) {
				add_filter('comments_open', '__return_false', 20, 2);
				add_filter('comments_array', '__return_empty_array', 10, 2);
			}				

			/**
			 * Disable Comment Form Website URL
			 */
			add_filter( 'comment_form_default_fields', array( $this, 'disable_url_field_comment_form' ), 150 );

			/**
			 * Disable pings on the front end.
			 */
			add_filter('pings_open', '__return_false', 20, 2);

		}

		/**
		 * Unset website URL field from comment form
		 *
		 * @param array $fields
		 * @return array
		 */
		public function disable_url_field_comment_form($fields) {
			if ( isset( $fields['url'] ) ) {
				unset( $fields['url'] );
			}
		
			return $fields;
		}
	}
	WPGenius_security_actions::init();
}
