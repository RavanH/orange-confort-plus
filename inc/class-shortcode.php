<?php
/**
 * Orange Comfort+ shortcode class.
 *
 * @package Orange Comfort+
 *
 * @since 0.6
 */

namespace OCplus;

/**
 * Shortcode class renders shordcode output.
 */
class Shortcode {
	/**
	 * Button rendered flag.
	 *
	 * @var string Whether the shortcode has already been rendered or not.
	 */
	public static $rendered = false;

	/**
	 * Render OC+ button by shortcode.
	 *
	 * @param array $atts Shortcode arguments array.
	 */
	public static function render( $atts = array() ) {
		// Skip if already rendered.
		if ( self::$rendered ) {
			return \is_user_logged_in() && \current_user_can( 'edit_pages' ) ? '<p>' . \esc_html__( 'Orange Comfort+ button already rendered! Please use this shortcode only once.', 'orange-confort-plus' ) . '</p>' : '';
		}

		$script_version = (string) \get_option( 'oc_plus_script_version', DEFAULT_SCRIPT );
		if ( $script_version && \version_compare( $script_version, '5', '>=' ) ) {
			return \is_user_logged_in() && \current_user_can( 'edit_pages' ) ? '<p>' . \esc_html__( 'Shortcode not supported by Orange Comfort+ version 5 and up!', 'orange-confort-plus' ) . '</p>' : '';
		}

		$atts = \shortcode_atts(
			array(
				'style'   => '',
				'color'   => 'white',
				'bgcolor' => '',
			),
			$atts
		);

		if ( ! empty( $atts['color'] ) ) {
			$styles[] = 'color:' . \esc_attr( $atts['color'] );
		}
		if ( ! empty( $atts['bgcolor'] ) ) {
			$styles[] = 'background-color:' . \esc_attr( $atts['bgcolor'] );
		}

		$outline = ! empty( $atts['style'] ) ? ' is-style-' . \esc_attr( $atts['style'] ) : '';
		$style   = isset( $styles ) ? '<style>#uci_link{' . implode( ';', $styles ) . '}</style>' : '';

		// Set rendered flag.
		self::$rendered = true;

		return '<div class="wp-block-buttons is-layout-flex wp-block-buttons-is-layout-flex"><div class="wp-block-button' . $outline . '" id="ocplus_button"></div></div>' . $style;
	}
}
