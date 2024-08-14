<?php
/**
 * Title: Data Table - Think Tank
 * Slug: ttt/data-table-think-tank
 * Categories: transparency
 * Inserter: false
 */

$post_id    = get_the_ID();
$post_title = get_the_title( $post_id );
 
echo do_shortcode( "[wpdatatable id=11 var1={$post_title}]" ); 
?>