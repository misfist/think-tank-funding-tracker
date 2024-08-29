<?php
/**
 * Title: Data Table - Think Tank Archive
 * Slug: ttt/data-table-archive-think-tank
 * Categories: transparency
 * Inserter: false
 */
use function Quincy\ttt\get_most_recent_donation_year;

$year = get_most_recent_donation_year();
$table_id = 13;

echo do_shortcode( "[wpdatatable id={$table_id} var1={$year}]" ); 
?>