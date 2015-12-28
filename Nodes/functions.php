<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Nodes' );
define( 'CHILD_THEME_URL', 'NODE Seweryn Kreja' );
define( 'CHILD_THEME_VERSION', '1.0.0' );

//* Enqueue Google Fonts
add_action( 'wp_enqueue_scripts', 'genesis_sample_google_fonts' );
function genesis_sample_google_fonts() {
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lato:300,400,700', array(), CHILD_THEME_VERSION );
}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

//* Add Accessibility support
add_theme_support( 'genesis-accessibility', array( 'headings', 'drop-down-menu',  'search-form', 'skip-links', 'rems' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Unregister content/sidebar layout setting
genesis_unregister_layout( 'content-sidebar' );
//* Unregister content/sidebar/sidebar layout setting
genesis_unregister_layout( 'content-sidebar-sidebar' );
//* Unregister sidebar/sidebar/content layout setting
genesis_unregister_layout( 'sidebar-sidebar-content' );
//* Unregister sidebar/content/sidebar layout setting
genesis_unregister_layout( 'sidebar-content-sidebar' );

//* Unregister Genesis widgets
add_action( 'widgets_init', 'unregister_genesis_widgets', 20 );
function unregister_genesis_widgets() {
	unregister_widget( 'Genesis_eNews_Updates' );
	unregister_widget( 'Genesis_Featured_Page' );
	unregister_widget( 'Genesis_Featured_Post' );
	unregister_widget( 'Genesis_Latest_Tweets_Widget' );
	unregister_widget( 'Genesis_Menu_Pages_Widget' );
	unregister_widget( 'Genesis_User_Profile_Widget' );
	unregister_widget( 'Genesis_Widget_Menu_Categories' );
}

/* ============================== */
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

/***** dave's genesis code for making the submenu  **/
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
	echo '<script type="text/javascript">$(document).ready(function(){$("#submenu").css("display","block");});</script>';
	echo '<nav id="submenu" class="nav-primary submenu" role="navigation" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement"><div class="wrap">';
	wp_nav_menu( array(
		'theme_location' => 'primary',
		'container' => 'false',
		'menu_class' => 'genesis-nav-menu',
		'sub_menu' => true
	) );
	echo '</div></nav>';
}
/**** end of dave's submenu code ****/