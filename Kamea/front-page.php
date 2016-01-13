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
 *
 */
function gs_home_helper() {

        if ( is_active_sidebar( 'rotator' ) || is_active_sidebar( 'home-middle-01' ) || is_active_sidebar( 'home-middle-02' ) || is_active_sidebar( 'home-middle-03' ) || is_active_sidebar( 'home-bottom' ) ) {
	        add_action( 'genesis_after_header', 'gs_home_rotator' );
            remove_action( 'genesis_loop', 'genesis_do_loop' );
            add_action( 'genesis_loop', 'gs_home_loop' );
            add_action( 'genesis_loop', 'gs_home_widgets' );
            add_action( 'genesis_before_footer', 'gs_do_prefooter' );
            /** Force Full Width */
            add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
            add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );
                
        }
}

/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function gs_home_rotator() {
	genesis_widget_area(
		'rotator',
		array(
			'before' => '<div id="rotator">',
			'after'=>'</div>'
		)
	);
}
// Home Loop
function gs_home_loop() {
	genesis_standard_loop();
}
function gs_home_widgets() {

    echo '<div id="home-middle" class="home-middle">';
    genesis_widget_area(
        'home-middle-01',
        array(
                'before' => '<aside id="home-left" class="first one-third"><div class="home-widget widget-area">',
                'after' => '</div></aside><!-- end #home-left -->',
        )
    );

    genesis_widget_area(
        'home-middle-02',
        array(
                'before' => '<aside id="home-center" class="one-third"><div class="home-widget widget-area">',
                'after' => '</div></aside><!-- end #home-middle -->',
        )
    );

    genesis_widget_area(
        'home-middle-03',
        array(
                'before' => '<aside id="home-right" class="one-third"><div class="home-widget widget-area">',
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
// Add Widget Prefooter
function gs_do_prefooter() {
	genesis_widget_area(
		'prefooter',
		array(
			'before' => '<div id="footer-widgets" class="footer-widgets gs-footer-widgets-1"><div class="wrap"><div class="footer-widgets-1 widget-area first ">',
			'after' => '</div></div></div>',
		)
	);
}
genesis();