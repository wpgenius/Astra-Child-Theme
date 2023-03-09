<?php
/**
 * Theme shortcodes
 *
 * @package astra-child-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPGenius_Shortcodes' ) ) {

	/**
	 * Shortcodes from theme.
	 * Write all shortcodes under class
	 */
	class WPGenius_Shortcodes {
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
				self::$instance = new WPGenius_Shortcodes();
			}
			return self::$instance;
		}

		/**
		 * Class constructor
		 */
		private function __construct() {
			// add_shortcode( 'sample_shortcode', array( $this, 'sample_callback' ) );
		}

		/**
		 * Sample shortcode code template
		 *
		 * @param array  $atts
		 * @param string $content
		 * @return string
		 */
		public function sample_callback( $atts, $content = '' ) {
			$atts = shortcode_atts(
				array(
					'title' => false,
					'limit' => 4,
				),
				$atts
			);

			ob_start();

			// include template with the arguments (The $args parameter was added in v5.5.0)
			get_template_part( 'templates/sample-template', 'single-template-name', $atts );

			return ob_get_clean();
		}

	}
	WPGenius_Shortcodes::init();

}
