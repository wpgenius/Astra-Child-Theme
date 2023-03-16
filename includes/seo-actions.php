<?php
/**
 * SEO actions.
 *
 * @package astra-child-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPGenius_seo_actions' ) ) {

	/**
	 * SEO actions needed for every project
	 */
	class WPGenius_seo_actions {
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
				self::$instance = new WPGenius_seo_actions();
			}
			return self::$instance;
		}

		/**
		 * Class constructor
		 */
		private function __construct() {

			/**
			 * Disable Attachment Pages
			 */
			if ( DISABLE_ATTACHMENT_PAGES ) {
				add_action( 'template_redirect', array( $this, 'disable_attachment_pages' ), 1 );
			}

			/**
			 * Remove Query Strings From Static Files
			 */
			if ( ( !defined( WP_ENVIRONMENT_TYPE ) || WP_ENVIRONMENT_TYPE === 'production' ) && REMOVE_QUERY_STRINGS ) {
				add_action( 'init', array( $this, 'remove_query_strings' ) );
			}

		}

		/**
		 * Disable Attachment Pages
		 *
		 * @return void
		 */
		public function disable_attachment_pages() {
			global $post;
			if ( ! is_attachment() || ! isset( $post->post_parent ) || ! is_numeric( $post->post_parent ) ) {
				return;
			}

			// Does the attachment have a parent post?
			// If the post is trashed, fallback to redirect to homepage.
			if ( 0 !== $post->post_parent && 'trash' !== get_post_status( $post->post_parent ) ) {
				// Redirect to the attachment parent.
				wp_safe_redirect( get_permalink( $post->post_parent ), 301 );
			} else {
				// For attachment without a parent redirect to homepage.
				wp_safe_redirect( get_bloginfo( 'wpurl' ), 302 );
			}
			exit;
		}

		/**
		 * Add filter to remove Query Strings From Static Files
		 *
		 * @return void
		 */
		public function remove_query_strings() {
			if ( ! is_admin() ) {
				add_filter( 'script_loader_src', array( $this, 'remove_query_strings_split' ), 15 );
				add_filter( 'style_loader_src', array( $this, 'remove_query_strings_split' ), 15 );
			}
		}

		/**
		 * Split Query Strings From urls
		 *
		 * @param string $src
		 * @return string
		 */
		public function remove_query_strings_split( $src ) {
			$output = preg_split( '/(&ver|\?ver)/', $src );

			return $output ? $output[0] : '';
		}

	}
	WPGenius_seo_actions::init();

}
