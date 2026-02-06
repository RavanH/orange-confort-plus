<?php
/**
 * Orange Comfort+ upgrade.
 *
 * @package Orange Comfort+
 *
 * @since 0.4
 */

namespace OCplus;

\defined( 'WPINC' ) || die;

/**
 * Upgrade plugin data.
 *
 * @since 0.1
 */

if ( '0' !== $db_version ) {
	// Upgrading to 0.5.
	if ( \version_compare( '0.5', $db_version, '>' ) ) {
		$position = \get_option( 'oc_plus_position' );
		if ( ! is_array( $position ) ) {
			$oc_settings = array(
				'button'  => ( strpos( $position, 'left' ) ) ? 'left' : '',
				'toolbar' => ( false !== strpos( $position, 'bottom' ) ) ? 'bottom' : '',
			);

			\update_option( 'oc_plus_position', $oc_settings );
		}
	}

	// Keep previous version.
	\add_option( 'oc_plus_script_version', '4.3.6' );
	\add_option( 'oc_plus_position', array() );
} else {
	// Fresh install.
	\add_option( 'oc_plus_script_version', DEFAULT_SCRIPT );
	\add_option( 'oc_plus_position', array() );
}

// Update DB version.
\update_option( 'oc_plus_version', PLUGIN_VERSION );
