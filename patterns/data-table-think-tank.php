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
use function Quincy\ttft\get_single_think_tank_total;

global $post;
$think_tank      = $post->post_name;
$post_id         = $post->ID;
$limited_info    = get_post_meta( $post_id, 'limited_info', true );
$is_limited      = ( $limited_info && strtolower( trim( $limited_info ) ) == 'x' ) ? true : false;
$is_transparent  = ( $limited_info && str_contains( strtolower( trim( $limited_info ) ), 'transparent' ) ) ? true : false;
$total_donations = get_single_think_tank_total( $think_tank );

if ( $is_limited ) :
	?>
	<!-- wp:group {"metadata":{"name":"No Data"},"className":"no-data","style":{"spacing":{"padding":{"top":"var:preset|spacing|10","bottom":"var:preset|spacing|10","left":"var:preset|spacing|10","right":"var:preset|spacing|10"}}},"backgroundColor":"var:custom|color|pink-light","layout":{"type":"default"}} -->
		<div class="wp-block-group has-pink-light-background-color has-background no-data" style="background-color:var(--wp--custom--color--pink-light);padding-top:var(--wp--preset--spacing--10);padding-right:var(--wp--preset--spacing--10);padding-bottom:var(--wp--preset--spacing--10);padding-left:var(--wp--preset--spacing--10)">

		<!-- wp:heading {"level":4} -->
		<h4><?php esc_html_e( 'This think tank has not provided data about it\'s donations.', 'ttft' ); ?></h4>
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
	<!-- wp:group {"metadata":{"name":"Filters"},"className":"data-filters","layout":{"type":"default"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|40"}}}} -->
	<div class="wp-block-group data-filters" style="margin-top:var(--wp--preset--spacing--40);">
		<!-- wp:group {"metadata":{"name":"Donation Year"},"layout":{"type":"default"}} -->
		<div class="wp-block-group">
			<!-- wp:data-tables/data-filter-donation-year /-->
		</div>
		<!-- /wp:group -->
		
		<!-- wp:group {"metadata":{"name":"Donor Type"},"layout":{"type":"default"}} -->
		<div class="wp-block-group">
			<!-- wp:data-tables/data-filter-donor-type /-->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->


	<!-- wp:group {"metadata":{"name":"Think Tank Total Donations Received"},"className":"total-donations","layout":{"type":"default"}} -->
	<div class="wp-block-group total-donations">
		<!-- wp:paragraph -->
		<p><?php esc_html_e( 'Minimum amount received', 'ttft' ); ?><p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"level":4, "className":"dollar-value"} -->
		<h4 class="dollar-value"><?php echo number_format( $total_donations ); ?></h4>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:data-tables/data-table {
		"tableType":"single-think-tank",
		"thinkTank":"<?php echo $think_tank; ?>"
	} /-->
	
	<?php
endif;
