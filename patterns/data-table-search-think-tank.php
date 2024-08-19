<?php
/**
 * Title: Data Table - Think Tank Search
 * Slug: ttt/data-table-search-think-tank
 * Categories: transparency
 * Inserter: false
 */

$search_term = get_search_query();
$table_id    = 13;

echo do_shortcode( "[wpdatatable id={$table_id}]" );
