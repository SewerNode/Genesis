<?php

/**
 * Home Page.
 */

add_action( 'get_header', 'home_helper' );
function home_helper() {
	add_action( 'genesis_after_header', 'home_slider' );
	if ( is_active_sidebar( 'home-top' ) || is_active_sidebar( 'home-middle' ) || is_active_sidebar( 'home-bottom' ) ) {
		remove_action( 'genesis_loop', 'genesis_do_loop' );
		add_action( 'genesis_loop', 'genesis_do_loop' );
		add_action( 'genesis_loop', 'home_widgets' );
		remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
		/** Force Full Width */
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
		add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

	}
}

function home_slider() {
	genesis_widget_area(
		'home-slider',
		array(
			'before' => '<div id="home-slider" class="home-widget widget-area home-slider">',
			'after' => '</div>'
			)
	);
}
function home_widgets() {
	genesis_widget_area(
		'home-top',
		array(
			'before' => '<aside id="home-top" class="home-widget widget-area">',
			'after' => '</aside>'
			)
	);

	genesis_widget_area(
		'home-middle',
		array(
			'before' => '<aside id="home-middle"><div class="home-widget widget-area">',
			'after' => '</div></aside>'
		)
	);

	genesis_widget_area(
		'home-bottom',
		array(
			'before' => '<aside id="home-bottom"><div class="home-widget widget-area">',
			'after' => '</div></aside>'
		)
	);
}

genesis();