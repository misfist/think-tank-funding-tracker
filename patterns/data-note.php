<?php
/**
 * Title: Data Note
 * Slug: ttt/data-note
 * Categories: hidden
 * Inserter: false
 */
$settings  = get_option( 'site_settings' );
$data_note = ( $settings && isset( $settings['data_note'] ) ) ? wpautop( wp_kses_post( $settings['data_note'] ) ) : '';
?>

<!-- wp:group {"metadata":{"name":"Data Note"},"className":"data-note","tagName":"footer","layout":{"type":"default"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|40"}}}} -->
<footer class="wp-block-group data-note" style="margin-top:var(--wp--preset--spacing--40);">
	<?php echo $data_note; ?>
</footer>
<!-- /wp:group -->

<?php

