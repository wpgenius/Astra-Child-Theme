<?php

/**
 * Add actions related to Security.
 *
 * @package astra-child-theme
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPGenius_security_action' ) ) {
	class WPGenius_security_action {
		public static $instance;
	
		public static function init() {
	
			if ( is_null( self::$instance ) ) {
				self::$instance = new WPGenius_security_action();
			}
			return self::$instance;
		}
	
		private function __construct() {
			// Enter hooks here
		}
	}
	WPGenius_security_action::init();
}


