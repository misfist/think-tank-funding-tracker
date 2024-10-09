<?php
/**
 * Title: Data Table - Donor Search
 * Slug: ttft/data-table-search-donor
 * Categories: transparency
 * Inserter: false
 *
 * %VAR1% = think_tank
 * %VAR2% = donor
 * %VAR3% = donation_year
 * %VAR4% = donor_type
 * %VAR5% = limit
 */
use function Quincy\ttft\get_app_id;
$app_namespace = get_app_id();
?>

<!-- wp:group {"metadata":{"name":"Donor Content"},"className":"tab","layout":{"type":"default"}} -->
<div 
	id="donor-results" 
	class="wp-block-group tab"
	data-wp-interactive=<?php echo $app_namespace; ?>
	data-wp-class--active="state.donorSelected"
	data-wp-bind--hidden="state.!donorSelected"
>

<!-- wp:data-tables/data-table { "tableType":"donor-archive", "donationYear":"all", "donorType":"all" } /-->
	
</div>
<!-- /wp:group -->


