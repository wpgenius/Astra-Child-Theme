<?php
/**
 * Seperate class to activate UAE module while theme switch or using cli
 *
 * @package astra-child-theme
 */

namespace UltimateElementor\Classes;

use UltimateElementor\Classes\UAEL_Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPGenius_UAEL_Modules' ) ) {

	/**
	 * Write theme configuration functions 
	 */
	class WPGenius_UAEL_Modules {
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
				self::$instance = new WPGenius_UAEL_Modules();
			}
			return self::$instance;
		}

		/**
		 * Class constructor
		 */
		private function __construct() {
            $this->activate_uael_modules();
		}

		/**
		 * Activate uae modules
		 *
		 * @param array  $atts
		 * @param string $content
		 * @return string
		 */
		public function activate_uael_modules() {
			$widgets = UAEL_Helper::get_admin_settings_option( '_uael_widgets', array() );

			$new_widgets = array(
				'Presets'          => 'Presets',
				'Cross_Domain'     => 'Cross_Domain',
				'Modal_Popup'      => 'Modal_Popup',
				'CfStyler'         => 'CfStyler',
				'Fancy_Heading'    => 'Fancy_Heading',
				'Advanced_Heading' => 'Advanced_Heading',
				'Image_Gallery'    => 'Image_Gallery',
			);

			foreach ( $widgets as $slug => $value ) {
				if ( ! isset( $new_widgets[ $slug ] ) ) {
					$new_widgets[ $slug ] = 'disabled';
				}
			}

			$new_widgets = array_map( 'esc_attr', $new_widgets );

			// Update widgets.
			UAEL_Helper::update_admin_settings_option( '_uael_widgets', $new_widgets );
			UAEL_Helper::create_specific_stylesheet();

		}
	}
	WPGenius_UAEL_Modules::init();

}
