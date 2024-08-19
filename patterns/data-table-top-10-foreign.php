<?php
/**
 * Title: Data Table - Top 10 Foreign
 * Slug: ttt/data-table-top-10-foreign
 * Inserter: no
 */
$table_id = 9;
$type     = 'Foreign';
?>
<!-- wp:group {"metadata":{"name":"<?php echo esc_attr( $type ); ?>"}} -->
<div class="wp-block-group alignwide">
	<!-- wp:heading -->
	<h2 class="wp-block-heading">
		<?php esc_html_e( 'Top 10 Think Tanks That Receive Funding from Foreign Interests.', 'ttt' ); ?>
	</h2>
	<!-- /wp:heading -->

	<!-- wp:shortcode -->
	<?php echo do_shortcode( "[wpdatatable id={$table_id} table_view=regular var1={$type}]" ); ?>
	<!-- /wp:shortcode -->
</div>
<!-- /wp:group -->
