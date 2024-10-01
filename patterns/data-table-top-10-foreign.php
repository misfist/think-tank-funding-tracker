<?php
/**
 * Title: Data Table - Top 10 Foreign
 * Slug: ttt/data-table-top-10-foreign
 * Inserter: no
 *
 * %VAR1% = think_tank
 * %VAR2% = donor
 * %VAR3% = donation_year
 * %VAR4% = donor_type
 * %VAR5% = limit
 */
$table_id = 9;
$type     = 'foreign-government';
$limit    = 5;
$year     = '';
?>
<!-- wp:group {"metadata":{"name":"<?php echo esc_attr( $type ); ?>"},"layout":{"type":"grid","columnCount":2,"minimumColumnWidth":"13rem"},"className":"section-table foreign","tagName":"div"} -->
<div class="wp-block-group section-table foreign">
	<!-- wp:heading -->
	<h2 class="wp-block-heading">
		<?php esc_html_e( sprintf( 'Top %d Think Tanks That Receive Funding from Foreign Interests%s.', intval( $limit ), ( $year ) ? ' in ' . $year : '' ), 'ttt' ); ?>
	</h2>
	<!-- /wp:heading -->

	<!-- wp:ttft/top-ten {"donorType":"<?php echo $type; ?>","donationYear":"<?php echo $year; ?>","number":"<?php echo $limit; ?>"} /-->

</div>
<!-- /wp:group -->
