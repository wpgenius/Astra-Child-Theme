<?php

/**
 * Add actions related to Theme.
 *
 * @package astra-child-theme
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WPGenius_theme_action' ) ) {
	return;
}

class WPGenius_theme_action {
	public static $instance;

	public static function init() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new WPGenius_theme_action();
		}
		return self::$instance;
	}

	private function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enque_scripts' ) );
	}

	public function my_theme_enqueue_styles() {
		wp_enqueue_style( 'astra-child-theme', get_stylesheet_uri(), array( 'astra-theme-css' ), wp_get_theme()->get( 'Version' ) );
	}
}
WPGenius_theme_action::init();

/**
 * Disable Gutenberg on the back end.
 */
add_filter( 'use_block_editor_for_post', '__return_false' );

/**
 * Disable Gutenberg for widgets.
 */
add_filter( 'use_widgets_block_editor', '__return_false' );
