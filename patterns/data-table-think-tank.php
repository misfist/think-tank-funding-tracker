<?php
/**
 * Title: Data Table - Think Tank
 * Slug: ttt/data-table-think-tank
 * Categories: transparency
 * Inserter: false
 */

$post_id    = get_the_ID();
$post_title = get_the_title( $post_id );
$table_id   = 11;

echo do_shortcode( "[wpdatatable id={$table_id} var1={$post_title}]" );

