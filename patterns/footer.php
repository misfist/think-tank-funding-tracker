<?php
/**
 * Title: Footer
 * Slug: ttft/footer
 * Categories: hidden
 * Inserter: no
 */
?>

<!-- wp:group {"metadata":{"name":"Footer"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}},"elements":{"link":{"color":{"text":"var:preset|color|base"}}}},"backgroundColor":"gray-900","textColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-base-color has-gray-900-background-color has-text-color has-background has-link-color"
	style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50)">
	<!-- wp:columns {"verticalAlignment":null,"metadata":{"name":"Footer Menu"}} -->
	<div class="wp-block-columns">
		<!-- wp:column {"width":"30%"} -->
		<div class="wp-block-column" style="flex-basis:30%">
			<!-- wp:site-title {"level":0,"fontSize":"large"} /-->

			<!-- wp:site-tagline {"style":{"elements":{"link":{"color":{"text":"var:preset|color|base"}}}},"textColor":"base","fontSize":"small"} /-->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"top","width":"75%"} -->
		<div class="wp-block-column is-vertically-aligned-top" style="flex-basis:75%">
			<!-- wp:navigation {"ref":31684,"overlayMenu":"never","layout":{"type":"flex","justifyContent":"right","orientation":"vertical"}} /-->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->

	<!-- wp:group {"fontSize":"small","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
	<div class="wp-block-group has-small-font-size">
		<!-- wp:paragraph -->
		<p>&copy;<? echo date( 'Y' );?> <!-- wp:site-title {"level":0,"fontSize":"small"} /--></p>
		<!-- /wp:paragraph -->

		<!-- wp:navigation {"ref":31686,"overlayMenu":"never","fontSize":"small","layout":{"type":"flex","justifyContent":"right"}} /-->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
