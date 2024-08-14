<?php
/**
 * Title: Data Table - Donor Archive
 * Slug: ttt/data-table-archive-donor
 * Categories: transparency
 * Inserter: false
 */
use function Quincy\ttt\get_most_recent_donation_year;

$year = get_most_recent_donation_year();

echo do_shortcode( "[wpdatatable id=12 var1={$year}]" ); 
?>