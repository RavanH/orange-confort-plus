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
		// Register settings.
		\register_setting(
			'reading',
			'oc_plus_script_version',
			array(
				'type'    => 'string',
				'default' => '4.3.6',
			)
		);

		\register_setting(
			'reading',
			'oc_plus_position',
			array(
				'type'    => 'array',
				'default' => array(),
			)
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
	 * Plugin action link.
	 *
	 * @since 0.7
	 *
	 * @param array $links Action links array.
	 *
	 * @return array $links
	 */
	public static function add_action_link( $links ) {
		$settings_link = '<a href="' . \admin_url( 'options-reading.php' ) . '#oc_plus">' . \esc_html__( 'Settings', 'xml-sitemaps-manager' ) . '</a>';
		\array_unshift( $links, $settings_link );
		return $links;
	}

	/**
	 * Plugin meta links.
	 *
	 * @since 0.1
	 *
	 * @param array  $links Meta links array.
	 * @param string $file  Plugin file name.
	 *
	 * @return array $links
	 */
	public static function plugin_meta_links( $links, $file ) {
		if (  BASENAME === $file ) {
			$links[] = '<a target="_blank" href="https://wordpress.org/support/plugin/orange-confort-plus/">' . \esc_html__( 'Support', 'xml-sitemaps-manager' ) . '</a>';
			$links[] = '<a target="_blank" href="https://wordpress.org/support/plugin/orange-confort-plus/reviews/?filter=5#new-post">' . \esc_html__( 'Rate ★★★★★', 'xml-sitemaps-manager' ) . '</a>';
		}
		return $links;
	}

	/**
	 * Settings field.
	 */
	public static function settings_field() {
		$script_v = (string) \get_option( 'oc_plus_script_version' );
		$position = (array) \get_option( 'oc_plus_position' );
		$button   = isset( $position['button'] ) ? $position['button'] : '';
		$toolbar  = isset( $position['toolbar'] ) ? $position['toolbar'] : '';
		?>
<fieldset id="oc_plus">
	<legend class="screen-reader-text">
		<?php \esc_html_e( 'Orange Confort+', 'orange-confort-plus' ); ?>
	</legend>
	<p>
		<label>
			<?php \esc_html_e( 'Accessibility toolbar version:', 'orange-confort-plus' ); ?>
			<select name="oc_plus_script_version" id="oc_plus_script_version">
				<option value="4.3.6"<?php \selected( '4.3.6', $script_v ); ?>>4.3.6</option>
				<option value="5.0.1"<?php \selected( '5.0.1', $script_v ); ?>>5.0.1</option>
			</select>
		</label>
	</p>
	<?php if ( ! $script_v || \version_compare( $script_v, '5', '<' ) ) : ?>
	<p>
		<label>
			<?php \esc_html_e( 'Accessibility toolbar position:', 'orange-confort-plus' ); ?>
			<select name="oc_plus_position[toolbar]" id="oc_plus_toolbar_position">
				<?php if ( ! $script_v || \version_compare( $script_v, '5', '<' ) ) : ?>
					<option value=""><?php \esc_html_e( 'Page top', 'orange-confort-plus' ); ?></option>
				<?php endif; ?>
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
		<?php \printf( /* translators: shortcode and ID examples */ \esc_html__( 'For a custom button position, use the shortcode %s.', 'orange-confort-plus' ), '<code>[ocplus_button style="outline" color="black" bgcolor="" /]</code>' ); ?>
		<a href="https://wordpress.org/plugins/orange-confort-plus/#how%20to%20use%20the%20shortcode%3F" target="_blank"><?php \esc_html_e( 'Learn more about the shortcode.', 'orange-confort-plus' ); ?></a>
	</p>
	<?php else : ?>
	<p class="description">
		<?php \esc_html_e( 'The toolbar version 5+ is positioned in the top right or the browser window. For custom position options, select a script version below 5.0.', 'orange-confort-plus' ); ?>
	</p>
	<?php endif; ?>
</fieldset>
<script>
if ( "#oc_plus" === window.location.hash ) {
	document.getElementById( "oc_plus" ).className += " highlight";
}
</script>
		<?php
	}
}
