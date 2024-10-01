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
$post    = get_post( $post_id );
$donor   = $post->post_name;
?>

<!-- wp:group {"metadata":{"name":"Think Tank Total Donations Received"},"className":"total-donations","layout":{"type":"default"}} -->
<div class="wp-block-group total-donations">
	<!-- wp:paragraph -->
	<p><?php esc_html_e( 'Minimum amount received', 'ttft' ); ?><p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"level":4, "className":"dollar-value"} -->
	<h4 class="dollar-value"><?php echo number_format( $total_donations ); ?></h4>
	<!-- /wp:heading -->
</div>
<!-- /wp:group -->

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
