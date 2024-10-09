<?php
/**
 * Block pattern categories.
 *
 * @package ttft
 */
namespace Quincy\ttft;

/**
 * Registers a custom block pattern category.
 * 
 * @return void
 */
function block_pattern_category(): void {
	register_block_pattern_category(
		'content-template',
		array(
			'label' => __( 'Content Template', 'text-domain' ),
		)
	);
}

add_action( 'init', __NAMESPACE__ . '\block_pattern_category' );
