<?php
/**
 *
 * @class       Settings template for child theme
 * @author      Team WPGenius (Makarand Mane)
 * @category    Admin
 * @package     includes/admin-settings
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPGenius_settings' ) ) {
	/**
	 * Class for child theme settings
	 */
	class WPGenius_settings {

		/**
		 * instance of class
		 *
		 * @var object
		 */
		protected static $instance;

		/**
		 * Prefix for every setting field name & section
		 *
		 * @var string
		 */
		private $prefix = 'wpg_';

		/**
		 * Prefix for option groups
		 *
		 * @var string
		 */
		private $opt_grp = 'wpg_api_';

		/**
		 * Setting page menu slug
		 *
		 * @var string
		 */
		private $page = 'wpgenius_settings';

		/**
		 * Initialise class
		 *
		 * @return void
		 */
		public static function init() {

			if ( is_null( self::$instance ) ) {
				self::$instance = new WPGenius_settings();
			}
			return self::$instance;
		}

		/**
		 * Class constructor
		 */
		private function __construct() {

			add_action( 'admin_menu', array( $this, 'add_menu_page' ), 11 );
			add_action( 'admin_init', array( $this, 'register_settings' ), 10 );

		} // END public function __construct

		/**
		 * Register menu page
		 *
		 * @return void
		 */
		public function add_menu_page() {

			add_submenu_page(
				'wpgenius',
				__( 'WPGenius Settings' ), // page title
				__( 'Settings' ), // menu title
				'manage_options', // capability
				$this->page, // menu slug
				array( $this, 'settings_page' )
			);
		}

		/**
		 * Register setting, settings field & sections
		 *
		 * @return void
		 */
		public function register_settings() {

			// Register settings
			register_setting(
				$this->opt_grp,
				$this->prefix . 'testimonial_per_page',
				array(
					'type'    => 'string',
					'default' => '',
				)
			);

			// Register sections
			add_settings_section( $this->prefix . 'register_section', __( 'Testimonials setting section', 'astra-child-theme' ), array( $this, 'section_title' ), $this->page );

			// Add settings to section- braincert_api_section
			add_settings_field( $this->prefix . 'per_page', __( 'Testimonial per page:', 'astra-child-theme' ), array( $this, 'per_page' ), $this->page, $this->prefix . 'register_section' );

		}

		/**
		 * Callback for settings page.
		 * Display registered setting sections & fields
		 *
		 * @return void
		 */
		public function settings_page() {
			?>
			<div class="wrap">

				<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

				<form method="POST" action="options.php">
					<?php
						// output security fields for the registered setting "wporg"
						settings_fields( $this->opt_grp );
						// output setting sections and their fields
						// (sections are registered for "wporg", each field is registered to a specific section)
						do_settings_sections( $this->page );
						// output save settings button
						submit_button( __( 'Save Settings', 'astra-child-theme' ) );
					?>
				</form>
			</div>
			<?php

		}

		/**
		 * Sample section
		 *
		 * @return void
		 */
		public function section_title() {
			?>
			<p><?php _e( 'First section', 'astra-child-theme' ); ?></p>
			<?php
		}

		/**
		 * Sample text field
		 *
		 * @return void
		 */
		public function per_page() {
			?>
			   <input type='text' name='<?php echo $this->prefix; ?>testimonial_per_page' id='<?php echo $this->prefix; ?>testimonial_per_page' value='<?php echo get_option( $this->prefix . 'testimonial_per_page' ); ?>' style="width: 300px;">
			<?php
		}

	}
	WPGenius_settings::init();
}
