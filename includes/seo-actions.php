<?php

/**
 * Add actions related to SEO.
 *
 * @package astra-child-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPGenius_seo_action' ) ) {
	class WPGenius_seo_action {
		public static $instance;
	
		public static function init() {
	
			if ( is_null( self::$instance ) ) {
				self::$instance = new WPGenius_seo_action();
			}
			return self::$instance;
		}
	
		private function __construct() {
			// Enter hooks here
		}
	}
	WPGenius_seo_action::init();
	
}

