<?php
/**
 * Register template-part areas.
 * Learn More: https://developer.wordpress.org/news/2023/06/16/upgrading-the-site-editing-experience-with-custom-template-part-areas/
 *
 * @package ttt
 */

namespace Quincy\ttft;

/**
 * Register template part areas
 *
 * @param  array $areas
 * @return array
 */
function register_template_part_areas( array $areas ): array {
	$areas[] = array(
		'area'        => 'sidebar',
		'area_tag'    => 'section',
		'label'       => __( 'Sidebar', 'ttft' ),
		'description' => __( 'Custom sidebar displays above footer', 'ttft' ),
		'icon'        => 'sidebar',
	);

	return $areas;
}
\add_filter( 'default_wp_template_part_areas', __NAMESPACE__ . '\register_template_part_areas' );
