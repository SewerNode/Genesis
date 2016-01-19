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
	/*add_theme_support( 'custom-header', array('height' => 100, 'width' => 290,) );*/
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

	/*add_filter( 'genesis_pre_load_favicon', 'gs_favicon_filter' );
	function gs_favicon_filter( $favicon_url ) {
		return get_stylesheet_directory_uri().'/images/favicon.ico';
	}*/

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
	
	// Custom Image Sizes
	//add_image_size( 'featured-image', 348, 448, TRUE );
	add_image_size( 'featured-image', 211, 271, TRUE );

	// Move image above post title in Genesis Framework 2.0
	remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
	add_action( 'genesis_entry_header', 'genesis_do_post_image', 8 );

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
		$args['labels']['category'] = ''; // Genesis 1.6 and later
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
	//add_theme_support( 'genesis-footer-widgets', 1 );


	remove_action( 'genesis_footer', 'genesis_do_footer' );
	function gs_custom_footer() {
		?>
		<div class="footer-top">
			<h3>Odwiedź nas w mediach społecznościowych:</h3>
			<a href="#" class="fb"></a>
			<a href="#" class="in"></a>
			<a href="#" class="gp"></a>
			<a href="#" class="dojazd"></a>
		</div>
		<div class="footer-bottom">
			<p>Copyright &copy; <?php echo date('Y'); ?> Kamea - Wszelkie prawa zastrzeżone. Kopiowanie zawartości serwisu lub jej części bez pisemnej zgody właścicieli serwisu jest zabronione.</p>
			<p class="rewizja"><a href="https://rewizja.net">Kreacja: Rewizja.net</a></p>
		</div>
	<?php
	}
	add_action( 'genesis_footer', 'gs_custom_footer' );

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
			'mobile'    => __( 'Mobile Navigation Menu', CHILD_DOMAIN ),
		)
	);

	//* Remove the entry meta in the entry footer (requires HTML5 theme support)
	remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

	//* Remove the post meta function
	remove_action( 'genesis_after_post_content', 'genesis_post_meta' );

	// Add Mobile Navigation
	add_action( 'genesis_before', 'gs_mobile_navigation', 5 );


	// add hook
add_filter( 'wp_nav_menu_objects', 'my_wp_nav_menu_objects_sub_menu', 10, 2 );
// filter_hook function to react on sub_menu flag
function my_wp_nav_menu_objects_sub_menu( $sorted_menu_items, $args ) {
	if ( isset( $args->sub_menu ) ) {
		$root_id = 0;

		// find the current menu item
		foreach ( $sorted_menu_items as $menu_item ) {
			if ( $menu_item->current ) {
				// set the root id based on whether the current menu item has a parent or not
				$root_id = ( $menu_item->menu_item_parent ) ? $menu_item->menu_item_parent : $menu_item->ID;
				break;
			}
		}

		// find the top level parent
		if ( ! isset( $args->direct_parent ) ) {
			$prev_root_id = $root_id;
			while ( $prev_root_id != 0 ) {
				foreach ( $sorted_menu_items as $menu_item ) {
					if ( $menu_item->ID == $prev_root_id ) {
						$prev_root_id = $menu_item->menu_item_parent;
						// don't set the root_id to 0 if we've reached the top of the menu
						if ( $prev_root_id != 0 ) $root_id = $menu_item->menu_item_parent;
						break;
					}
				}
			}
		}
		$menu_item_parents = array();
		foreach ( $sorted_menu_items as $key => $item ) {
			// init menu_item_parents
			if ( $item->ID == $root_id ) $menu_item_parents[] = $item->ID;
			if ( in_array( $item->menu_item_parent, $menu_item_parents ) ) {
				// part of sub-tree: keep!
				$menu_item_parents[] = $item->ID;
			} else if ( ! ( isset( $args->show_parent ) && in_array( $item->ID, $menu_item_parents ) ) ) {
				// not part of sub-tree: away with it!
				unset( $sorted_menu_items[$key] );
			}
		}

		return $sorted_menu_items;
	} else {
		return $sorted_menu_items;
	}
}

	/** dave's genesis code for making the submenu  **/
	add_action( 'wp_head', 'dc_add_tricky_menu' );
	function dc_add_tricky_menu () {
		// make all menus one level, or else dropdowns will be redundant in your submenu.
		add_filter( 'wp_nav_menu_args', 'my_wp_nav_menu_args' );
		// stick submenu under main menu. Of course you can use other hooks to put menu & submenu elsewhere.
		add_action( 'genesis_after_header', 'dc_add_tricky_two' );
	}

	function my_wp_nav_menu_args( $args = '' ) {
		$args['depth'] = 1;
		return $args;
	}

	function dc_add_tricky_two () {
		// this code is for retaining styling from the main menu, but giving you a class to re-style the menu if desired.
		echo '<nav class="nav-primary submenu" role="navigation" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" style="display:none;"><div class="wrap">';
		echo '<noscript><style type="text/css">.nav-primary.submenu {display:block !important;}</style></noscript>';
		echo '<script type="text/javascript"> jQuery(document).ready(function() {jQuery(".nav-primary.submenu").delay("200").slideDown("slow");}); </script>';
		wp_nav_menu( array(
			'theme_location' => 'primary',
			'container' => 'false',
			'menu_class' => 'genesis-nav-menu',
			'sub_menu' => true
		) );
		echo '</div></nav>';
	}
	/**** end of dave's submenu code ****/
	
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
	//unregister_widget( 'Genesis_Featured_Page' );
	//unregister_widget( 'Genesis_Featured_Post' );
	unregister_widget( 'Genesis_Latest_Tweets_Widget' );
	//unregister_widget( 'Genesis_Menu_Pages_Widget' );
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
			'name'			=> __( 'Główna - Baner Lewy', CHILD_DOMAIN ),
			'description'	=> __( 'This is the homepage left section.', CHILD_DOMAIN ),
		),
		array(
			'id'			=> 'home-middle-02',
			'name'			=> __( 'Główna - Baner Środkowy', CHILD_DOMAIN ),
			'description'	=> __( 'This is the homepage middle section.', CHILD_DOMAIN ),
		),
		array(
			'id'			=> 'home-middle-03',
			'name'			=> __( 'Główna - Baner Prawy', CHILD_DOMAIN ),
			'description'	=> __( 'This is the homepage right section.', CHILD_DOMAIN ),
		),
		array(
			'id'			=> 'home-bottom',
			'name'			=> __( 'Główna - Baner dolny', CHILD_DOMAIN ),
			'description'	=> __( 'This is the homepage right section.', CHILD_DOMAIN ),
		),
		array(
			'id'			=> 'prefooter',
			'name'			=> __( 'Główna - Przed stopką', CHILD_DOMAIN ),
			'description'	=> __( 'Use featured posts to showcase before footer.', CHILD_DOMAIN ),
		),
		/*array(
			'id'			=> 'portfolio',
			'name'			=> __( 'Portfolio', CHILD_DOMAIN ),
			'description'	=> __( 'Use featured posts to showcase your portfolio.', CHILD_DOMAIN ),
		),
		array(
			'id'			=> 'after-post',
			'name'			=> __( 'After Post', CHILD_DOMAIN ),
			'description'	=> __( 'This will show up after every post.', CHILD_DOMAIN ),
		),*/
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

