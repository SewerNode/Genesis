<?php
/**
 * Twenty Fifteen back compat functionality
 *
 * Prevents Twenty Fifteen from running on WordPress versions prior to 4.1,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 4.1.
 *
 * @package WordPress
 * @subpackage  Aga_ma_smaka_2015
 * @since Aga ma smaka 1.0
 */

/**
 * Prevent switching to Twenty Fifteen on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 * @since Aga ma smaka 1.0
 */
function agamasmaka_switch_theme() {
	switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'agamasmaka_upgrade_notice' );
}
add_action( 'after_switch_theme', 'agamasmaka_switch_theme' );

/**
 * Add message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * Twenty Fifteen on WordPress versions prior to 4.1.
 *
 * @since Aga ma smaka 1.0
 */
function agamasmaka_upgrade_notice() {
	$message = sprintf( __( 'Twenty Fifteen requires at least WordPress version 4.1. You are running version %s. Please upgrade and try again.', 'agamasmaka' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevent the Customizer from being loaded on WordPress versions prior to 4.1.
 *
 * @since Aga ma smaka 1.0
 */
function agamasmaka_customize() {
	wp_die( sprintf( __( 'Twenty Fifteen requires at least WordPress version 4.1. You are running version %s. Please upgrade and try again.', 'agamasmaka' ), $GLOBALS['wp_version'] ), '', array(
		'back_link' => true,
	) );
}
add_action( 'load-customize.php', 'agamasmaka_customize' );

/**
 * Prevent the Theme Preview from being loaded on WordPress versions prior to 4.1.
 *
 * @since Aga ma smaka 1.0
 */
function agamasmaka_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( __( 'Twenty Fifteen requires at least WordPress version 4.1. You are running version %s. Please upgrade and try again.', 'agamasmaka' ), $GLOBALS['wp_version'] ) );
	}
}
add_action( 'template_redirect', 'agamasmaka_preview' );
