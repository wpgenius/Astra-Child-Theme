<?php
/**
 * Create an elementor widget.
 *
 * @package astra-child-theme
 */

// https://develowp.com/build-a-custom-elementor-widget/

class WPGenius_Elementor_Widgets {
	/**
	 * instance of class
	 *
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * Initialise class
	 *
	 * @return void
	 */
	public static function get_instance() {
		if ( ! isset( static::$instance ) ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Class constructor
	 */
	protected function __construct() {
		// Register widget Styles
		add_action( 'elementor/frontend/before_enqueue_styles', array( $this, 'widget_styles' ) );
		// Register widget scripts
		add_action( 'elementor/frontend/after_register_scripts', array( $this, 'widget_scripts' ) );
		// Register widgets
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets' ) );
	}

	/**
	 * Enqueue styles for widget
	 *
	 * @return void
	 */
	public function widget_styles() {

		// Enqueue styles for widget
	}

	/**
	 * Enqueue Scripts for widget
	 *
	 * @return void
	 */
	public function widget_scripts() {

		// Enqueue Scripts for widget
	}

	/**
	 * Register widget
	 *
	 * @return void
	 */
	public function register_widgets() {
		// register widget here
		require_once __DIR__ . '/widgets-elementor/widget-testimonial.php';
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\WPG_Elementor_Testimonial_Widget() );
	}

}
