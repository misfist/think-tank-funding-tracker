<?php
/**
 * Title: Data Blocks - Think Tank
 * Slug: ttt/data-blocks-think-tank
 * Categories: transparency
 * Inserter: false
 */
use function Quincy\ttft\get_single_think_tank_total;
use function Quincy\ttft\generate_think_tank_data_array;

// echo '<pre>';
// var_dump( generate_think_tank_data_array() );
// echo '</pre>';

global $post;
$post_id            = get_the_ID();
$think_tank         = get_post_field( 'post_name', $post_id );
$limited_info       = get_post_meta( $post_id, 'limited_info', true );
$is_limited         = ( $limited_info && strtolower( trim( $limited_info ) ) == 'x' ) ? true : false;
$is_transparent     = ( $limited_info && str_contains( strtolower( trim( $limited_info ) ), 'transparent' ) ) ? true : false;
$no_domestic        = get_post_meta( $post_id, 'no_domestic_accepted', true );
$no_defense         = get_post_meta( $post_id, 'no_defense_accepted', true );
$no_foreign         = get_post_meta( $post_id, 'no_foreign_accepted', true );
$transparency_score = ( $score = get_post_meta( $post_id, 'transparency_score', true ) ) ? (int) $score : 0;
$think_tank_term    = wp_get_post_terms( $post_id, 'think_tank' );
$column_count       = ( $is_limited || $is_transparent ) ? 2 : 4;

$data_block_label = esc_html__( 'Minimum funding to date from', 'ttft' );

$domestic_total = get_single_think_tank_total( $think_tank, '', 'u-s-government' ) ?? 0;
$defense_total  = get_single_think_tank_total( $think_tank, '', 'pentagon-contractor' ) ?? 0;
$foreign_total  = get_single_think_tank_total( $think_tank, '', 'foreign-government' ) ?? 0;

$data = generate_think_tank_data_array( $post_id  );

$funding_sources = array(
	array(
		'donor_type'         => 'u-s-government',
		'no_funding_message' => 'Did not accept any donations from the U.S. Government',
		'total'              => $data['domestic_total'],
		'no_funding'         => $data['no_domestic'],
		'name'               => $data['donor_types']['u-s-government']->name,
	),
	array(
		'donor_type'         => 'pentagon-contractor',
		'no_funding_message' => 'Did not accept any donations from Defense Contractors',
		'total'              => $data['defense_total'],
		'no_funding'         => $data['no_defense'],
		'name'               => $data['donor_types']['pentagon-contractor']->name,
	),
	array(
		'donor_type'         => 'foreign-government',
		'no_funding_message' => 'Did not accept any donations from Foreign Governments',
		'total'              => $data['foreign_total'],
		'no_funding'         => $data['no_foreign'],
		'name'               => $data['donor_types']['foreign-government']->name,
	),
);

?>

<!-- wp:group {"metadata":{"name":"Data Blocks"},"className":"data-blocks","layout":{"type":"grid"}} -->
<div class="wp-block-group data-blocks">

	<?php
	foreach ( $funding_sources as $source ) :
		$no_funding_class = $source['no_funding'] ? 'no-funding' : 'is-funded';
		?>
		
		<div class="wp-block-group has-border-color has-gray-300-border-color has-gray-200-background-color has-background <?php echo $no_funding_class; ?>"
			style="border-width:1px;padding-top:var(--wp--preset--spacing--20);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20);padding-left:var(--wp--preset--spacing--20)">

			<p class="data-block--label"><?php echo $data['data_block_label']; ?></p>

			<!-- wp:heading {"level":4,"className":"donor-type"} -->
			<h4 class="donor-type"><?php esc_html_e( $source['name'], 'ttft' ); ?></h4>
			<!-- /wp:heading -->
			
			<?php if ( $source['no_funding'] ) : ?>
				<!-- wp:paragraph  -->
				<p class="data-blocks--no-funding"><?php esc_html_e( $source['no_funding_message'], 'ttft' ); ?></p>
				<!-- /wp:paragraph -->
			<?php else : ?>
				<!-- wp:paragraph {"className":"numeric dollar-value"} -->
				<p class="numeric dollar-value"><?php echo ( $source['total'] ) ? number_format( $source['total'] ) : 0; ?></p>
				<!-- /wp:paragraph -->
			<?php endif; ?>
		</div>
	<?php endforeach; ?>

	<!-- wp:pattern {"slug":"ttt/transparency-score"} /-->
</div>
<!-- /wp:group -->
