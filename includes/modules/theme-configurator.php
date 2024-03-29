<?php
/**
 * Theme Configurator execute on theme switch and using wpcli command.
 *
 * @package astra-child-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPGenius_Theme_Configurator' ) ) {

	/**
	 * Write theme configuration functions
	 */
	class WPGenius_Theme_Configurator {
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
				self::$instance = new WPGenius_Theme_Configurator();
			}
			return self::$instance;
		}

		/**
		 * Class constructor
		 */
		private function __construct() {

			add_action( 'after_switch_theme', array( $this, 'activation_hook' ) );

			if ( class_exists( 'WP_CLI' ) ) {
				WP_CLI::add_command( 'easy_setup', array( $this, 'easy_setup_command' ) );
			}
		}

		/**
		 * Register new wp cli command as easy_setup.
		 *
		 * @param array $args
		 * @return void
		 */
		public function easy_setup_command( $args ) {
			$this->activation_hook();
			WP_CLI::success( 'Child theme is ready with initial configuration...' );
		}

		/**
		 * Activate astra addon option While activate child theme.
		 *
		 * @return void
		 */
		function activation_hook() {
			if ( get_option( 'WPG_child_activate' ) != '1' ) {
				update_option( 'WPG_child_activate', '1' );
				$this->activate_astra_modules();
				$this->astra_white_lables();
				$this->uae_white_lables();
				require get_stylesheet_directory() . '/includes/modules/uae-modules.php';
				flush_rewrite_rules();
			}
		}

		/**
		 * Activates required astra addon modules for every project.
		 *
		 * @return void
		 */
		function activate_astra_modules() {
			$enabled_ext = array(
				'colors-and-background' => 'colors-and-background',
				'typography'            => 'typography',
				'spacing'               => 'spacing',
				'site-layouts'          => 'site-layouts',
				'advanced-hooks'        => 'advanced-hooks',
			);
			$extensions  = array_map( 'esc_attr', $enabled_ext );
			Astra_Admin_Helper::update_admin_settings_option( '_astra_ext_enabled_extensions', $extensions );
			Astra_Admin_Helper::update_admin_settings_option( '_astra_ext_http2', true );

			set_transient( 'astra_addon_activated_transient', $extensions );

		}

		/**
		 * Renames white lables when theme switch.
		 *
		 * @return void
		 */
		function astra_white_lables() {
			$white_label_settings = Astra_Ext_White_Label_Markup::get_white_labels();

			$white_label_settings['astra-agency']['author']     = __( 'WPGenius Solutions LLP', "astra-child-theme" );
			$white_label_settings['astra-agency']['author_url'] = 'http://wpgenius.in';
			$white_label_settings['astra-agency']['licence']    = 'https://wpgenius.in/contact/';
			$white_label_settings['astra']['name']              = __( 'WPGenius', "astra-child-theme" );
			$white_label_settings['astra']['description']       = __( 'WPGenius offers, fast, fully customizable & beautiful WordPress theme suitable for all your project needs.', "astra-child-theme" );
			$white_label_settings['astra']['screenshot']        = get_stylesheet_directory_uri() . '/screenshot.jpg';
			$white_label_settings['astra']['icon']              = get_stylesheet_directory_uri() . '/assets/images/wpgenius_logo.png';
			$white_label_settings['astra-pro']['name']          = __( 'WPGenius Pro', "astra-child-theme" );
			$white_label_settings['astra-pro']['description']   = __( 'This plugin is an add-on for your website. It offers premium features & functionalities that enhance your theming experience at next level.', "astra-child-theme" );
			$white_label_settings['astra-sites']['name']        = __( 'WPGenius Starter Templates', "astra-child-theme" );
			$white_label_settings['astra-sites']['description'] = __( 'WPGenius Starter Templates is all in one solution for complete starter sites, single page templates, blocks & images. This plugin offers the premium library of ready templates & provides quick access to beautiful Pixabay images that can be imported in your website easily.', "astra-child-theme" );

			Astra_Admin_Helper::update_admin_settings_option( '_astra_ext_white_label', $white_label_settings, true );
		}

		/**
		 * Change Ultimate adons white lables.
		 *
		 * @return void
		 */
		function uae_white_lables() {
			$uae_lables = array(
				'agency'                => array(
					'author'        => __( 'WPGenius Solutions LLP', "astra-child-theme" ),
					'author_url'    => 'https://wpgenius.in',
					'hide_branding' => false,
				),
				'plugin'                => array(
					'name'        => __( 'WPGenius Ultimate Addons', "astra-child-theme" ),
					'short_name'  => 'WAE',
					'description' => __( 'WPGenius Ultimate Addons is a premium extension for Elementor that adds 40+ widgets and works on top of any Elementor Package (Free, Pro). You can use it with any WordPress theme.', "astra-child-theme" ),
				),
				'replace_logo'          => 'enable',
				'enable_knowledgebase'  => 'disable',
				'knowledgebase_url'     => '',
				'enable_support'        => 'enable',
				'support_url'           => 'https://wpgenius.in/contact/',
				'enable_beta_box'       => 'disable',
				'enable_custom_tagline' => 'disable',
				'internal_help_links'   => 'enable',
			);
			update_option( '_uael_white_label', $uae_lables );
		}

	}
	WPGenius_Theme_Configurator::init();

}
