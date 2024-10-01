<?php
/**
 * Register blocks
 *
 * @package ttt
 */
namespace Quincy\ttft;

/**
 * Registers all block folders found in the `blocks` directory.
 *
 * @return void
 */
function register_blocks() {
	$block_folders = glob( get_stylesheet_directory() . '/build/blocks/*', GLOB_ONLYDIR );
	foreach ( $block_folders as $block_folder ) {
		register_block_type( $block_folder );
	}
}
add_action( 'init', __NAMESPACE__ . '\register_blocks' );
