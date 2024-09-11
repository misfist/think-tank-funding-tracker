<?php
/**
 * Table Data Functions
 */
namespace Quincy\ttt;

/**
 * Get Raw Table Data
 *
 * @param string $donor_type Optional. The slug of the donor_type taxonomy term. Default empty.
 * @param string $donation_year Optional. The slug of the donation_year taxonomy term. Default empty.
 * @param int    $number_of_items Optional. The number of items to return. Default 10.
 * @return array An array of transaction data including think_tank term and total amount.
 */
function get_top_ten_raw_data( $donor_type = '', $donation_year = '', $number_of_items = 10 ): array {
	$type_var = get_query_var( 'donor_type', '' );
	$year_var = get_query_var( 'donation_year', '' );

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
 * Retrieve donor data, optionally filtered by donation year.
 *
 * @param string $donation_year The slug of the donation year to filter transactions by (optional).
 * @return array
 */
function get_donors_raw_data( $donation_year = '', $donor_type = '' ) : array {
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
 * Get data for think tanks
 *
 * @param string $donation_year The donation year to filter by.
 * @return array Array of think tank data.
 */
function get_think_tanks_data( $donation_year = '' ) {
	$year_var = get_query_var( 'donation_year', '' );
	$args     = array(
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
					'transparency_score' => get_transparency_score( $think_tank_slug ),
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
 * Get data for donors
 *
 * @param  string $donation_year
 * @return array
 */
function get_donors_data( $donation_year = '', $donor_type = '' ) {
	$donor_data = get_donors_raw_data( $donation_year, $donor_type );
	$data = array_reduce(
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
 * Generate table for top ten
 *
 * @param string $donor_type Optional. The slug of the donor_type taxonomy term. Default empty.
 * @param string $donation_year Optional. The slug of the donation_year taxonomy term. Default empty.
 * @param int    $number_of_items Optional. The number of items to return. Default 10.
 * @return string HTML table markup.
 */
function generate_top_ten_table( $donor_type = '', $donation_year = '', $number_of_items = 10 ): string {
	$data = get_top_ten_data( $donor_type, $donation_year, $number_of_items );

	ob_start();
	?>

	<table class="top-ten-recipients dataTable" data-total-rows="<?php echo intval( count( $data ) ); ?>">
		<thead>
			<tr>
				<th class="column-think-tank"><?php esc_html_e( 'Think Tank', 'ttt' ); ?></th>
				<th class="column-min-amount column-numeric"><?php esc_html_e( 'Min Amount', 'ttt' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $data as $row ) : ?>
				<tr>
					<td class="column-think-tank" data-heading="<?php esc_attr_e( 'Think Tank', 'ttt' ); ?>">
						<a href="<?php echo esc_url( get_term_link( $row['think_tank'], 'think_tank' ) ); ?>"><?php echo esc_html( $row['think_tank'] ); ?></a>
					</td>
					<td class="column-min-amount column-numeric" data-heading="<?php esc_attr_e( 'Min Amount', 'ttt' ); ?>"><?php echo number_format( $row['total_amount'], 0 ); ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<?php
	return ob_get_clean();
}

/**
 * Generate table for think tanks
 *
 * @param  string $donation_year
 * @return string HTML table markup.
 */
function generate_think_tanks_table( $donation_year = '' ): string {
	$data = get_think_tanks_data( $donation_year );

	ob_start();
	if ( $data ) :
		?>
	<table class="think-tank-archive dataTable" data-total-rows="<?php echo intval( count( $data ) ); ?>">
		<?php
		if ( $donation_year ) :
			?>
			<caption><?php printf( 'Donations in <span class="donation-year">%s</span> received from…', intval( $donation_year ) ); ?></caption>
			<?php
		endif;
		?>
		<thead>
			<tr>
				<th class="column-think-tank"><?php esc_html_e( 'Think Tank', 'ttt' ); ?></th>
				<?php if ( ! empty( $data ) ) : ?>
					<?php
					$first_entry = reset( $data );
					foreach ( $first_entry['donor_types'] as $donor_type => $amount ) :
						?>
						<th class="column-numeric column-min-amount"><?php echo esc_html( $donor_type ); ?></th>
					<?php endforeach; ?>
				<?php endif; ?>
				<th class="column-numeric column-transparency-score"><?php esc_html_e( 'Score', 'ttt' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $data as $think_tank_slug => $data ) : ?>
				<tr data-think-tank="<?php echo esc_attr( $think_tank_slug ); ?>">
					<td class="column-think-tank" data-heading="<?php esc_attr_e( 'Think Tank', 'ttt' ); ?>"><a href="<?php echo esc_url( get_term_link( $think_tank_slug, 'think_tank' ) ); ?>"><?php echo esc_html( $data['think_tank'] ); ?></a></td>
					<?php foreach ( $data['donor_types'] as $donor_type => $amount ) : ?>
						<td class="column-numeric column-min-amount" data-heading="<?php echo esc_attr( $donor_type ); ?>"><?php echo esc_html( number_format( $amount, 0, '.', ',' ) ); ?></td>
					<?php endforeach; ?>
					<td class="column-numeric column-transparency-score" data-heading="<?php esc_attr_e( 'Transparency Score', 'ttt' ); ?>"><?php echo esc_html( $data['transparency_score'] ); ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
		<?php
	endif;

	$output = ob_get_clean();

	return $output;
}

/**
 * Generate table for think tanks
 *
 * @param  string $donation_year
 * @return string HTML table markup.
 */
function generate_donors_table( $donation_year = '', $donor_type = '' ): string {
	$data = get_donors_data( $donation_year, $donor_type );

	ob_start();
	if ( $data ) :
		?>
		<table class="donor-archive dataTable" data-total-rows="<?php echo intval( count( $data ) ); ?>">
			<?php
			if ( $donation_year ) :
				?>
				<caption><?php printf( 'Donations given in <span class="donation-year">%s</span>…', intval( $donation_year ) ); ?></caption>
				<?php
			endif;
			?>
			<thead>
				<tr>
					<th class="column-donor"><?php esc_html_e( 'Donor', 'ttt' ); ?></th>
					<th class="column-numeric column-min-amount"><?php esc_html_e( 'Min Amount', 'ttt' ); ?></th>
					<th class="column-type"><?php esc_html_e( 'Type', 'ttt' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ( $data as $key => $row ) :
					$amount = $row['amount_calc'];
					?>
					<tr data-think-tank="<?php echo esc_attr( $row['donor_slug'] ); ?>">
						<td class="column-donor" data-heading="<?php esc_attr_e( 'Donor', 'ttt' ); ?>"><a href="<?php echo esc_url( $row['donor_link'] ); ?>"><?php echo esc_html( $row['donor'] ); ?></a></td>
						<td class="column-numeric column-min-amount" data-heading="<?php esc_attr_e( 'Min Amount', 'ttt' ); ?>"><?php echo esc_html( number_format( $amount, 0, '.', ',' ) ); ?>
						<td class="column-donor-type" data-heading="<?php esc_attr_e( 'Type', 'ttt' ); ?>"><?php echo $row['donor_type']; ?>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php
	endif;

	$output = ob_get_clean();

	return $output;
}

/**
 * Render table for top ten
 *
 * @param  string  $donor_type
 * @param  string  $donation_year
 * @param  integer $number_of_items
 * @return void
 */
function render_top_ten_table( $donor_type = '', $donation_year = '', $number_of_items = 10 ): void {
	echo generate_top_ten_table( $donor_type, $donation_year, $number_of_items );
}

/**
 * Render table for think tanks
 *
 * @param  string  $donor_type
 * @param  string  $donation_year
 * @param  integer $number_of_items
 * @return void
 */
function render_think_tanks_table( $donation_year = '' ): void {
	echo generate_think_tanks_table( $donation_year );
}

/**
 * Render table for donors
 *
 * @param  string $donation_year
 * @return void
 */
function render_donors_table( $donation_year = '' ) {
	echo generate_donors_table( $donation_year );
}

/**
 * Shortcode to display the top ten table.
 *
 * @param array $atts Shortcode attributes.
 * @return string HTML table markup.
 */
function top_ten_table_shortcode( $atts ): string {
	$atts = shortcode_atts(
		array(
			'type'  => '',
			'year'  => '',
			'limit' => 10,
		),
		$atts,
		'top_ten_table'
	);

	return generate_top_ten_table(
		sanitize_text_field( $atts['type'] ),
		sanitize_text_field( $atts['year'] ),
		intval( $atts['limit'] )
	);
}
add_shortcode( 'top_ten_table', __NAMESPACE__ . '\top_ten_table_shortcode' );

/**
 * Shortcode to display the transaction table.
 *
 * @param array $atts Shortcode attributes.
 * @return string HTML table markup.
 */
function think_tanks_table_shortcode( $atts ): string {
	$atts = shortcode_atts(
		array(
			'year' => '',
		),
		$atts,
		'think_tanks_table'
	);

	return generate_think_tanks_table(
		sanitize_text_field( $atts['year'] )
	);
}
add_shortcode( 'think_tanks_table', __NAMESPACE__ . '\think_tanks_table_shortcode' );

/**
 * Shortcode to display the transaction table.
 *
 * @param array $atts Shortcode attributes.
 * @return string HTML table markup.
 */
function donors_table_shortcode( $atts ): string {
	$atts = shortcode_atts(
		array(
			'year' => '',
			'type' => ''
		),
		$atts,
		'donors_table'
	);

	return generate_donors_table(
		sanitize_text_field( $atts['year'] ),
		sanitize_text_field( $atts['type'] )
	);
}
add_shortcode( 'donors_table', __NAMESPACE__ . '\donors_table_shortcode' );

/**
 * Retrieves the Transparency Score for a given think tank slug.
 *
 * @param string $think_tank_slug The think tank slug.
 * @return int The Transparency Score.
 */
function get_transparency_score( $think_tank_slug ) : int {
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
