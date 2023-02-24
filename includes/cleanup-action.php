<?php
/**
 * Cleanup actions for every project
 *
 * @package astra-child-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPGenius_cleanup_actions' ) ) {

	/**
	 * Clean unwanted, unnecessory code from WordPress, Plugins or theme
	 */
	class WPGenius_cleanup_actions {
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
				self::$instance = new WPGenius_cleanup_actions();
			}
			return self::$instance;
		}

		/**
		 * Class constructor
		 */
		private function __construct() {

			/**
			 * Remove unwanted JS & CSS from front end
			 * - Gutenberg
			 */
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			
			/**
			 * Remove all dashboard widgets from admin panel
			 */
			add_action( 'wp_dashboard_setup', array( $this, 'remove_dashboard_widgets' ), 9999 );
			add_action( 'admin_init', array( $this, 'remove_welcome_panel' ), 9999 );

			/**
			 * Remove Slider Revolution Meta Generator Tag
			 */
			add_filter( 'revslider_meta_generator', '__return_empty_string' );

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
		public function remove_dashboard_widgets() {
			global $wp_meta_boxes;
			$wp_meta_boxes['dashboard']['normal']['core'] = array();
			$wp_meta_boxes['dashboard']['side']['core']   = array();
			$wp_meta_boxes['dashboard']['normal']['high'] = array();
		}

		/**
		 * Remove Dashboard Welcome Panel
		 *
		 * @return void
		 */
		public function remove_welcome_panel() {
			remove_action( 'welcome_panel', 'wp_welcome_panel' );
		}
	}
	WPGenius_cleanup_actions::init();
}
