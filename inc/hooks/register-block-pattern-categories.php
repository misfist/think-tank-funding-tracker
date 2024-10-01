<?php
/**
 * Registers custom block pattern categories for the WDS BT theme.
 *
 * @package ttt
 */

namespace Quincy\ttft;

/**
 * Registers custom block pattern categories for the WDS BT theme.
 */
function register_custom_block_pattern_categories() {

	register_block_pattern_category(
		'content',
		array(
			'label'       => __( 'Content', 'ttt' ),
			'description' => __( 'A collection of content patterns designed for WDS BT.', 'ttt' ),
		)
	);
	register_block_pattern_category(
		'hero',
		array(
			'label'       => __( 'Hero', 'ttt' ),
			'description' => __( 'A collection of hero patterns designed for WDS BT.', 'ttt' ),
		)
	);
	register_block_pattern_category(
		'page',
		array(
			'label'       => __( 'Pages', 'ttt' ),
			'description' => __( 'A collection of page patterns designed for WDS BT.', 'ttt' ),
		)
	);
	register_block_pattern_category(
		'template',
		array(
			'label'       => __( 'Templates', 'ttt' ),
			'description' => __( 'A collection of template patterns designed for WDS BT.', 'ttt' ),
		)
	);

	// Remove default patterns.
	remove_theme_support( 'core-block-patterns' );
}
add_action( 'init', __NAMESPACE__ . '\register_custom_block_pattern_categories', 9 );
