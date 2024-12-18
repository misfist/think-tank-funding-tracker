<?php
/**
 * Helper Functions
 */
namespace Quincy\ttft;

/**
 * Get a post by its slug.
 *
 * @param string $slug      The post slug.
 * @param string $post_type The post type. Default is 'think_tank'.
 * @return int|null The post->ID, or null if not.
 */
function get_post_id_by_slug( $slug, $post_type = 'think_tank' ): ?int {
	$args = array(
		'name'           => $slug,
		'post_type'      => $post_type,
		'posts_per_page' => 1,
		'fields'         => 'ids',
	);

	$posts = get_posts( $args );

	return ( ! empty( $posts ) && ! is_wp_error( $posts ) ) ? (int) $posts[0] : null;
}

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
	$range                = range( 4, 5 );
	$post_id              = $post_id ? (int) $post_id : get_the_ID();
	$no_defense_accepted  = get_post_meta( $post_id, 'no_defense_accepted', true );
	$no_domestic_accepted = get_post_meta( $post_id, 'no_domestic_accepted', true );
	$no_foreign_accepted  = get_post_meta( $post_id, 'no_foreign_accepted', true );
	$transparency_score   = get_post_meta( $post_id, 'transparency_score', true );

	return in_array( (int) $transparency_score, $range ) && $no_defense_accepted && $no_domestic_accepted && $no_foreign_accepted;
}

/**
 * Check if post does not accept any defense, domestic, or foreign funding, but is not transparent
 *
 * @param  integer $post_id
 * @return boolean
 */
function is_not_transparent( $post_id = 0 ): bool {
	$range                = range( 2, 3 );
	$post_id              = $post_id ? (int) $post_id : get_the_ID();
	$no_defense_accepted  = get_post_meta( $post_id, 'no_defense_accepted', true );
	$no_domestic_accepted = get_post_meta( $post_id, 'no_domestic_accepted', true );
	$no_foreign_accepted  = get_post_meta( $post_id, 'no_foreign_accepted', true );
	$transparency_score   = get_post_meta( $post_id, 'transparency_score', true );

	return in_array( (int) $transparency_score, $range ) && $no_defense_accepted && $no_domestic_accepted && $no_foreign_accepted;
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
 * Check if post is accepted
 *
 * @param  string $value
 * @return boolean
 */
function is_not_accepted( string $value ): bool {
	$value = strtolower( trim( $value ) );
	return (bool) in_array( $value, array( 'yes', 'x', '1' ), true );
}

/**
 * Check if all donor types are either undisclosed or not accepted.
 *
 * @param int $post_id The post ID to check. Defaults to current post ID.
 * @return bool True if all donor types are either undisclosed or not accepted, false otherwise.
 */
function is_undisclosed_or_not_accepted( $post_id = 0 ): bool {
	$post_id = $post_id ? (int) $post_id : get_the_ID();
	$data    = generate_think_tank_data_array( $post_id );

	if ( empty( $data['donor_types'] ) || ! is_array( $data['donor_types'] ) ) {
		return false;
	}

	foreach ( $data['donor_types'] as $donor_type ) {
		if ( empty( $donor_type['undisclosed'] ) && empty( $donor_type['not_accepted'] ) ) {
			return false;
		}
	}

	return true;
}

/**
 * Check if all donor types are either undisclosed or not accepted.
 *
 * @param array $data The data array to check.
 * @return bool True if all donor types are either undisclosed or not accepted, false otherwise.
 */
function is_undisclosed_or_not_accepted_from_data( $data ): bool {
	if ( empty( $data['donor_types'] ) || ! is_array( $data['donor_types'] ) ) {
		return false;
	}

	foreach ( $data['donor_types'] as $donor_type ) {
		if ( empty( $donor_type['undisclosed'] ) && empty( $donor_type['not_accepted'] ) ) {
			return false;
		}
	}

	return true;
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
	$score = get_post_meta( $post_id, 'transparency_score', true );

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
	$max   = 5;
	ob_start();
	?>
	
	<!-- wp:group {"metadata":{"name":"Transparency Stars"},"className":"star-group stars-<?php echo $score; ?> no-export noExport","layout":{"type":"default"}} -->
	<div class="wp-block-group star-group stars-<?php echo $score; ?> no-export noExport" aria-label="<?php echo $score; ?> stars">
		<?php
		$star_rating = '';

		for ( $i = 1; $i <= 5; $i++ ) :
			if ( $i <= $score ) :
				?>
				<span class="star filled">&#9733;</span>
				<?php
			else :
				?>
				<span class="star">&#9734;</span>
				<?php
			endif;
		endfor;
		?>
	</div>
	<!-- /wp:group -->

	<?php
	$stars = ob_get_clean();
	return $stars;
}

/**
 * Normalize a value to a boolean, considering empty values separately.
 *
 * @param mixed $value The value to normalize.
 * @return mixed Returns true, false, or null for empty values.
 */
function normalize_boolean( $value ) {
	if ( is_string( $value ) ) {
		$value = strtolower( trim( $value ) );
	}

	// Handle explicitly truthy values.
	if ( in_array( $value, array( '1', 'true', 'yes', 'x' ), true ) ) {
		return true;
	}

	// Handle explicitly falsy values.
	if ( in_array( $value, array( '0', 'no' ), true ) ) {
		return false;
	}

	// Treat empty strings or null as "empty" (null).
	if ( $value === '' || $value === null ) {
		return null;
	}

	// Fallback: Treat anything else as true.
	return true;
}
