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

/**
 * Add default wdt_search query var to search block
 *
 * @param  array  $args
 * @param  string $block_type
 * @return array
 */
function register_block_type_args( array $args, string $block_type ) : array {
	$search_term = $_GET['s'];
	if( 'core/search' === $block_type ) {
		$search_term  = $_GET['s'];
		if( $search_term ) {
			$args['attributes']['query']['default']['wdt_search'] = urlencode( sanitize_text_field( $search_term ) );
		}
	}
	return $args;
}
add_filter( 'register_block_type_args', __NAMESPACE__ . '\register_block_type_args', '', 2 );
