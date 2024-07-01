<?php
/**
 * Plugin Name: Orange Confort+
 * Plugin URI: https://status301.net/wordpress-plugins/orange-confort-plus/
 * Description: Add the Orange Confort+ accessibility toolbar to your WordPress site.
 * Version: 0.6
 * Text Domain: orange-confort-plus
 * Author: RavanH
 * Author URI: https://status301.net/
 *
 * @package Orange Confort+
 */

namespace OCplus;

\defined( '\WPINC' ) || \die;

const VERSION        = '0.6';
const SCRIPT_VERSION = '4.3.5';

/**
 * Plugin init.
 */
function init() {
	// Maybe upgrade or install.
	$db_version = \get_option( 'oc_plus_version', '0' );
	if ( 0 !== \version_compare( VERSION, $db_version ) ) {
		include_once __DIR__ . '/upgrade.php';
	}

	include_once __DIR__ . '/toolbar.php';
}

\add_action( 'init', __NAMESPACE__ . '\init' );

/**
 * Plugin admin.
 */
function admin() {
	include_once __DIR__ . '/admin.php';
}

\add_action( 'admin_init', __NAMESPACE__ . '\admin' );
