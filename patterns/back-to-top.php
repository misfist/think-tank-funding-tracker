<?php
/**
 * Title: Back to Top
 * Slug: ttft/back-to-top
 * Categories: hidden
 * Inserter: no
 */
// Define some global state
wp_interactivity_state(
	'ttft/back-to-top',
	array(
		'isIntersecting' => false,
	)
);

$context = array(
	'isIntersecting' => false,
);
?>

<!-- wp:group {"metadata":{"name":"Back to Top"},"layout":{"type":"default"}} -->
<div 
	class="wp-block-group back-to-top"
	data-wp-interactive="ttft/back-to-top"
	<?php echo wp_interactivity_data_wp_context( $context ); ?>
	data-wp-bind="state.isIntersecting"
	data-wp-class--is-intersecting="isIntersecting"
	data-wp-class--not-intersecting="!isIntersecting"
	data-wp-watch="callbacks.observe"
>
	<!-- wp:paragraph -->
	<p><a id="scroll-to-top" href="#top" class="is-hidden"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M0 16.67l2.829 2.83 9.175-9.339 9.167 9.339 2.829-2.83-11.996-12.17z"/></svg>
	<span class="screen-reader-text"><?php esc_html_e( 'Jump to top of page', 'ttft' ); ?></span>
	</a></p>
	<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
