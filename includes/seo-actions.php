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
			if( DISABLE_ATTACHMENT_PAGES )
				add_action( 'template_redirect', array( $this, 'disable_attachment_pages' ), 1 );
			
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
	}
	WPGenius_seo_actions::init();
	
}
