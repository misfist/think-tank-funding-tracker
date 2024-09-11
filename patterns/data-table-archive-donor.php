<?php
/**
 * Title: Data Table - Donor Archive
 * Slug: ttt/data-table-archive-donor
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
use function Quincy\ttt\get_vars;
use function Quincy\ttt\get_donors_raw_data;
use function Quincy\ttt\get_donors_data;

$year = get_most_recent_donation_year();
$vars = get_vars();

$var1 = ( isset( $vars['donor'] ) ) ? sprintf( "var2='%s'", $vars['donor'] ) : '';
$var3 = ( isset( $vars['year'] ) ) ? sprintf( "var3='%s'", $vars['year'] ) : sprintf( "var3='%s'", $year );

$year = '';
$type = get_query_var( 'donor_type', '' );
$table_id = 12;

?>

<!-- wp:group {"metadata":{"name":"Data Filters"},"id":"custom-filters","className":"wpDataTables data-filters","layout":{"type":"default"}} -->
<div id="custom-filters" class="wp-block-group wpDataTables data-filters" data-table-id="<?php echo intval( $table_id ); ?>" data-table-number="table_1">
	<!-- wp:shortcode -->
	<?php echo do_shortcode( "[donors_table year='{$year}' type='{$type}']" ); ?>
	<!-- /wp:shortcode -->
<!-- /wp:group -->
