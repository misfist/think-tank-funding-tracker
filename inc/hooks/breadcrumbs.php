<?php
/**
 * Breadcrumb Block Mods.
 *
 * @package ttt
 */

namespace Quincy\ttt;

/**
 * Modify Breadcrumb for Single Donor
 *
 * @param  string $breadcrumb
 * @param  array  $args
 * @param  obj    $instance
 * @return string
 */
function breadcrumb_trail( $breadcrumb, $args, $instance ): string {
	if ( is_singular( 'donor' ) ) {
		$post_id  = get_the_ID();
		$taxonomy = 'donor_type';
		if ( has_term( '', $taxonomy, $post_id ) ) {
			$donor_types = wp_get_post_terms( $post_id, $taxonomy, array( 'number' => 1 ) );
			$donor_type  = $donor_types[0];
			$search      = '<li class="breadcrumb-item breadcrumb-item--current"';
			$replace     = sprintf( '<li class="breadcrumb-item breadcrumb-item--taxonomy"><a href="%s">%s</a></li><li class="breadcrumb-item breadcrumb-item--current"', get_term_link( $donor_type, $taxonomy ), wp_strip_all_tags( $donor_type->name ) );
			$breadcrumb  = str_replace( $search, $replace, $breadcrumb );
		}
	}

	return $breadcrumb;
}
\add_filter( 'breadcrumb_block_get_breadcrumb_trail', __NAMESPACE__ . '\breadcrumb_trail', '', 3 );
