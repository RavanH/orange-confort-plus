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
	 * Render OC+ button by shortcode.
	 *
	 * @param array $atts Shortcode arguments array.
	 */
	public static function render( $atts = array() ) {
		$atts = \shortcode_atts(
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
}
