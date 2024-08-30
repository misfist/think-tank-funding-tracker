<?php
/**
 * Title: Data Table - Top 10 Domestic
 * Slug: ttt/data-table-top-10-domestic
 * Inserter: no
 */
$table_id = 9;
$type     = 'U.S.';
$limit    = 10;
?>
<!-- wp:group {"metadata":{"name":"<?php echo esc_attr( $type ); ?>"},"layout":{"type":"grid","columnCount":2,"minimumColumnWidth":"17rem"},"className":"section section__top-10 domestic","tagName":"section"} -->
<section class="wp-block-group section section__top-10 domestic">
	<!-- wp:heading -->
	<h2 class="wp-block-heading">
		<?php esc_html_e( sprintf( 'Top %d Think Tanks That Receive Funding from the U.S. Government.', intval( $limit ) ), 'ttt' ); ?>
	</h2>
	<!-- /wp:heading -->

	<!-- wp:shortcode -->
	<?php echo do_shortcode( "[wpdatatable id={$table_id} table_view=regular var1='{$type}' var2={$limit}]" ); ?>
	<!-- /wp:shortcode -->
</section>
<!-- /wp:group -->
