<?php
/**
 * Create an elementor widget.
 *
 * @package astra-child-theme
 */

// https://develowp.com/build-a-custom-elementor-widget/

class Wpgenius_Elementor_Widgets {

	protected static $instance = null;

	public static function get_instance() {
		if ( ! isset( static::$instance ) ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	protected function __construct() {
		// Register widget Styles
		add_action( 'elementor/frontend/before_enqueue_styles', array( $this, 'widget_styles' ) );
		// Register widget scripts
		add_action( 'elementor/frontend/after_register_scripts', array( $this, 'widget_scripts' ) );
		// Register widgets
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets' ) );
	}
	public function widget_styles() {

		// Enqueue styles for widget
	}

	public function widget_scripts() {

		// Enqueue Scripts for widget
	}

	public function register_widgets() {
		// register widget here
		require_once __DIR__ . '/widgets/wpg-widget.php';
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\WPG_widget() );
	}

}

function wpg_elementor_widgets() {
	Wpgenius_Elementor_Widgets::get_instance();
}
add_action( 'init', 'wpg_elementor_widgets' );
