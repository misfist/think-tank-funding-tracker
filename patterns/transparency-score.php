<?php
/**
 * Title: Data Block - Transparency Score
 * Slug: ttt/transparency-score
 * Categories: transparency
 * Inserter: false
 */
use function Quincy\ttft\render_star_rating;

$post_id = get_the_ID();
$score   = get_post_meta( $post_id, 'transparency_score', true );
?>

<!-- wp:group {"metadata":{"name":"Transparency Score"},"className":"stars-<?php echo $score; ?> is-style-score-<?php echo $score; ?>","layout":{"type":"default"}} -->
<div class="wp-block-group stars-<?php echo $score; ?> is-style-score-<?php echo $score; ?>">

	<!-- wp:heading {"level":4} -->
	<h4><?php esc_html_e( 'Transparency Score', 'ttft' ); ?></h4>
	<!-- /wp:heading -->

	<?php render_star_rating( $post_id ); ?>

	<!-- wp:paragraph {"fontSize":"small"} -->
	<p class="has-small-font-size"><a href="/about"><?php esc_html_e( 'Methodology', 'ttft' ); ?></a></p>
	<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

