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
use function Quincy\ttt\get_most_recent_donation_year;
use function Quincy\ttt\print_archive_years;
use function Quincy\ttt\get_vars;
use function Quincy\ttt\get_think_tanks_data;
use function Quincy\ttt\render_think_tanks_table;
use function Quincy\ttt\get_table_id;
use function Quincy\ttt\get_app_id;

$year = get_most_recent_donation_year();
$vars = get_vars();

$var1 = ( isset( $vars['think_tank'] ) ) ? sprintf( "var1='%s'", $vars['think_tank'] ) : '';
$var3 = ( isset( $vars['year'] ) ) ? sprintf( "var3='%s'", $vars['year'] ) : '';

$table_id = get_table_id();
$app_id   = get_app_id();

$year = '';
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
