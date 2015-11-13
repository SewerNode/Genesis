<?php
/**
 * Home Page.
 *
 * @category   Genesis_Sandbox
 * @package    Templates
 * @subpackage Home
 * @author     Travis Smith and Jonathan Perez, for Surefire Themes
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link       http://wpsmith.net/
 * @since      1.1.0
 */

add_action( 'get_header', 'gs_home_helper' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 */
function gs_home_helper() {
	if ( is_active_sidebar( 'home-slider' ) || is_active_sidebar( 'home-top' ) || is_active_sidebar( 'home-middle-01' ) /*|| is_active_sidebar( 'home-middle-02' )*/ || is_active_sidebar( 'home-middle-03' ) || is_active_sidebar( 'home-bottom' ) ) {
        add_action( 'genesis_after_header', 'gs_home_slider_widget' );
        remove_action( 'genesis_loop', 'genesis_do_loop' );
        add_action( 'genesis_loop', 'gs_home_widgets' );
		add_action( 'genesis_before_footer', 'gs_home_seo_widget' );
        /** Force Full Width */
        add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
        add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );
	}
}
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 */
function gs_home_slider_widget() {
	genesis_widget_area(
		'home-slider',
		array(
			'before' => '<div class="site-inner home-slider"><div class="wrap"><div class="content-sidebar-wrap">',
			'after' => '</div></div></div>'
		)
	);
}
function gs_home_widgets() {
    genesis_widget_area(
        'home-top',
        array(
	        /*'before' => '<div class="site-inner home-slider"><div class="wrap"><div class="content-sidebar-wrap">',
	        'after' => '</div></div></div>'*/

	        'before' => '<aside id="home-top" class="home-widget widget-area">', )
    );
    echo '<div id="home-middle" class="home-middle">';
    genesis_widget_area(
        'home-middle-01',
        array(
            'before' => '<aside id="home-middle-01" class="first one-half"><div class="home-widget widget-area">',
            'after' => '</div></aside><!-- end #home-left -->',
        )
    );
    /*genesis_widget_area(
        'home-middle-02',
        array(
            'before' => '<aside id="home-middle-01" class="one-third"><div class="home-widget widget-area">',
            'after' => '</div></aside><!-- end #home-middle -->',
        )
    );*/
    genesis_widget_area(
        'home-middle-03',
        array(
            'before' => '<aside id="home-right" class="one-half"><div class="home-widget widget-area">',
            'after' => '</div></aside><!-- end #home-right -->',
        )
    );
    echo '</div>';
    genesis_widget_area(
        'home-bottom',
        array(
            'before' => '<aside id="home-bottom"><div class="home-widget widget-area">',
            'after' => '</div></aside><!-- end #home-bottom -->',
        )
    );
}
function gs_home_seo_widget() {
	genesis_widget_area(
		'home-seo',
		array(
			'before' => '<div class="site-inner home-seo"><div class="wrap"><div class="content-sidebar-wrap">',
			'after' => '</div></div></div>'
		)
	);
}
genesis();
/** EndOfFront-Page */