<?php
/**
 * Admin actions.
 *
 * @package astra-child-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPGenius_admin_actions' ) ) {
	
	/**
	 * Class for Admin hooks
	 */
	class WPGenius_admin_actions {
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
				self::$instance = new WPGenius_admin_actions();
			}
			return self::$instance;
		}
	
		/**
		 * Class constructor
		 */
		private function __construct() {
			
			/**
			 * Disable Gutenberg on the back end.
			 */
			add_filter( 'use_block_editor_for_post', '__return_false' );

			/**
			 * Disable Gutenberg for widgets.
			 */
			add_filter( 'use_widgets_block_editor', '__return_false' );

			/**
			 * Allow SVG uploads
			 */
			if ( ALLOW_SVG ) {
				add_filter( 'upload_mimes', array( $this, 'enable_svg' ) );
				add_filter( 'wp_check_filetype_and_ext', array( $this, 'check_filetype_and_ext' ), 10, 5 );
			}			
			
		}

		/**
		 * Allow SVG uploads for administrator users.
		 *
		 * @param array $upload_mimes Allowed mime types.
		 *
		 * @return mixed
		 */
		public function enable_svg( $upload_mimes ) {
			// By default, only administrator users are allowed to add SVGs.
			// To enable more user types edit or comment the lines below but beware of
			// the security risks if you allow any user to upload SVG files.
			if ( ! current_user_can( 'administrator' ) ) {
				return $upload_mimes;
			}
	
			$upload_mimes['svg']  = 'image/svg+xml';
			$upload_mimes['svgz'] = 'image/svg+xml';
	
			return $upload_mimes;
		}

		/**
		 * Add SVG files mime check.
		 *
		 * @param array        $wp_check_filetype_and_ext Values for the extension, mime type, and corrected filename.
		 * @param string       $file Full path to the file.
		 * @param string       $filename The name of the file (may differ from $file due to $file being in a tmp directory).
		 * @param string[]     $mimes Array of mime types keyed by their file extension regex.
		 * @param string|false $real_mime The actual mime type or false if the type cannot be determined.
		 */
		public function check_filetype_and_ext( $wp_check_filetype_and_ext, $file, $filename, $mimes, $real_mime ) {

			if ( ! $wp_check_filetype_and_ext['type'] ) {
	
				$check_filetype  = wp_check_filetype( $filename, $mimes );
				$ext             = $check_filetype['ext'];
				$type            = $check_filetype['type'];
				$proper_filename = $filename;
	
				if ( $type && 0 === strpos( $type, 'image/' ) && 'svg' !== $ext ) {
					$ext  = false;
					$type = false;
				}
	
				$wp_check_filetype_and_ext = compact( 'ext', 'type', 'proper_filename' );
			}
	
			return $wp_check_filetype_and_ext;
	
		}

	}
	WPGenius_admin_actions::init();
	
}
