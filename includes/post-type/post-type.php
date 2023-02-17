<?php

/**
 * Create Testimonial post type.
 *
 * To add custom fields use ACF plugin.
 * field names: rating;
 */
function ast_testimonial_post_type() 
{
	
	$labels = array(
		'name' 					=> __( 'Testimonial', 'astra-child-theme' ),
		'singular_name' 		=> __( 'Testimonial', 'astra-child-theme' ),
		'all_items'         	=> __( 'All testimonials', 'astra-child-theme' ),
		'add_new' 				=> __( 'Add New', 'astra-child-theme' ),
		'add_new_item' 			=> __( 'Add new testimonial', 'astra-child-theme' ),
		'edit_item' 			=> __( 'Edit testimonial', 'astra-child-theme' ),
		'new_item' 				=> __( 'New testimonial', 'astra-child-theme' ),
		'view_item' 			=> __( 'View testimonial', 'astra-child-theme' ),
		'search_items' 			=> __( 'Search testimonial', 'astra-child-theme' ),
		'not_found' 			=> __( 'No testimonial found', 'astra-child-theme' ),
		'not_found_in_trash' 	=> __( 'No testimonial found in Trash', 'astra-child-theme' ), 
		'featured_image' 		=> __( 'Testimonial Cover Photo','astra-child-theme' ),
		'set_featured_image' 	=> __('Set as testimonial\'s Cover picture','astra-child-theme'),
	 );
	
	$args = array(
		'numberposts'      		=> 15,
		'labels' 				=> $labels,
		'menu_icon'				=> 'dashicons-format-quote',
		'show_in_menu'			=> true,
		'show_ui' 				=> true,
		'show_in_nav_menus'     => true,
		'public' 				=> true,
		'publicly_queryable'	=> true,
		'has_archive'			=> true,
		'rewrite'				=> array( 'slug' => 'testimonial', 'with_front' => false ),
		'supports' 				=> array( 'title', 'editor', 'thumbnail' ),
	); 
	  
	register_post_type( 'testimonial', $args );
	
}
add_action( 'init', 'ast_testimonial_post_type', 10, 1 );

/**
 * Edit columns
 *
 * @param array $columns
 * @return void
 */
function manage_testimonial_cols($columns) {

	$inserted = array( 
			'editor' => 'Testimonial',
			'thumbnail' => 'Testimonial Photo',
		 ); 

  	return array_merge(
	            array_slice($columns, 0, 2),
	            $inserted,
	            array_slice($columns, 2)
	        );
}
add_filter( 'manage_testimonial_posts_columns', 'manage_testimonial_cols');

/**
 * Create Custom columns
 *
 * @param string $column_name
 * @param int $post_id
 * @return void
 */
function testimonial_field_col( $column_name, $post_id ){

	if( $column_name == 'editor' ){
		echo "Rating: ".get_field( 'rating' );
		echo "<blockquote>\"".get_the_content()."\"</blockquote>";
	}

	if( $column_name == 'thumbnail' ){
		echo get_the_post_thumbnail( $post_id, 'thumbnail' );
	}

}
add_action( 'manage_testimonial_posts_custom_column', 'testimonial_field_col', 10, 2);
