<?php

/**
 * Add actions related to Cleanup.
 *
 * @package astra-child-theme
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPGenius_cleanup_action' ) ) {
	class WPGenius_cleanup_action {
		public static $instance;

		public static function init() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new WPGenius_cleanup_action();
			}
			return self::$instance;
		}

		private function __construct() {

			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			/**
			 * Disable Gutenberg on the back end.
			 */
			add_filter( 'use_block_editor_for_post', '__return_false' );

			/**
			 * Disable Gutenberg for widgets.
			 */
			add_filter( 'use_widgets_block_editor', '__return_false' );

			add_action( 'wp_dashboard_setup', array( $this, 'remove_unwanted_widgets' ), 9999 );

		}

		/**
		 * Remove Gutenberg Block Library CSS from loading on the frontend
		 *
		 * @return void
		 */
		public function enqueue_scripts() {
			wp_dequeue_style( 'wp-block-library' );
			wp_dequeue_style( 'bp-member-block' );
			wp_dequeue_style( 'wp-block-library-theme' );
			wp_dequeue_style( 'wc-block-style' );
			wp_dequeue_style( 'wc-blocks-vendors-style' );
			wp_deregister_style( 'wc-block-editor' );
			wp_deregister_style( 'wc-blocks-style' );
		}

		/**
		 * Remove unwanted widgets from dashboard
		 *
		 * @return void
		 */
		public function remove_unwanted_widgets() {
			global $wp_meta_boxes;
			$wp_meta_boxes['dashboard']['normal']['core'] = array();
			$wp_meta_boxes['dashboard']['side']['core']   = array();
			$wp_meta_boxes['dashboard']['normal']['high'] = array();
		}
	}
	WPGenius_cleanup_action::init();
}


