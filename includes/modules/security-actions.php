<?php
/**
 * Security actions
 *
 * @package astra-child-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPGenius_security_actions' ) ) {

	/**
	 * Security measurements for each project
	 */
	class WPGenius_security_actions {
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
				self::$instance = new WPGenius_security_actions();
			}
			return self::$instance;
		}

		/**
		 * Class constructor
		 */
		private function __construct() {
			/**
			 * Remove WordPress Meta Generator Tag
			 */
			remove_action( 'wp_head', 'wp_generator' );

			/**
			 * Disable XMLRPC
			 */
			add_filter( 'xmlrpc_enabled', '__return_false' );

			/**
			 * Remove link to the Really Simple Discovery service endpoint.
			 */
			remove_action( 'wp_head', 'rsd_link' );

			/**
			 * Disable wlwmanifest link
			 */
			remove_action( 'wp_head', 'wlwmanifest_link' );

			/**
			 * 1. Close comments on the front-end
			 * 2. Hide existing comments
			 */
			if ( DISABLE_COMMENTS ) {
				add_filter( 'comments_open', '__return_false', 20, 2 );
				add_filter( 'comments_array', '__return_empty_array', 10, 2 );
			}

			/**
			 * Disable Comment Form Website URL
			 */
			add_filter( 'comment_form_default_fields', array( $this, 'disable_url_field_comment_form' ), 150 );

			/**
			 * Disable pings on the front end.
			 */
			add_filter( 'pings_open', '__return_false', 20, 2 );

			/**
			 * 1. Disable core auto-updates
			 * 2. Disable auto-updates for plugins.
			 * 3. Disable auto-updates for themes.
			 */
			if ( DISABLE_AUTOMATIC_UPDATES ) {
				add_filter( 'auto_update_core', '__return_false' );
				add_filter( 'auto_update_plugin', '__return_false' );
				add_filter( 'auto_update_theme', '__return_false' );
			}

			/**
			 * 1. Disable auto-update emails for core.
			 * 2. Disable auto-update emails for plugins.
			 * 3. Disable auto-update emails for themes.
			 */
			if ( DISABLE_AUTOMATIC_UPDATE_EMAIL ) {
				add_filter( 'auto_core_update_send_email', '__return_false' );
				add_filter( 'auto_plugin_update_send_email', '__return_false' );
				add_filter( 'auto_theme_update_send_email', '__return_false' );
			}

			if ( STRICY_ADMIN_MODE ) {
				add_action( 'admin_print_scripts', array( $this, 'hide_unwanted_links' ) );
			}
			
			/**
			 * Remove Login Shake Animation
			 */
			if ( !defined( WP_ENVIRONMENT_TYPE ) || WP_ENVIRONMENT_TYPE === 'production' ) {
				add_action( 'login_footer', array( $this, 'remove_shake_js' ) );
				add_filter( 'login_errors', array( $this, 'hide_login_error' ) );
			}

		}

		/**
		 * Unset website URL field from comment form
		 *
		 * @param array $fields
		 * @return array
		 */
		public function disable_url_field_comment_form( $fields ) {
			if ( isset( $fields['url'] ) ) {
				unset( $fields['url'] );
			}

			return $fields;
		}

		/**
		 * Checks whether current user is from WPGenius
		 *
		 * @return boolean
		 */
		private function is_wpg_user() {
			$user = wp_get_current_user();
			return $user && isset( $user->user_login ) && ( $user->user_login == 'makarand' || preg_match( '/^\w+@wpgenius\.in$/i', $user->user_email ) > 0 );
		}

		/**
		 * Hide unwanted links to non WPG user.
		 *
		 * @return void
		 */
		function hide_unwanted_links() {
			if ( ! $this->is_wpg_user() ) {
				// remove menu
				remove_menu_page( 'elementor' );
				remove_submenu_page( 'woocommerce', 'wc-status' );
				remove_submenu_page( 'woocommerce', 'wc-addons' );
				// Hide links using css
				?>
				<style type="text/css">
					#menu-plugins, #menu-settings, 
					.theme.add-new-theme, div[data-slug="astra"], .themes-php .page-title-action{ display:none; }
				</style>
				<?php
			}
		}
		
		/**
		 * Remove Login Shake Animation
		 *
		 * @return void
		 */
		public function remove_shake_js() {
			remove_action( 'login_footer', 'wp_shake_js', 12 );
		}

		/**
		 * Hide Login Errors in WordPress. Add custom login error message
		 *
		 * @param string $error
		 * @return string
		 */
		public function hide_login_error( $error ) {
			// Edit the line below to customize the message.
			return __( 'Something is wrong!', 'astra-child-theme' );
		}

	}
	WPGenius_security_actions::init();
}
