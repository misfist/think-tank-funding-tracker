<?php
/**
 * Title: Data Table - Think Tank Search
 * Slug: ttt/data-table-search-think-tank
 * Categories: transparency
 * Inserter: false
 *
 * %VAR1% corresponses to donation_year name
 * %VAR2% corresponses to think_tank name
 */

$search_term = get_search_query();
$table_id    = 13;
?>

<!-- wp:shortcode -->
<?php echo do_shortcode( "[wpdatatable id={$table_id} var2='{$search_term}']" ); ?>
<!-- /wp:shortcode -->