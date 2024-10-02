<?php
/**
 * Title: Data Block - Transparency Score
 * Slug: ttt/transparency-score
 * Categories: transparency
 * Inserter: false
 */
$transparency_score = ( $score = get_post_meta( get_the_ID(), 'transparency_score', true ) ) ? (int) $score : 0;
?>

<!-- wp:group {"metadata":{"name":"Transparency Score"},"className":"stars-<?php echo $transparency_score; ?> is-style-score-<?php echo $transparency_score; ?>","layout":{"type":"default"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|20","right":"var:preset|spacing|20","bottom":"var:preset|spacing|20","left":"var:preset|spacing|20"}}}} -->
<div class="wp-block-group stars-<?php echo $transparency_score; ?> is-style-score-<?php echo $transparency_score; ?>" style="padding-top:var(--wp--preset--spacing--20);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20);padding-left:var(--wp--preset--spacing--20)">

	<!-- wp:heading {"level":4} -->
	<h4><?php esc_html_e( 'Transparency Score', 'ttft' ); ?></h4>
	<!-- /wp:heading -->

	<!-- wp:group {"metadata":{"name":"Stars"},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
	<div class="wp-block-group">

		<?php
		$max = 5;
		for ( $x = 1; $x <= $transparency_score && $x <= $max; $x++ ) :
			?>
				
			<!-- wp:outermost/icon-block {"iconName":"wordpress-starFilled","width":"24px"} -->
			<div class="wp-block-outermost-icon-block">
				<div class="icon-container" style="width:24px">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
						aria-hidden="true"
						<?php echo ( $transparency_score && '5' == $transparency_score ) ? ' style="fill:var(--wp--preset--color--base)"' : ''; ?>>
						<path
							d="M11.776 4.454a.25.25 0 01.448 0l2.069 4.192a.25.25 0 00.188.137l4.626.672a.25.25 0 01.139.426l-3.348 3.263a.25.25 0 00-.072.222l.79 4.607a.25.25 0 01-.362.263l-4.138-2.175a.25.25 0 00-.232 0l-4.138 2.175a.25.25 0 01-.363-.263l.79-4.607a.25.25 0 00-.071-.222L4.754 9.881a.25.25 0 01.139-.426l4.626-.672a.25.25 0 00.188-.137l2.069-4.192z">
						</path>
					</svg></div>
			</div>
			<!-- /wp:outermost/icon-block -->
			<?php
		endfor;

		for ( $x = ( $transparency_score + 1 ); $x <= $max; $x++ ) :
			?>
				
			<!-- wp:outermost/icon-block {"iconName":"wordpress-starEmpty","width":"24px"} -->
			<div class="wp-block-outermost-icon-block">
				<div class="icon-container" style="width:24px">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
						aria-hidden="true"
						<?php echo ( $transparency_score && '5' == $transparency_score ) ? ' style="fill:var(--wp--preset--color--base)"' : ''; ?>>
						<path fill-rule="evenodd"
							d="M9.706 8.646a.25.25 0 01-.188.137l-4.626.672a.25.25 0 00-.139.427l3.348 3.262a.25.25 0 01.072.222l-.79 4.607a.25.25 0 00.362.264l4.138-2.176a.25.25 0 01.233 0l4.137 2.175a.25.25 0 00.363-.263l-.79-4.607a.25.25 0 01.072-.222l3.347-3.262a.25.25 0 00-.139-.427l-4.626-.672a.25.25 0 01-.188-.137l-2.069-4.192a.25.25 0 00-.448 0L9.706 8.646zM12 7.39l-.948 1.921a1.75 1.75 0 01-1.317.957l-2.12.308 1.534 1.495c.412.402.6.982.503 1.55l-.362 2.11 1.896-.997a1.75 1.75 0 011.629 0l1.895.997-.362-2.11a1.75 1.75 0 01.504-1.55l1.533-1.495-2.12-.308a1.75 1.75 0 01-1.317-.957L12 7.39z"
							clip-rule="evenodd"></path>
					</svg></div>
			</div>
			<!-- /wp:outermost/icon-block -->
			<?php
		endfor
		?>

	</div>
	<!-- /wp:group -->

	<!-- wp:paragraph {
		"metadata":{
			"bindings":{
				"content":{
					"source":"core/post-meta",
					"args":{
						"key":"transparency_score"
					}
				}
			}
		},
		"className": "screen-reader-text"
	} -->
	<p class="screen-reader-text"></p>
	<!-- /wp:paragraph -->

	<!-- wp:paragraph {"fontSize":"small"} -->
	<p class="has-small-font-size"><a href="#">Methodology</a></p>
	<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
