<?php

/**
 * Add actions related to Theme.
 *
 * @package astra-child-theme
 */

function my_theme_enqueue_styles() {
	wp_enqueue_style( 'astra-theme-css', get_template_directory_uri() . '/style.css', array(), wp_get_theme()->parent()->get( 'Version' ) );
	wp_enqueue_style( 'astra-child-theme', get_stylesheet_uri(), array( 'astra-theme-css' ), wp_get_theme()->get( 'Version' )	);
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
