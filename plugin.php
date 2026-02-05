<?php
/**
 * Plugin Name: Orange Comfort+ accessibility toolbar for WordPress
 * Plugin URI:  https://status301.net/wordpress-plugins/orange-confort-plus/
 * Description: Add the Orange Comfort+ accessibility toolbar to your WordPress site.
 * Version:     0.8.0
 * Text Domain: orange-confort-plus
 * Author:      RavanH
 * Author URI:  https://status301.net/
 * License:     GPL v2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package Orange Comfort+
 */

namespace OCplus;

const PLUGIN_VERSION = '0.8.0';
const PLUGIN_FILE    = __FILE__;

\defined( 'WPINC' ) || die;

\spl_autoload_register( __NAMESPACE__ . '\autoload' );

\add_action( 'init', __NAMESPACE__ . '\init', 9 );
\add_action( 'admin_init', array( __NAMESPACE__ . '\Admin', 'init' ) );

/**
 * Maybe upgrade or install.
 */
function init() {
	/* Maybe upgrade */
	$db_version = \get_option( 'oc_plus_version', '0' );
	if ( 0 !== \version_compare( PLUGIN_VERSION, $db_version ) ) {
		include_once __DIR__ . '/upgrade.php';
	}

	$script_version = (string) \get_option( 'oc_plus_script_version', '4.3.6' );
	if ( \function_exists( 'wp_add_cookie_info' ) && ( ! $script_version || \version_compare( $script_version, '5', '<' ) ) ) {
		\wp_add_cookie_info( 'UCI42', \__( 'Orange Comfort+', 'orange-confort-plus' ), 'functional', \__( '1 Year', 'orange-confort-plus' ), \__( 'Store user preferences.', 'orange-confort-plus' ) );
		\wp_add_cookie_info( 'uci-bl', \__( 'Orange Comfort+', 'orange-confort-plus' ), 'functional', \__( 'Session', 'orange-confort-plus' ), \__( 'Store user preferences.', 'orange-confort-plus' ) );
	}

	/* Hooks */
	\add_action( 'wp_enqueue_scripts', array( __NAMESPACE__ . '\Toolbar', 'script' ) );
	\add_action( 'wp_footer', array( __NAMESPACE__ . '\Toolbar', 'css' ) );
	\add_filter( 'wp_consent_api_registered_' . \plugin_basename( PLUGIN_FILE ), '__return_true' );

	/* Shortcode */
	\add_shortcode( 'ocplus_button', array( __NAMESPACE__ . '\Shortcode', 'render' ) );
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
