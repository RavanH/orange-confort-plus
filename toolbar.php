<?php
/**
 * Plugin Name: Orange Confort+
 * Plugin URI: https://status301.net/wordpress-plugins/orange-confort-plus/
 * Description: Add the Orange Confort+ accessibility toolbar to your WordPress site.
 * Version: 0.4
 * Text Domain: orange-confort-plus
 * Author: RavanH
 * Author URI: https://status301.net/
 *
 * @package Orange Confort+
 */

namespace OCplus;

\defined( '\WPINC' ) || \die;

const VERSION        = '0.4';
const SCRIPT_VERSION = '4.3.5';

/**
 * Enqueue main script.
 */
function enqueue_script() {
	// Consent API compatibility.
	if ( function_exists( 'wp_has_consent' ) ) {
		\wp_enqueue_script( 'orange-confort-plus', \plugins_url( 'js/consent-api-wrapper.min.js', __FILE__ ), array(), VERSION, true );
	} else {
		\wp_enqueue_script( 'orange-confort-plus', \plugins_url( 'vendor/js/toolbar.min.js', __FILE__ ), array(), SCRIPT_VERSION, true );
	}

	$script  = '/* Orange Confort+ accessibility toolbar for WordPress ' . VERSION . ' ( RavanH - http://status301.net/wordpress-plugins/orange-confort-plus/ ) */' . \PHP_EOL;
	$script .= 'var hebergementFullPath = \'' . \plugins_url( 'vendor/', __FILE__ ) . '\';';

	\wp_add_inline_script( 'orange-confort-plus', $script, 'before' );
}

\add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_script' );

/**
 * Custom styles.
 */
function custom_css() {
	$position = \get_option( 'oc_plus_position', 'bottom-right' );

	if ( ! $position ) {
		return;
	}

	$css = '';

	if ( false !== strpos( $position, 'bottom' ) ) {
		$css .= '#accessibilitytoolbarGraphic{position:fixed;top:auto;bottom:0}#cdu_close{top:auto;bottom:0;border-top:1px solid #000;border-bottom:none}#uci_toolbar-quick{border-bottom:none;border-top:2px solid #000}';
	}

	if ( strpos( $position, 'left' ) ) {
		$css .= '#cdu_close{right:auto;left:0}';
	}

	echo '<style>' . esc_html( $css ) . '</style>';
}

\add_action( 'wp_footer', __NAMESPACE__ . '\custom_css' );

/**
 * Consent API.
 */

\add_filter( 'wp_consent_api_registered_' . plugin_basename( __FILE__ ), '__return_true' );

/**
 * Register cookies.
 */
function register_cookies() {
	if ( \function_exists( 'wp_add_cookie_info' ) ) {
		\wp_add_cookie_info( 'UCI42', \__( 'Orange Confort+', 'orange-confort-plus' ), 'functional', \__( '1 Year', 'orange-confort-plus' ), \__( 'Store user toolbar settings.', 'orange-confort-plus' ) );
		\wp_add_cookie_info( 'uci-bl', \__( 'Orange Confort+', 'orange-confort-plus' ), 'functional', \__( 'Session', 'orange-confort-plus' ), \__( 'Store user toolbar toggle setting.', 'orange-confort-plus' ) );
	}
}

\add_action( 'plugins_loaded', __NAMESPACE__ . '\register_cookies' );

/**
 * Settings.
 */

/**
 * Register settings.
 */
function register_settings() {
	\register_setting(
		'reading',
		'oc_plus_position',
		array(
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'bottom-right',
		),
	);

	// Field.
	\add_settings_field(
		'oc_plus',
		\__( 'Orange Confort+', 'orange-confort-plus' ),
		__NAMESPACE__ . '\settings_field',
		'reading'
	);
}

\add_action( 'admin_init', __NAMESPACE__ . '\register_settings' );

/**
 * Settings field.
 */
function settings_field() {
	$position = \get_option( 'oc_plus_position' );
	?>
<fieldset id="oc_plus">
	<legend class="screen-reader-text">
		<?php \esc_html_e( 'Orange Confort+', 'orange-confort-plus' ); ?>
	</legend>
	<label for="page_on_front">
		<?php \esc_html_e( 'Accessibility toolbar position:', 'orange-confort-plus' ); ?>
		<select name="oc_plus_position" id="oc_plus_position">
			<option value=""><?php \esc_html_e( 'Page top, button right', 'orange-confort-plus' ); ?></option>
			<option value="top-left"<?php selected( 'top-left', $position ); ?>><?php \esc_html_e( 'Page top, button left', 'orange-confort-plus' ); ?></option>
			<option value="bottom-right"<?php selected( 'bottom-right', $position ); ?>><?php \esc_html_e( 'Window bottom, button right', 'orange-confort-plus' ); ?></option>
			<option value="bottom-left"<?php selected( 'bottom-left', $position ); ?>><?php \esc_html_e( 'Window bottom, button left', 'orange-confort-plus' ); ?></option>
		</select>
	</label>
</fieldset>
	<?php
}

/**
 * Activate or upgrade, maybe.
 */
function maybe_upgrade() {
	$db_version = \get_option( 'oc_plus_version', '0' );

	// Maybe upgrade or install.
	if ( 0 !== \version_compare( VERSION, $db_version ) ) {
		include_once __DIR__ . '/upgrade.php';
	}
}

\add_action( 'init', __NAMESPACE__ . '\maybe_upgrade' );
