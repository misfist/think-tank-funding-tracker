<?php
/**
 * Title: Data Table - Donor
 * Slug: ttt/data-table-donor
 * Categories: transparency
 * Inserter: false
 */

$post_id    = get_the_ID();
$post_title = get_the_title( $post_id );

echo do_shortcode( "[wpdatatable id=10 var1={$post_title}]" ); 
?>