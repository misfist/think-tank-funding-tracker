<?php
/**
 * Helper Functions
 */
namespace Quincy\ttft;

/**
 * Retrieves the Transparency Score for a given think tank slug.
 *
 * @param string $think_tank_slug The think tank slug.
 * @return int The Transparency Score.
 */
function get_transparency_score_from_slug( string $think_tank_slug ): int {
	$post_type = 'think_tank';
	$args      = array(
		'post_type'      => $post_type,
		'posts_per_page' => 1,
		'name'           => $think_tank_slug,
		'fields'         => 'ids',
	);

	$think_tank = get_post_from_term( $think_tank_slug, $post_type );

	if ( ! empty( $think_tank ) && ! is_wp_error( $think_tank ) ) {
		$score = get_post_meta( $think_tank[0], 'transparency_score', true );
		wp_reset_postdata();
		return intval( $score );
	}

	return 0;
}

/**
 * Check if post is transparent
 *
 * @param  integer $post_id
 * @return boolean
 */
function is_transparent( $post_id = 0 ): bool {
	$post_id              = $post_id ? (int) $post_id : get_the_ID();
	$no_defense_accepted  = get_post_meta( $post_id, 'no_defense_accepted', true );
	$no_domestic_accepted = get_post_meta( $post_id, 'no_domestic_accepted', true );
	$no_foreign_accepted  = get_post_meta( $post_id, 'no_foreign_accepted', true );
	return $no_defense_accepted && $no_domestic_accepted && $no_foreign_accepted;
}

/**
 * Check if post is limited
 *
 * @param  integer $post_id
 * @return boolean
 */
function is_limited( $post_id = 0 ): bool {
	$post_id = $post_id ? (int) $post_id : get_the_ID();
	return (bool) get_post_meta( $post_id, 'limited_info', true );
}

/**
 * Get post that matches taxonomy term
 *
 * @param  string $slug
 * @param  string $type
 * @return array $post_id
 */
function get_post_from_term( $slug, $type ) {
	$args = array(
		'post_type'      => $type,
		'posts_per_page' => 1,
		'name'           => $slug,
		'fields'         => 'ids',
	);

	return get_posts( $args );
}

/**
 * Get Post Transparency Score
 *
 * @param  integer $post_id
 * @return string
 */
function get_star_rating( $post_id = 0 ): string {
	$post_id = $post_id ? (int) $post_id : get_the_ID();
	if ( ! $post_id ) {
		return '';
	}
	$score   = get_post_meta( $post_id, 'transparency_score', true );

	return convert_star_rating( $score );
}

/**
 * Render Star Rating
 *
 * @param  integer $post_id
 * @return void
 */
function render_star_rating( $post_id = 0 ): void {
	echo get_star_rating( $post_id );
}

/**
 * Convert the Transparency Score to a star rating.
 *
 * @param int $score The Transparency Score.
 * @return string The star rating.
 */
function convert_star_rating( $score = 0 ): string {
	$score = (int) $score;
	$max = 5;
	ob_start();
	?>
	<!-- wp:group {"metadata":{"name":"Transparency Stars"},"className":"star-group stars-<?php echo $score; ?>","layout":{"type":"default"}} -->
	<div class="wp-block-group star-group stars-<?php echo $score; ?>" aria-label="<?php echo $score; ?> stars">
		<?php
		for ( $x = 1; $x <= $score && $x <= $max; $x++ ) :
			?>
			<span class="icon material-symbols-outlined star" data-filled="true" role="img"><svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor"><g><path d="M0 0h24v24H0V0z" fill="none"/><path d="M0 0h24v24H0V0z" fill="none"/></g><g><path d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21 12 17.27z"/></g></svg></span>
			<?php
		endfor;

		for ( $x = ( $score + 1 ); $x <= $max; $x++ ) :
			?>
			<span class="icon material-symbols-outlined star" data-filled="false" role="img"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor"><path d="m354-287 126-76 126 77-33-144 111-96-146-13-58-136-58 135-146 13 111 97-33 143ZM233-120l65-281L80-590l288-25 112-265 112 265 288 25-218 189 65 281-247-149-247 149Zm247-350Z"/></svg></g></svg></span>
			<?php
		endfor;
		?>
	</div>
	<!-- /wp:group -->

	<?php
	$stars = ob_get_clean();
	return $stars;
}