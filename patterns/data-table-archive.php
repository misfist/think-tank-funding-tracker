<?php
/**
 * Title: Data Table - Archive
 * Slug: ttt/data-table-archive
 * Categories: transparency
 * Inserter: false
 *
 * %VAR1% = think_tank
 * %VAR2% = donor
 * %VAR3% = donation_year
 * %VAR4% = donor_type
 * %VAR5% = limit
 */
global $post, $wp_query;
var_dump( $wp_query->query_vars );
?>

<!-- wp:group {"metadata":{"name":"Filters"},"className":"data-filters","layout":{"type":"default"}} -->
<div class="wp-block-group data-filters">
	<!-- wp:group {"metadata":{"name":"Donation Year"},"layout":{"type":"default"}} -->
	<?php
	if ( ! is_tax( 'donation_year' ) ) :
		?>
		<div class="wp-block-group">
			<!-- wp:data-tables/data-filter-donation-year /-->
		</div>
		<!-- /wp:group -->
		<?php
	endif;
	?>

	<?php
	if ( ! is_tax( 'donor_type' ) ) :
		?>
		<!-- wp:group {"metadata":{"name":"Donor Type"},"layout":{"type":"default"}} -->
		<div class="wp-block-group">
			<!-- wp:data-tables/data-filter-donor-type /-->
			</div>
		<!-- /wp:group -->
		<?php
	endif;
	?>
</div>
<!-- /wp:group -->

<!-- wp:data-tables/data-table {
	"tableType":"donor-archive",
	"donationYear":"all",
	"donorType":"all"
} /-->

