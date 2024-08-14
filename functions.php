<?php
/**
 * WDS BT functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ttt
 * @author  Quincy
 * @license GNU General Public License v3
 */

namespace Quincy\ttt;

// Define a global path and url.
define( 'Quincy\ttt\ROOT_PATH', trailingslashit( get_template_directory() ) );
define( 'Quincy\ttt\ROOT_URL', trailingslashit( get_template_directory_uri() ) );


/**
 * Get all the include files for the theme.
 *
 * @author Quincy
 */
function include_inc_files() {
	$files = array(
		'inc/functions/',
		'inc/hooks/',
		'inc/setup/',
	);

	foreach ( $files as $include ) {
		$include = trailingslashit( get_template_directory() ) . $include;

		if ( is_dir( $include ) ) {
			foreach ( glob( $include . '*.php' ) as $file ) {
				include $file;
			}
		} else {
			include $include;
		}
	}
}

include_inc_files();
