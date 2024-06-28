<?php
/**
 * Title: home
 * Slug: ttt/home
 * Categories: hidden
 * Inserter: no
 */
?>
<!-- wp:template-part {"slug":"header","tagName":"header","area":"header"} /-->

<!-- wp:group {"tagName":"main","metadata":{"name":"Main Content"},"style":{"spacing":{"blockGap":"0","margin":{"top":"0"}}},"layout":{"type":"default"}} -->
<main class="wp-block-group" style="margin-top:0">
	<!-- wp:group {"metadata":{"name":"Main Top"},"layout":{"type":"constrained"}} -->
	<div class="wp-block-group">
		<!-- wp:pattern {"slug":"ttt/search-form"} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"metadata":{"name":"Hero"},"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50","right":"var:preset|spacing|50"}}},"layout":{"type":"constrained","contentSize":"","wideSize":""}} -->
	<div class="wp-block-group alignfull"
		style="padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)">
		<!-- wp:group {"style":{"spacing":{"blockGap":"0px"}},"layout":{"type":"constrained","contentSize":"565px"}} -->
		<div class="wp-block-group"><!-- wp:heading {"textAlign":"center","level":1,"fontSize":"x-large"} -->
			<h1 class="wp-block-heading has-text-align-center has-x-large-font-size">A commitment to innovation and
				sustainability</h1>
			<!-- /wp:heading -->

			<!-- wp:spacer {"height":"1.25rem"} -->
			<div style="height:1.25rem" aria-hidden="true" class="wp-block-spacer"></div>
			<!-- /wp:spacer -->

			<!-- wp:paragraph {"align":"center"} -->
			<p class="has-text-align-center">Études is a pioneering firm that seamlessly merges creativity and
				functionality to redefine architectural excellence.</p>
			<!-- /wp:paragraph -->

			<!-- wp:spacer {"height":"1.25rem"} -->
			<div style="height:1.25rem" aria-hidden="true" class="wp-block-spacer"></div>
			<!-- /wp:spacer -->

			<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
			<div class="wp-block-buttons"><!-- wp:button -->
				<div class="wp-block-button"><a class="wp-block-button__link wp-element-button">
						<?php echo __( 'About us', 'ttt' ); ?>
					</a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"metadata":{"name":"Post List"},"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50","right":"var:preset|spacing|50"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
	<div class="wp-block-group alignfull"
		style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)">
		<!-- wp:heading {"align":"wide","style":{"typography":{"lineHeight":"1"},"spacing":{"margin":{"top":"0","bottom":"var:preset|spacing|40"}}},"fontSize":"x-large"} -->
		<h2 class="wp-block-heading alignwide has-x-large-font-size"
			style="margin-top:0;margin-bottom:var(--wp--preset--spacing--40);line-height:1">
			<?php echo __( 'Think Tanks', 'ttt' ); ?>
		</h2>
		<!-- /wp:heading -->

		<!-- wp:group {"metadata":{"name":"Think Tank List"},"align":"wide","layout":{"type":"constrained"}} -->
		<div class="wp-block-group alignwide">
			<!-- wp:query {"queryId":1,"query":{"perPage":24,"pages":0,"offset":0,"postType":"think_tank","order":"asc","orderBy":"title","author":"","search":"","exclude":[],"sticky":"","inherit":false,"parents":[]},"align":"wide","layout":{"type":"default"}} -->
			<div class="wp-block-query alignwide"><!-- wp:post-template -->
				<!-- wp:separator {"backgroundColor":"contrast-3","className":"alignwide is-style-wide"} -->
				<hr
					class="wp-block-separator has-text-color has-contrast-3-color has-alpha-channel-opacity has-contrast-3-background-color has-background alignwide is-style-wide" />
				<!-- /wp:separator -->

				<!-- wp:columns {"verticalAlignment":"center","align":"wide","style":{"spacing":{"margin":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}}}} -->
				<div class="wp-block-columns alignwide are-vertically-aligned-center"
					style="margin-top:var(--wp--preset--spacing--20);margin-bottom:var(--wp--preset--spacing--20)">
					<!-- wp:column {"verticalAlignment":"center","width":"72%"} -->
					<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:72%">
						<!-- wp:post-title {"isLink":true,"style":{"typography":{"lineHeight":"1.1","fontSize":"1.5rem"}}} /-->
					</div>
					<!-- /wp:column -->

					<!-- wp:column {"verticalAlignment":"center","width":"28%"} -->
					<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:28%">
						<!-- wp:template-part {"slug":"post-meta"} /--></div>
					<!-- /wp:column -->
				</div>
				<!-- /wp:columns -->
				<!-- /wp:post-template -->

				<!-- wp:spacer {"height":"var:preset|spacing|30"} -->
				<div style="height:var(--wp--preset--spacing--30)" aria-hidden="true" class="wp-block-spacer"></div>
				<!-- /wp:spacer -->

				<!-- wp:query-pagination {"paginationArrow":"arrow","layout":{"type":"flex","justifyContent":"space-between"}} -->
				<!-- wp:query-pagination-previous /-->

				<!-- wp:query-pagination-numbers /-->

				<!-- wp:query-pagination-next /-->
				<!-- /wp:query-pagination -->

				<!-- wp:query-no-results -->
				<!-- wp:paragraph -->
				<p>
					<?php echo __( 'No posts were found.', 'ttt' ); ?>
				</p>
				<!-- /wp:paragraph -->
				<!-- /wp:query-no-results -->
			</div>
			<!-- /wp:query -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"metadata":{"name":"Post List"},"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50","right":"var:preset|spacing|50"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
	<div class="wp-block-group alignfull"
		style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)">
		<!-- wp:heading {"align":"wide","style":{"typography":{"lineHeight":"1"},"spacing":{"margin":{"top":"0","bottom":"var:preset|spacing|40"}}},"className":"is-style-default","fontSize":"x-large"} -->
		<h2 class="wp-block-heading alignwide is-style-default has-x-large-font-size"
			style="margin-top:0;margin-bottom:var(--wp--preset--spacing--40);line-height:1">
			<?php echo __( 'Donors', 'ttt' ); ?>
		</h2>
		<!-- /wp:heading -->

		<!-- wp:group {"metadata":{"name":"Donor List"},"align":"wide","layout":{"type":"constrained"}} -->
		<div class="wp-block-group alignwide">
			<!-- wp:query {"queryId":2,"query":{"perPage":24,"pages":0,"offset":0,"postType":"donor","order":"asc","orderBy":"title","author":"","search":"","exclude":[],"sticky":"","inherit":false,"parents":[]},"align":"wide","layout":{"type":"default"}} -->
			<div class="wp-block-query alignwide"><!-- wp:post-template -->
				<!-- wp:separator {"backgroundColor":"contrast-3","className":"alignwide is-style-wide"} -->
				<hr
					class="wp-block-separator has-text-color has-contrast-3-color has-alpha-channel-opacity has-contrast-3-background-color has-background alignwide is-style-wide" />
				<!-- /wp:separator -->

				<!-- wp:columns {"verticalAlignment":"center","align":"wide","style":{"spacing":{"margin":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}}}} -->
				<div class="wp-block-columns alignwide are-vertically-aligned-center"
					style="margin-top:var(--wp--preset--spacing--20);margin-bottom:var(--wp--preset--spacing--20)">
					<!-- wp:column {"verticalAlignment":"center","width":"72%"} -->
					<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:72%">
						<!-- wp:post-title {"isLink":true,"style":{"typography":{"lineHeight":"1.1","fontSize":"1.5rem"}}} /-->
					</div>
					<!-- /wp:column -->

					<!-- wp:column {"verticalAlignment":"center","width":"28%"} -->
					<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:28%">
						<!-- wp:template-part {"slug":"post-meta"} /--></div>
					<!-- /wp:column -->
				</div>
				<!-- /wp:columns -->
				<!-- /wp:post-template -->

				<!-- wp:spacer {"height":"var:preset|spacing|30"} -->
				<div style="height:var(--wp--preset--spacing--30)" aria-hidden="true" class="wp-block-spacer"></div>
				<!-- /wp:spacer -->

				<!-- wp:query-pagination {"paginationArrow":"arrow","layout":{"type":"flex","justifyContent":"space-between"}} -->
				<!-- wp:query-pagination-previous /-->

				<!-- wp:query-pagination-numbers /-->

				<!-- wp:query-pagination-next /-->
				<!-- /wp:query-pagination -->

				<!-- wp:query-no-results -->
				<!-- wp:paragraph -->
				<p>
					<?php echo __( 'No posts were found.', 'ttt' ); ?>
				</p>
				<!-- /wp:paragraph -->
				<!-- /wp:query-no-results -->
			</div>
			<!-- /wp:query -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"metadata":{"name":"Testimonial"},"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60","left":"var:preset|spacing|60","right":"var:preset|spacing|60"},"margin":{"top":"0","bottom":"0"}}},"backgroundColor":"contrast","textColor":"base","layout":{"type":"constrained","contentSize":""}} -->
	<div class="wp-block-group alignfull has-base-color has-contrast-background-color has-text-color has-background"
		style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--60)">
		<!-- wp:group {"layout":{"type":"constrained"}} -->
		<div class="wp-block-group">
			<!-- wp:paragraph {"align":"center","style":{"typography":{"lineHeight":"1.2"}},"textColor":"base","fontSize":"x-large","fontFamily":"heading"} -->
			<p class="has-text-align-center has-base-color has-text-color has-heading-font-family has-x-large-font-size"
				style="line-height:1.2">
				<em>“Études has saved us thousands of hours of work and has unlocked insights we never thought
					possible.”</em>
			</p>
			<!-- /wp:paragraph -->

			<!-- wp:spacer {"height":"var:preset|spacing|10"} -->
			<div style="height:var(--wp--preset--spacing--10)" aria-hidden="true" class="wp-block-spacer"></div>
			<!-- /wp:spacer -->

			<!-- wp:group {"metadata":{"name":"Testimonial source"},"style":{"spacing":{"blockGap":"0"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center","flexWrap":"nowrap"}} -->
			<div class="wp-block-group">
				<!-- wp:image {"width":"60px","aspectRatio":"1","scale":"cover","sizeSlug":"thumbnail","linkDestination":"none","align":"center","style":{"border":{"radius":"100px"}}} -->
				<figure class="wp-block-image aligncenter size-thumbnail is-resized has-custom-border"><img
						alt="<?php echo __( '', 'ttt' ); ?>"
						style="border-radius:100px;aspect-ratio:1;object-fit:cover;width:60px" /></figure>
				<!-- /wp:image -->

				<!-- wp:paragraph {"align":"center","style":{"spacing":{"margin":{"top":"var:preset|spacing|10","bottom":"0"}}}} -->
				<p class="has-text-align-center" style="margin-top:var(--wp--preset--spacing--10);margin-bottom:0">Annie
					Steiner</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph {"align":"center","style":{"typography":{"fontStyle":"normal","fontWeight":"300"}},"textColor":"contrast-3","fontSize":"small"} -->
				<p class="has-text-align-center has-contrast-3-color has-text-color has-small-font-size"
					style="font-style:normal;font-weight:300">
					<?php echo __( 'CEO, Greenprint', 'ttt' ); ?>
				</p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"metadata":{"name":"Subscribe"},"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50","right":"var:preset|spacing|50"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
	<div class="wp-block-group alignfull"
		style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)">
		<!-- wp:group {"align":"wide","style":{"border":{"radius":"16px"},"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|50","right":"var:preset|spacing|50"}}},"backgroundColor":"base-2","layout":{"type":"constrained"}} -->
		<div class="wp-block-group alignwide has-base-2-background-color has-background"
			style="border-radius:16px;padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--50)">
			<!-- wp:spacer {"height":"var:preset|spacing|10"} -->
			<div style="height:var(--wp--preset--spacing--10)" aria-hidden="true" class="wp-block-spacer"></div>
			<!-- /wp:spacer -->

			<!-- wp:heading {"textAlign":"center","fontSize":"x-large"} -->
			<h2 class="wp-block-heading has-text-align-center has-x-large-font-size">
				<?php echo __( 'Stay Informed', 'ttt' ); ?>
			</h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"align":"center"} -->
			<p class="has-text-align-center">
				<?php echo __( 'Stay in the loop with everything you need to know.', 'ttt' ); ?>
			</p>
			<!-- /wp:paragraph -->

			<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
			<div class="wp-block-buttons"><!-- wp:button -->
				<div class="wp-block-button"><a class="wp-block-button__link wp-element-button">
						<?php echo __( 'Sign up', 'ttt' ); ?>
					</a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->

			<!-- wp:spacer {"height":"var:preset|spacing|10"} -->
			<div style="height:var(--wp--preset--spacing--10)" aria-hidden="true" class="wp-block-spacer"></div>
			<!-- /wp:spacer -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->
</main>
<!-- /wp:group -->

<!-- wp:template-part {"slug":"footer","tagName":"footer","area":"footer"} /-->
