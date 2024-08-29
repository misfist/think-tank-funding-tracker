<?php
/**
 * Title: Data Table - Donor Search
 * Slug: ttt/data-table-search-donor
 * Categories: transparency
 * Inserter: false
 */

$search_term = get_search_query();
$table_id    = 12;
?>

<!-- wp:shortcode -->
<?php echo do_shortcode( "[wpdatatable id={$table_id} var1='{$search_term}']" ); ?>
<!-- /wp:shortcode -->
