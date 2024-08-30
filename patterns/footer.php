<?php
/**
 * Title: Footer
 * Slug: ttt/footer
 * Categories: hidden
 * Inserter: no
 */
?>
<!-- wp:group {"metadata":{"name":"Pre-footer"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"
	style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50)">
	<!-- wp:group {"metadata":{"name":"Pre-footer Wrapper"}} -->
	<div class="wp-block-group">
		<!-- wp:pattern {"slug":"ttt/search-form"} /-->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Footer"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}},"elements":{"link":{"color":{"text":"var:preset|color|base"}}}},"backgroundColor":"gray-900","textColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-base-color has-gray-900-background-color has-text-color has-background has-link-color"
	style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50)">
	<!-- wp:columns {"metadata":{"name":"Footer Menu"}} -->
	<div class="wp-block-columns">
		<!-- wp:column {"width":"30%"} -->
		<div class="wp-block-column" style="flex-basis:30%">
			<!-- wp:site-title {"level":0,"fontSize":"large"} /-->

			<!-- wp:site-tagline {"style":{"elements":{"link":{"color":{"text":"var:preset|color|base"}}}},"textColor":"base","fontSize":"small"} /-->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"width":"75%"} -->
		<div class="wp-block-column" style="flex-basis:75%">
			<!-- wp:navigation {"ref":29851,"layout":{"type":"flex","justifyContent":"right"}} /--></div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->

	<!-- wp:group {"metadata":{"name":"Legal"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"0"}}}} -->
	<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--50);padding-bottom:0">
		<!-- wp:paragraph {"style":{"elements":{"link":{":hover":{"color":{"text":"var:preset|color|gray-100"}}}}},"textColor":"contrast-2","fontSize":"small"} -->
		<p class="has-contrast-2-color has-text-color has-small-font-size">
			<?php echo __( 'Legal Info', 'ttt' ); ?>
		</p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->