<?php
/**
 * Title: Data Table - Think Tank
 * Slug: ttft/data-table-think-tank
 * Categories: transparency
 * Inserter: false
 *
 * %VAR1% = think_tank
 * %VAR2% = donor
 * %VAR3% = donation_year
 * %VAR4% = donor_type
 * %VAR5% = limit
 */
use function Quincy\ttft\generate_think_tank_data_array;

global $post;
$post_id = get_the_ID();
$data    = generate_think_tank_data_array( $post_id );

if ( ! $data ) {
	return;
}

$think_tank                     = $data['think_tank'];
$is_limited                     = (bool) $data['is_limited'];
$is_transparent                 = (bool) $data['is_transparent'];
$is_not_transparent             = (bool) $data['is_not_transparent'];
$is_undisclosed_or_not_accepted = (bool) $data['is_undisclosed_or_not_accepted'];

$settings        = get_option( 'site_settings' );
$total_donations = $data['amount_calc'];

if ( $is_limited ) {
	// Displayed for think tanks tagged as having little or no data available
	$color   = 'accent-10';
	$content = $settings['think_tank_no_data_text'] ? esc_html( $settings['think_tank_no_data_text'] ) : esc_html__( 'This think tank has not provided data about it\'s donations.', 'ttft' );
} elseif ( $is_transparent ) {
	// Displayed for think tanks with a transparency score 4 or higher
	$color   = 'accent-5';
	$content = $settings['think_tank_is_transparent_text'] ? esc_html( $settings['think_tank_is_transparent_text'] ) : esc_html__( 'This think tank is transparent.', 'ttft' );
} elseif ( $is_not_transparent ) {
	// Displayed for think tanks that didn't accept from 3 donor types, but hava a transparency score 3 or lower
	$color   = 'accent-6';
	$content = $settings['think_tank_none_accepted_text'] ? esc_html( $settings['think_tank_none_accepted_text'] ) : esc_html__( 'Donations were not received from these donor types.', 'ttft' );
}

if ( $is_limited || $is_transparent || $is_not_transparent ) :
	/**
	 * Message is displayed in place of table.
	 */
	?>
	<!-- wp:group {"metadata":{"name":"No Data"},"className":"no-data","style":{"spacing":{"padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20","left":"var:preset|spacing|20","right":"var:preset|spacing|20"}}},"backgroundColor":"var:custom|color|<?php echo esc_attr( $color ); ?>","layout":{"type":"default"}} -->
	<div class="wp-block-group has-<?php echo esc_attr( $color ); ?>-background-color has-background no-data" style="padding-top:var(--wp--preset--spacing--20);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20);padding-left:var(--wp--preset--spacing--20)">

		<!-- wp:heading {"level":4} -->
		<h4><?php echo $content; ?></h4>
		<!-- /wp:heading -->

	</div>
	<!-- /wp:group -->
	<?php
else :
	/**
	 * Message containing total donations is display above table.
	 */
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
		<p><?php echo $settings['think_tank_total_text'] ? esc_html( $settings['think_tank_total_text'] ) : esc_html__( 'Minimum amount received', 'ttft' ); ?></p>
		<!-- /wp:paragraph -->

		<?php
		if ( $is_undisclosed_or_not_accepted ) :
			/**
			 * If all donor types are either undisclosed or not accepted, display unknown amount.
			 */
			?>
			<!-- wp:heading {"level":4,"className":"not-disclosed"} -->
			<h4 class="wp-block-heading not-disclosed"><?php echo $settings['unknown_amount'] ?? esc_attr__( 'Unknown Amt', 'ttft' ); ?></h4>
			<!-- /wp:heading -->
			<?php
		else :
			?>
			<!-- wp:heading {"level":4,"className":"dollar-value"} -->
			<h4 class="wp-block-heading dollar-value"><?php echo number_format( $total_donations, 0, '.', ',' ); ?></h4>
			<!-- /wp:heading -->
			<?php
		endif;
		?>
		
	</div>
	<!-- /wp:group -->

	<!-- wp:data-tables/data-table {
		"tableType":"single-think-tank",
		"thinkTank":"<?php echo $think_tank; ?>"
	} /-->
	<?php
endif;
