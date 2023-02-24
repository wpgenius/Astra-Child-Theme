<?php
/**
 * Cleanup actions for every project
 *
 * @package astra-child-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPGenius_cleanup_actions' ) ) {

	/**
	 * Clean unwanted, unnecessory code from WordPress, Plugins or theme
	 */
	class WPGenius_cleanup_actions {
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
				self::$instance = new WPGenius_cleanup_actions();
			}
			return self::$instance;
		}

		/**
		 * Class constructor
		 */
		private function __construct() {

			/**
			 * Remove unwanted JS & CSS from front end
			 * - Gutenberg
			 */
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			
			/**
			 * Remove all dashboard widgets from admin panel
			 */
			add_action( 'wp_dashboard_setup', array( $this, 'remove_dashboard_widgets' ), 9999 );
			add_action( 'admin_init', array( $this, 'remove_welcome_panel' ), 9999 );

			/**
			 * Remove Slider Revolution Meta Generator Tag
			 */
			add_filter( 'revslider_meta_generator', '__return_empty_string' );

			/**
			 * Disable the emojis in WordPress.
			 */
			if ( DISABLE_EMOJI )
				add_action( 'init', array( $this, 'disable_emoji' ) );

			/**
			 * Disable all embeds in WordPress.
			 */
			if ( DISABLE_OEMBED )
				add_action( 'init', array( $this, 'disable_oembed' ), 9999 );

			/**
			 * Disable RSS FEEDS
			 */
			if ( DISABLE_FEEDS ){
				// Replace all feeds with the message above.
				add_action( 'do_feed_rdf', array( $this, 'disable_feed' ), 1 );
				add_action( 'do_feed_rss', array( $this, 'disable_feed' ), 1 );
				add_action( 'do_feed_rss2', array( $this, 'disable_feed' ), 1 );
				add_action( 'do_feed_atom', array( $this, 'disable_feed' ), 1 );
				add_action( 'do_feed_rss2_comments', array( $this, 'disable_feed' ), 1 );
				add_action( 'do_feed_atom_comments', array( $this, 'disable_feed' ), 1 );
				// Remove links to feed from the header.
				remove_action( 'wp_head', 'feed_links_extra', 3 );
				remove_action( 'wp_head', 'feed_links', 2 );
			}			

			/**
			 * Clean wordpress admin
			 */
			add_action( 'admin_print_styles', array( $this, 'clean_admin' ), 9999 );

		}

		/**
		 * Remove Gutenberg Block Library CSS from loading on the frontend
		 *
		 * @return void
		 */
		public function enqueue_scripts() {
			wp_dequeue_style( 'wp-block-library' );
			wp_dequeue_style( 'bp-member-block' );
			wp_dequeue_style( 'wp-block-library-theme' );
			wp_dequeue_style( 'wc-block-style' );
			wp_dequeue_style( 'wc-blocks-vendors-style' );
			wp_deregister_style( 'wc-block-editor' );
			wp_deregister_style( 'wc-blocks-style' );
		}

		/**
		 * Remove unwanted widgets from dashboard
		 *
		 * @return void
		 */
		public function remove_dashboard_widgets() {
			global $wp_meta_boxes;
			$wp_meta_boxes['dashboard']['normal']['core'] = array();
			$wp_meta_boxes['dashboard']['side']['core']   = array();
			$wp_meta_boxes['dashboard']['normal']['high'] = array();
		}

		/**
		 * Remove Dashboard Welcome Panel
		 *
		 * @return void
		 */
		public function remove_welcome_panel() {
			remove_action( 'welcome_panel', 'wp_welcome_panel' );
		}

		/**
		 * Disable the emojis in WordPress.
		 *
		 * @return void
		 */
		public function disable_emoji() {
			remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
			remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
			remove_action( 'wp_print_styles', 'print_emoji_styles' );
			remove_action( 'admin_print_styles', 'print_emoji_styles' );
			remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
			remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
			remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
			add_filter( 'tiny_mce_plugins', array( $this, 'disable_emoji_from_tinymce' ) );
			add_filter( 'wp_resource_hints', array( $this, 'disable_emoji_from_prefetch' ), 10, 2 );
		}

		/**
		 * Remove from TinyMCE.
		 *
		 * @param array $plugins
		 * @return array
		 */
		public function disable_emoji_from_tinymce( $plugins ) {
			if ( is_array( $plugins ) ) {
				return array_diff( $plugins, array( 'wpemoji' ) );
			} else {
				return array();
			}
		}

		/**
		 * Remove from dns-prefetch.
		 *
		 * @param string $urls
		 * @param array $relation_type
		 * @return array
		 */
		public function disable_emoji_from_prefetch( $urls, $relation_type ) {
			if ( 'dns-prefetch' === $relation_type ) {
				$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );
				$urls          = array_diff( $urls, array( $emoji_svg_url ) );
			}
	
			return $urls;
		}

		/**
		 * Disable all embeds in WordPress.
		 *
		 * @return void
		 */
		public function disable_oembed() {
			// Remove the REST API endpoint.
			remove_action( 'rest_api_init', 'wp_oembed_register_route' );
		
			// Turn off oEmbed auto discovery.
			add_filter( 'embed_oembed_discover', '__return_false' );
		
			// Don't filter oEmbed results.
			remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
		
			// Remove oEmbed discovery links.
			remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
		
			// Remove oEmbed-specific JavaScript from the front-end and back-end.
			remove_action( 'wp_head', 'wp_oembed_add_host_js' );
			add_filter( 'tiny_mce_plugins', array( $this, 'disable_oembed_from_tinymce' ) );
		
			// Remove all embeds rewrite rules.
			add_filter( 'rewrite_rules_array', array( $this, 'disable_oembed_from_rewrite_rules' ) );
		
			// Remove filter of the oEmbed result before any HTTP requests are made.
			remove_filter( 'pre_oembed_result', 'wp_filter_pre_oembed_result', 10 );
		}

		/**
		 * Remove all embeds from tinymce editor
		 *
		 * @param array $plugins
		 * @return array
		 */
		public function disable_oembed_from_tinymce( $plugins ) {
			return array_diff( $plugins, array( 'wpembed' ) );
		}

		/**
		 * Remove all embeds rewrite rules.
		 *
		 * @param array $rules
		 * @return array
		 */
		public function disable_oembed_from_rewrite_rules( $rules ) {
			foreach ( $rules as $rule => $rewrite ) {
				if ( false !== strpos( $rewrite, 'embed=true' ) ) {
					unset( $rules[ $rule ] );
				}
			}
	
			return $rules;
		}

		/**
		 * Display a custom message instead of the RSS Feeds.
		 *
		 * @return void
		 */
		public function disable_feed() {
			wp_die(
				sprintf(
					// Translators: Placeholders for the homepage link.
					esc_html__( 'No feed available, please visit our %1$shomepage%2$s!' ),
					' <a href="' . esc_url( home_url( '/' ) ) . '">',
					'</a>'
				)
			);
		}

		/**
		 * Clears things from WordPress admin
		 *
		 * @return void
		 */
		public function clean_admin() {
			?>
			<style type="text/css">
				<?php if( DISABLE_BLOG ) { ?>
				#menu-posts,	/* Hide posts menu from back end */
				#front-static-pages label[for="page_for_posts"],
				#front-static-pages .screen-reader-text + p , /* Hide posts selection page option */
				<?php } ?>
			</style>
			<?php
		}
	}
	WPGenius_cleanup_actions::init();
}
