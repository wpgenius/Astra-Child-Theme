<?php
/**
 * Astra child Theme functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package astra-child-theme
 */

/**
 * Allow administrator to upload SVG file.
 * Default : false
 */
define( 'ALLOW_SVG', false );

/**
 * Disable comments from comments. Removes comments menu from admin.
 * Default : true
 */
define( 'DISABLE_COMMENTS', true );

/**
 * Disable the emojis in WordPress from backend & front end.
 * Default : true
 */
define( 'DISABLE_EMOJI', true );

/**
 * Disable all embeds in WordPress.
 * Default : true
 */
define( 'DISABLE_OEMBED', true );

/**
 * Disable Attachment Pages
 * Default : true
 */
define( 'DISABLE_ATTACHMENT_PAGES', true );

/**
 * Disable automatic updates
 * Default : false
 */
define( 'DISABLE_AUTOMATIC_UPDATES', false );

/**
 * Disable automatic updates email
 * Default : false
 */
define( 'DISABLE_AUTOMATIC_UPDATE_EMAIL', false );

/**
 * Remove Query Strings From Static Files
 * Default : true
 */
define( 'REMOVE_QUERY_STRINGS', true );

/**
 * Enable option to duplicate posts
 * Default : true
 */
define( 'ENABLE_DUPLICATE_POST', true );

/**
 * White label admin footer.
 * Default : true
 */
define( 'WHITE_LABEL_ADMIN_FOOTER', true );

require get_stylesheet_directory() . '/includes/theme-functions.php';
