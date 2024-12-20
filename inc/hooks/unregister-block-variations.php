<?php
/**
 * Functions to disable core Gutenberg blocks.
 *
 * @package ttft
 */

namespace Quincy\ttft;

/**
 * Prevents editors from adding unregistered core blocks to content or pages.
 *
 * @return void
 */
function remove_core_blocks_gutenberg_editor() {
	wp_enqueue_script(
		'unregister_core_blocks',
		get_template_directory_uri() . '/build/js/filters.js',
		array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ),
		wp_get_theme()->get( 'Version' ),
		true
	);
}
// add_action( 'enqueue_block_assets', __NAMESPACE__ . '\remove_core_blocks_gutenberg_editor' );
