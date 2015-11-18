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
function gs_theme_setup()
{
	//Enable HTML5 Support
	add_theme_support('html5');

	// Remove Genesis Layout Settings
	//remove_theme_support('genesis-inpost-layouts');
	// Unregister content/sidebar layout setting
	genesis_unregister_layout('content-sidebar');
	// Unregister sidebar/content layout setting
	//genesis_unregister_layout('sidebar-content');
	// Unregister content/sidebar/sidebar layout setting
	genesis_unregister_layout('content-sidebar-sidebar');
	// Unregister sidebar/sidebar/content layout setting
	genesis_unregister_layout('sidebar-sidebar-content');
	// Unregister sidebar/content/sidebar layout setting
	genesis_unregister_layout('sidebar-content-sidebar');
	// Unregister full-width content layout setting
	//genesis_unregister_layout('full-width-content');

	/**
	 * Custom Colors
	 */
	/*function gs_customizer ( $wp_customize ) {
		// add new section
		$wp_customize->add_section( 'gs_theme_colors', array(
			'title' => __( 'Theme Colors', 'gs' ),
			'priority' => 100,
		) );

		// add color picker setting
		$wp_customize->add_setting( 'slider_bg', array(
			'default' => '#3e6b85'
		) );

		// add color picker control
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'slider_bg', array(
			'label' => 'Slider Background',
			'section' => 'gs_theme_colors',
			'settings' => 'slider_bg',
		) ) );
	}
	add_action( 'customize_register', 'gs_customizer' );*/

	/** Custom site title
	 * Add header_image as image
	 * Remove site description
	 * Remove header_image in background
	 */
	if(get_header_image()){
		add_filter('genesis_seo_title', 'gs_genesis_header_background_to_img', 10, 2);
		function gs_genesis_header_background_to_img($title, $inside)
		{
			$inline_logo = sprintf('<a href="%s" title="%s"><img src="' . get_header_image() . '" title="%s" alt="%s"/></a>', trailingslashit(home_url()), esc_attr(get_bloginfo('name')), esc_attr(get_bloginfo('name')), esc_attr(get_bloginfo('name')));
			$title = str_replace($inside, $inline_logo, $title);
			return $title;
		}
		remove_action('genesis_site_description', 'genesis_seo_site_description');
	};
	remove_action( 'wp_head', 'genesis_custom_header_style' );
	add_action( 'wp_head', 'gs_custom_header_style' );
	function gs_custom_header_style() {

		//* Do nothing if custom header not supported
		if ( ! current_theme_supports( 'custom-header' ) )
			return;

		//* Do nothing if user specifies their own callback
		if ( get_theme_support( 'custom-header', 'wp-head-callback' ) )
			return;

		$output = '';

		$header_image = get_header_image();
		$text_color   = get_header_textcolor();

		//* If no options set, don't waste the output. Do nothing.
		if ( empty( $header_image ) && ! display_header_text() && $text_color === get_theme_support( 'custom-header', 'default-text-color' ) )
			return;

		$header_selector = get_theme_support( 'custom-header', 'header-selector' );
		$title_selector  = genesis_html5() ? '.custom-header .site-title'       : '.custom-header #title';
		$desc_selector   = genesis_html5() ? '.custom-header .site-description' : '.custom-header #description';

		//* Header selector fallback
		if ( ! $header_selector )
			$header_selector = genesis_html5() ? '.custom-header .site-header' : '.custom-header #header';

		//* Header image CSS, if exists
		if ( $header_image )
			//$output .= sprintf( '%s { background: url(%s) no-repeat !important; }', $header_selector, esc_url( $header_image ) );
			$output .= '';

		//* Header text color CSS, if showing text
		if ( display_header_text() && $text_color !== get_theme_support( 'custom-header', 'default-text-color' ) )
			$output .= sprintf( '%2$s a, %2$s a:hover, %3$s { color: #%1$s !important; }', esc_html( $text_color ), esc_html( $title_selector ), esc_html( $desc_selector ) );

		if ( $output )
			printf( '<style type="text/css">%s</style>' . "\n", $output );

	}
/*
	add_action( 'genesis_before_header', 'beforeheader' );
	function beforeheader(){
		echo '<div class="site-inner before_header"><div class="wrap">xxxxxxxxxxxxxxxxxx</div></div>';
	}*/

	//Enable Post Navigation
	//add_action( 'genesis_after_entry_content', 'genesis_prev_next_post_nav', 5 );

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
	add_image_size( 'featured-image', 250, 180, TRUE );
	
	// Enable Custom Background
	add_theme_support( 'custom-background' );

	// Enable Custom Header
	add_theme_support('genesis-custom-header', array('width'=> 220, 'height'=> 100));

	// Add support for structural wraps
	add_theme_support( 'genesis-structural-wraps', array(
		'header',
		'nav',
		'subnav',
		'inner',
		'footer-widgets',
		'footer'
	) );

	/** Unregister Genesis widgets */
	add_action( 'widgets_init', 'unregister_genesis_widgets', 20 );
	function unregister_genesis_widgets() {
		unregister_widget( 'Genesis_eNews_Updates' );
		//unregister_widget( 'Genesis_Featured_Page' );
		//unregister_widget( 'Genesis_Featured_Post' );
		unregister_widget( 'Genesis_Latest_Tweets_Widget' );
		//unregister_widget( 'Genesis_Menu_Pages_Widget' );
		unregister_widget( 'Genesis_User_Profile_Widget' );
		//unregister_widget( 'Genesis_Widget_Menu_Categories' );
	}


	/**
	 * 07 Footer Widgets
	 * Add support for 3-column footer widgets
	 * Change 3 for support of up to 6 footer widgets (automatically styled for layout)
	 */
	add_theme_support( 'genesis-footer-widgets', 3 );

	remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

	/**
	 * 08 Genesis Menus
	 * Genesis Sandbox comes with 4 navigation systems built-in ready.
	 * Delete any menu systems that you do not wish to use.
	 */
	add_theme_support(
		'genesis-menus', 
		array(
			'primary'   => __( 'Primary Navigation Menu', CHILD_DOMAIN ), 
			'secondary' => __( 'Secondary Navigation Menu', CHILD_DOMAIN ),
			//'footer'    => __( 'Footer Navigation Menu', CHILD_DOMAIN ),
			'mobile'    => __( 'Mobile Navigation Menu', CHILD_DOMAIN ),
		)
	);

	//* Reposition the primary navigation menu
	unregister_sidebar( 'header-right' );
	remove_action( 'genesis_after_header', 'genesis_do_nav' );
	add_action( 'genesis_header', 'genesis_do_nav', 12 );

	//* Reposition the primary navigation menu
	//remove_action( 'genesis_after_header', 'genesis_do_nav' );
	//add_action( 'genesis_header', 'genesis_do_nav', 12 );
	
	// Add Mobile Navigation
	add_action( 'genesis_before', 'gs_mobile_navigation', 5 );

	//* Customize the site footer
	//remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
	remove_action( 'genesis_footer', 'genesis_do_footer' );
	//remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );
	function gs_custom_footer() {
		genesis_widget_area ('footercontent');
	};
	add_action( 'genesis_footer', 'gs_custom_footer' );


	//Enqueue Scripts
	add_action( 'wp_enqueue_scripts', 'gs_enqueue_scripts' );
	
	/**
	 * 13 Editor Styles
	 * Takes a stylesheet string or an array of stylesheets.
	 * Default: editor-style.css 
	 */
	//add_editor_style();

	/** Unregister  templates */
	function remove_genesis_page_templates( $page_templates ) {
		unset( $page_templates['page_archive.php'] );
		unset( $page_templates['page_blog.php'] );
		unset( $page_templates['page_landing.php'] );
		unset( $page_templates['page_portfolio.php'] );
		return $page_templates;
	}
	add_filter( 'theme_page_templates', 'remove_genesis_page_templates' );

	// Register Sidebars

	gs_register_sidebars();
	//unregister_sidebar( 'sidebar' );
	unregister_sidebar( 'sidebar-alt' );

} // End of Set Up Function

// Register Sidebars
function gs_register_sidebars() {
	$sidebars = array(
		array(
			'id'			=> 'home-slider',
			'name'			=> __( 'Rotator', CHILD_DOMAIN ),
			'description'	=> __( 'This is the most top homepage section.', CHILD_DOMAIN ),
		),
		array(
			'id'			=> 'home-top',
			'name'			=> __( 'Strona główna', CHILD_DOMAIN ),
			'description'	=> __( 'This is the top homepage section.', CHILD_DOMAIN ),
		),
		array(
			'id'			=> 'home-seo',
			'name'			=> __( 'Strona główna SEO', CHILD_DOMAIN ),
			'description'	=> __( 'This is the homepage bottom text.', CHILD_DOMAIN ),
		),
		array(
			'id'			=> 'after-contact',
			'name'			=> __( 'Pod kontaktem', CHILD_DOMAIN ),
			'description'	=> __( 'This will show up after contact content.', CHILD_DOMAIN ),
		),
		array(
			'id'          => 'footercontent',
			'name'        => __( 'Stopka witryny', CHILD_DOMAIN ),
			'description' => __( 'This is the general footer area.', CHILD_DOMAIN ),
		)
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

add_action( 'genesis_loop', 'gs_add_contact_body_class' );

/*EOF*/