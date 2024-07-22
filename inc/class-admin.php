<?php
/**
 * Orange Confort+ admin class.
 *
 * @package Orange Confort+
 *
 * @since 0.6
 */

namespace OCplus;

/**
 * Admin class handles settings and fields.
 */
class Admin {
	/**
	 * Settings.
	 */
	public static function settings() {
		// Register setting.
		\register_setting(
			'reading',
			'oc_plus_position',
			array(
				'type'    => 'array',
				'default' => array(),
			),
		);

		// Add field.
		\add_settings_field(
			'oc_plus',
			\__( 'Orange Confort+', 'orange-confort-plus' ),
			array( __CLASS__, 'settings_field' ),
			'reading'
		);
	}

	/**
	 * Settings field.
	 */
	public static function settings_field() {
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
				<option value="top"<?php \selected( 'top', $toolbar ); ?>><?php \esc_html_e( 'Window top', 'orange-confort-plus' ); ?></option>
				<option value="bottom"<?php \selected( 'bottom', $toolbar ); ?>><?php \esc_html_e( 'Window bottom', 'orange-confort-plus' ); ?></option>
			</select>
		</label>
	</p>
	<p>
		<label>
			<?php \esc_html_e( 'Accessibility button position:', 'orange-confort-plus' ); ?>
			<select name="oc_plus_position[button]" id="oc_plus_button_position">
				<option value=""><?php \esc_html_e( 'Right', 'orange-confort-plus' ); ?></option>
				<option value="left"<?php \selected( 'left', $button ); ?>><?php \esc_html_e( 'Left', 'orange-confort-plus' ); ?></option>
			</select>
		</label>
	</p>
	<p class="description">
		<?php \printf( /* translators: shortcode and ID examples */ \esc_html__( 'For a custom button position, use either the shortcode %1$s or a button block with the ID (HTML anchor) %2$s on your site.', 'orange-confort-plus' ), '<code>[ocplus_button style="outline" color="black" bgcolor="" /]</code>', '<code>ocplus_button</code>' ); ?>
		<br>
		<?php \esc_html_e( 'Please note: not all toolbar positions may work well in combination with a custom button position.', 'orange-confort-plus' ); ?>
	</p>
</fieldset>
		<?php
	}
}
