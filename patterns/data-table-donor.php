<?php
/**
 * Title: Data Table - Donor
 * Slug: ttt/data-table-donor
 * Categories: transparency
 * Inserter: false
 */
use function Quincy\ttt\get_most_recent_donation_year;

$post_id    = get_the_ID();
$post_title = get_the_title( $post_id );
$terms      = wp_get_post_terms(
	$post_id,
	'donor',
	array(
		'number' => 1,
		'fields' => 'names',
	)
);
$term_name  = ( $terms ) ? $terms[0] : $post_title;
$table_id   = 10;
$year       = get_most_recent_donation_year();

echo do_shortcode( "[wpdatatable id={$table_id} var2='' var1='{$term_name}' export_file_name='{$term_name}']]" );



