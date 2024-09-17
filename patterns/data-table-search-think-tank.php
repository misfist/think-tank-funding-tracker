<?php
/**
 * Title: Data Table - Think Tank Search
 * Slug: ttt/data-table-search-think-tank
 * Categories: transparency
 * Inserter: false
 *
 * %VAR1% = think_tank
 * %VAR2% = donor
 * %VAR3% = donation_year
 * %VAR4% = donor_type
 * %VAR5% = limit
 */
use function Quincy\ttt\get_table_id;
use function Quincy\ttt\get_app_id;

$entity_type = isset( $_GET['entity_type'] ) ? sanitize_text_field( $_GET['entity_type'] ) : 'donor';
$search_term = get_search_query();
$table_id    = 13;
?>

<!-- wp:group {"metadata":{"name":"Think Tanks Content"},"className":"tab <?php echo $entity_type === 'think_tank' ? 'active' : ''; ?>","layout":{"type":"default"}} -->
<div id="think-tank-results" class="wp-block-group tab">
	<!-- wp:shortcode -->
	<?php echo do_shortcode( "[wpdatatable id={$table_id}]" ); ?>
	<!-- /wp:shortcode -->
</div>
<!-- /wp:group -->
