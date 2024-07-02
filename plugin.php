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

\defined( 'WPINC' ) || die;

const VERSION        = '0.6';
const SCRIPT_VERSION = '4.3.5';

\spl_autoload_register( __NAMESPACE__ . '\autoload' );

\add_action( 'init', __NAMESPACE__ . '\maybe_upgrade' );
\add_action( 'admin_init', array( __NAMESPACE__ . '\Admin', 'settings' ) );
\add_action( 'wp_enqueue_scripts', array( __NAMESPACE__ . '\Toolbar', 'script' ) );
\add_action( 'wp_footer', array( __NAMESPACE__ . '\Toolbar', 'css' ) );
\add_action( 'plugins_loaded', __NAMESPACE__ . '\register_cookies' );
\add_filter( 'wp_consent_api_registered_' . \plugin_basename( __FILE__ ), '__return_true' );
\add_shortcode( 'ocplus_button', array( __NAMESPACE__ . '\Shortcode', 'render' ) );

/**
 * Register cookies.
 */
function register_cookies() {
	if ( \function_exists( 'wp_add_cookie_info' ) ) {
		\wp_add_cookie_info( 'UCI42', \__( 'Orange Confort+', 'orange-confort-plus' ), 'functional', \__( '1 Year', 'orange-confort-plus' ), \__( 'Store user preferences.', 'orange-confort-plus' ) );
		\wp_add_cookie_info( 'uci-bl', \__( 'Orange Confort+', 'orange-confort-plus' ), 'functional', \__( 'Session', 'orange-confort-plus' ), \__( 'Store user preferences.', 'orange-confort-plus' ) );
	}
}

/**
 * Maybe upgrade or install.
 */
function maybe_upgrade() {
	$db_version = \get_option( 'oc_plus_version', '0' );
	if ( 0 !== \version_compare( VERSION, $db_version ) ) {
		include_once __DIR__ . '/upgrade.php';
	}
}

/**
 * Autoloader.
 *
 * @since 0.6
 *
 * @param string $class_name The fully-qualified class name.
 */
function autoload( $class_name ) {
	// Skip this if not in our namespace.
	if ( 0 !== \strpos( $class_name, __NAMESPACE__ ) ) {
		return;
	}

	// Replace namespace separators with directory separators in the relative
	// class name, prepend with class-, append with .php, build our file path.
	$class_name = \str_replace( __NAMESPACE__, 'inc', $class_name );
	$class_name = \strtolower( $class_name );
	$path_array = \explode( '\\', $class_name );
	$file_name  = \array_pop( $path_array );
	$file_name  = 'class-' . $file_name . '.php';
	$file       = __DIR__ . DIRECTORY_SEPARATOR . \implode( DIRECTORY_SEPARATOR, $path_array ) . DIRECTORY_SEPARATOR . $file_name;

	// If the file exists, inlcude it.
	if ( \file_exists( $file ) ) {
		include $file;
	}
}
