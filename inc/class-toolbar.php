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
		$version = (string) \get_option( 'oc_plus_script_version' );

		if ( ! $version || ! in_array( $version, array( '4.3.6', '5.0.1' ) ) ) {
			$version = '4.3.6';
		}

		// Consent API compatibility.
		if ( \version_compare( $version, '5', '<' ) ) {
			$inline = 'var hebergementFullPath = "' . \plugins_url( 'vendor/' . $version, PLUGIN_FILE ) . '", accessibilitytoolbar_custom = { idLinkModeContainer : "' . \esc_js( \apply_filters( 'ocplus_container_id', 'ocplus_button' ) ) . '", cssLinkModeClassName : "wp-block-button__link wp-element-button" };';

			if ( \function_exists( 'wp_has_consent' ) ) {
				\wp_enqueue_script( 'orange-confort-plus', \plugins_url( 'js/consent-api-wrapper.min.js', PLUGIN_FILE ), array(), VERSION, true );
				$inline .= 'var ocPlusScriptVersion = "' . $version . '";';
			} else {
				\wp_enqueue_script( 'orange-confort-plus', \plugins_url( 'vendor/' . $version . '/js/toolbar.min.js', PLUGIN_FILE ), array(), null, true ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
			}
		} else {
			\wp_enqueue_script( 'orange-confort-plus', \plugins_url( 'vendor/' . $version . '/js/toolbar.min.js', PLUGIN_FILE ), array(), null, true ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
			$inline = 'const customAppPath = "' . \trailingslashit( \plugins_url( 'vendor/' . $version, PLUGIN_FILE ) ) . '";';
		}

		\wp_add_inline_script( 'orange-confort-plus', $inline, 'before' );
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
