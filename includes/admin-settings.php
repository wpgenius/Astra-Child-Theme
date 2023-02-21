<?php
/**
 *
 * @class       WPGenius_settings
 * @author      Team WPGenius (Makarand Mane)
 * @category    Admin
 * @package     wpg-setting-api/includes
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPGenius_settings' ) ) {
	class WPGenius_settings {

		public static $instance;
		private $prefix  = 'wpg_';
		private $opt_grp = 'wpg_api_';
		private $page    = 'wpgenius_settings';

		public static function init() {

			if ( is_null( self::$instance ) ) {
				self::$instance = new WPGenius_settings();
			}
			return self::$instance;
		}

		private function __construct() {

			add_action( 'admin_menu', array( $this, 'add_menu_page' ), 11 );
			add_action( 'admin_init', array( $this, 'register_settings' ), 10 );

		} // END public function __construct

		public function add_menu_page() {

			add_submenu_page(
				'edit.php?post_type=testimonial',
				__( 'WPGenius Settings' ), // page title
				__( 'Settings' ), // menu title
				'manage_options', // capability
				$this->page, // menu slug
				array( $this, 'settings_page' )
			);
		}

		public function register_settings() {

			// Register settings
			register_setting(
				$this->opt_grp,
				$this->prefix . 'register_setting',
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

		public function section_title() {
			?>
			<p><?php // _e( '' ); ?></p>
			<?php
		}

		public function per_page() {
			?>
			   <input type='text' name='<?php echo $this->prefix; ?>register_setting' id='<?php echo $this->prefix; ?>register_setting' value='<?php echo get_option( $this->prefix . 'register_setting' ); ?>' style="width: 300px;">
			<?php
		}

	}
	WPGenius_settings::init();
}


