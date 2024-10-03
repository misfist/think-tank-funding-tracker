<?php
/**
 * Title: Data Blocks - Think Tank
 * Slug: ttt/data-blocks-think-tank
 * Categories: transparency
 * Inserter: false
 */
use function Quincy\ttft\get_single_think_tank_total;
use function Quincy\ttft\generate_think_tank_data_array;

global $post;
$post_id = get_the_ID();
$data    = generate_think_tank_data_array( $post_id );

if ( ! $data ) {
	return;
}

$is_limited     = ( $data['limited_info'] ) ? true : false;
$is_transparent = ( isset( $data['transparency_score'] ) && 5 < $data['transparency_score'] ) ? true : false;

$settings           = get_option( 'site_settings' );
$data_block_label   = $settings['think_tank_box_total'] ?? esc_html__( 'Minimum funding to date from', 'ttft' );
$no_funding_message = $settings['think_tank_box_not_accepted'] ?? esc_html__( 'Did not accept any donations from', 'ttft' );

$funding_sources = array(
	array(
		'donor_type' => 'u-s-government',
		'name'       => $data['donor_types']['u-s-government']->name,
		'total'      => $data['domestic_total'],
		'no_funding' => $data['no_domestic'],
	),
	array(
		'donor_type' => 'pentagon-contractor',
		'name'       => $data['donor_types']['pentagon-contractor']->name,
		'total'      => $data['defense_total'],
		'no_funding' => $data['no_defense'],
	),
	array(
		'donor_type' => 'foreign-government',
		'total'      => $data['foreign_total'],
		'name'       => $data['donor_types']['foreign-government']->name,
		'no_funding' => $data['no_foreign'],
	),
);
?>
<!-- wp:group {"metadata":{"name":"Data Blocks"},"className":"data-boxes<?php echo $is_limited ? ' is-limited' : ''; ?>","layout":{"type":"grid"}} -->
<div class="wp-block-group data-boxes<?php echo $is_limited ? ' is-limited' : ''; ?>">
	<?php
	if ( $is_limited ) :
		?>
		<!-- wp:group {"metadata":{"name":"No Data"},"className":"data-box no-data","style":{"spacing":{"padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20","left":"var:preset|spacing|20","right":"var:preset|spacing|20"}}},"layout":{"type":"default"}} -->
		<div class="wp-block-group has-background data-box no-data" style="padding-top:var(--wp--preset--spacing--20);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20);padding-left:var(--wp--preset--spacing--20)">

		<!-- wp:heading {"level":4} -->
			<h4><?php echo $settings['think_tank_all_no_data'] ?? esc_html__( 'No donation data available for this think tank.', 'ttft' ); ?></h4>
		<!-- /wp:heading -->

		</div>
		<!-- /wp:group -->

		<?php
	elseif ( $is_transparent ) :
		?>
		<!-- wp:group {"metadata":{"name":"Transparent"},"className":"data-box is-transparent","spacing":{"padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20","left":"var:preset|spacing|20","right":"var:preset|spacing|20"}}},"layout":{"type":"default"}} -->
		<div class="wp-block-group has-background data-box is-transparent" style="border-width:1px;padding-top:var(--wp--preset--spacing--20);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20);padding-left:var(--wp--preset--spacing--20)">

		<!-- wp:heading {"level":4} -->
		<h4><?php echo esc_html( '{Transparent}' ); ?> </h4>
		<!-- /wp:heading -->

		</div>
		<!-- /wp:group -->
		<?php
	else :
		foreach ( $funding_sources as $source ) :
			$no_funding_class = $source['no_funding'] ? 'no-funding' : 'is-funded';
			?>

			<!-- wp:group {"metadata":{"name":"Data Box"},"className":"no-data data-box <?php echo esc_attr( $no_funding_class ); ?>","spacing":{"padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20","left":"var:preset|spacing|20","right":"var:preset|spacing|20"}}},"layout":{"type":"default"}} -->
			<div class="wp-block-group has-background data-box <?php echo esc_attr( $no_funding_class ); ?>"
				style="padding-top:var(--wp--preset--spacing--20);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20);padding-left:var(--wp--preset--spacing--20)">

				<?php if ( $source['no_funding'] ) : ?>
					<!-- wp:paragraph  -->
					<p class="data-box--label"><?php echo esc_html( $no_funding_message ); ?></p>
					<!-- /wp:paragraph -->

					<!-- wp:heading {"level":4,"className":"donor-type"} -->
					<h4 class="donor-type"><?php echo esc_html( $source['name'] ); ?></h4>
					<!-- /wp:heading -->
				<?php else : ?>
					<p class="data-box--label"><?php echo esc_html( $data_block_label ); ?></p>

					<!-- wp:heading {"level":4,"className":"donor-type"} -->
					<h4 class="donor-type"><?php echo esc_html( $source['name'] ); ?></h4>
					<!-- /wp:heading -->

					<!-- wp:paragraph -->
					<p class="numeric dollar-value"><?php echo esc_html( number_format_i18n( $source['total'] ) ); ?></p>
					<!-- /wp:paragraph -->
				<?php endif; ?>

			</div>
			<!-- /wp:group -->
			<?php
		endforeach;

	endif;
	?>
	<!-- wp:pattern {"slug":"ttt/transparency-score"} /-->
</div>
<!-- /wp:group -->
