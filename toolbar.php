<?php
/**
 * Plugin Name: Orange Confort+
 * Plugin URI: https://status301.net/wordpress-plugins/orange-confort-plus/
 * Description: Add the Orange Confort+ accessibility toolbar to your WordPress site.
 * Version: 0.3
 * Text Domain: orange-confort-plus
 * Author: RavanH
 * Author URI: https://status301.net/
 *
 * @package Orange Confort+
 */

namespace OCplus;

\defined( '\WPINC' ) || \die;

\define( __NAMESPACE__ . '\VERSION', '0.3' );
\define( __NAMESPACE__ . '\SCRIPT_VERSION', '4.3.3' );
\define( __NAMESPACE__ . '\PLUGIN', plugin_basename( __FILE__ ) );

/**
 * Enqueue main script.
 */
function enqueue_script() {
	$script  = '/* Orange Confort+ accessibility toolbar for WordPress ' . VERSION . ' ( RavanH - http://status301.net/wordpress-plugins/orange-confort-plus/ ) */' . \PHP_EOL;
	$script .= 'var hebergementFullPath = \'' . \plugins_url( 'vendor/', __FILE__ ) . '\';';

	// Consent API compatibility.
	if ( function_exists( 'wp_has_consent' ) ) {
		\wp_enqueue_script( 'orange-confort-plus', \plugins_url( '/js/consent-api-wrapper.min.js', __FILE__ ), array(), VERSION, true );
	} else {
		\wp_enqueue_script( 'orange-confort-plus', \plugins_url( 'vendor/js/toolbar.min.js', __FILE__ ), array(), SCRIPT_VERSION, true );
	}

	\wp_add_inline_script( 'orange-confort-plus', $script, 'before' );
}

\add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_script' );

/**
 * Custom styles.
 */
function custom_css() {
	// TODO: make this optional.
	echo '<style>#accessibilitytoolbarGraphic{position:fixed;top:auto;bottom:0}#cdu_close{top:auto;bottom:0;border-top:1px solid #000;border-bottom:none}#uci_toolbar-quick{border-bottom:none;border-top:2px solid #000}</style>';
}

\add_action( 'wp_footer', __NAMESPACE__ . '\custom_css' );

/**
 * Consent API.
 */

\add_filter( 'wp_consent_api_registered_' . PLUGIN, '__return_true' );

/**
 * Register cookies.
 */
function register_cookies() {
	if ( function_exists( 'wp_add_cookie_info' ) ) {
		wp_add_cookie_info( 'UCI42', 'Orange Confort+', 'functional', __( '1 Year', 'orange-confort-plus' ), __( 'Store user toolbar settings.', 'orange-confort-plus' ) );
		wp_add_cookie_info( 'uci-bl', 'Orange Confort+', 'functional', __( 'Session', 'orange-confort-plus' ), __( 'Store user toolbar toggle setting.', 'orange-confort-plus' ) );
	}
}

\add_action( 'plugins_loaded', __NAMESPACE__ . '\register_cookies' );
