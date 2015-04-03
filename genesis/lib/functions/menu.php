<?php
/**
 * Genesis Framework.
 *
 * WARNING: This file is part of the core Genesis Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package Genesis\Menus
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/genesis/
 */

/**
 * Determine if a child theme supports a particular Genesis nav menu.
 *
 * @since 1.8.0
 *
 * @param string $menu Name of the menu to check support for.
 *
 * @return boolean True if menu supported, false otherwise.
 */
function genesis_nav_menu_supported( $menu ) {

	if ( ! current_theme_supports( 'genesis-menus' ) )
		return false;

	$menus = get_theme_support( 'genesis-menus' );

	if ( array_key_exists( $menu, (array) $menus[0] ) )
		return true;

	return false;

}

/**
 * Determine if the Superfish script is enabled.
 *
 * If child theme supports HTML5 and the Load Superfish Script theme setting is checked, or if the
 * `genesis_superfish_enabled` filter is true, then this function returns true. False otherwise.
 *
 * @since 1.9.0
 *
 * @uses genesis_html5()      Check for HTML5 support.
 * @uses genesis_get_option() Get Theme settings value.
 *
 * @return boolean True if Superfish is enabled, false otherwise.
 */
function genesis_superfish_enabled() {

	return ( ! genesis_html5() && genesis_get_option( 'superfish' ) ) || apply_filters( 'genesis_superfish_enabled', false );

}

/**
 * Return the markup to display a menu consistent with the Genesis format.
 *
 * Applies the `genesis_$location_nav` filter e.g. `genesis_header_nav`. For primary and secondary menu locations, it
 * also applies the `genesis_do_nav` and `genesis_do_subnav` filters for backwards compatibility.
 *
 * @since 2.1.0
 *
 * @uses genesis_markup()             Contextual markup.
 * @uses genesis_html5()              Check for HTML5 support.
 * @uses genesis_structural_wrap()    Adds optional internal wrap divs.
 *
 * @param string $args Menu arguments.
 *
 * @return string Navigation menu markup.
 */
function genesis_get_nav_menu( $args = array() ) {

	$args = wp_parse_args( $args, array(
		'theme_location' => '',
		'container'      => '',
		'menu_class'     => 'menu genesis-nav-menu',
		'echo'           => 0,
	) );

	//* If a menu is not assigned to theme location, abort
	if ( ! has_nav_menu( $args['theme_location'] ) ) {
		return;
	}

	$sanitized_location = sanitize_key( $args['theme_location'] );

	$nav = wp_nav_menu( $args );

	//* Do nothing if there is nothing to show
	if ( ! $nav ) {
		return;
	}

	$xhtml_id = $args['theme_location'];

	if ( 'primary' === $args['theme_location'] ) {
		$xhtml_id = 'nav';
	} elseif ( 'secondary' === $args['theme_location'] ) {
		$xhtml_id = 'subnav';
	}

	$nav_markup_open = genesis_markup( array(
		'html5'   => '<nav %s>',
		'xhtml'   => '<div id="' . $xhtml_id . '">',
		'context' => 'nav-' . $sanitized_location,
		'echo'    => false,
	) );
	$nav_markup_open .= genesis_structural_wrap( 'menu-' . $sanitized_location, 'open', 0 );

	$nav_markup_close  = genesis_structural_wrap( 'menu-' . $sanitized_location, 'close', 0 );
	$nav_markup_close .= genesis_html5() ? '</nav>' : '</div>';

	$nav_output = $nav_markup_open . $nav . $nav_markup_close;

	$filter_location = 'genesis_' . $sanitized_location . '_nav';

	//* Handle back-compat for primary and secondary nav filters.
	if ( 'primary' === $args['theme_location'] ) {
		$filter_location = 'genesis_do_nav';
	} elseif ( 'secondary' === $args['theme_location'] ) {
		$filter_location = 'genesis_do_subnav';
	}

	/**
	 * Filter the navigation markup.
	 *
	 * @since 2.1.0
	 *
	 * @param string $nav_output Opening container markup, nav, closing container markup.
	 * @param string $nav Navigation list (`<ul>`).
	 * @param array $args {
	 *     Arguments for `wp_nav_menu()`.
	 *
	 *     @type string $theme_location Menu location ID.
	 *     @type string $container Container markup.
	 *     @type string $menu_class Class(es) applied to the `<ul>`.
	 *     @type bool $echo 0 to indicate `wp_nav_menu()` should return not echo.
	 * }
	 */
	return apply_filters( $filter_location, $nav_output, $nav, $args );
}

/**
 * Echo the output from `genesis_get_nav_menu()`.
 *
 * @since 2.1.0
 *
 * @uses genesis_get_nav_menu() Return the markup to display a menu consistent with the Genesis format.
 *
 * @param string $args Menu arguments.
 */
function genesis_nav_menu( $args ) {
	echo genesis_get_nav_menu( $args );
}

/**
 * Echo or return a pages or categories menu.
 *
 * Now only used for backwards-compatibility (genesis_vestige).
 *
 * The array of menu arguments (and their defaults) are:
 *
 *  - theme_location => ''
 *  - type           => 'pages'
 *  - sort_column    => 'menu_order, post_title'
 *  - menu_id        => false
 *  - menu_class     => 'nav'
 *  - echo           => true
 *  - link_before    => ''
 *  - link_after     => ''
 *
 * Themes can short-circuit the function early by filtering on `genesis_pre_nav` or on the string of list items via
 * `genesis_nav_items`. They can also filter the complete menu markup via `genesis_nav`. The `$args` (merged with
 * defaults) are available for all filters.
 *
 * @since 0.2.3
 *
 * @uses genesis_get_seo_option() Get SEO setting value.
 * @uses genesis_rel_nofollow()   Add `rel="nofollow"` attribute and value to all links.
 *
 * @see genesis_do_nav()
 * @see genesis_do_subnav()
 *
 * @param array $args Menu arguments.
 *
 * @return string HTML for menu, unless `genesis_pre_nav` returns something truthy.
 */
function genesis_nav( $args = array() ) {

	if ( isset( $args['context'] ) )
		_deprecated_argument( __FUNCTION__, '1.2', __( 'The argument, "context", has been replaced with "theme_location" in the $args array.', 'genesis' ) );

	//* Default arguments
	$defaults = array(
		'theme_location' => '',
		'type'           => 'pages',
		'sort_column'    => 'menu_order, post_title',
		'menu_id'        => false,
		'menu_class'     => 'nav',
		'echo'           => true,
		'link_before'    => '',
		'link_after'     => '',
	);

	$defaults = apply_filters( 'genesis_nav_default_args', $defaults );
	$args     = wp_parse_args( $args, $defaults );

	//* Allow child theme to short-circuit this function
	$pre = apply_filters( 'genesis_pre_nav', false, $args );
	if ( $pre )
		return $pre;

	$menu = '';

	$list_args = $args;

	//* Show Home in the menu (mostly copied from WP source)
	if ( isset( $args['show_home'] ) && ! empty( $args['show_home'] ) ) {
		if ( true === $args['show_home'] || '1' === $args['show_home'] || 1 === $args['show_home'] )
			$text = apply_filters( 'genesis_nav_home_text', __( 'Home', 'genesis' ), $args );
		else
			$text = $args['show_home'];

		if ( is_front_page() && ! is_paged() )
			$class = 'class="home current_page_item"';
		else
			$class = 'class="home"';

		$home = '<li ' . $class . '><a href="' . trailingslashit( home_url() ) . '">' . $args['link_before'] . $text . $args['link_after'] . '</a></li>';

		$menu .= genesis_get_seo_option( 'nofollow_home_link' ) ? genesis_rel_nofollow( $home ) : $home;

		//* If the front page is a page, add it to the exclude list
		if ( 'page' === get_option( 'show_on_front' ) && 'pages' === $args['type'] ) {
			$list_args['exclude'] .= $list_args['exclude'] ? ',' : '';

			$list_args['exclude'] .= get_option( 'page_on_front' );
		}
	}

	$list_args['echo']     = false;
	$list_args['title_li'] = '';

	//* Add menu items
	if ( 'pages' === $args['type'] )
		$menu .= str_replace( array( "\r", "\n", "\t" ), '', wp_list_pages( $list_args ) );
	elseif ( 'categories' === $args['type'] )
		$menu .= str_replace( array( "\r", "\n", "\t" ), '', wp_list_categories( $list_args ) );

	//* Apply filters to the nav items
	$menu = apply_filters( 'genesis_nav_items', $menu, $args );

	$menu_class = ( $args['menu_class'] ) ? ' class="' . esc_attr( $args['menu_class'] ) . '"' : '';
	$menu_id    = ( $args['menu_id'] ) ? ' id="' . esc_attr( $args['menu_id'] ) . '"' : '';

	if ( $menu )
		$menu = '<ul' . $menu_id . $menu_class . '>' . $menu . '</ul>';

	//* Apply filters to the final nav output
	$menu = apply_filters( 'genesis_nav', $menu, $args );

	if ( $args['echo'] )
		echo $menu;
	else
		return $menu;

}
