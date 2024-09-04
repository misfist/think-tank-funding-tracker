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
$type     = 'Pentagon';
$limit    = 10;
?>
<!-- wp:group {"metadata":{"name":"<?php echo esc_attr( $type ); ?>"},"layout":{"type":"grid","columnCount":2,"minimumColumnWidth":"13rem"},"className":"section section__top-10 pentagon","tagName":"section"} -->
<section class="wp-block-group section section__top-10 pentagon">
	<!-- wp:heading -->
	<h2 class="wp-block-heading">
		<?php esc_html_e( sprintf( 'Top %d Think Tanks That Receive Funding from Pentagon Contractors', intval( $limit ) ), 'ttt' ); ?>
	</h2>
	<!-- /wp:heading -->

	<!-- wp:shortcode -->
	<?php echo do_shortcode( "[wpdatatable id={$table_id} table_view=regular var4='{$type}' var5={$limit}]" ); ?>
	<!-- /wp:shortcode -->
</section>
<!-- /wp:group -->
