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
use function Quincy\ttt\get_most_recent_donation_year;
use function Quincy\ttt\print_years;
use function Quincy\ttt\get_donor_think_tank_raw_data;
use function Quincy\ttt\get_donor_think_tank_data;

$post_id    = get_the_ID();
$post       = get_post( $post_id );
$post_title = $post->post_title;
$donor      = $post->post_name;
$donors     = wp_get_post_terms(
	$post_id,
	'donor',
	array(
		'number' => 1,
		'fields' => 'names',
	)
);
$donor_name = ( $donors ) ? $donors[0] : $post_title;
$table_id   = 10;
$year       = get_most_recent_donation_year();
$year       = '';
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
	"thinkTank":"<?php echo $donor; ?>"
	} /-->
