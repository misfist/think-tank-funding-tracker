<?php
/**
 * Removes or Adjusts the prefix on category archive page titles.
 *
 * @package ttt
 */

namespace Quincy\ttft;

/**
 * Removes or Adjusts the prefix on category archive page titles.
 *
 * @author Quincy
 *
 * @param string $archive_title The default $archive_title of the page.
 *
 * @return string The updated $archive_title.
 */
function remove_archive_title_prefix( $archive_title ) {
	$single_cat_title = single_term_title( '', false );

	if ( is_post_type_archive( array( 'think_tank', 'donor' ) ) ) {
		return sprintf( '%s %s', esc_html__( 'All', 'ttft' ), $archive_title );
	}

	if ( is_category() || is_tag() || is_tax() ) {
		return esc_html( $single_cat_title );
	}

	return $archive_title;
}

add_filter( 'get_the_archive_title', __NAMESPACE__ . '\remove_archive_title_prefix' );
