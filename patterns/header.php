<?php
/**
 * Title: Header
 * Slug: ttft/header
 * Categories: hidden
 * Inserter: no
 */
?>
<!-- wp:group {"metadata":{"name":"Header Wrapper"},"style":{"spacing":{"padding":{"top":"20px","bottom":"20px"}},"elements":{"link":{"color":{"text":"var:preset|color|base-2"}}}},"backgroundColor":"contrast-2","textColor":"base-2","className":"header-wrapper","layout":{"type":"constrained"}} -->
<div class="wp-block-group header-wrapper has-base-2-color has-contrast-2-background-color has-text-color has-background has-link-color"
	style="padding-top:20px;padding-bottom:20px">
	<!-- wp:group {"metadata":{"name":"Header Row"},"layout":{"type":"flex","justifyContent":"space-between","flexWrap":"nowrap"}} -->
	<div class="wp-block-group">
		<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"},"layout":{"selfStretch":"fit","flexSize":null}},"className":"site-branding","layout":{"type":"flex"}} -->
		<div class="wp-block-group site-branding">
			<!-- wp:group {"style":{"spacing":{"blockGap":"0px"}}} -->
			<div class="wp-block-group">
				<!-- wp:site-title {"level":0} /-->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"left"}} -->
		<div class="wp-block-group">
			<!-- wp:navigation {"ref":11684,"backgroundColor":"contrast-2","overlayMenu":"always","icon":"menu","overlayBackgroundColor":"contrast-2","overlayTextColor":"base-2","layout":{"type":"flex","justifyContent":"left","orientation":"horizontal"},"style":{"spacing":{"margin":{"top":"0"},"blockGap":"var:preset|spacing|20"},"layout":{"selfStretch":"fit","flexSize":null}}} /-->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Sub-header Wrapper"},"className":"breadcrumb-wrapper","style":{"spacing":{"margin":{"top":"var:preset|spacing|30"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group breadcrumb-wrapper" style="margin-top:var(--wp--preset--spacing--30)">
	<!-- wp:group {"layout":{"type":"default"}} -->
	<div class="wp-block-group">
		<!-- wp:boldblocks/breadcrumb-block {"hideCurrentPage":false} /-->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->