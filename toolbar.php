<?php
/**
 * Plugin Name: Orange Confort+
 * Plugin URI: https://status301.net/wordpress-plugins/orange-confort-plus/
 * Description: Add the Orange Confort+ accessibility toolbar to your WordPress site.
 * Version: 0.5
 * Text Domain: orange-confort-plus
 * Author: RavanH
 * Author URI: https://status301.net/
 *
 * @package Orange Confort+
 */

namespace OCplus;

\defined( '\WPINC' ) || \die;

const VERSION        = '0.5';
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
	$script .= 'var hebergementFullPath = "' . \plugins_url( 'vendor/', __FILE__ ) . '", accessibilitytoolbar_custom = { idLinkModeContainer : "' . apply_filters( 'ocplus_container_id', 'ocplus_button' ) . '", cssLinkModeClassName : "wp-block-button__link wp-element-button ocplus-custom-button" };';

	\wp_add_inline_script( 'orange-confort-plus', $script, 'before' );
}

\add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_script' );



/**
 * Custom styles.
 */
function custom_css() {
	$position = (array) \get_option( 'oc_plus_position', array() );
	$css      = '';

	if ( ! empty( $position['toolbar'] ) ) {
		$css .= 'bottom' === $position['toolbar'] ? '#cdu_zone{position:fixed;bottom:0}#cdu_close{top:auto;bottom:0;border-top:1px solid #000;border-bottom:none}#uci_toolbar-quick{border-bottom:none;border-top:2px solid #000}.uci_submenu{top:auto;bottom:3.125em}' : '#cdu_zone{position:fixed}';
	}

	if ( ! empty( $position['button'] ) && 'left' === $position['button'] ) {
		$css .= '#cdu_close{right:auto;left:0}';
	}

	if ( ! empty( $css ) ) {
		echo '<style>' . esc_html( $css ) . '</style>';
	}
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
			'type'    => 'array',
			'default' => array(),
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
	$settings = (array) \get_option( 'oc_plus_position' );
	$button   = isset( $settings['button'] ) ? $settings['button'] : '';
	$toolbar  = isset( $settings['toolbar'] ) ? $settings['toolbar'] : '';
	?>
<fieldset id="oc_plus">
	<legend class="screen-reader-text">
		<?php \esc_html_e( 'Orange Confort+', 'orange-confort-plus' ); ?>
	</legend>
	<p>
		<label>
			<?php \esc_html_e( 'Accessibility toolbar position:', 'orange-confort-plus' ); ?>
			<select name="oc_plus_position[toolbar]" id="oc_plus_toolbar_position">
				<option value=""><?php \esc_html_e( 'Page top', 'orange-confort-plus' ); ?></option>
				<option value="top"<?php selected( 'top', $toolbar ); ?>><?php \esc_html_e( 'Window top', 'orange-confort-plus' ); ?></option>
				<option value="bottom"<?php selected( 'bottom', $toolbar ); ?>><?php \esc_html_e( 'Window bottom', 'orange-confort-plus' ); ?></option>
			</select>
		</label>
	</p>
	<p>
		<label>
			<?php \esc_html_e( 'Accessibility button position:', 'orange-confort-plus' ); ?>
			<select name="oc_plus_position[button]" id="oc_plus_button_position">
				<option value=""><?php \esc_html_e( 'Right', 'orange-confort-plus' ); ?></option>
				<option value="left"<?php selected( 'left', $button ); ?>><?php \esc_html_e( 'Left', 'orange-confort-plus' ); ?></option>
			</select>
		</label>
	</p>
	<p class="description">
		<?php printf( /* translators: shortcode and ID examples */ \esc_html__( 'For a custom button position, use either the shortcode %1$s or a button block with the ID (HTML anker) %2$s on your site.', 'orange-confort-plus' ), '<code>[ocplus_button style="outline" color="black" bgcolor="" /]</code>', '<code>ocplus_button</code>' ); ?>
		<br>
		<?php \esc_html_e( 'Please note: not all toolbar positions may work well in combination with a custom button position.', 'orange-confort-plus' ); ?>
	</p>
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

/**
 * Render OC+ button by shortcode.
 *
 * @param array $atts Shortcode arguments array.
 */
function render_button_wrapper( $atts = array() ) {
	$atts = shortcode_atts(
		array(
			'style'   => 'outline',
			'color'   => '',
			'bgcolor' => '',
		),
		$atts
	);

	$outline = 'outline' === $atts['style'] ? ' is-style-outline' : '';
	$styles  = array();
	$style   = '';

	if ( ! empty( $atts['color'] ) ) {
		$styles[] = 'color:' . esc_attr( $atts['color'] );
	}
	if ( ! empty( $atts['color'] ) ) {
		$styles[] = 'background-color:' . esc_attr( $atts['bgcolor'] );
	}
	if ( ! empty( $styles ) ) {
		$style  = '<style>#uci_link{';
		$style .= implode( ';', $styles );
		$style .= '}</style>';
	}

	return '<div class="wp-block-buttons is-layout-flex wp-block-buttons-is-layout-flex"><div class="wp-block-button' . $outline . '" id="ocplus_button"></div></div>' . $style;
}
\add_shortcode( 'ocplus_button', __NAMESPACE__ . '\render_button_wrapper' );
