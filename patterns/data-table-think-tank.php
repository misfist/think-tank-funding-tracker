<?php
/**
 * Title: Data Table - Think Tank
 * Slug: ttt/data-table-think-tank
 * Categories: transparency
 * Inserter: false
 *
 * %VAR1% = think_tank
 * %VAR2% = donor
 * %VAR3% = donation_year
 * %VAR4% = donor_type
 * %VAR5% = limit
 */
global $post;
$think_tank     = $post->post_name;
$post_id        = $post->ID;
$limited_info   = get_post_meta( $post_id, 'limited_info', true );
$is_limited     = ( $limited_info && strtolower( trim( $limited_info ) ) == 'x' ) ? true : false;
$is_transparent = ( $limited_info && str_contains( strtolower( trim( $limited_info ) ), 'transparent' ) ) ? true : false;

if ( $is_limited ) :
	?>
	<!-- wp:group {"metadata":{"name":"No Data"},"className":"no-data","style":{"spacing":{"padding":{"top":"var:preset|spacing|10","bottom":"var:preset|spacing|10","left":"var:preset|spacing|10","right":"var:preset|spacing|10"}}},"backgroundColor":"var:custom|color|pink-light","layout":{"type":"default"}} -->
		<div class="wp-block-group has-pink-light-background-color has-background no-data" style="background-color:var(--wp--custom--color--pink-light);padding-top:var(--wp--preset--spacing--10);padding-right:var(--wp--preset--spacing--10);padding-bottom:var(--wp--preset--spacing--10);padding-left:var(--wp--preset--spacing--10)">

		<!-- wp:heading {"level":4} -->
		<h4><?php esc_html_e( 'This think tank has not provided data about it\'s donations.', 'ttt' ); ?></h4>
		<!-- /wp:heading -->

	</div>
	<!-- /wp:group -->
	<?php
elseif ( $is_transparent ) :
	?>
		<!-- hidden -->
	<?php
else :
	?>
	<!-- wp:group {"metadata":{"name":"Filters"},"className":"data-filters","layout":{"type":"default"}} -->
	<div class="wp-block-group data-filters">
		<!-- wp:group {"metadata":{"name":"Donation Year"},"layout":{"type":"default"}} -->
		<div class="wp-block-group"><!-- wp:data-tables/data-filter-donation-year /--></div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->

	<!-- wp:data-tables/data-table {
		"tableType":"single-think-tank",
		"thinkTank":"<?php echo $think_tank; ?>"
	 } /-->
	
	<?php
endif;
