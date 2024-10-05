<?php
/**
 * Title: Data Blocks - Donor
 * Slug: ttt/data-blocks-donor
 * Categories: transparency
 * Inserter: false
 */
use function Quincy\ttft\get_single_donor_total;

$post_id         = get_the_ID();
$donor           = get_post_field( 'post_name', $post_id );
$total_donations = get_single_donor_total( $donor );
$settngs         = get_option( 'site_settings' );
$text            = $settngs['donor_total_text'] ?? __( 'Minimum contributions', 'ttft' );
?>
<!-- wp:group {"metadata":{"name":"Think Tank Total Donations Received"},"className":"total-donations","layout":{"type":"default"}} -->
<div class="wp-block-group total-donations">
	<!-- wp:paragraph -->
	<p><?php echo esc_html( $text ); ?><p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"level":4, "className":"dollar-value"} -->
	<h4 class="dollar-value"><?php echo number_format( $total_donations ); ?></h4>
	<!-- /wp:heading -->
</div>
<!-- /wp:group -->
