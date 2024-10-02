<?php
/**
 * Title: Home Page Content
 * Slug: ttt/content-home
 * Categories: page-template
 * Inserter: true
 * Blocks: core/post-content
 */
?>

<!-- wp:paragraph {"className":"is-style-intro"} -->
<p class="is-style-intro"><?php esc_html_e( 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.', 'ttft' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.', 'ttft' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:pattern {"slug":"ttt/search-form"} /-->

<!-- wp:group {"tagName":"section","metadata":{"name":"Data Tables"},"className":"section section__top-10"} -->
<section class="wp-block-group section section__top-10">
    <!-- wp:group {"metadata":{"name":"foreign-government","patternName":"ttt/data-table-top-10-foreign"},"className":"section-table foreign","layout":{"type":"grid","columnCount":2,"minimumColumnWidth":"13rem"}} -->
    <div class="wp-block-group section-table foreign">
        <!-- wp:heading {"style":{"elements":{"link":{"color":{"text":"var:preset|color|base"}}}},"backgroundColor":"contrast-5","textColor":"base"} -->
        <h2 class="wp-block-heading has-base-color has-contrast-5-background-color has-text-color has-background has-link-color">
            <?php esc_html_e( 'Top 10 Think Tanks That Receive Funding from Foreign Interests', 'ttft' ); ?>
        </h2>
        <!-- /wp:heading -->

        <!-- wp:ttft/top-ten {"donorType":"foreign-government","donationYear":""} /-->
    </div>
    <!-- /wp:group -->

    <!-- wp:group {"metadata":{"name":"pentagon-contractor","patternName":"ttt/data-table-top-10-pentagon"},"className":"section-table pentagon","layout":{"type":"grid","columnCount":2,"minimumColumnWidth":"13rem"}} -->
    <div class="wp-block-group section-table pentagon">
        <!-- wp:heading {"style":{"elements":{"link":{"color":{"text":"var:preset|color|base"}}}},"backgroundColor":"contrast-5","textColor":"base"} -->
        <h2 class="wp-block-heading has-base-color has-contrast-5-background-color has-text-color has-background has-link-color">
            <?php esc_html_e( 'Top 10 Think Tanks That Receive Funding from Pentagon Contractors.', 'ttft' ); ?>
        </h2>
        <!-- /wp:heading -->

        <!-- wp:ttft/top-ten {"donorType":"pentagon-contractor","donationYear":""} /-->
    </div>
    <!-- /wp:group -->

    <!-- wp:group {"metadata":{"name":"u-s-government","patternName":"ttt/data-table-top-10-domestic"},"className":"section-table domestic","layout":{"type":"grid","columnCount":2,"minimumColumnWidth":"17rem"}} -->
    <div class="wp-block-group section-table domestic">
        <!-- wp:heading {"style":{"elements":{"link":{"color":{"text":"var:preset|color|base"}}}},"backgroundColor":"contrast-5","textColor":"base"} -->
        <h2 class="wp-block-heading has-base-color has-contrast-5-background-color has-text-color has-background has-link-color">
            <?php esc_html_e( 'Top 10 Think Tanks That Receive Funding from the U.S. Government.', 'ttft' ); ?>
        </h2>
        <!-- /wp:heading -->

        <!-- wp:ttft/top-ten {"donorType":"u-s-government","donationYear":""} /-->
    </div>
    <!-- /wp:group -->
</section>
<!-- /wp:group -->