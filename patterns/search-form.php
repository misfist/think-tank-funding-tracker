<?php
/**
 * Title: Search Form
 * Slug: ttft/search-form
 * Categories: Search
 */
?>
<!-- wp:group {"metadata":{"name":"Search Component"},"className":"search-component","layout":{"type":"default"}} -->
<div class="wp-block-group search-component">
    
    <!-- wp:ttft/search-form {"ajax":true} /-->

    <!-- wp:buttons {"style":{"layout":{"selfStretch":"fixed","flexSize":"100%"}},"layout":{"type":"flex","justifyContent":"space-between","flexWrap":"nowrap"}} -->
    <div class="wp-block-buttons">
        <!-- wp:button {"backgroundColor":"contrast-3","metadata":{"name":"Button","bindings":{"__default":{"source":"core/pattern-overrides"}}},"className":"is-style-fill"} -->
        <div class="wp-block-button is-style-fill"><a
            class="wp-block-button__link has-contrast-3-background-color has-background wp-element-button" href="<?php echo esc_url( get_post_type_archive_link( 'think_tank' ) ); ?>"><?php esc_html_e( 'All Think Tanks', 'ttft' ); ?></a></div>
        <!-- /wp:button -->

        <!-- wp:button {"backgroundColor":"contrast-3","metadata":{"name":"Button","bindings":{"__default":{"source":"core/pattern-overrides"}}},"className":"is-style-fill"} -->
        <div class="wp-block-button is-style-fill">
            <a class="wp-block-button__link has-contrast-3-background-color has-background wp-element-button" href="<?php echo esc_url( get_post_type_archive_link( 'donor' ) ); ?>"><?php esc_html_e( 'All Donors', 'ttft' ); ?></a></div>
        <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->
</div>
<!-- /wp:group -->
