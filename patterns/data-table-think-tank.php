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
use function Quincy\ttft\is_transparent;

global $post;
$think_tank      = $post->post_name;
$post_id         = $post->ID;
$is_limited      = ( get_post_meta( $post_id, 'limited_info', true ) ) ? true : false;
$is_transparent  = is_transparent( $post_id );
$settings        = get_option( 'site_settings' );
$total_donations = get_single_think_tank_total( $think_tank );

if ( $is_limited ) :
	?>
	<!-- wp:group {"metadata":{"name":"No Data"},"className":"no-data","style":{"spacing":{"padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20","left":"var:preset|spacing|20","right":"var:preset|spacing|20"}}},"backgroundColor":"var:custom|color|pink-light","layout":{"type":"default"}} -->
		<div class="wp-block-group has-pink-light-background-color has-background no-data" style="background-color:var(--wp--custom--color--pink-light);padding-top:var(--wp--preset--spacing--20);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20);padding-left:var(--wp--preset--spacing--20)">

		<!-- wp:heading {"level":4} -->
		<h4><?php echo $settings['think_tank_no_data_text'] ?? esc_html__( 'This think tank has not provided data about it\'s donations.', 'ttft' ); ?></h4>
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
		<p><?php echo $settings['think_tank_total_text'] ?? esc_html__( 'Minimum amount received', 'ttft' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"level":4,"className":"dollar-value"} -->
		<h4 class="wp-block-heading dollar-value"><?php echo number_format( $total_donations, 0, '.', ',' ); ?></h4>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:data-tables/data-table {
		"tableType":"single-think-tank",
		"thinkTank":"<?php echo $think_tank; ?>"
	} /-->
	
	<?php
endif;
