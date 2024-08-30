<?php
/**
 * Title: Data Table - Donor
 * Slug: ttt/data-table-donor
 * Categories: transparency
 * Inserter: false
 */
use function Quincy\ttt\get_most_recent_donation_year;
use function Quincy\ttt\print_years;

$post_id    = get_the_ID();
$post_title = get_the_title( $post_id );
$terms      = wp_get_post_terms(
	$post_id,
	'donor',
	array(
		'number' => 1,
		'fields' => 'names',
	)
);
$term_name  = ( $terms ) ? $terms[0] : $post_title;
$table_id   = 10;
$year       = get_most_recent_donation_year();
?>

<!-- wp:group {"metadata":{"name":"Data Filters"},"id":"custom-filters","className":"wpDataTables data-filters","layout":{"type":"default"}} -->
<div id="custom-filters" class="wp-block-group wpDataTables data-filters" data-table-id="<?php echo intval( $table_id ); ?>" data-table-number="table_1">

	<?php print_years(); ?>

</div>
<!-- /wp:group -->

<!-- wp:shortcode -->
<?php echo do_shortcode( "[wpdatatable id={$table_id} var1='{$term_name}' var2='' export_file_name='{$term_name}']" ); ?>
<!-- /wp:shortcode -->



