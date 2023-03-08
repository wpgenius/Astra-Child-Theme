<?php
/**
 * Add Functions related to themes.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package astra-child-theme
 */

require get_stylesheet_directory() . '/includes/theme-actions.php';
require get_stylesheet_directory() . '/includes/theme-settings.php';
require get_stylesheet_directory() . '/includes/security-actions.php';
require get_stylesheet_directory() . '/includes/cleanup-action.php';
require get_stylesheet_directory() . '/includes/admin-actions.php';
require get_stylesheet_directory() . '/includes/user-actions.php';
require get_stylesheet_directory() . '/includes/seo-actions.php';
require get_stylesheet_directory() . '/includes/ajax-actions.php';
require get_stylesheet_directory() . '/includes/woo-actions.php';
require get_stylesheet_directory() . '/includes/theme-shortcodes.php';
if ( is_plugin_active( 'elementor/elementor.php' ) ) {
	require get_stylesheet_directory() . '/includes/widgets-elementor.php';
}
