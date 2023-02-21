<?php
/**
 * Add actions related to wp users.
 *
 * @package astra-child-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPGenius_user_action' ) ) {
	
	class WPGenius_user_action {
		public static $instance;
	
		public static function init() {
	
			if ( is_null( self::$instance ) ) {
				self::$instance = new WPGenius_user_action();
			}
			return self::$instance;
		}
	
		private function __construct() {
			add_filter( 'wp_is_application_passwords_available', '__return_false' );
		}
	}
	WPGenius_user_action::init();
	
}



