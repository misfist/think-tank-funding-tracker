<?php
/**
 * Enqueue scripts and styles.
 *
 * @package ttft
 */

namespace Quincy\ttft;

/**
 * Enqueue scripts and styles.
 *
 * @author Quincy
 *
 * @return void
 */
function scripts(): void {
	$asset_file_path = get_template_directory() . '/build/js/index.asset.php';

	if ( is_readable( $asset_file_path ) ) {
		$asset_file = include $asset_file_path;
	} else {
		$asset_file = array(
			'version'      => '0.1.0',
			'dependencies' => array( 'wp-polyfill' ),
		);
	}

	// Register styles & scripts.
	wp_enqueue_style( 'ttft-styles', get_stylesheet_directory_uri() . '/build/css/style.css', array(), $asset_file['version'] );
	wp_enqueue_script( 'ttft-scripts', get_stylesheet_directory_uri() . '/build/js/index.js', $asset_file['dependencies'], $asset_file['version'], true );

}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\scripts' );
