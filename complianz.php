<?php
/**
 * Complianz integration file.
 *
 * @package Orange Confort+
 */

defined( 'WPINC' ) || die;

error_log( __FILE__ . ' called' );

/**
 * Add a script to the blocked list.
 *
 * @param array $tags Tags array.
 *
 * @return array
 */
function cmplz_ocplus_script( $tags ) {
	$tags[] = array(
		'name'               => 'orange-confort-plus',
		'category'           => 'functional',
		'urls'               => array(
			'orange-confort-plus/vendor/js/toolbar',
		),
		'enable_placeholder' => '0',
		'enable_dependency'  => '0',
	);

	return $tags;
}

add_filter( 'cmplz_known_script_tags', 'cmplz_ocplus_script' );
