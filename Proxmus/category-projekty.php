<?php

/**
 * Template Name: Archive
 *
 * This file adds the Landing template. This file assumes that nothing has been moved
 * from the Genesis default.
 *
 * @category   Genesis_Sandbox
 * @package    Templates
 * @subpackage Page
 * @author     Travis Smith
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link       http://wpsmith.net/
 * @since      1.1.0
 */

/** Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) exit( 'Cheatin&#8217; uh?' );

add_filter( 'body_class', 'gs_add_landing_body_class' );
/**
 * Add page specific body class
 *
 * @param $classes array Body Classes
 * @return $classes array Modified Body Classes
 */
function gs_add_landing_body_class( $classes ) {
	$classes[] = 'landing category-grid';
	return $classes;
}

/** Force Layout */
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

add_filter( 'genesis_entry_heade', 'genesis_post_meta' );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

/** Remove Breadcrumbs */
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs');

/** Remove Footer Widgets */
//remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );

//* Remove the post meta function
remove_action( 'genesis_after_post_content', 'genesis_post_meta' );


genesis();