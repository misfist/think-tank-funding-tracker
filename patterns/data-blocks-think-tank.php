<?php
/**
 * Title: Data Blocks - Think Tank
 * Slug: ttt/data-blocks-think-tank
 * Categories: transparency
 * Inserter: false
 */
$post_id            = get_the_ID();
$no_domestic        = get_post_meta( $post_id, 'no_domestic_accepted', true );
$no_defense         = get_post_meta( $post_id, 'no_defense_accepted', true );
$no_foreign         = get_post_meta( $post_id, 'no_foreign_accepted', true );
$transparency_score = ( $score = get_post_meta( $post_id, 'transparency_score', true ) ) ? (int) $score : 0;
$think_tank_term    = wp_get_post_terms( $post_id, 'think_tank' );
?>

<!-- wp:group {"layout":{"type":"grid","columnCount":4,"minimumColumnWidth":"12rem","rowCount":"1"}} -->
<div class="wp-block-group">
	<!-- wp:group {"metadata":{"name":"U.S. Government Funding"},"className":"<?php echo ( $no_domestic ) ? 'no-funding' : 'is-funded'; ?>","style":{"border":{"width":"1px"},"spacing":{"padding":{"top":"var:preset|spacing|10","bottom":"var:preset|spacing|10","left":"var:preset|spacing|10","right":"var:preset|spacing|10"}}},"borderColor":"contrast-3","backgroundColor":"base","layout":{"type":"default"}} -->
	<div class="wp-block-group has-border-color has-contrast-3-border-color has-base-background-color has-background <?php echo ( $no_domestic ) ? 'no-funding' : 'is-funded'; ?>"
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

			<!-- wp:paragraph {
				"metadata":{
					"bindings":{
						"content":{
							"source":"core/post-meta",
							"args":{
								"key":"amount_domestic"
							}
						}
					}
				}
			} -->
			<p>$X</p>
			<!-- /wp:paragraph -->


			<?php
		endif;
		?>

	</div>
	<!-- /wp:group -->

	<!-- wp:group {"metadata":{"name":"Pentagon Contractor Funding"},"className":"<?php echo ( $no_defense ) ? 'no-funding' : 'is-funded'; ?>","style":{"border":{"width":"1px"},"spacing":{"padding":{"top":"var:preset|spacing|10","bottom":"var:preset|spacing|10","left":"var:preset|spacing|10","right":"var:preset|spacing|10"}}},"borderColor":"contrast-3","backgroundColor":"base","layout":{"type":"default"}} -->
	<div class="wp-block-group has-border-color has-contrast-3-border-color has-base-background-color has-background <?php echo ( $no_defense ) ? 'no-funding' : 'is-funded'; ?>"
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

			<!-- wp:paragraph {
				"metadata":{
					"bindings":{
						"content":{
							"source":"core/post-meta",
							"args":{
								"key":"amount_defense"
							}
						}
					}
				}
			} -->
			<p>$X</p>
			<!-- /wp:paragraph -->

			<?php
		endif;
		?>
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"metadata":{"name":"Foreign Interest Funding"},"className":"<?php echo ( $no_foreign ) ? 'no-funding' : 'is-funded'; ?>","style":{"border":{"width":"1px"},"spacing":{"padding":{"top":"var:preset|spacing|10","bottom":"var:preset|spacing|10","left":"var:preset|spacing|10","right":"var:preset|spacing|10"}}},"borderColor":"contrast-3","backgroundColor":"base","layout":{"type":"default"}} -->
	<div class="wp-block-group has-border-color has-contrast-3-border-color has-base-background-color has-background <?php echo ( $no_foreign ) ? 'no-funding' : 'is-funded'; ?>"
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

			<!-- wp:paragraph {
				"metadata":{
					"bindings":{
						"content":{
							"source":"core/post-meta",
							"args":{
								"key":"amount_foreign"
							}
						}
					}
				}
			} -->
			<p>$X</p>
			<!-- /wp:paragraph -->

			<?php
		endif;
		?>
		
	</div>
	<!-- /wp:group -->

	<!-- wp:pattern {"slug":"ttt/transparency-score"} /-->
</div>
<!-- /wp:group -->
