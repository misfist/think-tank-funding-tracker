<?php
/**
 * Functions.
 *
 * @package ttt
 */

namespace Quincy\ttt;

/**
 * Retrieve the most recent donation year term.
 *
 * @return string|false The name of the most recent donation year term, or false if none found.
 */
function get_most_recent_donation_year() {
	$taxonomy = 'donation_year';

	$args = array(
		'taxonomy'   => $taxonomy,
		'orderby'    => 'name',
		'order'      => 'DESC',
		'number'     => 1,
		'hide_empty' => true,
	);

	$terms = get_terms( $args );

	if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
		return $terms[0]->name;
	}

	return false;
}

/**
 * Retrieves all donation_year terms associated with transaction posts for a specific donor.
 *
 * @param string $name The donor taxonomy term name.
 * @param string $type The donor taxonomy name. Default 'donor'.
 * @return array An array of donation_year term names.
 */
function get_years( $name, $type = 'donor' ): array {
	$post_type     = 'transaction';
	$year_taxonomy = 'donation_year';

	$donor_term = get_term_by( 'name', $name, $type );

	if ( ! $donor_term || is_wp_error( $donor_term ) ) {
		return array();
	}

	$tax_query = array(
		array(
			'taxonomy' => $type,
			'field'    => 'term_id',
			'terms'    => $donor_term->term_id,
		),
	);

	$query_args = array(
		'post_type'      => $post_type,
		'posts_per_page' => -1,
		'fields'         => 'ids',
		'tax_query'      => $tax_query,
	);

	$post_ids = get_posts( $query_args );

	if ( empty( $post_ids ) ) {
		return array();
	}

	$term_args = array(
		'fields' => 'names',
		'order'  => 'DESC',
	);

	$terms = wp_get_object_terms( $post_ids, $year_taxonomy, $term_args );

	return ! is_wp_error( $terms ) ? array_unique( $terms ) : array();
}

/**
 * Print year tabs
 *
 * @param  string  $name
 * @param  string  $type
 * @param  integer $column
 * @return void
 */
function print_years( $name = '', $type = 'donor', $column = 2 ): void {
	global $post;
	$post_id = $post->ID;
	$type    = $post->post_type;
	$name    = ( $name ) ? $name : $post->post_title;
	$years   = get_years( $name, $type );

	if ( $years ) {
		?>
		<div class="filter-group year" data-index="<?php echo intval( $column ); ?>">
			<input type="radio" name="filter-year" id="filter-year-all" class="filter-checkbox" value="all" data-query-var="donation_year=" data-index="<?php echo intval( $column ); ?>" checked />
			<label for="filter-year-all">
				<?php esc_html_e( 'All', 'ttt' ); ?>
			</label>
			<?php
			foreach ( $years as $year ) :
				$url = esc_url( add_query_arg( 'donation_year', $year, get_permalink( $post_id ) ) );
				?>
				<input type="radio" id="filter-<?php echo esc_attr( $year ); ?>" name="filter-year" class="filter-checkbox" value="<?php echo esc_attr( $year ); ?>" data-query-var="donation_year=<?php echo esc_attr( $year ); ?>" data-index="<?php echo intval( $column ); ?>" />
				<label for="filter-<?php echo esc_attr( $year ); ?>">
					<?php echo esc_html( $year ); ?>
				</label>
				<?php
			endforeach;
			?>
		</div>
		
		<?php
	}
}

/**
 * Print year tabs
 *
 * @param  string  $name
 * @param  string  $type
 * @param  integer $column
 * @return void
 */
function print_archive_years( $column = 2 ): void {
	global $post;
	$post_id = $post->ID;
	$type    = $post->post_type;
	$args    = array(
		'taxonomy' => 'donation_year',
		'fields'   => 'slugs',
		'order'    => 'DESC',
	);
	$years   = get_terms( $args );

	if ( $years ) {
		?>
		<div class="filter-group year year__archive" data-index="<?php echo intval( $column ); ?>">
			<input type="radio" name="filter-year" id="filter-year-all" class="filter-checkbox" value="all" data-query-var="donation_year=" checked />
			<label for="filter-year-all">
				<?php esc_html_e( 'All', 'ttt' ); ?>
			</label>
			<?php
			foreach ( $years as $year ) :
				$url = esc_url( add_query_arg( 'donation_year', $year, get_permalink( $post_id ) ) );
				?>
				
					<input type="radio" id="filter-<?php echo esc_attr( $year ); ?>" name="filter-year" class="filter-checkbox" value="<?php echo intval( $year ); ?>" data-query-var="donation_year=<?php echo esc_attr( $year ); ?>" data-index="<?php echo intval( $column ); ?>" />
					<label for="filter-<?php echo esc_attr( $year ); ?>">
						<?php echo esc_html( $year ); ?>
					</label>
				<?php
			endforeach;
			?>
		</div>
		
		<?php
	}
}

/**
 * Print type tabs
 *
 * @param  string  $name
 * @param  string  $type
 * @param  integer $column
 * @return void
 */
function print_types( $column = 3 ): void {
	global $post;
	$taxonomy = 'donor_type';
	$types    = get_terms(
		array(
			'taxonomy' => $taxonomy,
		)
	);

	if ( $types ) {
		?>
		<div class="filter-group type" data-index="<?php echo intval( $column ); ?>">
			<input type="radio" id="filter-type-all" name="filter-type" class="filter-checkbox" value="all" data-index="<?php echo intval( $column ); ?>" data-query-var="donor_type=" checked />
			<label for="filter-type-all">
				<?php esc_html_e( 'All', 'ttt' ); ?>
			</label>
			<?php
			foreach ( $types as $type ) :
				?>
				<input type="radio" id="filter-<?php echo esc_attr( $type->slug ); ?>" name="filter-type" class="filter-checkbox" value="<?php echo esc_attr( $type->slug ); ?>" data-query-var="donor_type='<?php echo esc_attr( $type->slug ); ?>'" data-index="<?php echo intval( $column ); ?>" />
				<label for="filter-<?php echo esc_attr( $type->slug ); ?>">
					<?php echo esc_html( $type->name ); ?>
				</label>
				<?php
			endforeach;
			?>
		</div>
		
		<?php
	}
}

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
