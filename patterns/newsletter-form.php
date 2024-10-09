<?php
/**
 * Title: Newsletter Form
 * Slug: ttft/newsletter-form
 * Inserter: no
 */
?>
<!-- wp:group {"metadata":{"name":"Newsletter","patternName":"ttft/newsletter-form"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}},"backgroundColor":"accent-10","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-accent-10-background-color has-background"
    style="padding-top:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30)">
    <!-- wp:heading {"level":3} -->
    <h3 class="wp-block-heading">Stay up to date on this project and other news</h3>
    <!-- /wp:heading -->

    <!-- wp:paragraph -->
    <p>Messaging, sign up for the newsletter...</p>
    <!-- /wp:paragraph -->

    <!-- wp:group {"metadata":{"name":"Newsletter"},"layout":{"type":"default"}} -->
    <div class="wp-block-group">
		<!-- wp:getwid/mailchimp {"backgroundColor":"contrast-3","ids":["5f148d0656"]} -->
		<!-- wp:getwid/mailchimp-field-email {"label":"Email Address","required":true,"placeholder":"Email"} /-->
		<!-- /wp:getwid/mailchimp -->
    </div>
    <!-- /wp:group -->
</div>
<!-- /wp:group -->