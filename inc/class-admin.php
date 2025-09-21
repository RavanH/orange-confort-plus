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

		/**
		 * Plugin action links.
		 */
		\add_filter( 'plugin_action_links_' . BASENAME, array( __CLASS__, 'add_action_link' ) );
		\add_filter( 'plugin_row_meta', array( __CLASS__, 'plugin_meta_links' ), 10, 2 );
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
		<?php \printf( /* translators: shortcode and ID examples */ \esc_html__( 'For a custom button position, use the shortcode %1$s.', 'orange-confort-plus' ), '<code>[ocplus_button style="outline" color="black" bgcolor="" /]</code>' ); ?>
		<a href="https://wordpress.org/plugins/orange-confort-plus/#how%20to%20use%20the%20shortcode%3F" target="_blank"><?php \esc_html_e( 'Learn more about the shortcode.', 'orange-confort-plus' ); ?></a>
	</p>
</fieldset>
<script>
if ( "#oc_plus" === window.location.hash ) {
	document.getElementById( "oc_plus" ).className += " highlight";
}
</script>
		<?php
	}
}
