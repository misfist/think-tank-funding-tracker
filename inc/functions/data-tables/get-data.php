<?php
/**
 * Get Data Functions
 */
namespace Quincy\ttft;

/**
 * Get transaction IDs for think tank
 *
 * @param string $think_tank    Optional. Slug of the think tank.
 * @param string $donation_year Optional. Slug of the donation year.
 * @param string $donor_type    Optional. Slug of the donor type.
 * @return array
 */
function get_single_think_tank_transaction_ids( $think_tank = '', $donation_year = '', $donor_type = '' ): array {
	$think_tank    = sanitize_text_field( $think_tank );
	$donation_year = sanitize_text_field( $donation_year );
	$donor_type    = sanitize_text_field( $donor_type );

	$transient_key = 'single_think_tank_ids_' . md5( $think_tank . $donation_year . $donor_type );

	$data = get_transient( $transient_key );
	if ( false !== $data ) {
		return $data;
	}

	$args = array(
		'post_type'      => 'transaction',
		'posts_per_page' => -1,
		'fields'         => 'ids',
		'tax_query'      => array(
			'relation' => 'AND',
		),
	);

	if ( $think_tank ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'think_tank',
			'field'    => 'slug',
			'terms'    => $think_tank,
		);
	}

	if ( $donation_year ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'donation_year',
			'field'    => 'slug',
			'terms'    => $donation_year,
		);
	}

	if ( $donor_type ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'donor_type',
			'field'    => 'slug',
			'terms'    => $donor_type,
		);
	}

	$query = new \WP_Query( $args );

	$data = $query->get_posts();

	set_transient( $transient_key, $data, 12 * HOUR_IN_SECONDS );

	return $data;
}

/**
 * Get Raw Table Data
 *
 * @param string $donor_type Optional. The slug of the donor_type taxonomy term. Default empty.
 * @param string $donation_year Optional. The slug of the donation_year taxonomy term. Default empty.
 * @param int    $number_of_items Optional. The number of items to return. Default 10.
 * @return array An array of transaction data including think_tank term and total amount.
 */
function get_top_ten_raw_data( $donor_type = '', $donation_year = '', $number_of_items = 10 ): array {
	$args = array(
		'post_type'      => 'transaction',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
	);

	$tax_query = array( 'relation' => 'AND' );

	if ( $donor_type ) {
		$tax_query[] = array(
			'taxonomy' => 'donor_type',
			'field'    => 'slug',
			'terms'    => $donor_type,
		);
	}

	if ( $donation_year ) {
		$tax_query[] = array(
			'taxonomy' => 'donation_year',
			'field'    => 'slug',
			'terms'    => $donation_year,
		);
	}

	if ( ! empty( $tax_query ) ) {
		$args['tax_query'] = $tax_query;
	}

	$query = new \WP_Query( $args );

	$result = array();

	foreach ( $query->posts as $post ) {
		$think_tanks = wp_get_post_terms( $post->ID, 'think_tank' );
		if ( ! $think_tanks ) {
			continue;
		}

		$think_tank = $think_tanks[0];
		$amount     = get_post_meta( $post->ID, 'amount_calc', true );

		$result[] = array(
			'think_tank'   => $think_tank->name,
			'total_amount' => (int) $amount,
			'year'         => implode( ',', wp_get_post_terms( $post->ID, 'donation_year', array( 'fields' => 'names' ) ) ),
			'type'         => implode( ',', wp_get_post_terms( $post->ID, 'donor_type', array( 'fields' => 'names' ) ) ),
		);
	}

	usort(
		$result,
		function ( $a, $b ) {
			return ( strcmp( $a['think_tank'], $b['think_tank'] ) );
		}
	);

	return $result;
}

/**
 * Get raw donor data for think tank.
 *
 * @param string $think_tank    Optional. Slug of the think tank.
 * @param string $donation_year Optional. Slug of the donation year.
 * @param string $donor_type    Optional. Slug of the donor type.
 * @return array
 */
function get_single_think_tank_raw_data( $think_tank = '', $donation_year = '', $donor_type = '' ): array {
	$think_tank    = sanitize_text_field( $think_tank );
	$donation_year = sanitize_text_field( $donation_year );
	$donor_type    = sanitize_text_field( $donor_type );

	$transient_key = 'single_think_tank_' . md5( $think_tank . $donation_year . $donor_type );

	$data = get_transient( $transient_key );
	if ( false !== $data ) {
		return $data;
	}

	$args = array(
		'post_type'      => 'transaction',
		'posts_per_page' => -1,
		'fields'         => 'ids',
		'tax_query'      => array(
			'relation' => 'AND',
		),
	);

	if ( $think_tank ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'think_tank',
			'field'    => 'slug',
			'terms'    => $think_tank,
		);
	}

	if ( $donation_year ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'donation_year',
			'field'    => 'slug',
			'terms'    => $donation_year,
		);
	}

	if ( $donor_type ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'donor_type',
			'field'    => 'slug',
			'terms'    => $donor_type,
		);
	}

	$query = new \WP_Query( $args );
	$data  = array();

	if ( $query->have_posts() ) {
		foreach ( $query->posts as $post_id ) {
			$donors = wp_get_object_terms( $post_id, 'donor', array( 'orderby' => 'parent' ) );
			if ( empty( $donors ) || is_wp_error( $donors ) ) {
				continue;
			}

			$donor_names = wp_list_pluck( $donors, 'name' );
			$donor_slugs = wp_list_pluck( $donors, 'slug' );
			$donor_name  = implode( ' > ', $donor_names );
			$donor_slug  = implode( '-', $donor_slugs );

			$amount_calc = (int) get_post_meta( $post_id, 'amount_calc', true );
			if ( empty( $amount_calc ) ) {
				$amount_calc = 0;
			}

			$data[] = array(
				'donor'       => $donor_name,
				'amount_calc' => $amount_calc,
				'donor_type'  => get_the_term_list( $post_id, 'donor_type' ),
				'donor_link'  => get_term_link( $donor_slugs[0], 'donor' ),
				'donor_slug'  => $donor_slug,
				'source'      => get_post_meta( $post_id, 'source', true ),
			);
		}
	}

	// wp_reset_postdata();

	set_transient( $transient_key, $data, 12 * HOUR_IN_SECONDS );

	return $data;
}

/**
 * Retrieve think tank data for individual donor
 *
 * @param string $donor Optional. Slug of the donor taxonomy term to filter by.
 * @param string $donation_year Optional. Slug of the donation_year taxonomy term to filter by.
 * @return array Array of transaction data.
 */
function get_single_donor_raw_data( $donor = '', $donation_year = '', $donor_type = '' ) {
	$donor         = sanitize_text_field( $donor );
	$donation_year = sanitize_text_field( $donation_year );
	$donor_type    = sanitize_text_field( $donor_type );

	$transient_key = 'single_donor_' . md5( $donor . $donation_year . $donor_type );

	$args = array(
		'post_type'      => 'transaction',
		'posts_per_page' => -1,
		'post_status'    => 'publish',
		'fields'         => 'ids',
	);

	$tax_query = array( 'relation' => 'AND' );

	if ( ! empty( $donor ) ) {
		$tax_query[] = array(
			'taxonomy' => 'donor',
			'field'    => 'slug',
			'terms'    => $donor,
		);
	}

	if ( ! empty( $donation_year ) ) {
		$tax_query[] = array(
			'taxonomy' => 'donation_year',
			'field'    => 'slug',
			'terms'    => $donation_year,
		);
	}

	if ( ! empty( $donor_type ) ) {
		$tax_query[] = array(
			'taxonomy' => 'donor_type',
			'field'    => 'slug',
			'terms'    => $donor_type,
		);
	}

	if ( ! empty( $tax_query ) ) {
		$args['tax_query'] = $tax_query;
	}

	$query = new \WP_Query( $args );

	$data = array();

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$post_id     = get_the_ID();
			$think_tanks = get_the_terms( $post_id, 'think_tank' );

			if ( ! $think_tanks ) {
				continue;
			}

			$think_tank      = $think_tanks[0];
			$think_tank_slug = $think_tank->slug;
			$source          = get_post_meta( $post_id, 'source', true );

			$amount_calc = get_post_meta( $post_id, 'amount_calc', true );
			if ( empty( $amount_calc ) ) {
				$amount_calc = 0;
			}

			$donor_type = get_the_term_list( $post_id, 'donor_type', '', ', ', '' );

			$donors = wp_get_object_terms( $post_id, 'donor', array( 'orderby' => 'parent' ) );
			if ( empty( $donors ) || is_wp_error( $donors ) ) {
				continue;
			}

			$donor_names = wp_list_pluck( $donors, 'name' );
			$donor       = end( $donor_names );

			$data[] = array(
				'think_tank'      => $think_tank->name,
				'donor'           => $donor,
				'amount_calc'     => (int) $amount_calc,
				'donor_type'      => $donor_type,
				'source'          => $source,
				'think_tank_slug' => $think_tank_slug,
			);
		}
		// wp_reset_postdata();
	}

	set_transient( $transient_key, $data, 12 * HOUR_IN_SECONDS );

	return $data;
}

/**
 * Retrieve donor data, optionally filtered by donation year.
 *
 * @param string $donation_year The slug of the donation year to filter transactions by (optional).
 * @return array
 */
function get_donor_archive_raw_data( $donation_year = '', $donor_type = '' ): array {
	$args = array(
		'post_type'      => 'transaction',
		'posts_per_page' => -1,
	);

	if ( $donation_year ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'donation_year',
				'field'    => 'slug',
				'terms'    => sanitize_title( $donation_year ),
			),
		);
	}
	if ( $donor_type ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'donor_type',
				'field'    => 'slug',
				'terms'    => sanitize_title( $donor_type ),
			),
		);
	}

	$query = new \WP_Query( $args );

	$data = array();

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();

			$post_id = get_the_ID();

			$donors = wp_get_object_terms( $post_id, 'donor', array( 'orderby' => 'parent' ) );
			if ( empty( $donors ) || is_wp_error( $donors ) ) {
				continue;
			}

			$donor_names = wp_list_pluck( $donors, 'name' );
			$donor_slugs = wp_list_pluck( $donors, 'slug' );
			$donor_name  = implode( ' > ', $donor_names );
			$donor_slug  = implode( '-', $donor_slugs );

			$amount = get_post_meta( $post_id, 'amount_calc', true );
			$amount = intval( $amount );

			$data[] = array(
				'donor'       => $donor_name,
				'amount_calc' => $amount,
				'donor_type'  => get_the_term_list( $post_id, 'donor_type' ),
				'donor_slug'  => $donor_slug,
				'donor_link'  => get_term_link( $donor_slugs[0], 'donor' ),
				'year'        => get_the_term_list( $post_id, 'donation_year' ),
			);
		}

		wp_reset_postdata();
	}

	return $data;
}

/**
 * Get data for top ten
 *
 * @param string $donor_type Optional. The slug of the donor_type taxonomy term. Default empty.
 * @param string $donation_year Optional. The slug of the donation_year taxonomy term. Default empty.
 * @param int    $number_of_items Optional. The number of items to return. Default 10.
 * @return array An array of transaction data including think_tank term and total amount.
 */
function get_top_ten_data( $donor_type = '', $donation_year = '', $number_of_items = 10 ): array {
	$raw_data = get_top_ten_raw_data( $donor_type, $donation_year, $number_of_items );

	if ( empty( $raw_data ) ) {
		return array();
	}

	$data = array();

	foreach ( $raw_data as $item ) {
		$data[ $item['think_tank'] ] += (int) $item['total_amount'];
	}

	arsort( $data );

	$data = array_slice( $data, 0, $number_of_items, true );

	$result = array();
	foreach ( $data as $think_tank => $total_amount ) {
		$result[] = array(
			'think_tank'   => $think_tank,
			'total_amount' => $total_amount,
		);
	}

	return $result;
}

/**
 * Get data for think tanks
 *
 * @param string $donation_year The donation year to filter by.
 * @return array Array of think tank data.
 */
function get_think_tank_archive_data( $donation_year = '' ) {
	$args = array(
		'post_type'      => 'transaction',
		'posts_per_page' => -1,
		'post_status'    => 'publish',
		'tax_query'      => array(),
	);

	if ( ! empty( $donation_year ) ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'donation_year',
			'field'    => 'slug',
			'terms'    => $donation_year,
		);
	}

	$query = new \WP_Query( $args );

	$data            = array();
	$all_donor_types = array();

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();

			$think_tank_terms = wp_get_post_terms( get_the_ID(), 'think_tank' );
			if ( ! $think_tank_terms ) {
				continue;
			}

			$think_tank      = $think_tank_terms[0]->name;
			$think_tank_slug = $think_tank_terms[0]->slug;

			if ( ! isset( $data[ $think_tank_slug ] ) ) {
				$post_id                  = get_post_from_term( $think_tank_slug, 'think_tank' );
				$data[ $think_tank_slug ] = array(
					'think_tank'         => $think_tank,
					'donor_types'        => array(),
					'transparency_score' => get_transparency_score_from_slug( $think_tank_slug ),
				);
			}

			$donor_type_terms = wp_get_post_terms( get_the_ID(), 'donor_type' );
			foreach ( $donor_type_terms as $donor_type_term ) {
				$donor_type = $donor_type_term->name;

				if ( ! isset( $data[ $think_tank_slug ]['donor_types'][ $donor_type ] ) ) {
					$data[ $think_tank_slug ]['donor_types'][ $donor_type ] = 0;
				}

				$amount_calc = get_post_meta( get_the_ID(), 'amount_calc', true );
				$amount_calc = floatval( $amount_calc );

				$data[ $think_tank_slug ]['donor_types'][ $donor_type ] += $amount_calc;

				$all_donor_types[ $donor_type ] = true;
			}
		}
	}

	wp_reset_postdata();

	foreach ( $data as &$think_tank_data ) {
		foreach ( $all_donor_types as $donor_type => $value ) {
			if ( ! isset( $think_tank_data['donor_types'][ $donor_type ] ) ) {
				$think_tank_data['donor_types'][ $donor_type ] = 0;
			}
		}
	}

	ksort( $data );

	return $data;
}

/**
 * Aggregates donor data for think tank.
 *
 * @param string $think_tank    Optional. Slug of the think tank.
 * @param string $donation_year Optional. Slug of the donation year.
 * @param string $donor_type    Optional. Slug of the donor type.
 * @return array
 */
function get_single_think_tank_data( $think_tank = '', $donation_year = '', $donor_type = '' ): array {
	$raw_data = get_single_think_tank_raw_data( $think_tank, $donation_year, $donor_type );

	if ( empty( $raw_data ) ) {
		return array();
	}

	$data = array_reduce(
		$raw_data,
		function ( $carry, $item ) {
			$donor_slug = $item['donor_slug'];

			if ( ! isset( $carry[ $donor_slug ] ) ) {
				$carry[ $donor_slug ] = array(
					'donor'       => $item['donor'],
					'amount_calc' => 0,
					'donor_type'  => $item['donor_type'],
					'donor_slug'  => $donor_slug,
					'donor_link'  => $item['donor_link'],
					'source'      => $item['source'],
				);
			}

			$carry[ $donor_slug ]['amount_calc'] += $item['amount_calc'];

			return $carry;
		},
		array()
	);

	ksort( $data );

	return $data;
}

/**
 * Aggregate 'amount_calc' values for individual donor
 *
 * @param string $donor Optional. Slug of the donor taxonomy term to filter by.
 * @param string $donation_year Optional. Slug of the donation_year taxonomy term to filter by.
 * @return array Aggregated data with summed 'amount_calc' values.
 */
function get_single_donor_data( $donor = '', $donation_year = '', $donor_type = '' ) {
	$raw_data = get_single_donor_raw_data( $donor, $donation_year, $donor_type );

	$data = array_reduce(
		$raw_data,
		function ( $carry, $item ) {
			$think_tank_slug = $item['think_tank_slug'];
			if ( ! isset( $carry[ $think_tank_slug ] ) ) {
				$carry[ $think_tank_slug ] = array(
					'think_tank'      => $item['think_tank'],
					'donor'           => $item['donor'],
					'amount_calc'     => 0,
					'donor_type'      => $item['donor_type'],
					'source'          => $item['source'],
					'think_tank_slug' => $think_tank_slug,
				);
			}
			$carry[ $think_tank_slug ]['amount_calc'] += $item['amount_calc'];

			return $carry;
		},
		array()
	);

	ksort( $data );

	return $data;
}

/**
 * Get data for donors
 *
 * @param  string $donation_year
 * @return array
 */
function get_donor_archive_data( $donation_year = '', $donor_type = '' ) {
	$donor_data = get_donor_archive_raw_data( $donation_year, $donor_type );
	$data       = array_reduce(
		$donor_data,
		function ( $carry, $item ) {
			$donor_slug  = $item['donor_slug'];
			$amount_calc = $item['amount_calc'];
			$year        = $item['year'];

			if ( ! isset( $carry[ $donor_slug ] ) ) {
				$carry[ $donor_slug ] = array(
					'donor'       => $item['donor'],
					'amount_calc' => $amount_calc,
					'donor_type'  => $item['donor_type'],
					'donor_slug'  => $donor_slug,
					'donor_link'  => $item['donor_link'],
					'year'        => $year,
				);
			} else {
				$carry[ $donor_slug ]['amount_calc'] += $amount_calc;

				$years = explode( ', ', $carry[ $donor_slug ]['year'] );
				if ( ! in_array( $year, $years ) ) {
					$years[]                      = $year;
					$carry[ $donor_slug ]['year'] = implode( ', ', $years );
				}
			}

			return $carry;
		},
		array()
	);

	ksort( $data );

	return $data;
}

/**
 * Get the total amount of donations for a think tank
 *
 * @param string $think_tank
 * @param string $donation_year
 * @param string $donor_type
 * @return int
 */
function get_single_think_tank_total( $think_tank, $donation_year = '', $donor_type = '' ): int {
	$think_tank    = sanitize_text_field( $think_tank );
	$donation_year = sanitize_text_field( $donation_year );
	$donor_type    = sanitize_text_field( $donor_type );

	$transient_key = 'single_think_tank_cumulative_' . md5( $think_tank . $donation_year . $donor_type );

	$total = get_transient( $transient_key );
	if ( false !== $total ) {
		return $total;
	}

	$data = get_single_think_tank_transaction_ids( $think_tank, $donation_year, $donor_type );

	if ( ! empty( $data ) ) {
		$amounts = get_meta_values_for_records( $data, 'amount_calc' );
		if ( $amounts ) {
			$total = array_sum( $amounts );
		} else {
			$total = 0;
		}
	} else {
		$total = 0;
	}

	set_transient( $transient_key, $total, 12 * HOUR_IN_SECONDS );

	return $total;
}


/**
 * Get the total amount of donations for a donor
 *
 * @param string $donor
 * @param string $donor_type
 * @return int
 */
function get_single_donor_total( $donor, $donation_year = '', $donor_type = '' ): int {
	$donor         = sanitize_text_field( $donor );
	$donation_year = sanitize_text_field( $donation_year );
	$donor_type    = sanitize_text_field( $donor_type );

	$transient_key = 'single_donor_cumulative_' . md5( $donor . $donation_year . $donor_type );

	$data = get_single_donor_raw_data( $donor, $donation_year, $donor_type );

	if ( ! empty( $data ) ) {
		$amounts = wp_list_pluck( $data, 'amount_calc' ) ;
		$total   = array_sum( $amounts );
	} else {
		$total = 0;
	}

	set_transient( $transient_key, $data, 12 * HOUR_IN_SECONDS );

	return $total;
}

/**
 * Get the total amount of donations for a group of posts
 *
 * @param  array  $post_ids
 * @param  string $meta_key
 * @return array
 */
function get_meta_values_for_records( array $post_ids, string $meta_key ): array {
	global $wpdb;

	if ( empty( $post_ids ) ) {
		return array();
	}

	$meta_values = array();
	$chunks      = array_chunk( $post_ids, 1000 ); // Split into chunks to handle large arrays

	foreach ( $chunks as $chunk ) {
		$placeholders = implode( ',', array_fill( 0, count( $chunk ), '%d' ) );
		$query        = $wpdb->prepare(
			"
            SELECT post_id, meta_value
            FROM $wpdb->postmeta
            WHERE post_id IN ($placeholders)
            AND meta_key = %s
        ",
			array_merge( $chunk, array( $meta_key ) )
		);

		$results = $wpdb->get_results( $query, OBJECT_K );

		foreach ( $results as $post_id => $result ) {
			$meta_values[ $post_id ] = $result->meta_value;
		}
	}
	return $meta_values;
}

/**
 * Generate data array for a think tank.
 *
 * @param int $post_id Post ID of the think tank.
 * @return array Data array containing think tank details.
 */
function generate_think_tank_data_array( $post_id = 0 ): array {
	$post_id            = $post_id ?? get_the_ID();
	$think_tank         = get_post_field( 'post_name', $post_id );
	$limited_info       = get_post_meta( $post_id, 'limited_info', true );
	$is_limited         = ( $limited_info && strtolower( trim( $limited_info ) ) == 'x' ) ? true : false;
	$is_transparent     = ( $limited_info && str_contains( strtolower( trim( $limited_info ) ), 'transparent' ) ) ? true : false;
	$no_domestic        = get_post_meta( $post_id, 'no_domestic_accepted', true );
	$no_defense         = get_post_meta( $post_id, 'no_defense_accepted', true );
	$no_foreign         = get_post_meta( $post_id, 'no_foreign_accepted', true );
	$transparency_score = ( $score = get_post_meta( $post_id, 'transparency_score', true ) ) ? (int) $score : 0;
	$think_tank_term    = wp_get_post_terms( $post_id, 'think_tank' );
	$column_count       = ( $is_limited || $is_transparent ) ? 2 : 4;

	$data_block_label = esc_html__( 'Minimum funding to date from', 'ttft' );

	$domestic_total = get_single_think_tank_total( $think_tank, '', 'u-s-government' ) ?? 0;
	$defense_total  = get_single_think_tank_total( $think_tank, '', 'pentagon-contractor' ) ?? 0;
	$foreign_total  = get_single_think_tank_total( $think_tank, '', 'foreign-government' ) ?? 0;

	$donor_types = array(
		'u-s-government'      => get_term_by( 'slug', 'u-s-government', 'donor_type' ),
		'pentagon-contractor' => get_term_by( 'slug', 'pentagon-contractor', 'donor_type' ),
		'foreign-government'  => get_term_by( 'slug', 'foreign-government', 'donor_type' ),
	);

	return array(
		'post_id'            => $post_id,
		'think_tank'         => $think_tank,
		'limited_info'       => $limited_info,
		'is_limited'         => $is_limited,
		'is_transparent'     => $is_transparent,
		'no_domestic'        => $no_domestic,
		'no_defense'         => $no_defense,
		'no_foreign'         => $no_foreign,
		'transparency_score' => $transparency_score,
		'think_tank_term'    => $think_tank_term,
		'column_count'       => $column_count,
		'data_block_label'   => $data_block_label,
		'domestic_total'     => $domestic_total,
		'defense_total'      => $defense_total,
		'foreign_total'      => $foreign_total,
		'donor_types'        => $donor_types,
	);
}

/**
 * Retrieves transaction posts that share the same think_tank taxonomy term as the specified or current post.
 *
 * @param int $post_id The ID of the post. Defaults to 0 to use the current post in the loop.
 * @return string JSON encoded data including columns and rows for DataTables.
 */
function get_single_think_tank_json( $post_id = 0 ) {
	if ( 0 === $post_id && \is_singular() ) {
		$post_id = \get_the_ID();
	}

	if ( 0 === $post_id ) {
		return \wp_json_encode( array() );
	}

	$think_tank_terms = \wp_get_post_terms( $post_id, 'think_tank' );

	if ( empty( $think_tank_terms ) || \is_wp_error( $think_tank_terms ) ) {
		return \wp_json_encode( array() );
	}

	$think_tank_term_id = $think_tank_terms[0]->term_id;

	$args = array(
		'post_type'      => 'transaction',
		'tax_query'      => array(
			array(
				'taxonomy' => 'think_tank',
				'field'    => 'term_id',
				'terms'    => $think_tank_term_id,
			),
		),
		'posts_per_page' => 20,
	);

	$query = new \WP_Query( $args );

	$transactions = array();

	foreach ( $query->posts as $post ) {
		$think_tank_hierarchy = \get_term_parents_list(
			\wp_get_post_terms( $post->ID, 'think_tank' )[0]->term_id,
			'think_tank',
			array( 'format' => 'name' )
		);

		$amount_calc = \get_post_meta( $post->ID, 'amount_calc', true );
		$source      = \get_post_meta( $post->ID, 'source', true );

		$donation_year_terms = \wp_get_post_terms( $post->ID, 'donation_year' );
		$donor_type_terms    = \wp_get_post_terms( $post->ID, 'donor_type' );

		$transactions[] = array(
			'Think Tank'   => $think_tank_hierarchy,
			'Min Donation' => $amount_calc,
			'Year'         => ! empty( $donation_year_terms ) ? $donation_year_terms[0]->name : '',
			'Type'         => ! empty( $donor_type_terms ) ? $donor_type_terms[0]->name : '',
			'Source'       => $source,
		);
	}

	return \wp_json_encode(
		array(
			'columns' => array(
				array(
					'title' => 'Think Tank',
					'data'  => 'Think Tank',
				),
				array(
					'title' => 'Min Donation',
					'data'  => 'Min Donation',
				),
				array(
					'title' => 'Year',
					'data'  => 'Year',
				),
				array(
					'title' => 'Type',
					'data'  => 'Type',
				),
				array(
					'title' => 'Source',
					'data'  => 'Source',
				),
			),
			'data'    => $transactions,
		)
	);
}

