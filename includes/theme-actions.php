<?php

/**
 * Add actions related to Theme.
 *
 * @package astra-child-theme
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPGenius_theme_action' ) ) {
	class WPGenius_theme_action {
		public static $instance;

		private $post_types = array(
            'testimonial'
        );

		private $widgets = array(
            'testimonial'
        );
	
		public static function init() {
	
			if ( is_null( self::$instance ) ) {
				self::$instance = new WPGenius_theme_action();
			}
			return self::$instance;
		}
	
		private function __construct() {

			$this->register_post_types();
			$this->register_widget();

			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		}
	
		public function enqueue_scripts() {
			wp_enqueue_style( 'astra-child-theme', get_stylesheet_uri(), array( 'astra-theme-css' ), wp_get_theme()->get( 'Version' ) );
			wp_enqueue_style( 'custom', get_stylesheet_directory() . 'assets/css/custom.css', array( 'astra-child-theme' ), 1.00 );
		}

		public function register_post_types(){
			foreach ($this->post_types as $post_type) {
                if (file_exists(dirname(__FILE__) . '/post-types/' . $post_type . '.php')) {
                    include dirname(__FILE__) . '/post-types/' . $post_type . '.php';
                }
            }
		}

		public function register_widget(){
			foreach ($this->widgets as $widget) {
                if (file_exists(dirname(__FILE__) . '/widgets/widget-' . $widget . '.php')) {
                    include dirname(__FILE__) . '/widgets/widget-' . $widget . '.php';
                }
            }
		}

	}
	WPGenius_theme_action::init();
}


