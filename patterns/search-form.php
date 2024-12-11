<?php
/**
 * Title: Search Form
 * Slug: ttft/search-form
 * Categories: Search
 */
?>
<!-- wp:group {"metadata":{"name":"Search Component"},"className":"search-component","layout":{"type":"default"}} -->
<div class="wp-block-group search-component">
    <!-- wp:ttft/search-form {"description":"<?php esc_html_e( 'Examples: Lockheed Martin, Brookings Institution, US Department of Defense', 'ttft' ); ?>","ajax":true} /-->

    <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"space-between"}} -->
    <div class="wp-block-buttons">
        <!-- wp:button {"backgroundColor":"contrast-3","width":50,"metadata":{"name":"Button","bindings":{"__default":{"source":"core/pattern-overrides"}}},"className":"is-style-fill"} -->
        <div class="wp-block-button has-custom-width wp-block-button__width-50 is-style-fill"><a
            class="wp-block-button__link has-contrast-3-background-color has-background wp-element-button" href="/think-tanks/">All Think Tanks</a></div>
        <!-- /wp:button -->

        <!-- wp:button {"backgroundColor":"contrast-3","width":50,"metadata":{"name":"Button","bindings":{"__default":{"source":"core/pattern-overrides"}}},"className":"is-style-fill"} -->
        <div class="wp-block-button has-custom-width wp-block-button__width-50 is-style-fill">
            <a class="wp-block-button__link has-contrast-3-background-color has-background wp-element-button" href="/donors/">All Donors</a></div>
        <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->
</div>
<!-- /wp:group -->