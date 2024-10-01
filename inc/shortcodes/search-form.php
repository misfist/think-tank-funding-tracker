<?php
/**
 * Custom search form
 *
 * @package ttt
 */

namespace Quincy\ttft;

/**
 * Render search form
 *
 * @return void
 */
function search_form() {
	$output = shortcode_unautop( \get_search_form( array( 'echo' => false ) ) );
	return $output;
}
add_shortcode( 'search_form', __NAMESPACE__ . '\search_form' );
