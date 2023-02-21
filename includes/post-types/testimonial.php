<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'WPGenius_testimonial' ) ) {
	class WPGenius_testimonial {
		public static $instance;
	
		public static function init() {
	
			if ( is_null( self::$instance ) ) {
				self::$instance = new WPGenius_testimonial();
			}
			return self::$instance;
		}
	
		private function __construct() {
			add_action( 'init', array( $this, 'register_post_type' ), 10, 1 );
			add_filter( 'manage_testimonial_posts_columns ', array( $this, 'manage_column' ) );
			add_action( 'manage_testimonial_posts_custom_column', array( $this, 'manage_custom_column' ), 10, 2 );
		}
	
		 /**
		  * Create Testimonial post type.
		  *
		  * To add custom fields use ACF plugin.
		  * field names: rating;
		  */
		public function register_post_type() {
			$labels = array(
				'name'               => __( 'Testimonials', 'akhilbaheti' ),
				'singular_name'      => __( 'Testimonial', 'akhilbaheti' ),
				'add_new'            => __( 'Add New', 'akhilbaheti' ),
				'add_new_item'       => __( 'Add new testimonial', 'akhilbaheti' ),
				'edit_item'          => __( 'Edit testimonial', 'akhilbaheti' ),
				'new_item'           => __( 'New testimonial', 'akhilbaheti' ),
				'view_item'          => __( 'View testimonials', 'akhilbaheti' ),
				'search_items'       => __( 'Search testimonials', 'akhilbaheti' ),
				'not_found'          => __( 'No testimonials found', 'akhilbaheti' ),
				'not_found_in_trash' => __( 'No testimonials found in Trash', 'akhilbaheti' ),
				'featured_image'     => __( 'Testimonial author Photo', 'akhilbaheti' ),
				'set_featured_image' => __( 'Set as testimonial\'s author picture', 'akhilbaheti' ),
			);

			$args = array(
				'labels'             => $labels,
				'menu_icon'          => 'dashicons-format-quote',
				'show_in_menu'       => true,
				'show_ui'            => true,
				'show_in_nav_menus'  => true,
				'public'             => false,
				'publicly_queryable' => true,
				'has_archive'        => true,
				'rewrite'            => array(
					'slug'       => 'testimonials',
					'with_front' => false,
				),
				'supports'           => array( 'title', 'editor', 'thumbnail' ),
			);

			register_post_type( 'testimonial', $args );

		}

		/**
		 * Edit columns
		 *
		 * @param array $columns
		 * @return void
		 */
		public function manage_column( $columns ) {

			$inserted = array(
				'editor'    => 'Testimonial',
				'thumbnail' => 'Testimonial Photo',
			);

			return array_merge(
				array_slice( $columns, 0, 2 ),
				$inserted,
				array_slice( $columns, 2 )
			);
		}

		/**
		 * Create Custom columns
		 *
		 * @param string $column_name
		 * @param int    $post_id
		 * @return void
		 */
		public function manage_custom_column( $column_name, $post_id ) {
			if ( $column_name == 'rating' ) {
				echo get_post_meta( 'ratings_value' );
			}
		}
		}
	}
	WPGenius_testimonial::init();
}


