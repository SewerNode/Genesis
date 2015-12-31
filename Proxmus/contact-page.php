<?php

/**
 * Template Name: Kontakt
 */

/** Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) exit( 'Cheatin&#8217; uh?' );

/*add_filter( 'body_class', 'add_contact_body_class' );*/
/**
 * Add page specific body class
 *
 * @param $classes array Body Classes
 * @return $classes array Modified Body Classes
 */
/*function add_contact_body_class( $classes ) {
	$classes[] = 'contact';
	return $classes;
}*/

/** Force Layout */
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

/** Remove Breadcrumbs */
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs');

//* Remove the post meta function
remove_action( 'genesis_after_post_content', 'genesis_post_meta' );
add_action( 'genesis_after_content', 'gs_contact_widget' );
function gs_contact_widget() {
	genesis_widget_area(
		'after-contact',
		array(
			'before' => '<div class="contact-sidebar-wrap">',
			'after' => '</div>'
		)
	);
}

genesis();