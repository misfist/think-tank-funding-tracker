<?php
/**
 * Register custom block styles.
 * Learn More: https://developer.wordpress.org/reference/functions/register_block_style/
 *
 * @package ttt
 */

namespace Quincy\ttft;

/**
 * Register block styles.
 */
function register_block_styles() {

	$block_styles = array(
		'core/button' => array(
			'minimal' => __( 'Minimal', 'ttft' ),
			'text'    => __( 'Text Only', 'ttft' ),
		),
		'core/quote'  => array(
			'large' => __( 'Large', 'ttft' ),
		),
	);

	foreach ( $block_styles as $block => $styles ) {
		foreach ( $styles as $style_name => $style_label ) {
			register_block_style(
				$block,
				array(
					'name'  => $style_name,
					'label' => $style_label,
				)
			);
		}
	}
}
add_filter( 'init', __NAMESPACE__ . '\register_block_styles', 10, 1 );
