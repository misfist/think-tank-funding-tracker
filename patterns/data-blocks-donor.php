<?php
/**
 * Title: Data Blocks - Donor
 * Slug: ttft/data-blocks-donor
 * Categories: transparency
 * Inserter: false
 */
use function Quincy\ttft\get_single_donor_sums_by_id;

$post_id          = get_the_ID();
$settngs          = get_option( 'site_settings' );
$sums             = get_single_donor_sums_by_id( $post_id );
$text             = $settngs['donor_total_text'] ?? __( 'Minimum contributions', 'ttft' );
$undisclosed_text = $settngs['unknown_amount'] ?? __( 'Unknown Amt §', 'ttft' );
$total            = $sums['amount_calc'];
$undisclosed      = $sums['undisclosed'];
?>
<!-- wp:group {"metadata":{"name":"Think Tank Total Donations Received"},"className":"total-donations","layout":{"type":"default"}} -->
<div class="wp-block-group total-donations">
	<!-- wp:paragraph -->
	<p><?php echo esc_html( $text ); ?></p>
	<!-- /wp:paragraph -->

	<?php
	if ( $undisclosed ) :
		?>
		<!-- wp:paragraph {"className":"not-disclosed"} -->
		<p class="not-disclosed"><?php echo esc_html( $undisclosed_text ); ?></p>
		<!-- /wp:paragraph -->
		<?php
	else :
		?>
		<!-- wp:heading {"level":4, "className":"dollar-value"} -->
		<h4 class="dollar-value"><?php echo number_format( $total ); ?></h4>
		<!-- /wp:heading -->
		<?php
	endif;
	?>

</div>
<!-- /wp:group -->
