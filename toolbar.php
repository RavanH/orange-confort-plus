<?php
/**
 * Plugin Name: Orange Confort+
 * Plugin URI: https://status301.net/wordpress-plugins/orange-confort-plus/
 * Description: Add the Orange Confort+ accessibility toolbar to your WordPress site.
 * Version: 0.3-alpha1
 * Text Domain: orange-confort-plus
 * Requires at least: 4.4
 * Requires PHP: 5.6
 * Author: RavanH
 * Author URI: https://status301.net/
 *
 * @package Orange Confort+
 */

namespace OCplus;

\defined( '\WPINC' ) || \die;

const VERSION        = '0.3-alpha1';
const SCRIPT_VERSION = '4.3.3';

/**
 * Enqueue main script.
 */
function enqueue_script() {

	\wp_enqueue_script( 'orange-confort-plus', \plugins_url( 'vendor/js/toolbar.min.js', __FILE__ ), array(), SCRIPT_VERSION, true );

	$script  = '/* Orange Confort+ accessibility toolbar for WordPress ' . VERSION . ' ( RavanH - http://status301.net/wordpress-plugins/orange-confort-plus/ ) */' . \PHP_EOL;
	$script .= 'var hebergementFullPath = \'' . \plugins_url( 'vendor/', __FILE__ ) . '\';';

	\wp_add_inline_script( 'orange-confort-plus', $script, 'before' );
}

\add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_script' );

/**
 * Custom styles.
 */
function custom_css() {
	// TODO: make this optional.
	$css = '';

	echo '<style>#accessibilitytoolbarGraphic{position:fixed;top:auto;bottom:0}#cdu_close{top:auto;bottom:0;border-top:1px solid #000;border-bottom:none}#uci_toolbar-quick{border-bottom:none;border-top:2px solid #000}</style>';
}

\add_action( 'wp_footer', __NAMESPACE__ . '\custom_css', 99 );

/**
 * Complianz integration.
 *
 * @param array $data Intergated plugins data.
 *
 * @return array
 */
function complianz_integration( $data ) {
	$data['orange-confort-plus'] = array(
		'constant_or_function' => __NAMESPACE__ . '\VERSION',
		'label'                => 'Orange Confort+',
		'firstparty_marketing' => false,
	);

	return $data;
}

\add_filter( 'cmplz_integrations', __NAMESPACE__ . '\complianz_integration' );

/**
 * Add services to the list of detected items, so it will get set as default, and will be added to the notice about it
 *
 * @param array $services Services array.
 *
 * @return array
 */
function complianz_detected_services( $services ) {

	if ( ! in_array( 'orange-confort-plus', $services, true ) ) {
		$services[] = 'orange-confort-plus';
	}

	return $services;
}

\add_filter( 'cmplz_detected_services', __NAMESPACE__ . '\complianz_detected_services' );

/**
 * Locate Complianz integration file.
 *
 * @param string $path   Path string.
 * @param string $plugin Plugin slug.
 *
 * @return string
 */
function complianz_integration_path( $path, $plugin ) {
	if ( 'orange-confort-plus' === $plugin ) {
		return __DIR__ . '/complianz.php';
	}
	return $path;
}

\add_filter( 'cmplz_integration_path', __NAMESPACE__ . '\complianz_integration_path', 10, 2 );
