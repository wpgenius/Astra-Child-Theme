<?php
/**
 * Post type : testimonial
 *
 * @package astra-child-theme/generic class
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPGenius_testimonial' ) ) {
	class WPGenius_testimonial {
		protected static $instance;

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
			add_filter( 'enter_title_here', array( $this, 'entry_title_text' ), 10, 2 );
			add_filter( 'default_content', array( $this, 'editor_content' ), 10, 2 );
			add_action( 'pre_get_posts', array( $this, 'pre_get_post' ), 10 );
			add_action( 'template_redirect', array( $this, 'template_redirect' ) );
			add_action( 'add_meta_boxes', array( $this, 'meta_box' ) );
			add_action( 'save_post', array( $this, 'save_post_meta' ) );
			add_action( 'wp', array( $this, 'template_hooks' ) );
		}

		 /**
		  * Create Testimonial post type.
		  *
		  * To add custom fields use ACF plugin.
		  * field names: rating;
		  */
		public function register_post_type() {
			$labels = array(
				'name'               => __( 'Testimonials', 'astra-child-theme' ),
				'singular_name'      => __( 'Testimonial', 'astra-child-theme' ),
				'add_new'            => __( 'Add New', 'astra-child-theme' ),
				'add_new_item'       => __( 'Add new testimonial', 'astra-child-theme' ),
				'edit_item'          => __( 'Edit testimonial', 'astra-child-theme' ),
				'new_item'           => __( 'New testimonial', 'astra-child-theme' ),
				'view_item'          => __( 'View testimonials', 'astra-child-theme' ),
				'search_items'       => __( 'Search testimonials', 'astra-child-theme' ),
				'not_found'          => __( 'No testimonials found', 'astra-child-theme' ),
				'not_found_in_trash' => __( 'No testimonials found in Trash', 'astra-child-theme' ),
				'featured_image'     => __( 'Testimonial author Photo', 'astra-child-theme' ),
				'set_featured_image' => __( 'Set as testimonial\'s author picture', 'astra-child-theme' ),
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
				'editor'    => __( 'Testimonial', 'astra-child-theme' ),
				'thumbnail' => __( 'Author picture', 'astra-child-theme' ),
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
			if ( $column_name == 'editor' ) {
				echo '<blockquote>"' . get_the_content() . '"</blockquote>';
			}
			if ( $column_name == 'thumbnail' ) {
				echo get_the_post_thumbnail( $post_id, 'thumbnail' );
			}
		}

		/**
		 * Change post entry title
		 *
		 * @param string $title
		 * @param object $post
		 * @return string
		 */
		public function entry_title_text( $title, $post ) {
			if ( $post->post_type == 'testimonial' ) {

				$title = __( 'Enter testimonial author title here', 'astra-child-theme' );
			}

			return $title;
		}

		/**
		 * Change default content of editor
		 *
		 * @param string $content
		 * @return void
		 */
		function editor_content( $content,$post ) {
			if ( 'testimonial' == $post->post_type ) {
				$content = __( 'Write testimonial here.', 'astra-child-theme' );
			}
			return $content;
		}

		/*
		 * Display posts for a custom post type called 'testimonial'
		 *
		 * @param array $query
		 * @return void
		 */
		function pre_get_post( $query ) {
			// enter code here
			if ( 'testimonial' == get_post_type() && get_option( 'wpg_testimonial_per_page' )) {
				$query->set( 'posts_per_page', get_option( 'wpg_testimonial_per_page' ) );
			}
		}

		/**
		 * Redirect template
		 *
		 * @return void
		 */
		function template_redirect() {
			// enter code here
		}

		/**
		 * Add metabox for testimonial.
		 *
		 * @return array
		 */
		public function meta_box() {
			add_meta_box( 'testimonial-meta', __( 'Testimonials meta' , 'astra-child-theme' ), array( $this, 'post_meta_callback' ), 'testimonial', 'advanced', 'high' );
		}

		/**
		 * Add post meta boxes to post type
		 *
		 * @param object $post
		 * @return void
		 */
		public function post_meta_callback( $post ) {

			$value = get_post_meta( $post->ID, 'ratings_value', true ); ?>

			<table class="form-table as_metabox">

				<div class="myplugin-image-preview">
					<div style="margin-bottom:10px;">
						<label for="rating"><?php _e( 'Choose rating', 'astra-child-theme' ); ?></label>
					</div>
					<div>
						<input style="width:100%; padding:10px !important;" type="text" id="rating" name="rating" value="<?php echo $value; ?>" />
					</div>
				</div>
			</table>
			<?php
		}

		/**
		 * Save post data of post type
		 *
		 * @param int $post_id
		 * @return void
		 */
		public function save_post_meta( $post_id ) {

			if ( isset( $_POST['rating'] ) && $_POST['rating'] != '' ) {
				$mydata = $_POST['rating'];
				update_post_meta( $post_id, 'ratings_value', $mydata );

			}
		}

		/**
		 * add hooks for archive page
		 *
		 * @return void
		 */
		public function template_hooks() {
			if ( is_post_type_archive( 'testimonial' ) ) {
				add_action( 'astra_archive_header', array( $this, 'archive_header' ) );
				add_action( 'astra_template_parts_content', array( $this, 'template_parts_function' ) );
			}
		}

		/**
		 * Add title to archive page.
		 *
		 * @return string
		 */
		public function archive_header() {
			if ( is_post_type_archive( 'testimonial' ) ) {
				remove_action( 'astra_template_parts_content', array( Astra_Loop::get_instance(), 'template_parts_default' ) );
			}
			echo '<h1 class="post-title">'.__( 'Testimonials' , 'astra-child-theme' ).'</h1>';
		}

		/**
		 * Add code to display content on post type archive page.
		 *
		 * @return void
		 */
		public function template_parts_function() {
			global $post;
			// Enter template code here to show on archive page
		}

	}

	WPGenius_testimonial::init();
}


