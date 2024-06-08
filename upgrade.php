<?php
/**
 * Orange Confort+ upgrade.
 *
 * @package Orange Confort+
 *
 * @since 0.4
 */

namespace OCplus;

\defined( 'WPINC' ) || \die;

/**
 * Upgrade plugin data.
 *
 * @since 0.1
 */

if ( '0' !== $db_version ) {
	// Upgrading to 0.4.
	if ( \version_compare( '0.4', $db_version, '>' ) ) {
		\add_option( 'oc_plus_position', 'bottom-right' );
	}
}

// Update DB version.
\update_option( 'oc_plus_version', VERSION );
