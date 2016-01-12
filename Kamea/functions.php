<?php

/**
 * Custom amendments for the theme.
 *
 * @category   Genesis_Sandbox
 * @package    Functions
 * @subpackage Functions
 * @author     Travis Smith and Jonathan Perez
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link       http://surefirewebservices.com/
 * @since      1.1.0
 */

// Initialize Sandbox ** DON'T REMOVE **
require_once( get_stylesheet_directory() . '/lib/init.php');

add_action( 'genesis_setup', 'gs_theme_setup', 15 );

//Theme Set Up Function
function gs_theme_setup() {
	
	//Enable HTML5 Support
	add_theme_support( 'html5' );
	genesis_unregister_layout('content-sidebar');
	genesis_unregister_layout('sidebar-content');
	genesis_unregister_layout('content-sidebar-sidebar');
	genesis_unregister_layout('sidebar-sidebar-content');
	genesis_unregister_layout('sidebar-content-sidebar');

	/** Unregister  templates */
	function remove_genesis_page_templates( $page_templates ) {
		unset( $page_templates['page_archive.php'] );
		unset( $page_templates['page_blog.php'] );
		unset( $page_templates['page_landing.php'] );
		unset( $page_templates['page_portfolio.php'] );
		return $page_templates;
	}
	add_filter( 'theme_page_templates', 'remove_genesis_page_templates' );

	/** Custom site title
	 * Add header_image as image
	 * Remove site description
	 * Remove header_image in background
	 */
	if(get_header_image()){
		add_filter('genesis_seo_title', 'gs_genesis_header_background_to_img', 10, 2);
		function gs_genesis_header_background_to_img($title, $inside)
		{
			$inline_logo = sprintf('<a href="%s" title="%s"><img src="'.get_header_image().'" title="%s" alt="%s"/></a>', trailingslashit(home_url()), esc_attr(get_bloginfo('name')), esc_attr(get_bloginfo('name')), esc_attr(get_bloginfo('name')));
			$title = str_replace($inside, $inline_logo, $title);
			return $title;
		}
		remove_action('genesis_site_description', 'genesis_seo_site_description');
	};

	//Enable Post Navigation
	add_action( 'genesis_after_entry_content', 'genesis_prev_next_post_nav', 5 );

	/** 
	 * 01 Set width of oEmbed
	 * genesis_content_width() will be applied; Filters the content width based on the user selected layout.
	 *
	 * @see genesis_content_width()
	 * @param integer $default Default width
	 * @param integer $small Small width
	 * @param integer $large Large width
	 */
	$content_width = apply_filters( 'content_width', 600, 430, 920, 1152 );
	
	//Custom Image Sizes
	add_image_size( 'featured-image', 225, 160, TRUE );
	
	// Enable Custom Background
	//add_theme_support( 'custom-background' );

	// Enable Custom Header
	//add_theme_support('genesis-custom-header', array('width'=> 300, 'height'=> 100));

	// Add support for structural wraps
	add_theme_support( 'genesis-structural-wraps', array(
		'header',
		'nav',
		'subnav',
		'inner',
		'footer-widgets',
		'footer'
	) );

	add_filter( 'genesis_breadcrumb_args', 'sp_breadcrumb_args' );
	function sp_breadcrumb_args( $args ) {
		$args['home'] = 'STRONA GŁÓWNA';
		$args['sep'] = ' <span class="separator"><i class="fa fa-chevron-right"></i></span> ';
		$args['list_sep'] = ', '; // Genesis 1.5 and later
		$args['prefix'] = '<div class="breadcrumb">';
		$args['suffix'] = '</div>';
		$args['heirarchial_attachments'] = true; // Genesis 1.5 and later
		$args['heirarchial_categories'] = true; // Genesis 1.5 and later
		$args['display'] = true;
		$args['labels']['prefix'] = '<span class="separator"><i class="fa fa-square"></i></span> ';
		$args['labels']['author'] = 'Archiwum ';
		$args['labels']['category'] = 'Kategoria '; // Genesis 1.6 and later
		$args['labels']['tag'] = 'Tag ';
		$args['labels']['date'] = 'Data ';
		$args['labels']['search'] = 'Wynik wyszukiwania dla ';
		$args['labels']['tax'] = 'Archives for ';
		$args['labels']['post_type'] = 'Archives for ';
		$args['labels']['404'] = 'Nie znaleziono: '; // Genesis 1.5 and later
		return $args;
	}


	/**
	 * 07 Footer Widgets
	 * Add support for 3-column footer widgets
	 * Change 3 for support of up to 6 footer widgets (automatically styled for layout)
	 */
	add_theme_support( 'genesis-footer-widgets', 1 );

	/**
	 * 08 Genesis Menus
	 * Genesis Sandbox comes with 4 navigation systems built-in ready.
	 * Delete any menu systems that you do not wish to use.
	 */
	add_theme_support(
		'genesis-menus', 
		array(
			'primary'   => __( 'Primary Navigation Menu', CHILD_DOMAIN ), 
			//'secondary' => __( 'Secondary Navigation Menu', CHILD_DOMAIN ),
			'mobile'    => __( 'Mobile Navigation Menu', CHILD_DOMAIN ),
		)
	);
	
	// Add Mobile Navigation
	add_action( 'genesis_before', 'gs_mobile_navigation', 5 );
	
	//Enqueue Sandbox Scripts
	add_action( 'wp_enqueue_scripts', 'gs_enqueue_scripts' );
	
	/**
	 * 13 Editor Styles
	 * Takes a stylesheet string or an array of stylesheets.
	 * Default: editor-style.css 
	 */
	//add_editor_style();

	// Register Sidebars
	add_action( 'widgets_init', 'unregister_genesis_widgets', 20 );
	unregister_sidebar( 'sidebar' );
	unregister_sidebar( 'sidebar-alt' );
	unregister_sidebar( 'header-right' );
	gs_register_sidebars();
} // End of Set Up Function

// Register Sidebars
function unregister_genesis_widgets() {
	unregister_widget( 'Genesis_eNews_Updates' );
	unregister_widget( 'Genesis_Featured_Page' );
	unregister_widget( 'Genesis_Featured_Post' );
	unregister_widget( 'Genesis_Latest_Tweets_Widget' );
	unregister_widget( 'Genesis_Menu_Pages_Widget' );
	unregister_widget( 'Genesis_User_Profile_Widget' );
	unregister_widget( 'Genesis_Widget_Menu_Categories' );
}
function gs_register_sidebars() {
	$sidebars = array(
		array(
			'id'			=> 'search',
			'name'			=> __( 'Wyszukiwarka', CHILD_DOMAIN ),
			'description'	=> __( 'This is the top section.', CHILD_DOMAIN ),
		),
		array(
			'id'			=> 'rotator',
			'name'			=> __( 'Rotator', CHILD_DOMAIN ),
			'description'	=> __( 'This is the top homepage section.', CHILD_DOMAIN ),
		),
		array(
			'id'			=> 'home-middle-01',
			'name'			=> __( 'Baner Lewy', CHILD_DOMAIN ),
			'description'	=> __( 'This is the homepage left section.', CHILD_DOMAIN ),
		),
		array(
			'id'			=> 'home-middle-02',
			'name'			=> __( 'Baner Środkowy', CHILD_DOMAIN ),
			'description'	=> __( 'This is the homepage middle section.', CHILD_DOMAIN ),
		),
		array(
			'id'			=> 'home-middle-03',
			'name'			=> __( 'Baner Prawy', CHILD_DOMAIN ),
			'description'	=> __( 'This is the homepage right section.', CHILD_DOMAIN ),
		),
		array(
			'id'			=> 'home-bottom',
			'name'			=> __( 'Home Bottom', CHILD_DOMAIN ),
			'description'	=> __( 'This is the homepage right section.', CHILD_DOMAIN ),
		),
		array(
			'id'			=> 'portfolio',
			'name'			=> __( 'Portfolio', CHILD_DOMAIN ),
			'description'	=> __( 'Use featured posts to showcase your portfolio.', CHILD_DOMAIN ),
		),
		array(
			'id'			=> 'after-post',
			'name'			=> __( 'After Post', CHILD_DOMAIN ),
			'description'	=> __( 'This will show up after every post.', CHILD_DOMAIN ),
		),
	);
	
	foreach ( $sidebars as $sidebar )
		genesis_register_sidebar( $sidebar );
}

/**
 * Enqueue and Register Scripts - Twitter Bootstrap, Font-Awesome, and Common.
 */
require_once('lib/scripts.php');

/**
 * Add navigation menu 
 * Required for each registered menu.
 * 
 * @uses gs_navigation() Sandbox Navigation Helper Function in gs-functions.php.
 */

//Add Mobile Menu
function gs_mobile_navigation() {
	
	$mobile_menu_args = array(
		'echo' => true,
	);
	
	gs_navigation( 'mobile', $mobile_menu_args );
}

// Add Widget Area For Search
add_action('genesis_before_header', 'gs_search');
function gs_search() {
	genesis_widget_area(
		'search',
		array(
			'before' => '<div id="search-area" class="search-area"><div class="wrap"><div class="widget-area">',
			'after' => '</div></div></div>',
		)
	);
}

// Add Widget Area After Post
add_action('genesis_after_entry', 'gs_do_after_entry');
function gs_do_after_entry() {
 	if ( is_single() ) {
 	genesis_widget_area( 
                'after-post', 
                array(
                        'before' => '<aside id="after-post" class="after-post"><div class="home-widget widget-area">', 
                        'after' => '</div></aside><!-- end #home-left -->',
                ) 
        );
 }
 }
