<?php
/**
 * Genesis Framework.
 *
 * WARNING: This file is part of the core Genesis Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package Genesis\Updates
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/genesis/
 */

/**
 * Calculate or return the first version of Genesis to run on this site.
 *
 * @since 2.1.0
 *
 * @uses genesis_get_option() Get theme setting value.
 * @uses PARENT_THEME_VERSION Genesis version string.
 *
 * @return sting First version.
 */
function genesis_first_version() {

	$first_version = genesis_get_option( 'first_version' );

	if ( ! $first_version ) {
		$first_version = PARENT_THEME_VERSION;
	}

	return $first_version;

}

/**
 * Helper function for comparing the "first install" version to a user specified version.
 *
 * @since 2.1.0
 *
 * @uses version_compare()    Compare two versions.
 * @uses genesis_get_option() Get theme setting value.
 *
 * @return bool
 */
function genesis_first_version_compare( $version, $operator  ) {

	return version_compare( genesis_first_version(), $version, $operator );

}

/**
 * Ping http://api.genesistheme.com/ asking if a new version of this theme is available.
 *
 * If not, it returns false.
 *
 * If so, the external server passes serialized data back to this function, which gets unserialized and returned for use.
 *
 * Applies `genesis_update_remote_post_options` filter.
 *
 * Ping occurs at a maximum of once every 24 hours.
 *
 * @since 1.1.0
 *
 * @uses genesis_get_option() Get theme setting value.
 * @uses genesis_html5()      Check for HTML5 support.
 * @uses PARENT_THEME_VERSION Genesis version string.
 *
 * @global string $wp_version WordPress version string.
 *
 * @return array Unserialized data, or empty on failure.
 */
function genesis_update_check() {

	//* Use cache
	static $genesis_update = null;

	global $wp_version;

	//* If updates are disabled
	if ( ! genesis_get_option( 'update' ) || ! current_theme_supports( 'genesis-auto-updates' ) ) {
		return array();
	}

	//* If cache is empty, pull transient
	if ( ! $genesis_update ) {
		$genesis_update = get_transient( 'genesis-update' );
	}

	//* If transient has expired, do a fresh update check
	if ( ! $genesis_update ) {

		$url     = 'http://api.genesistheme.com/update-themes/';
		$options = apply_filters(
			'genesis_update_remote_post_options',
			array(
				'body' => array(
					'genesis_version' => PARENT_THEME_VERSION,
					'html5'           => genesis_html5(),
					'php_version'     => phpversion(),
					'uri'             => home_url(),
					'user-agent'      => "WordPress/$wp_version;",
					'wp_version'      => $wp_version,
				),
			)
		);

		$response = wp_remote_post( $url, $options );
		$genesis_update = wp_remote_retrieve_body( $response );

		//* If an error occurred, return FALSE, store for 1 hour
		if ( 'error' === $genesis_update || is_wp_error( $genesis_update ) || ! is_serialized( $genesis_update ) ) {
			set_transient( 'genesis-update', array( 'new_version' => PARENT_THEME_VERSION ), 60 * 60 );
			return array();
		}

		//* Else, unserialize
		$genesis_update = maybe_unserialize( $genesis_update );

		//* And store in transient for 24 hours
		set_transient( 'genesis-update', $genesis_update, 60 * 60 * 24 );

	}

	//* If we're already using the latest version, return empty array.
	if ( version_compare( PARENT_THEME_VERSION, $genesis_update['new_version'], '>=' ) ) {
		return array();
	}

	return $genesis_update;

}

/**
 * Upgrade the database to version 2104.
 *
 * @since 2.1.2
 *
 * @uses genesis_update_settings()  Merges new settings with old settings and pushes them into the database.
 * @uses genesis_get_option()       Get theme setting value.
 */
function genesis_upgrade_2104() {

	//* Update Settings
	genesis_update_settings( array(
		'theme_version'   => '2.1.2',
		'db_version'      => '2104',
	) );

}

/**
 * Upgrade the database to version 2100.
 *
 * @since 2.1.0
 *
 * @uses genesis_update_settings()  Merges new settings with old settings and pushes them into the database.
 * @uses genesis_get_option()       Get theme setting value.
 */
function genesis_upgrade_2100() {

	//* Update Settings
	genesis_update_settings( array(
		'db_version'      => '2100',
		'image_alignment' => 'alignleft',
		'first_version'   => '2.0.2',
	) );

}

/**
 * Upgrade the database to version 2003.
 *
 * @since 2.0.0
 *
 * @uses genesis_update_settings() Merges new settings with old settings and pushes them into the database.
 * @uses genesis_get_option()       Get theme setting value.
 */
function genesis_upgrade_2003() {

	//* Update Settings
	genesis_update_settings( array(
		'superfish'     => genesis_get_option( 'nav_superfish', null, 0 ) || genesis_get_option( 'subnav_superfish', null, 0 ) ? 1 : 0,
		'db_version'    => '2003',
	) );

}

/**
 * Upgrade the database to version 2001.
 *
 * @since 2.0.0
 *
 * @uses genesis_update_settings() Merges new settings with old settings and pushes them into the database.
 * @uses genesis_get_option()       Get theme setting value.
 */
function genesis_upgrade_2001() {

	//* Update Settings
	genesis_update_settings( array(
		'nav_extras' => genesis_get_option( 'nav_extras_enable', null, 0 ) ? genesis_get_option( 'nav_extras', null, 0 ) : '',
		'db_version' => '2001',
	) );

}

/**
 * Upgrade the database to version 1901.
 *
 * @since 1.9.0
 *
 * @uses genesis_update_settings() Merges new settings with old settings and pushes them into the database.
 * @uses genesis_get_option()       Get theme setting value.
 */
function genesis_upgrade_1901() {

	//* Get menu locations
	$menu_locations = get_theme_mod( 'nav_menu_locations' );

	//* Clear assigned nav if nav disabled
	if ( ! genesis_get_option( 'nav' ) && $menu_locations['primary'] ) {
		$menu_locations['primary'] = 0;
		set_theme_mod( 'nav_menu_locations', $menu_locations );
	}

	//* Clear assigned subnav if subnav disabled
	if ( ! genesis_get_option( 'subnav' ) && $menu_locations['secondary'] ) {
		$menu_locations['secondary'] = 0;
		set_theme_mod( 'nav_menu_locations', $menu_locations );
	}

	//* Update Settings
	genesis_update_settings( array(
		'db_version'    => '1901',
	) );

}

/**
 * Upgrade the database to version 1800.
 *
 * @since 1.8.0
 *
 * @uses genesis_update_settings() Merges new settings with old settings and pushes them into the database.
 */
function genesis_upgrade_1800() {

	//* Convert term meta for new title/description options
	$terms     = get_terms( get_taxonomies(), array( 'hide_empty' => false ) );
	$term_meta = get_option( 'genesis-term-meta' );

	foreach ( (array) $terms as $term ) {
		if ( isset( $term_meta[$term->term_id]['display_title'] ) && $term_meta[$term->term_id]['display_title'] )
			$term_meta[$term->term_id]['headline'] = $term->name;

		if ( isset( $term_meta[$term->term_id]['display_description'] ) && $term_meta[$term->term_id]['display_description'] )
			$term_meta[$term->term_id]['intro_text'] = $term->description;
	}

	update_option( 'genesis-term-meta', $term_meta );

	//* Update Settings
	genesis_update_settings( array(
		'db_version'    => '1800',
	) );

}

/**
 * Upgrade the database to version 1700.
 *
 * Also removes old user meta box options, as the UI changed.
 *
 * @since 1.7.0
 *
 * @uses genesis_update_settings() Merges new settings with old settings and pushes them into the database.
 *
 * @global object $wpdb WordPress database object.
 */
function genesis_upgrade_1700() {

	global $wpdb;

	//* Changing the UI. Remove old user options.
	$wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->usermeta WHERE meta_key = %s OR meta_key = %s", 'meta-box-order_toplevel_page_genesis', 'meta-box-order_genesis_page_seosettings' ) );
	$wpdb->query( $wpdb->prepare( "UPDATE $wpdb->usermeta SET meta_value = %s WHERE meta_key = %s OR meta_key = %s", '1', 'screen_layout_toplevel_page_genesis', 'screen_layout_genesis_page_seosettings' ) );

	//* Update Settings
	genesis_update_settings( array(
		'db_version'    => '1700',
	) );

}

add_action( 'admin_init', 'genesis_upgrade', 20 );
/**
 * Update Genesis to the latest version.
 *
 * This iterative update function will take a Genesis installation, no matter
 * how old, and update its options to the latest version.
 *
 * It used to iterate over theme version, but now uses a database version
 * system, which allows for changes within pre-releases, too.
 *
 * @since 1.0.1
 *
 * @uses _genesis_vestige()
 * @uses genesis_get_option()     Get theme setting value.
 * @uses genesis_get_seo_option() Get SEO setting value.
 * @uses genesis_upgrade_1700()
 * @uses genesis_upgrade_1800()
 * @uses genesis_upgrade_1901()
 * @uses genesis_upgrade_2001()
 * @uses genesis_upgrade_2003()
 * @uses PARENT_DB_VERSION
 * @uses GENESIS_SETTINGS_FIELD
 * @uses GENESIS_SEO_SETTINGS_FIELD
 *
 * @return null Return early if we're already on the latest version.
 */
function genesis_upgrade() {

	//* Don't do anything if we're on the latest version
	if ( genesis_get_option( 'db_version', null, false ) >= PARENT_DB_VERSION )
		return;

	#########################
	# UPDATE TO VERSION 1.0.1
	#########################

	if ( version_compare( genesis_get_option( 'theme_version', null, false ), '1.0.1', '<' ) ) {
		$theme_settings = get_option( GENESIS_SETTINGS_FIELD );
		$new_settings   = array(
			'nav_home'         => 1,
			'nav_twitter_text' => 'Follow me on Twitter',
			'subnav_home'      => 1,
			'theme_version'    => '1.0.1',
		);

		$settings = wp_parse_args( $new_settings, $theme_settings );
		update_option( GENESIS_SETTINGS_FIELD, $settings );
	}

	#########################
	# UPDATE TO VERSION 1.1
	#########################

	if ( version_compare( genesis_get_option( 'theme_version', null, false ), '1.1', '<' ) ) {
		$theme_settings = get_option( GENESIS_SETTINGS_FIELD );
		$new_settings   = array(
			'content_archive_thumbnail' => genesis_get_option( 'thumbnail' ),
			'theme_version'             => '1.1',
		);

		$settings = wp_parse_args( $new_settings, $theme_settings );
		update_option( GENESIS_SETTINGS_FIELD, $settings );
	}

	#########################
	# UPDATE TO VERSION 1.1.2
	#########################

	if ( version_compare( genesis_get_option( 'theme_version', null, false ), '1.1.2', '<' ) ) {
		$theme_settings = get_option( GENESIS_SETTINGS_FIELD );
		$new_settings   = array(
			'header_right'            => genesis_get_option( 'header_full' ) ? 0 : 1,
			'nav_superfish'           => 1,
			'subnav_superfish'        => 1,
			'nav_extras_enable'       => genesis_get_option( 'nav_right' ) ? 1 : 0,
			'nav_extras'              => genesis_get_option( 'nav_right' ),
			'nav_extras_twitter_id'   => genesis_get_option( 'twitter_id' ),
			'nav_extras_twitter_text' => genesis_get_option( 'nav_twitter_text' ),
			'theme_version'           => '1.1.2',
		);

		$settings = wp_parse_args( $new_settings, $theme_settings );
		update_option( GENESIS_SETTINGS_FIELD, $settings );
	}

	#########################
	# UPDATE TO VERSION 1.2
	#########################

	if ( version_compare( genesis_get_option( 'theme_version', null, false ), '1.2', '<' ) ) {
		$theme_settings = get_option( GENESIS_SETTINGS_FIELD );
		$new_settings   = array(
			'update'        => 1,
			'theme_version' => '1.2',
		);

		$settings = wp_parse_args( $new_settings, $theme_settings );
		update_option( GENESIS_SETTINGS_FIELD, $settings );
	}

	#########################
	# UPDATE TO VERSION 1.3
	#########################

	if ( version_compare( genesis_get_option( 'theme_version', null, false ), '1.3', '<' ) ) {
		//* Update theme settings
		$theme_settings = get_option( GENESIS_SETTINGS_FIELD );
		$new_settings   = array(
			'author_box_single' => genesis_get_option( 'author_box' ),
			'theme_version'     => '1.3',
		);

		$settings = wp_parse_args( $new_settings, $theme_settings );
		update_option( GENESIS_SETTINGS_FIELD, $settings );

		//* Update SEO settings
		$seo_settings = get_option( GENESIS_SEO_SETTINGS_FIELD );
		$new_settings = array(
			'noindex_cat_archive'    => genesis_get_seo_option( 'index_cat_archive' ) ? 0 : 1,
			'noindex_tag_archive'    => genesis_get_seo_option( 'index_tag_archive' ) ? 0 : 1,
			'noindex_author_archive' => genesis_get_seo_option( 'index_author_archive' ) ? 0 : 1,
			'noindex_date_archive'   => genesis_get_seo_option( 'index_date_archive' ) ? 0 : 1,
			'noindex_search_archive' => genesis_get_seo_option( 'index_search_archive' ) ? 0 : 1,
			'noodp'                  => 1,
			'noydir'                 => 1,
			'canonical_archives'     => 1,
		);

		$settings = wp_parse_args( $new_settings, $seo_settings );
		update_option( GENESIS_SEO_SETTINGS_FIELD, $settings );

		//* Delete the store transient, force refresh
		delete_transient( 'genesis-remote-store' );
	}

	#########################
	# UPDATE TO VERSION 1.6
	#########################

	if ( version_compare( genesis_get_option( 'theme_version', null, false ), '1.6', '<' ) ) {
		//* Vestige nav settings, for backward compatibility
		if ( 'nav-menu' !== genesis_get_option( 'nav_type' ) )
			_genesis_vestige( array( 'nav_type', 'nav_superfish', 'nav_home', 'nav_pages_sort', 'nav_categories_sort', 'nav_depth', 'nav_exclude', 'nav_include', ) );

		//* Vestige subnav settings, for backward compatibility
		if ( 'nav-menu' !== genesis_get_option( 'subnav_type' ) )
			_genesis_vestige( array( 'subnav_type', 'subnav_superfish', 'subnav_home', 'subnav_pages_sort', 'subnav_categories_sort', 'subnav_depth', 'subnav_exclude', 'subnav_include', ) );

		$theme_settings = get_option( GENESIS_SETTINGS_FIELD );
		$new_settings   = array( 'theme_version' => '1.6', );

		$settings = wp_parse_args( $new_settings, $theme_settings );
		update_option( GENESIS_SETTINGS_FIELD, $settings );
	}

	###########################
	# UPDATE DB TO VERSION 1700
	###########################

	if ( genesis_get_option( 'db_version', null, false ) < '1700' )
		genesis_upgrade_1700();

	###########################
	# UPDATE DB TO VERSION 1800
	###########################

	if ( genesis_get_option( 'db_version', null, false ) < '1800' )
		genesis_upgrade_1800();

	###########################
	# UPDATE DB TO VERSION 1901
	###########################

	if ( genesis_get_option( 'db_version', null, false ) < '1901' )
		genesis_upgrade_1901();

	###########################
	# UPDATE DB TO VERSION 2001
	###########################

	if ( genesis_get_option( 'db_version', null, false ) < '2001' )
		genesis_upgrade_2001();

	###########################
	# UPDATE DB TO VERSION 2003
	###########################

	if ( genesis_get_option( 'db_version', null, false ) < '2003' )
		genesis_upgrade_2003();

	###########################
	# UPDATE DB TO VERSION 2100
	###########################

	if ( genesis_get_option( 'db_version', null, false ) < '2100' )
		genesis_upgrade_2100();

	###########################
	# UPDATE DB TO VERSION 2104
	###########################

	if ( genesis_get_option( 'db_version', null, false ) < '2104' )
		genesis_upgrade_2104();

	do_action( 'genesis_upgrade' );

}

add_action( 'wpmu_upgrade_site', 'genesis_network_upgrade_site' );
/**
 * Run silent upgrade on each site in the network during a network upgrade.
 *
 * Update Genesis database settings for all sites in a network during network upgrade process.
 *
 * @since 2.0.0
 *
 * @param int $blog_id Blog ID.
 */
function genesis_network_upgrade_site( $blog_id ) {

	switch_to_blog( $blog_id );
	$upgrade_url = add_query_arg( array( 'action' => 'genesis-silent-upgrade' ), admin_url( 'admin-ajax.php' ) );
	restore_current_blog();

	wp_remote_get( $upgrade_url );

}

add_action( 'wp_ajax_no_priv_genesis-silent-upgrade', 'genesis_silent_upgrade' );
/**
 * Genesis settings upgrade. Silent upgrade (no redirect).
 *
 * Meant to be called via ajax request during network upgrade process.
 *
 * @since 2.0.0
 *
 * @uses genesis_upgrade() Update Genesis to the latest version.
 */
function genesis_silent_upgrade() {

	remove_action( 'genesis_upgrade', 'genesis_upgrade_redirect' );
	genesis_upgrade();
	exit( 0 );

}

add_action( 'genesis_upgrade', 'genesis_upgrade_redirect' );
/**
 * Redirect the user back to the theme settings page, refreshing the data and notifying the user that they have
 * successfully updated.
 *
 * @since 1.6.0
 *
 * @uses genesis_admin_redirect() Redirect the user to an admin page, and add query args to the URL string for alerts.
 *
 * @return null Returns early if not an admin page.
 */
function genesis_upgrade_redirect() {

	if ( ! is_admin() || ! current_user_can( 'edit_theme_options' ) )
		return;

	#genesis_admin_redirect( 'genesis', array( 'upgraded' => 'true' ) );
	genesis_admin_redirect( 'genesis-upgraded' );
	exit;

}

add_action( 'admin_notices', 'genesis_upgraded_notice' );
/**
 * Displays the notice that the theme settings were successfully updated to the latest version.
 *
 * Currently only used for pre-release update notices.
 *
 * @since 1.2.0
 *
 * @uses genesis_get_option()   Get theme setting value.
 * @uses genesis_is_menu_page() Check that we're targeting a specific Genesis admin page.
 *
 * @return null Returns early if not on the Theme Settings page.
 */
function genesis_upgraded_notice() {

	if ( ! genesis_is_menu_page( 'genesis' ) )
		return;

	if ( isset( $_REQUEST['upgraded'] ) && 'true' === $_REQUEST['upgraded'] )
		echo '<div id="message" class="updated highlight" id="message"><p><strong>' . sprintf( __( 'Congratulations! You are now rocking Genesis %s', 'genesis' ), genesis_get_option( 'theme_version' ) ) . '</strong></p></div>';

}

add_filter( 'update_theme_complete_actions', 'genesis_update_action_links', 10, 2 );
/**
 * Filter the action links at the end of an update.
 *
 * This function filters the action links that are presented to the user at the end of a theme update. If the theme
 * being updated is not Genesis, the filter returns the default values. Otherwise, it will provide a link to the
 * Genesis Theme Settings page, which will trigger the database upgrade.
 *
 * @since 1.1.3
 *
 * @param array  $actions Existing array of action links.
 * @param string $theme   Theme name.
 *
 * @return string Removes all existing action links in favour of a single link, if Genesis.
 */
function genesis_update_action_links( array $actions, $theme ) {

	if ( 'genesis' !== $theme )
		return $actions;

	return sprintf( '<a href="%s">%s</a>', menu_page_url( 'genesis', 0 ), __( 'Click here to complete the upgrade', 'genesis' ) );

}

add_action( 'admin_notices', 'genesis_update_nag' );
/**
 * Display the update nag at the top of the dashboard if there is a Genesis update available.
 *
 * @since 1.1.0
 *
 * @uses genesis_update_check() Ping http://api.genesistheme.com/ asking if a new version of this theme is available.
 *
 * @return boolean Return false if there is no available update, or user is not a site administrator.
 */
function genesis_update_nag() {

	if ( defined( 'DISALLOW_FILE_MODS' ) && true == DISALLOW_FILE_MODS )
		return false;

	$genesis_update = genesis_update_check();

	if ( ! is_super_admin() || ! $genesis_update )
		return false;

	echo '<div id="update-nag">';
	printf(
		__( 'Genesis %s is available. <a href="%s" %s>Check out what\'s new</a> or <a href="%s" %s>update now.</a>', 'genesis' ),
		esc_html( $genesis_update['new_version'] ),
		esc_url( $genesis_update['changelog_url'] ),
		'class="thickbox thickbox-preview"',
		wp_nonce_url( 'update.php?action=upgrade-theme&amp;theme=genesis', 'upgrade-theme_genesis' ),
		'class="genesis-js-confirm-upgrade"'
	);
	echo '</div>';

}

add_action( 'init', 'genesis_update_email' );
/**
 * Sends out update notification email.
 *
 * Does several checks before finally sending out a notification email to the
 * specified email address, alerting it to a Genesis update available for that install.
 *
 * @since 1.1.0
 *
 * @uses genesis_get_option()  Get theme setting value.
 * @uses genesis_update_check() Ping http://api.genesistheme.com/ asking if a new version of this theme is available.
 *
 * @return null Returns null if email should not be sent.
 */
function genesis_update_email() {

	//* Pull email options from DB
	$email_on = genesis_get_option( 'update_email' );
	$email    = genesis_get_option( 'update_email_address' );

	//* If we're not supposed to send an email, or email is blank / invalid, stop!
	if ( ! $email_on || ! is_email( $email ) )
		return;

	//* Check for updates
	$update_check = genesis_update_check();

	//* If no new version is available, stop!
	if ( ! $update_check )
		return;

	//* If we've already sent an email for this version, stop!
	if ( get_option( 'genesis-update-email' ) === $update_check['new_version'] )
		return;

	//* Let's send an email!
	$subject  = sprintf( __( 'Genesis %s is available for %s', 'genesis' ), esc_html( $update_check['new_version'] ), home_url() );
	$message  = sprintf( __( 'Genesis %s is now available. We have provided 1-click updates for this theme, so please log into your dashboard and update at your earliest convenience.', 'genesis' ), esc_html( $update_check['new_version'] ) );
	$message .= "\n\n" . wp_login_url();

	//* Update the option so we don't send emails on every pageload!
	update_option( 'genesis-update-email', $update_check['new_version'], TRUE );

	//* Send that puppy!
	wp_mail( sanitize_email( $email ), $subject, $message );

}

add_filter( 'pre_set_site_transient_update_themes', 'genesis_disable_wporg_updates' );
add_filter( 'pre_set_transient_update_themes', 'genesis_disable_wporg_updates' );
/**
 * Disable WordPress from giving update notifications on Genesis or Genesis child themes.
 *
 * This function filters the value that is saved after WordPress tries to pull theme update transient data from WordPress.org
 *
 * Its purpose is to disable update notifications for Genesis and Genesis child themes.
 * This prevents WordPress.org repo themes from being installed over one of our themes.
 *
 * @since 2.0.2
 *
 * @param object $value
 *
 * @return object
 */
function genesis_disable_wporg_updates( $value ) {

	foreach ( wp_get_themes() as $theme ) {

		if ( 'genesis' == $theme->get( 'Template' ) ) {

			unset( $value->response[ $theme->get_stylesheet() ] );

		}

	}

	return $value;

}

add_filter( 'site_transient_update_themes', 'genesis_update_push' );
add_filter( 'transient_update_themes', 'genesis_update_push' );
/**
 * Integrate the Genesis update check into the WordPress update checks.
 *
 * This function filters the value that is returned when WordPress tries to pull theme update transient data.
 *
 * It uses `genesis_update_check()` to check to see if we need to do an update, and if so, adds the proper array to the
 * `$value->response` object. WordPress handles the rest.
 *
 * @since 1.1.0
 *
 * @uses genesis_update_check() Ping http://api.genesistheme.com/ asking if a new version of this theme is available.
 *
 * @param object $value
 *
 * @return object
 */
function genesis_update_push( $value ) {

	if ( defined( 'DISALLOW_FILE_MODS' ) && true == DISALLOW_FILE_MODS )
		return $value;

	if ( isset ( $value->response['genesis'] ) ) {
		unset( $value->response['genesis'] );
	}

	$genesis_update = genesis_update_check();

	if ( $genesis_update )
		$value->response['genesis'] = $genesis_update;

	return $value;

}

add_action( 'load-update-core.php', 'genesis_clear_update_transient' );
add_action( 'load-themes.php', 'genesis_clear_update_transient' );
/**
 * Delete Genesis update transient after updates or when viewing the themes page.
 *
 * The server will then do a fresh version check.
 *
 * It also disables the update nag on those pages as well.
 *
 * @since 1.1.0
 *
 * @see genesis_update_nag()
 */
function genesis_clear_update_transient() {

	delete_transient( 'genesis-update' );
	remove_action( 'admin_notices', 'genesis_update_nag' );

}

/**
 * Converts array of keys from Genesis options to vestigial options.
 *
 * This is done for backwards compatibility.
 *
 * @since 1.6.0
 *
 * @access private
 *
 * @param array  $keys    Array of keys to convert. Default is an empty array.
 * @param string $setting Optional. The settings field the original keys are found under. Default is GENESIS_SETTINGS_FIELD.
 *
 * @return null Return null on failure.
 */
function _genesis_vestige( array $keys = array(), $setting = GENESIS_SETTINGS_FIELD ) {

	//* If no $keys passed, do nothing
	if ( ! $keys )
		return;

	//* Pull options
	$options = get_option( $setting );
	$vestige = get_option( 'genesis-vestige' );

	//* Cycle through $keys, creating new vestige array
	$new_vestige = array();
	foreach ( (array) $keys as $key ) {
		if ( isset( $options[$key] ) ) {
			$new_vestige[$key] = $options[$key];
			unset( $options[$key] );
		}
	}

	//* If no new vestigial options being pushed, do nothing
	if ( ! $new_vestige )
		return;

	//* Merge the arrays, if necessary
	$vestige = $vestige ? wp_parse_args( $new_vestige, $vestige ) : $new_vestige;

	//* Insert into options table
	update_option( 'genesis-vestige', $vestige );
	update_option( $setting, $options );

}
