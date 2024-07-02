<?php
/**
 * Orange Confort+ toolbar class.
 *
 * @package Orange Confort+
 *
 * @since 0.6
 */

namespace OCplus;

/**
 * Toolbar class enqueues script and styles.
 */
class Toolbar {
	/**
	 * Enqueue main script.
	 */
	public static function script() {
		// Consent API compatibility.
		if ( \function_exists( 'wp_has_consent' ) ) {
			\wp_enqueue_script( 'orange-confort-plus', \plugins_url( 'js/consent-api-wrapper.min.js', __DIR__ ), array(), VERSION, true );
		} else {
			\wp_enqueue_script( 'orange-confort-plus', \plugins_url( 'vendor/js/toolbar.min.js', __DIR__ ), array(), SCRIPT_VERSION, true );
		}

		$script  = '/* Orange Confort+ accessibility toolbar for WordPress ' . VERSION . ' ( RavanH - http://status301.net/wordpress-plugins/orange-confort-plus/ ) */' . \PHP_EOL;
		$script .= 'var hebergementFullPath = "' . \plugins_url( 'vendor/', __DIR__ ) . '", accessibilitytoolbar_custom = { idLinkModeContainer : "' . apply_filters( 'ocplus_container_id', 'ocplus_button' ) . '", cssLinkModeClassName : "wp-block-button__link wp-element-button" };';

		\wp_add_inline_script( 'orange-confort-plus', $script, 'before' );
	}

	/**
	 * Custom styles.
	 */
	public static function css() {
		$position = (array) \get_option( 'oc_plus_position', array() );
		$css      = '';

		if ( ! empty( $position['toolbar'] ) ) {
			$css .= 'bottom' === $position['toolbar'] ? '#cdu_zone{position:fixed;bottom:0}#cdu_close{top:auto;bottom:0;border-top:1px solid #000;border-bottom:none}#uci_toolbar-quick{border-bottom:none;border-top:2px solid #000}.uci_submenu{top:auto;bottom:3.125em}' : '#cdu_zone{position:fixed}';
		}

		if ( ! empty( $position['button'] ) && 'left' === $position['button'] ) {
			$css .= '#cdu_close{right:auto;left:0}';
		}

		if ( ! empty( $css ) ) {
			echo '<style>' . \esc_html( $css ) . '</style>';
		}
	}
}
