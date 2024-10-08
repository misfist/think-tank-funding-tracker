<?php
/**
 * PHP file to use when rendering the block type on the server to show on the front end.
 *
 * The following variables are exposed to the file:
 *     $attributes (array): The block attributes.
 *     $content (string): The block default content.
 *     $block (WP_Block): The block instance.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

// Define some global state
wp_interactivity_state(
	'back-to-top',
	array(
		'isIntersecting' => false,
	)
);

$context = array(
	'isIntersecting' => false,
);

$attributes = get_block_wrapper_attributes(
	array(
		...$attributes,
		'class' => 'back-to-to',
		'id'    => 'bottom',
		'href'  => '#top',
	)
);
?>
<div <?php echo wp_kses_data( $attributes ); ?>
	data-wp-interactive="back-to-top"
	<?php echo wp_interactivity_data_wp_context( $context ); ?>
	data-wp-bind="state.isIntersecting"
	data-wp-class--is-intersecting="isIntersecting"
	data-wp-class--not-intersecting="!isIntersecting"
	data-wp-watch="callbacks.observe"
>
>
	<a id="bottom" href="#top" class="back-to-top">
		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M0 16.67l2.829 2.83 9.175-9.339 9.167 9.339 2.829-2.83-11.996-12.17z"/></svg>
		<span class="screen-reader-text"><?php esc_html_e( 'Jump to top of page', 'ttft' ); ?></span>
	</a>
</div>
