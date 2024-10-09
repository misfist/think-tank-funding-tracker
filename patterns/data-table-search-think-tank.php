<?php
/**
 * Title: Data Table - Think Tank Search
 * Slug: ttft/data-table-search-think-tank
 * Categories: transparency
 * Inserter: false
 *
 * %VAR1% = think_tank
 * %VAR2% = donor
 * %VAR3% = donation_year
 * %VAR4% = donor_type
 * %VAR5% = limit
 */
use function Quincy\ttft\get_table_id;
use function Quincy\ttft\get_app_id;

$app_namespace = get_app_id();
?>

<!-- wp:group {"metadata":{"name":"Think Tanks Content"},"className":"tab","layout":{"type":"default"}} -->
<div 
	id="think-tank-results" 
	class="wp-block-group tab"
	data-wp-interactive=<?php echo $app_namespace; ?>
	data-wp-class--active="state.thinkTankSelected"
	data-wp-bind--hidden="state.!thinkTankSelected"
>
	<!-- /wp:group -->
		<!-- wp:data-tables/data-table {
		"tableType":"think-tank-archive",
		"donationYear":"all",
		"donorType":"all"
	} /-->
</div>

