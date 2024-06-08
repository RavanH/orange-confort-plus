<?php
/**
 * Orange Confort+ uninstallation.
 *
 * @package Orange Confort+
 *
 * @since 0.4
 */

namespace OCplus;

// Exit if uninstall not called from WordPress.
\defined( 'WPINC' ) || \die;

// Check if it is a multisite and not a large one.
if ( \is_multisite() ) {
	if ( \wp_is_large_network() ) {
		uninstall();
		return;
	}

	$_ids = get_sites(
		array(
			'fields' => 'ids',
			'number' => -1,
		)
	); // TEST number = -1..1000.

	foreach ( $_ids as $_id ) {
		\switch_to_blog( $_id );

		uninstall( $_id );

		\restore_current_blog();
	}
} else {
	uninstall();
}

/**
 * Remove plugin data.
 *
 * @since 0.4
 *
 * @param int $_id Blog ID.
 */
function uninstall( $_id = false ) {
	/**
	 * Remove plugin settings.
	 */
	\delete_option( 'oc_plus_position' );
	\delete_option( 'oc_plus_version' );
}
