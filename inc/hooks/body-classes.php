<?php
/**
 * Modify Body Classes.
 *
 * @package ttft
 */

namespace Quincy\ttft;

/**
 * Add body classes
 * 
 * @link https://developer.wordpress.org/reference/hooks/body_class/
 *
 * @param  array $classes
 * @return array
 */
function body_classes( $classes ): array {
	if ( is_singular( 'think_tank' ) ) {
		$is_transparent = is_transparent();
		if(  $is_transparent ) {
			$classes[] = 'is-transparent';
		}
		$is_limited = is_limited();
		if(  $is_limited ) {
			$classes[] = 'is-limited';
		}
	}

	if ( is_singular() || is_page() ) {
		global $post;
		$classes[] = 'post-' . $post->post_name;
		$classes[] = sprintf( '%s-%s', $post->post_type, $post->post_name );
	}

	return $classes;
}
add_filter( 'body_class', __NAMESPACE__ . '\body_classes' );