<?php
/**
 * Title: Data Blocks - Think Tank
 * Slug: ttt/data-blocks-think-tank
 * Categories: transparency
 * Inserter: false
 */
$no_domestic        = get_post_meta( get_the_ID(), 'no_domestic_accepted', true );
$no_defense         = get_post_meta( get_the_ID(), 'no_defense_accepted', true );
$no_foreign         = get_post_meta( get_the_ID(), 'no_foreign_accepted', true );
$transparency_score = ( $score = get_post_meta( get_the_ID(), 'transparency_score', true ) ) ? (int) $score : 0;
?>

<!-- wp:group {"layout":{"type":"grid","columnCount":4,"minimumColumnWidth":"12rem","rowCount":"1"}} -->
<div class="wp-block-group">
	<!-- wp:group {"metadata":{"name":"U.S. Government Funding"},"className":"<?php echo ( $no_domestic ) ? 'no-funding' : 'is-funded'; ?>","style":{"border":{"width":"1px"},"spacing":{"padding":{"top":"var:preset|spacing|10","bottom":"var:preset|spacing|10","left":"var:preset|spacing|10","right":"var:preset|spacing|10"}}},"borderColor":"contrast-3","backgroundColor":"base","layout":{"type":"default"}} -->
	<div class="wp-block-group has-border-color has-contrast-3-border-color has-base-background-color has-background <?php echo ( $no_domestic ) ? 'no-funding' : 'is-funded'; ?>"
		style="border-width:1px;padding-top:var(--wp--preset--spacing--10);padding-right:var(--wp--preset--spacing--10);padding-bottom:var(--wp--preset--spacing--10);padding-left:var(--wp--preset--spacing--10)">
		<!-- wp:heading {"level":4} -->
		<h4>U.S. Government Funding</h4>
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
								"key":"amount_domestic_cumulative"
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

	<!-- wp:group {"metadata":{"name":"Defense Contractor Funding"},"className":"<?php echo ( $no_defense ) ? 'no-funding' : 'is-funded'; ?>","style":{"border":{"width":"1px"},"spacing":{"padding":{"top":"var:preset|spacing|10","bottom":"var:preset|spacing|10","left":"var:preset|spacing|10","right":"var:preset|spacing|10"}}},"borderColor":"contrast-3","backgroundColor":"base","layout":{"type":"default"}} -->
	<div class="wp-block-group has-border-color has-contrast-3-border-color has-base-background-color has-background <?php echo ( $no_defense ) ? 'no-funding' : 'is-funded'; ?>"
		style="border-width:1px;padding-top:var(--wp--preset--spacing--10);padding-right:var(--wp--preset--spacing--10);padding-bottom:var(--wp--preset--spacing--10);padding-left:var(--wp--preset--spacing--10)">

		<!-- wp:heading {"level":4} -->
		<h4>Defense Contractor Funding</h4>
		<!-- /wp:heading -->

		<?php
		if ( $no_defense ) :
			?>

			<!-- wp:paragraph  -->
			<p><?php esc_html_e( 'Did not accept any donations from the Defense Contractors', 'ttt' ); ?></p>
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
								"key":"amount_defense_cumulative"
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
		<h4>Foreign Interest Funding</h4>
		<!-- /wp:heading -->

		<?php
		if ( $no_foreign ) :
			?>

			<!-- wp:paragraph  -->
			<p><?php esc_html_e( 'Did not accept any donations from the Foreign Interests', 'ttt' ); ?></p>
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
								"key":"amount_foreign_cumulative"
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

	<!-- wp:group {"metadata":{"name":"Transparency Score"},"className":"stars-<?php echo $transparency_score ?>","style":{"elements":{"link":{"color":{"text":"var:preset|color|base-2"},":hover":{"color":{"text":"var:preset|color|base-2"}}}},"spacing":{"padding":{"top":"var:preset|spacing|10","bottom":"var:preset|spacing|10","left":"var:preset|spacing|10","right":"var:preset|spacing|10"}}},"backgroundColor":"accent-3","textColor":"base-2","layout":{"type":"default"}} -->
	<div class="wp-block-group has-base-2-color has-accent-3-background-color has-text-color has-background has-link-color stars-<?php echo $transparency_score ?>"
		style="padding-top:var(--wp--preset--spacing--10);padding-right:var(--wp--preset--spacing--10);padding-bottom:var(--wp--preset--spacing--10);padding-left:var(--wp--preset--spacing--10)">

		<!-- wp:heading {"level":4} -->
		<h4>Transparency Score</h4>
		<!-- /wp:heading -->

		<!-- wp:group {"metadata":{"name":"Stars"},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
		<div class="wp-block-group">

        <?php
        $max = 5;
        for( $x = 1; $x <= $transparency_score && $x <= $max; $x++ ) :
            ?>
             
            <!-- wp:outermost/icon-block {"iconName":"wordpress-starFilled","width":"24px"} -->
            <div class="wp-block-outermost-icon-block">
                <div class="icon-container" style="width:24px"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        aria-hidden="true">
                        <path
                            d="M11.776 4.454a.25.25 0 01.448 0l2.069 4.192a.25.25 0 00.188.137l4.626.672a.25.25 0 01.139.426l-3.348 3.263a.25.25 0 00-.072.222l.79 4.607a.25.25 0 01-.362.263l-4.138-2.175a.25.25 0 00-.232 0l-4.138 2.175a.25.25 0 01-.363-.263l.79-4.607a.25.25 0 00-.071-.222L4.754 9.881a.25.25 0 01.139-.426l4.626-.672a.25.25 0 00.188-.137l2.069-4.192z">
                        </path>
                    </svg></div>
            </div>
            <!-- /wp:outermost/icon-block -->
            <?php
        endfor;

        for( $x = ( $transparency_score + 1 ); $x <= $max; $x++ ) :
            ?>
             
            <!-- wp:outermost/icon-block {"iconName":"wordpress-starEmpty","width":"24px"} -->
            <div class="wp-block-outermost-icon-block">
                <div class="icon-container" style="width:24px"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        aria-hidden="true">
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
			}
		} -->
		<p></p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph {"fontSize":"small"} -->
		<p class="has-small-font-size"><a href="#">Methodology</a></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
