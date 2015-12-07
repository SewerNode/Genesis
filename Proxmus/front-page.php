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
	if ( is_active_sidebar( 'home-slider' ) || is_active_sidebar( 'home-top' ) || is_active_sidebar( 'home-bottom' ) ) {
        add_action( 'genesis_after_header', 'gs_home_slider_widget' );
        remove_action( 'genesis_loop', 'genesis_do_loop' );
		add_action( 'genesis_after_header', 'gs_home_widgets' );
		add_action( 'genesis_before_footer', 'gs_map_widgets' );
        /** Force Full Width */
        add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
        add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );
	}
}
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 */
function gs_home_slider_widget() {
	//if( function_exists('cyclone_slider') ) cyclone_slider('testowy-rotator');
	genesis_widget_area(
		'home-slider',
		array()
	);
}
function gs_home_widgets() {
	genesis_widget_area(
		'home-seo',
		array(
			'before' => '<div class="site-inner home-seo"><div class="wrap"><div class="home-widget widget-area">',
			'after' => '</div></div></div>'
		)
	);
    genesis_widget_area(
        'home-top',
        array(
	        'before' => '<div class="site-inner home-top"><div class="wrap"><div class="home-widget widget-area">',
	        'after' => '</div></div></div>'
        )
    );

}
add_action( 'genesis_loop', 'homelinks' );
function homelinks(){
	echo '<div class="site-inner home-links"><div class="wrap"><div class="home-widget widget-area">';
	echo '<div class="home_box">
		<img src="'.get_stylesheet_directory_uri().'/images/skrawanie.jpg" alt="OBRÓBKA SKRAWANIEM" />
		<h2>OBRÓBKA SKRAWANIEM</h2>
		<a href="'.home_url('/oferta/elementy-wielkogabarytowe').'">'.__('Elementy wielkogabarytowe').'</a>
		<a href="'.home_url('/oferta/ciecie-i-ksztaltowanie-profili').'">'.__('Cięcie i kształtowanie profili').'</a>
		</div>
		<div class="home_box">
		<img src="'.get_stylesheet_directory_uri().'/images/instalacje.jpg" alt="INSTALACJE I TECHNOLOGIA" />
		<h2>INSTALACJE I TECHNOLOGIA</h2>
		<a href="'.home_url('/oferta/linie-technologiczne').'">'.__('Linie technologiczne').'</a>
		<a href="'.home_url('/oferta/konstrukcje-stalowe').'">'.__('Konstrukcje stalowe').'</a>
		<a href="'.home_url('/oferta/wykonawstwo-maszyn').'">'.__('Wykonawstwo maszyn').'</a>
		</div>
		<div class="home_box">
		<img src="'.get_stylesheet_directory_uri().'/images/czesci.jpg" alt="CZĘŚCI ZAMIENNE I MODERNIZACJE" />
		<h2>REMONTY, MODERNIZACJE I CZĘŚCI ZAMIENNE</h2>
		<a href="'.home_url('/oferta/remonty-maszyn-i-urzadzen').'">'.__('Remonty maszyn i urządzeń').'</a>
		<a href="'.home_url('/oferta/wykonawstwo-czesci-zamiennych').'">'.__('Wykonawstwo części zamiennych').'</a>
		<a href="'.home_url('/oferta/modernizacja-maszyn').'">'.__('Modernizacja maszyn').'</a>
		</div>
		<div class="home_box">
		<img src="'.get_stylesheet_directory_uri().'/images/urzadzenia.jpg" alt="URZĄDZENIA PROCESOWE" />
		<h2>URZĄDZENIA PROCESOWE</h2>
		<a href="'.home_url('/oferta/wykonawstwo-urzadzen-procesowych').'">'.__('Wykonawstwo urządzeń procesowych').'</a>
		<a href="'.home_url('/oferta/zbiorniki').'">'.__('Zbiorniki').'</a>
		<a href="'.home_url('/oferta/wykonawstwo-na-zamowienie').'">'.__('Wykonawstwo na zamówienie').'</a>
		</div>';
	echo '</div></div></div>';
}
function gs_map_widgets() {
	genesis_widget_area(
		'home-bottom',
		array(
			'before' => '<div class="site-inner home-bottom"><div class="wrap"><div class="home-widget widget-area">',
			'after' => '</div></div></div>'
		)
	);
}

genesis();
/** EndOfFront-Page */