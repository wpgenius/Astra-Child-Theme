<?php
/**
 * Admin actions.
 *
 * @package astra-child-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPGenius_admin_actions' ) ) {
	
	/**
	 * Class for Admin hooks
	 */
	class WPGenius_admin_actions {
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
				self::$instance = new WPGenius_admin_actions();
			}
			return self::$instance;
		}
	
		/**
		 * Class constructor
		 */
		private function __construct() {
			
			/**
			 * Disable Gutenberg on the back end.
			 */
			add_filter( 'use_block_editor_for_post', '__return_false', 5);
			add_filter( 'gutenberg_can_edit_post', '__return_false', 5);

			/**
			 * Disable Gutenberg for widgets.
			 */
			add_filter( 'use_widgets_block_editor', '__return_false' );

			/**
			 * Allow SVG uploads
			 */
			if ( ALLOW_SVG ) {
				add_filter( 'upload_mimes', array( $this, 'enable_svg' ) );
				add_filter( 'wp_check_filetype_and_ext', array( $this, 'check_filetype_and_ext' ), 10, 5 );
			}			
			
			/**
			 * Remove comments support for all post types. Remove comment menu, widget from admin
			 */
			if ( DISABLE_COMMENTS ) {
				add_action('admin_init',  	array( $this, 'disable_comments_support' ) );
				add_action('admin_menu',  	array( $this, 'remove_comments_page' ) );
				add_action('init',  		array( $this, 'remove_admin_bar_comments_menu' ) );
			}

			/**
			 * Add duplicate button to post/page list of actions. 
			 */
			if ( ENABLE_DUPLICATE_POST ) {
				add_filter( 'post_row_actions', array( $this, 'duplicate_post_link' ), 10, 2 );
				add_filter( 'page_row_actions', array( $this, 'duplicate_post_link' ), 10, 2 );
				add_action( 'admin_action_duplicate_post', array( $this, 'duplicate_post_action' ) );
			}

			/**
			 * White label admin footer
			 */
			if( WHITE_LABEL_ADMIN_FOOTER )
				add_filter( 'admin_footer_text', array( $this, 'white_label_admin_footer' ) );

			/**
			 * Lowercase Filenames for Uploads
			 */
			add_filter( 'sanitize_file_name', 'mb_strtolower' );
			
		}

		/**
		 * Allow SVG uploads for administrator users.
		 *
		 * @param array $upload_mimes Allowed mime types.
		 *
		 * @return mixed
		 */
		public function enable_svg( $upload_mimes ) {
			// By default, only administrator users are allowed to add SVGs.
			// To enable more user types edit or comment the lines below but beware of
			// the security risks if you allow any user to upload SVG files.
			if ( ! current_user_can( 'administrator' ) ) {
				return $upload_mimes;
			}
	
			$upload_mimes['svg']  = 'image/svg+xml';
			$upload_mimes['svgz'] = 'image/svg+xml';
	
			return $upload_mimes;
		}

		/**
		 * Add SVG files mime check.
		 *
		 * @param array        $wp_check_filetype_and_ext Values for the extension, mime type, and corrected filename.
		 * @param string       $file Full path to the file.
		 * @param string       $filename The name of the file (may differ from $file due to $file being in a tmp directory).
		 * @param string[]     $mimes Array of mime types keyed by their file extension regex.
		 * @param string|false $real_mime The actual mime type or false if the type cannot be determined.
		 */
		public function check_filetype_and_ext( $wp_check_filetype_and_ext, $file, $filename, $mimes, $real_mime ) {

			if ( ! $wp_check_filetype_and_ext['type'] ) {
	
				$check_filetype  = wp_check_filetype( $filename, $mimes );
				$ext             = $check_filetype['ext'];
				$type            = $check_filetype['type'];
				$proper_filename = $filename;
	
				if ( $type && 0 === strpos( $type, 'image/' ) && 'svg' !== $ext ) {
					$ext  = false;
					$type = false;
				}
	
				$wp_check_filetype_and_ext = compact( 'ext', 'type', 'proper_filename' );
			}
	
			return $wp_check_filetype_and_ext;
	
		}

		/**
		 * 1. Redirect any user trying to access comments page
		 * 2. Remove comments metabox from dashboard
		 * 3. Disable support for comments and trackbacks in post types
		 *
		 * @return void
		 */
		public function disable_comments_support() {
			// Redirect any user trying to access comments page
			global $pagenow;
			
			if ($pagenow === 'edit-comments.php') {
				wp_safe_redirect(admin_url());
				exit;
			}
		
			// Remove comments metabox from dashboard
			remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
		
			// Disable support for comments and trackbacks in post types
			foreach (get_post_types() as $post_type) {
				if (post_type_supports($post_type, 'comments')) {
					remove_post_type_support($post_type, 'comments');
					remove_post_type_support($post_type, 'trackbacks');
				}
			}
		}

		/**
		 * Remove comments page in menu
		 *
		 * @return void
		 */
		public function remove_comments_page() {
			remove_menu_page('edit-comments.php');
		}

		/**
		 * Remove comments links from admin bar
		 * 
		 * @return void
		 */
		public function remove_admin_bar_comments_menu() {
			if (is_admin_bar_showing()) {
				remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
			}
		}

		/**
		 * Add duplication post link in action links to the admin
		 * 
		 * @param array   $actions The actions added as links to the admin.
		 * @param WP_Post $post The post object.
		 *
		 * @return array
		 */
		function duplicate_post_link( $actions, $post ) {

			// Don't add action if the current user can't create posts of this post type.
			$post_type_object = get_post_type_object( $post->post_type );

			if ( null === $post_type_object || ! current_user_can( $post_type_object->cap->create_posts ) ) {
				return $actions;
			}


			$url = wp_nonce_url(
				add_query_arg(
					array(
						'action'  => 'duplicate_post',
						'post_id' => $post->ID,
					),
					'admin.php'
				),
				'wpgenius_duplicate_post_' . $post->ID,
				'wpgenius_duplicate_nonce'
			);

			$actions['wpgenius_duplicate_post'] = '<a href="' . $url . '" title="Duplicate item" rel="permalink">Duplicate</a>';

			return $actions;
		}

		/**
		 * Handle the custom action when clicking the button we added above.
		 *
		 * @return void
		 */
		public function duplicate_post_action() {

			if ( empty( $_GET['post_id'] ) ) {
				wp_die( 'No post id set for the duplicate action.' );
			}
		
			$post_id = absint( $_GET['post_id'] );
		
			// Check the nonce specific to the post we are duplicating.
			if ( ! isset( $_GET['wpgenius_duplicate_nonce'] ) || ! wp_verify_nonce( $_GET['wpgenius_duplicate_nonce'], 'wpgenius_duplicate_post_' . $post_id ) ) {
				// Display a message if the nonce is invalid, may it expired.
				wp_die( 'The link you followed has expired, please try again.' );
			}
		
			// Load the post we want to duplicate.
			$post = get_post( $post_id );
		
			// Create a new post data array from the post loaded.
			if ( $post ) {
				$current_user = wp_get_current_user();
				$new_post     = array(
					'comment_status' => $post->comment_status,
					'menu_order'     => $post->menu_order,
					'ping_status'    => $post->ping_status,
					'post_author'    => $current_user->ID,
					'post_content'   => $post->post_content,
					'post_excerpt'   => $post->post_excerpt,
					'post_name'      => $post->post_name,
					'post_parent'    => $post->post_parent,
					'post_password'  => $post->post_password,
					'post_status'    => 'draft',
					'post_title'     => $post->post_title . ' (copy)',// Add "(copy)" to the title.
					'post_type'      => $post->post_type,
					'to_ping'        => $post->to_ping,
				);
				// Create the new post
				$duplicate_id = wp_insert_post( $new_post );
				// Copy the taxonomy terms.
				$taxonomies = get_object_taxonomies( get_post_type( $post ) );
				if ( $taxonomies ) {
					foreach ( $taxonomies as $taxonomy ) {
						$post_terms = wp_get_object_terms( $post_id, $taxonomy, array( 'fields' => 'slugs' ) );
						wp_set_object_terms( $duplicate_id, $post_terms, $taxonomy );
					}
				}
				// Copy all the custom fields.
				$post_meta = get_post_meta( $post_id );
				if ( $post_meta ) {
		
					foreach ( $post_meta as $meta_key => $meta_values ) {
						if ( '_wp_old_slug' === $meta_key ) { // skip old slug.
							continue;
						}
						foreach ( $meta_values as $meta_value ) {
							add_post_meta( $duplicate_id, $meta_key, $meta_value );
						}
					}
				}
		
				// Redirect to edit the new post.
				wp_safe_redirect(
					add_query_arg(
						array(
							'action' => 'edit',
							'post'   => $duplicate_id
						),
						admin_url( 'post.php' )
					)
				);
				exit;
			} else {
				wp_die( 'Error loading post for duplication, please try again.' );
			}
		}

		/**
		 * White label admin footer
		 *
		 * @param string $footer_text
		 * @return string
		 */
		public function white_label_admin_footer( $footer_text ) {
			$footer_text = 'Powered by <a href="https://wpgenius.in" target="_blank" rel="noopener">WPGenius</a>';			
			return $footer_text;
		}

	}
	WPGenius_admin_actions::init();
	
}
