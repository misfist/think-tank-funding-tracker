<?php
/**
 * Title: Data Note
 * Slug: ttft/data-note
 * Categories: hidden
 * Inserter: false
 */
use function Quincy\ttft\is_transparent;
use function Quincy\ttft\is_limited;
use function Quincy\ttft\is_not_transparent;

$settings  = get_option( 'site_settings' );
$data_note = ( $settings && isset( $settings['data_note'] ) ) ? wpautop( wp_kses_post( $settings['data_note'] ) ) : '';
if ( is_singular( 'think_tank' ) && ( is_transparent() || is_limited() || is_not_transparent() ) ) {
	return;
}
?>

<!-- wp:group {"metadata":{"name":"Data Note"},"className":"data-note","tagName":"footer","layout":{"type":"default"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|40"}}}} -->
<footer class="wp-block-group data-note" style="margin-top:var(--wp--preset--spacing--40);">
	<?php echo $data_note; ?>
</footer>
<!-- /wp:group -->

<?php

