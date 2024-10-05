<?php
/**
 * Title: Data Table - Donor
 * Slug: ttt/data-table-donor
 * Categories: transparency
 * Inserter: false
 *
 * %VAR1% = think_tank
 * %VAR2% = donor
 * %VAR3% = donation_year
 * %VAR4% = donor_type
 * %VAR5% = limit
 */
use function Quincy\ttft\get_single_donor_total;
global $post;

$post_id = get_the_ID();
$donor   = get_post_field( 'post_name', $post_id );
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
	"tableType":"single-donor",
	"donor":"<?php echo $donor; ?>"
	} /-->
