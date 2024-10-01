<?php
/**
 * Title: Data Table - Top 10 Domestic
 * Slug: ttt/data-table-top-10-domestic
 * Inserter: no
 *
 * %VAR1% = think_tank
 * %VAR2% = donor
 * %VAR3% = donation_year
 * %VAR4% = donor_type
 * %VAR5% = limit
 */
$type  = 'u-s-government';
$limit = 10;
$year  = '';
?>
<!-- wp:group {"metadata":{"name":"<?php echo esc_attr( $type ); ?>"},"layout":{"type":"grid","columnCount":2,"minimumColumnWidth":"17rem"},"className":"section-table domestic","tagName":"div"} -->
<div class="wp-block-group section-table domestic">
	<!-- wp:heading -->
	<h2 class="wp-block-heading">
		<?php esc_html_e( sprintf( 'Top %d Think Tanks That Receive Funding from the U.S. Government%s.', intval( $limit ), ( $year ) ? ' in ' . $year : '' ), 'ttft' ); ?>
	</h2>
	<!-- /wp:heading -->

	<!-- wp:ttft/top-ten {"donorType":"<?php echo $type; ?>","donationYear":"<?php echo $year; ?>","number":"<?php echo $limit; ?>"} /-->
</div>
<!-- /wp:group -->
