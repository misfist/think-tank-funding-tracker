<?php
/**
 * Title: Data Table - Donor Search
 * Slug: ttt/data-table-search-donor
 * Categories: transparency
 * Inserter: false
 *
 * %VAR1% = think_tank
 * %VAR2% = donor
 * %VAR3% = donation_year
 * %VAR4% = donor_type
 * %VAR5% = limit
 */

$entity_type = isset( $_GET['entity_type'] ) ? sanitize_text_field( $_GET['entity_type'] ) : 'donor';
$search_term = get_search_query();
$table_id    = 12;
?>

<!-- wp:group {"metadata":{"name":"Donor Content"},"className":"tab <?php echo $entity_type === 'donor' ? 'active' : ''; ?>","layout":{"type":"default"}} -->
<div id="donor-results" class="wp-block-group tab">
	<!-- wp:shortcode -->
	<?php echo do_shortcode( "[wpdatatable id={$table_id}]" ); ?>
	<!-- /wp:shortcode -->
</div>
<!-- /wp:group -->

