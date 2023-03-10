<?php
/**
 * Theme related actions
 *
 * @package astra-child-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPGenius_theme_actions' ) ) {

	/**
	 * First class from theme to execute actions
	 */
	class WPGenius_theme_actions {
		/**
		 * instance of class
		 *
		 * @var object
		 */
		protected static $instance;

		/**
		 * List of post type to be created.
		 *
		 * @var array
		 */
		private $post_types = array(
			'testimonial',
		);

		/**
		 * List of widgets to be loaded
		 *
		 * @var array
		 */
		private $widgets = array(
			'testimonial',
		);

		/**
		 * Initialise class
		 *
		 * @return void
		 */
		public static function init() {

			if ( is_null( self::$instance ) ) {
				self::$instance = new WPGenius_theme_actions();
			}
			return self::$instance;
		}

		/**
		 * Class constructor
		 */
		private function __construct() {

			$this->register_post_types();
			$this->register_widgets();
			if ( did_action( 'elementor/loaded' ) ) {
				add_action( 'init', array( $this, 'register_widgets_elementor' ) );
			}
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'after_switch_theme', array( $this, 'activation_hook' ) );

			if ( class_exists( 'WP_CLI' ) ) {
				WP_CLI::add_command( 'easy_setup', array( $this, 'easy_setup_command' ) );
			}

		}

		/**
		 * Enqueue stylesheet file on front end.
		 *
		 * @return void
		 */
		public function enqueue_scripts() {
			// wp_enqueue_style( 'astra-child-theme', get_stylesheet_uri(), array( 'astra-theme-css' ), wp_get_theme()->get( 'Version' ) );
			// We will not use default stylesheet file. Only write CSS to style.css file under assets/css folder.
			wp_enqueue_style( 'astra-child-theme', get_stylesheet_directory() . 'assets/css/style.css', array( 'astra-theme-css' ), wp_get_theme()->get( 'Version' ) );
		}

		/**
		 * Includes post type files. Check if file exist or not and then include it.
		 * To add more post types create php file with post type as name & add name in array $post_types present in this class
		 *
		 * @return void
		 */
		private function register_post_types() {
			foreach ( $this->post_types as $post_type ) {
				if ( file_exists( dirname( __FILE__ ) . '/post-types/' . $post_type . '.php' ) ) {
					include dirname( __FILE__ ) . '/post-types/' . $post_type . '.php';
				}
			}
		}

		/**
		 * Includes widget files. Check if file exist or not and then include it.
		 * To add more widget create php file with prefix "widget-" & add name in array $widgets present in this class
		 *
		 * @return void
		 */
		private function register_widgets() {
			foreach ( $this->widgets as $widget ) {
				if ( file_exists( dirname( __FILE__ ) . '/widgets/widget-' . $widget . '.php' ) ) {
					include dirname( __FILE__ ) . '/widgets/widget-' . $widget . '.php';
				}
			}
		}

		/**
		 * Register elementor widgets by creating instance of class WPGenius_Elementor_Widgets
		 *
		 * @return void
		 */
		public function register_widgets_elementor() {
			WPGenius_Elementor_Widgets::get_instance();
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
				require get_stylesheet_directory() . '/includes/theme-configurator.php';
				Flush_rewrite_rules();
			}
		}
	}
	WPGenius_theme_actions::init();
}
