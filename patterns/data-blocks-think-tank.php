<?php
/**
 * Title: Data Blocks - Think Tank
 * Slug: ttft/data-blocks-think-tank
 * Categories: transparency
 * Inserter: false
 */
use function Quincy\ttft\generate_think_tank_data_array;

global $post;
$post_id = get_the_ID();
$data    = generate_think_tank_data_array( $post_id );

if ( ! $data ) {
	return;
}

$is_limited     = (bool) $data['is_limited'];
$is_transparent = (bool) $data['is_transparent'];

$settings           = get_option( 'site_settings' );
$data_block_label   = $settings['think_tank_box_total'] ?? esc_html__( 'Minimum funding to date from', 'ttft' );
$no_funding_message = $settings['think_tank_box_not_accepted'] ?? esc_html__( 'Did not accept any donations from', 'ttft' );

// echo '<pre>';
// var_dump( $data );
// echo '</pre>';
?>
<!-- wp:group {"metadata":{"name":"Data Blocks"},"className":"data-boxes<?php echo $is_limited ? ' is-limited' : ''; ?>","layout":{"type":"grid"}} -->
<div class="wp-block-group data-boxes<?php echo $is_limited ? ' is-limited' : ''; ?>">
	<?php
	if ( $is_limited ) :
		?>
		<!-- wp:group {"metadata":{"name":"No Data"},"className":"data-box no-data","layout":{"type":"default"}} -->
		<div class="wp-block-group has-background data-box no-data">

		<!-- wp:heading {"level":4} -->
			<h4><?php echo $settings['think_tank_all_no_data'] ?? esc_html__( 'No donation data available for this think tank.', 'ttft' ); ?></h4>
		<!-- /wp:heading -->

		</div>
		<!-- /wp:group -->

		<?php
	elseif ( $is_transparent ) :
		?>
		<!-- wp:group {"metadata":{"name":"Transparent"},"className":"data-box is-transparent","layout":{"type":"default"}} -->
		<div class="wp-block-group has-background data-box is-transparent">

		<!-- wp:heading {"level":4} -->
		<h4><?php echo esc_html( '{Transparent}' ); ?> </h4>
		<!-- /wp:heading -->

		</div>
		<!-- /wp:group -->
		<?php
	else :
		foreach ( $data['donor_types'] as $donor_type ) :
			$no_funding_class = $donor_type['not_accepted'] ? 'no-funding' : 'is-funded';
			?>

			<!-- wp:group {"metadata":{"name":"Data Box"},"className":"no-data data-box <?php echo esc_attr( $no_funding_class ); ?>","layout":{"type":"default"}} -->
			<div class="wp-block-group has-background data-box <?php echo esc_attr( $no_funding_class ); ?>">

				<?php if ( $donor_type['not_accepted'] ) : ?>
					<!-- wp:paragraph  -->
					<p class="data-box--label"><?php echo esc_html( $no_funding_message ); ?></p>
					<!-- /wp:paragraph -->

					<!-- wp:heading {"level":4,"className":"donor-type"} -->
					<h4 class="donor-type"><?php echo esc_html( $donor_type['name'] ); ?></h4>
					<!-- /wp:heading -->
				<?php else : ?>
					<p class="data-box--label"><?php echo esc_html( $data_block_label ); ?></p>

					<!-- wp:heading {"level":4,"className":"donor-type"} -->
					<h4 class="donor-type"><?php echo esc_html( $donor_type['name'] ); ?></h4>
					<!-- /wp:heading -->

					<?php
					if( $donor_type['undisclosed'] ) :
						/**
						 * If all transactions for this donor types are either undisclosed, display unknown amount.
						 */
						?>
						<!-- wp:paragraph -->
						<p class="not-disclosed"><?php echo $settings['unknown_amount'] ?? esc_attr__( 'Unknown Amt', 'ttft' ); ?></p>
						<!-- /wp:paragraph -->
						<?php
					else :
						?>
						<!-- wp:paragraph -->
						<p class="numeric dollar-value"><?php echo esc_html( number_format_i18n( $donor_type['amount_calc'] ) ); ?></p>
						<!-- /wp:paragraph -->
						<?php
					endif;
					?>
				<?php endif; ?>

			</div>
			<!-- /wp:group -->
			<?php
		endforeach;

	endif;
	?>
	<!-- wp:pattern {"slug":"ttft/transparency-score"} /-->
</div>
<!-- /wp:group -->
