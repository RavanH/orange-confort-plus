<?php
/**
 * Orange Confort+ shortcode class.
 *
 * @package Orange Confort+
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
	 * @var string Whether the shortcode has already been redered or not.
	 */
	public static $already_done = false;

	/**
	 * Render OC+ button by shortcode.
	 *
	 * @param array $atts Shortcode arguments array.
	 */
	public static function render( $atts = array() ) {
		// Skip if already rendered.
		if ( self::$already_done ) {
			return is_user_loggeg_in() && current_user_can( 'edit_pages' ) ? esc_html__( 'Orange Confort+ button already rendered!', 'orange-confort-plus' ) : '';
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
			$styles[] = 'color:' . esc_attr( $atts['color'] );
		}
		if ( ! empty( $atts['bgcolor'] ) ) {
			$styles[] = 'background-color:' . esc_attr( $atts['bgcolor'] );
		}

		$outline = ! empty( $atts['style'] ) ? ' is-style-' . $atts['style'] : '';
		$style   = isset( $styles ) ? '<style>#uci_link{' . implode( ';', $styles ) . '}</style>' : '';

		// Set rendered flag.
		self::$already_done = true;

		return '<div class="wp-block-buttons is-layout-flex wp-block-buttons-is-layout-flex"><div class="wp-block-button' . $outline . '" id="ocplus_button"></div></div>' . $style;
	}
}
