<?php
/**
 * User actions.
 *
 * @package astra-child-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPGenius_user_actions' ) ) {

	/**
	 * User actions for each class
	 */
	class WPGenius_user_actions {
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
				self::$instance = new WPGenius_user_actions();
			}
			return self::$instance;
		}

		/**
		 * Class constructor
		 */
		private function __construct() {

			/**
			 * Remove application password settings from user profile
			 */
			add_filter( 'wp_is_application_passwords_available', '__return_false' );

			/**
			 * Remove Login Shake Animation
			 */
			if ( !defined( WP_ENVIRONMENT_TYPE ) || WP_ENVIRONMENT_TYPE === 'production' ) {
				add_action( 'login_footer', array( $this, 'remove_shake_js' ) );
				add_filter( 'login_errors', array( $this, 'hide_login_error' ) );
			}

		}

		/**
		 * Remove Login Shake Animation
		 *
		 * @return void
		 */
		public function remove_shake_js() {
			remove_action( 'login_footer', 'wp_shake_js', 12 );
		}

		/**
		 * Hide Login Errors in WordPress. Add custom login error message
		 *
		 * @param string $error
		 * @return string
		 */
		public function hide_login_error( $error ) {
			// Edit the line below to customize the message.
			return __( 'Something is wrong!', 'astra-child-theme' );
		}

	}
	WPGenius_user_actions::init();

}
