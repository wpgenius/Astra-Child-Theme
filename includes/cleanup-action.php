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

			/**
			 * Disable the emojis in WordPress.
			 */
			if ( DISABLE_EMOJI )
				add_action( 'init', array( $this, 'disable_emoji' ) );

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

		/**
		 * Disable the emojis in WordPress.
		 *
		 * @return void
		 */
		public function disable_emoji() {
			remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
			remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
			remove_action( 'wp_print_styles', 'print_emoji_styles' );
			remove_action( 'admin_print_styles', 'print_emoji_styles' );
			remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
			remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
			remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
			add_filter( 'tiny_mce_plugins', array( $this, 'disable_emoji_from_tinymce' ) );
			add_filter( 'wp_resource_hints', array( $this, 'disable_emoji_from_prefetch' ), 10, 2 );
		}

		/**
		 * Remove from TinyMCE.
		 *
		 * @param array $plugins
		 * @return array
		 */
		public function disable_emoji_from_tinymce( $plugins ) {
			if ( is_array( $plugins ) ) {
				return array_diff( $plugins, array( 'wpemoji' ) );
			} else {
				return array();
			}
		}

		/**
		 * Remove from dns-prefetch.
		 *
		 * @param string $urls
		 * @param array $relation_type
		 * @return array
		 */
		public function disable_emoji_from_prefetch( $urls, $relation_type ) {
			if ( 'dns-prefetch' === $relation_type ) {
				$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );
				$urls          = array_diff( $urls, array( $emoji_svg_url ) );
			}
	
			return $urls;
		}

	}
	WPGenius_cleanup_actions::init();
}
