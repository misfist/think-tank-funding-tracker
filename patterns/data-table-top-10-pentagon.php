<?php
/**
 * Title: Data Table - Top 10 Pentagon
 * Slug: ttt/data-table-top-10-pentagon
 * Inserter: no
 */
$type = 'Pentagon';
?>
<!-- wp:group {"metadata":{"name":"<?php echo esc_attr( $type ); ?>"}} -->
<div class="wp-block-group alignwide">
	<!-- wp:heading -->
	<h2 class="wp-block-heading">
		<?php esc_html_e( 'Top 10 Think Tanks That Receive Funding from Pentagon Contractors', 'ttt' ); ?>
	</h2>
	<!-- /wp:heading -->

	<!-- wp:shortcode -->
    <?php echo do_shortcode( "[wpdatatable id=9 table_view=regular var1={$type}]" ); ?>
	<!-- /wp:shortcode -->
</div>
<!-- /wp:group -->