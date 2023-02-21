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
				'name'               => __( 'Testimonial', 'astra-child-theme' ),
				'singular_name'      => __( 'Testimonial', 'astra-child-theme' ),
				'all_items'          => __( 'Alltestimonials', 'astra-child-theme' ),
				'add_new'            => __( 'AddNew', 'astra-child-theme' ),
				'add_new_item'       => __( 'Addnewtestimonial', 'astra-child-theme' ),
				'edit_item'          => __( 'Edittestimonial', 'astra-child-theme' ),
				'new_item'           => __( 'Newtestimonial', 'astra-child-theme' ),
				'view_item'          => __( 'Viewtestimonial', 'astra-child-theme' ),
				'search_items'       => __( 'Searchtestimonial', 'astra-child-theme' ),
				'not_found'          => __( 'Notestimonialfound', 'astra-child-theme' ),
				'not_found_in_trash' => __( 'NotestimonialfoundinTrash', 'astra-child-theme' ),
				'featured_image'     => __( 'TestimonialCoverPhoto', 'astra-child-theme' ),
				'set_featured_image' => __( 'Setastestimonial\'sCoverpicture', 'astra-child-theme' ),
			);
	
			$args = array(
				'numberposts'        => 15,
				'labels'             => $labels,
				'menu_icon'          => 'dashicons-format-quote',
				'show_in_menu'       => true,
				'show_ui'            => true,
				'show_in_nav_menus'  => true,
				'public'             => true,
				'publicly_queryable' => true,
				'has_archive'        => true,
				'rewrite'            => array(
					'slug'       => 'testimonial',
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
		function manage_column( $columns ) {
	
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
		function manage_custom_column( $column_name, $post_id ) {
	
			if ( $column_name == 'editor' ) {
				echo 'Rating: ' . get_field( 'rating' );
				echo '<blockquote>"' . get_the_content() . '"</blockquote>';
			}
	
			if ( $column_name == 'thumbnail' ) {
				echo get_the_post_thumbnail( $post_id, 'thumbnail' );
			}
	
		}
	}
	WPGenius_testimonial::init();
}


