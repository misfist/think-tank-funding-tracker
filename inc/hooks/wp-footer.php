<?php
/**
 * Filter wp_footer
 *
 * @package ttt
 */

namespace Quincy\ttft;

/**
 * Add back to top link to footer
 *
 * @return void
 */
function wp_footer(): void {
	?>
	<a href="#top"><?php esc_html_e( 'Jump to top of page', 'ttt' ); ?></a>
	<?php
}
add_action( 'wp_footer', __NAMESPACE__ . '\wp_footer' );
