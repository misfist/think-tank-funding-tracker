<?php
/**
 * Title: Data Table - Top 10 Pentagon
 * Slug: ttt/data-table-top-10-pentagon
 * Inserter: no
 * 
 * %VAR1% = think_tank
 * %VAR2% = donor
 * %VAR3% = donation_year
 * %VAR4% = donor_type
 * %VAR5% = limit
 */
$table_id = 9;
$type     = 'pentagon-contractor';
$limit    = 10;
$year     = '';
?>
<!-- wp:group {"metadata":{"name":"<?php echo esc_attr( $type ); ?>"},"layout":{"type":"grid","columnCount":2,"minimumColumnWidth":"13rem"},"className":"pentagon","tagName":"div"} -->
<div class="wp-block-group section-table pentagon">
	<!-- wp:heading -->
	<h2 class="wp-block-heading">
		<?php esc_html_e( sprintf( 'Top %d Think Tanks That Receive Funding from Pentagon Contractors%s.', intval( $limit ), ( $year ) ? ' in ' . $year : '' ), 'ttt' ); ?>
	</h2>
	<!-- /wp:heading -->

	<!-- wp:shortcode -->
	<?php echo do_shortcode( "[top_ten_table type='{$type}' year='{$year}' limit={$limit}]" ); ?>
	<!-- /wp:shortcode -->
</div>
<!-- /wp:group -->
