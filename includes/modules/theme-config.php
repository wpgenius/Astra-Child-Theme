<?php
/**
 * Theme Configuration file to define constants.
 *
 * @package astra-child-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Allow administrator to upload SVG file.
 * Default : false
 */
define( 'ALLOW_SVG', false );

/**
 * Disable blog. Removes posts option from admin.
 * Default : false
 */
define( 'DISABLE_BLOG', true );

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
 * Disable RSS FEEDS
 * Default : true
 */
define( 'DISABLE_FEEDS', true );

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
 * Strict admin mode.
 * Default : true
 */
define( 'STRICY_ADMIN_MODE', false );

/**
 * White label admin footer.
 * Default : true
 */
define( 'WHITE_LABEL_ADMIN_FOOTER', true );
