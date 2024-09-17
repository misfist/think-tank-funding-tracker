<?php
/**
 * Block variations.
 *
 * @package ttt
 */
namespace Quincy\ttt;

/**
 * Add title attribute to post-title and post-featured-image blocks
 *
 * @link https://developer.wordpress.org/reference/classes/wp_html_tag_processor/
 *
 * @param  string $block_content
 * @param  array  $block
 * @return string $block_content
 */
function remove_autop( $block_content, $block ) {
	if ( 'core/shortcode' !== $block['blockName'] ) {
		return $block_content;
	}
	remove_filter( 'the_content', 'wpautop' );
	return $block_content;
}
add_filter( 'render_block', __NAMESPACE__ . '\remove_autop', 10, 2 );
