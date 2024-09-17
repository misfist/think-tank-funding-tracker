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
<!-- wp:group {"metadata":{"name":"Data Filters"},"id":"custom-filters","className":"wpDataTables data-filters","layout":{"type":"default"}} -->
<div 
	id="custom-filters" 
	class="wp-block-group wpDataTables data-filters" 
	data-table-id="<?php echo sanitize_key( $table_id ); ?>"
	data-wp-interactive="<?php echo sanitize_key( $app_id ); ?>"
>
	<?php echo print_archive_years( 6 ); ?>
</div>
<!-- /wp:group -->
	
<!-- wp:shortcode -->
<?php echo do_shortcode( '[think_tanks_table]' ); ?>
<!-- /wp:shortcode -->
	
