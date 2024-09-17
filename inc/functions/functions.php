<?php
/**
 * Functions.
 *
 * @package ttt
 */

namespace Quincy\ttt;

/**
 * Retrieves transaction posts that share the same think_tank taxonomy term as the specified or current post.
 *
 * @param int $post_id The ID of the post. Defaults to 0 to use the current post in the loop.
 * @return string JSON encoded data including columns and rows for DataTables.
 */
function get_transaction_data_by_think_tank( $post_id = 0 ) {
	// Use the current post ID if not provided and we are in a singular post context
	if ( 0 === $post_id && \is_singular() ) {
		$post_id = \get_the_ID();
	}

	// If post ID is still not determined, return empty JSON
	if ( 0 === $post_id ) {
		return \wp_json_encode( array() );
	}

	// Get the think_tank taxonomy terms for the specified post
	$think_tank_terms = \wp_get_post_terms( $post_id, 'think_tank' );

	if ( empty( $think_tank_terms ) || \is_wp_error( $think_tank_terms ) ) {
		return \wp_json_encode( array() );
	}

	// Use the first term if multiple terms are returned
	$think_tank_term_id = $think_tank_terms[0]->term_id;

	// Prepare the query to get transaction posts with the same think_tank term
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
		// Get the think_tank term hierarchy
		$think_tank_hierarchy = \get_term_parents_list(
			\wp_get_post_terms( $post->ID, 'think_tank' )[0]->term_id,
			'think_tank',
			array( 'format' => 'name' )
		);

		// Retrieve meta values
		$amount_calc = \get_post_meta( $post->ID, 'amount_calc', true );
		$source      = \get_post_meta( $post->ID, 'source', true );

		// Retrieve taxonomy terms
		$donation_year_terms = \wp_get_post_terms( $post->ID, 'donation_year' );
		$donor_type_terms    = \wp_get_post_terms( $post->ID, 'donor_type' );

		// Format the transaction data
		$transactions[] = array(
			'Think Tank'   => $think_tank_hierarchy,
			'Min Donation' => $amount_calc,
			'Year'         => ! empty( $donation_year_terms ) ? $donation_year_terms[0]->name : '',
			'Type'         => ! empty( $donor_type_terms ) ? $donor_type_terms[0]->name : '',
			'Source'       => $source,
		);
	}

	// Return the data as a JSON object
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

/**
 * Shortcode to output JSON data for transactions based on the specified or current post's think_tank term.
 *
 * @param array $atts Shortcode attributes.
 * @return string HTML output for the JSON data script.
 */
function transaction_data_shortcode( $atts ) {
	// Extract and sanitize shortcode attributes
	$atts = \shortcode_atts(
		array(
			'post_type' => 'think_tank',
		),
		$atts,
		'transaction_data'
	);

	// Ensure we are in a single post context for the specified post type
	if ( \is_singular( $atts['post_type'] ) ) {
		global $post;
		$json_data = get_transaction_data_by_think_tank( $post->ID );

		// Ensure JSON data is properly escaped
		$json_data_encoded = \wp_json_encode( $json_data );

		error_log( $json_data_encoded ); // This will log the raw JSON data to the debug log.

		// Return the JSON data within a script tag
		return '<script type="application/json" id="pageData">' . $json_data_encoded . '</script>';
	}

	return '';
}
\add_shortcode( 'transaction_data', __NAMESPACE__ . '\transaction_data_shortcode' );
