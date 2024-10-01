<?php
/**
 * Title: Data Table - Think Tank Archive
 * Slug: ttt/data-table-archive-think-tank
 * Categories: transparency
 * Inserter: false
 *
 * %VAR1% = think_tank
 * %VAR2% = donor
 * %VAR3% = donation_year
 * %VAR4% = donor_type
 * %VAR5% = limit
 */
?>
<!-- wp:group {"metadata":{"name":"Filters"},"className":"data-filters","layout":{"type":"default"}} -->
<div class="wp-block-group data-filters"><!-- wp:group {"metadata":{"name":"Donation Year"},"layout":{"type":"default"}} -->
	<div class="wp-block-group">
		<!-- wp:data-tables/data-filter-donation-year /-->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->

<!-- wp:data-tables/data-table {
	"tableType":"think-tank-archive",
	"donationYear":"all",
	"donorType":"all"
} /-->
