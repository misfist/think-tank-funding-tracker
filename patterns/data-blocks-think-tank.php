<?php
/**
 * Title: Data Blocks - Think Tank
 * Slug: ttt/data-blocks-think-tank
 * Categories: transparency
 * Inserter: false
 */
use function Quincy\ttft\get_think_tank_total;

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

$domestic_total  = get_think_tank_total( $think_tank, 'u-s-government' ) ?? 0;
$defense_total  = get_think_tank_total( $think_tank, 'pentagon-contractor' ) ?? 0;
$foreign_total  = get_think_tank_total( $think_tank, 'foreign-government' ) ?? 0;
?>

<!-- wp:group {"layout":{"type":"grid","columnCount":<?php echo intval( $column_count ); ?>,"minimumColumnWidth":"12rem","rowCount":"1"}} -->
<div class="wp-block-group">

	<?php
	if ( $is_limited ) :
		?>
		<!-- wp:group {"metadata":{"name":"No Data"},"className":"no-data","style":{"border":{"width":"1px"},"spacing":{"padding":{"top":"var:preset|spacing|10","bottom":"var:preset|spacing|10","left":"var:preset|spacing|10","right":"var:preset|spacing|10"}}},"borderColor":"contrast-3","backgroundColor":"gray-100","layout":{"type":"default"}} -->
		<div class="wp-block-group has-border-color has-contrast-3-border-color has-gray-100-background-color has-background no-data" style="border-width:1px;padding-top:var(--wp--preset--spacing--10);padding-right:var(--wp--preset--spacing--10);padding-bottom:var(--wp--preset--spacing--10);padding-left:var(--wp--preset--spacing--10)">

			<!-- wp:heading {"level":4} -->
				<h4><?php esc_html_e( 'No donation data available for this think tank.', 'ttt' ); ?></h4>
			<!-- /wp:heading -->
			
		</div>
		<!-- /wp:group -->
		<?php
	elseif ( $is_transparent ) :
		?>
		<!-- wp:group {"metadata":{"name":"Transparent"},"className":"is-transparent","style":{"border":{"width":"1px"},"spacing":{"padding":{"top":"var:preset|spacing|10","bottom":"var:preset|spacing|10","left":"var:preset|spacing|10","right":"var:preset|spacing|10"}}},"borderColor":"contrast-2","backgroundColor":"gray-100","layout":{"type":"default"}} -->
		<div class="wp-block-group has-border-color has-contrast-2-border-color has-gray-100-background-color has-background no-data" style="border-width:1px;padding-top:var(--wp--preset--spacing--10);padding-right:var(--wp--preset--spacing--10);padding-bottom:var(--wp--preset--spacing--10);padding-left:var(--wp--preset--spacing--10)">

			<!-- wp:heading {"level":4} -->
				<h4><?php echo esc_html( $limited_info ); ?> </h4>
			<!-- /wp:heading -->
			
		</div>
		<!-- /wp:group -->
		<?php
	else :
		?>
		<!-- wp:group {"metadata":{"name":"U.S. Government Funding"},"className":"<?php echo ( $no_domestic ) ? 'no-funding' : 'is-funded'; ?>","style":{"border":{"width":"1px"},"spacing":{"padding":{"top":"var:preset|spacing|10","bottom":"var:preset|spacing|10","left":"var:preset|spacing|10","right":"var:preset|spacing|10"}}},"borderColor":"gray-300","backgroundColor":"gray-200","layout":{"type":"default"}} -->
		<div class="wp-block-group has-border-color has-gray-300-border-color has-gray-200-background-color has-background <?php echo ( $no_domestic ) ? 'no-funding' : 'is-funded'; ?>"
			style="border-width:1px;padding-top:var(--wp--preset--spacing--10);padding-right:var(--wp--preset--spacing--10);padding-bottom:var(--wp--preset--spacing--10);padding-left:var(--wp--preset--spacing--10)">

			<!-- wp:heading {"level":4} -->
			<h4><?php esc_html_e( 'U.S. Government Funding', 'ttt' ); ?></h4>
			<!-- /wp:heading -->
			
			<?php
			if ( $no_domestic ) :
				?>

				<!-- wp:paragraph  -->
				<p><?php esc_html_e( 'Did not accept any donations from the U.S. Government', 'ttt' ); ?></p>
				<!-- /wp:paragraph -->

				<?php
			else :
				?>

				<!-- wp:paragraph {"className":"numeric dollar-value"} -->
				<p class="numeric dollar-value"><?php echo ( $domestic_total ) ? number_format( $domestic_total ) : 0; ?></p>
				<!-- /wp:paragraph -->

				<?php
			endif;
			?>

		</div>
		<!-- /wp:group -->

		<!-- wp:group {"metadata":{"name":"Pentagon Contractor Funding"},"className":"<?php echo ( $no_defense ) ? 'no-funding' : 'is-funded'; ?>","style":{"border":{"width":"1px"},"spacing":{"padding":{"top":"var:preset|spacing|10","bottom":"var:preset|spacing|10","left":"var:preset|spacing|10","right":"var:preset|spacing|10"}}},"borderColor":"gray-300","backgroundColor":"gray-200","layout":{"type":"default"}} -->
		<div class="wp-block-group has-border-color has-gray-300-border-color has-gray-200-background-color has-background <?php echo ( $no_defense ) ? 'no-funding' : 'is-funded'; ?>"
			style="border-width:1px;padding-top:var(--wp--preset--spacing--10);padding-right:var(--wp--preset--spacing--10);padding-bottom:var(--wp--preset--spacing--10);padding-left:var(--wp--preset--spacing--10)">

			<!-- wp:heading {"level":4} -->
			<h4><?php esc_html_e( 'Pentagon Contractor Funding', 'ttt' ); ?></h4>
			<!-- /wp:heading -->

			<?php
			if ( $no_defense ) :
				?>

				<!-- wp:paragraph  -->
				<p><?php esc_html_e( 'Did not accept any donations from Pentagon Contractors', 'ttt' ); ?></p>
				<!-- /wp:paragraph -->

				<?php
			else :
				?>

				<!-- wp:paragraph {"className":"numeric dollar-value"} -->
				<p class="numeric dollar-value"><?php echo ( $defense_total ) ? number_format( $defense_total ) : 0; ?></p>
				<!-- /wp:paragraph -->

				<?php
			endif;
			?>
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"metadata":{"name":"Foreign Interest Funding"},"className":"<?php echo ( $no_foreign ) ? 'no-funding' : 'is-funded'; ?>","style":{"border":{"width":"1px"},"spacing":{"padding":{"top":"var:preset|spacing|10","bottom":"var:preset|spacing|10","left":"var:preset|spacing|10","right":"var:preset|spacing|10"}}},"borderColor":"gray-300","backgroundColor":"gray-200","layout":{"type":"default"}} -->
		<div class="wp-block-group has-border-color has-gray-300-border-color has-gray-200-background-color has-background <?php echo ( $no_foreign ) ? 'no-funding' : 'is-funded'; ?>"
			style="border-width:1px;padding-top:var(--wp--preset--spacing--10);padding-right:var(--wp--preset--spacing--10);padding-bottom:var(--wp--preset--spacing--10);padding-left:var(--wp--preset--spacing--10)">

			<!-- wp:heading {"level":4} -->
			<h4><?php esc_html_e( 'Foreign Interest Funding', 'ttt' ); ?></h4>
			<!-- /wp:heading -->

			<?php
			if ( $no_foreign ) :
				?>

				<!-- wp:paragraph  -->
				<p><?php esc_html_e( 'Did not accept any donations from Foreign Interests', 'ttt' ); ?></p>
				<!-- /wp:paragraph -->

				<?php
			else :
				?>

				<!-- wp:paragraph {"className":"numeric dollar-value"} -->
				<p class="numeric dollar-value"><?php echo ( $foreign_total ) ? number_format( $foreign_total ) : 0; ?></p>
				<!-- /wp:paragraph -->

				<?php
			endif;
			?>
			
		</div>
		<!-- /wp:group -->
		<?php
	endif;
	?>

	<!-- wp:pattern {"slug":"ttt/transparency-score"} /-->
</div>
<!-- /wp:group -->
