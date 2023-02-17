<?php

/**
 * Add actions related to Theme.
 *
 * @package astra-child-theme
 */

function my_theme_enqueue_styles() {
	wp_enqueue_style( 'astra-theme-css', get_template_directory_uri() . '/style.css', array(), wp_get_theme()->parent()->get( 'Version' ) );
	wp_enqueue_style( 'astra-child-theme', get_stylesheet_uri(), array( 'astra-theme-css' ), wp_get_theme()->get( 'Version' ) );

	// Remove Gutenberg Block Library CSS from loading on the frontend
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'bp-member-block' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'wc-block-style' );
	wp_dequeue_style( 'wc-blocks-vendors-style' );
	wp_deregister_style( 'wc-block-editor' );
	wp_deregister_style( 'wc-blocks-style' );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

/**
 * Disable Gutenberg on the back end.
 */
add_filter( 'use_block_editor_for_post', '__return_false' );

/**
 * Disable Gutenberg for widgets.
 */
add_filter( 'use_widgets_block_editor', '__return_false' );
