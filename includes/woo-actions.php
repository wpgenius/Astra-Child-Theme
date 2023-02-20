<?php
/**
 * Add actions related to Woocommerce.
 *
 * @package astra-child-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WPGenius_woo_action' ) ) {
	return;
}

class WPGenius_woo_action {
	public static $instance;

	public static function init() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new WPGenius_woo_action();
		}
		return self::$instance;
	}

	private function __construct() {
		// Add hooks here
	}
}
WPGenius_woo_action::init();
