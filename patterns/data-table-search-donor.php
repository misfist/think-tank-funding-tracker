<?php
/**
 * Title: Data Table - Donor Search
 * Slug: ttt/data-table-search-donor
 * Categories: transparency
 * Inserter: false
 */

$search_term = get_search_query();
$table_id    = 12;

echo do_shortcode( "[wpdatatable id={$table_id}]" );
