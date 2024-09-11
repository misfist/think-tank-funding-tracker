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
 * Retrieves think tank data grouped by think tank with summed amounts for each donor type,
 * and sorts the data by the think tank key.
 *
 * @param string $donation_year The donation year to filter by.
 * @return array Array of think tank data.
 */
function get_think_tanks_data( $donation_year = '' ) {
	$year_var = get_query_var( 'donation_year', '' );
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

	$results         = array();
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

			if ( ! isset( $results[ $think_tank_slug ] ) ) {
				$post_id                     = get_post_from_term( $think_tank_slug, 'think_tank' );
				$results[ $think_tank_slug ] = array(
					'think_tank'         => $think_tank,
					'donor_types'        => array(),
					'transparency_score' => get_transparency_score( $think_tank_slug ),
				);
			}

			$donor_type_terms = wp_get_post_terms( get_the_ID(), 'donor_type' );
			foreach ( $donor_type_terms as $donor_type_term ) {
				$donor_type = $donor_type_term->name;

				if ( ! isset( $results[ $think_tank_slug ]['donor_types'][ $donor_type ] ) ) {
					$results[ $think_tank_slug ]['donor_types'][ $donor_type ] = 0;
				}

				$amount_calc = get_post_meta( get_the_ID(), 'amount_calc', true );
				$amount_calc = floatval( $amount_calc );

				$results[ $think_tank_slug ]['donor_types'][ $donor_type ] += $amount_calc;

				$all_donor_types[ $donor_type ] = true;
			}
		}
	}

	wp_reset_postdata();

	foreach ( $results as &$think_tank_data ) {
		foreach ( $all_donor_types as $donor_type => $value ) {
			if ( ! isset( $think_tank_data['donor_types'][ $donor_type ] ) ) {
				$think_tank_data['donor_types'][ $donor_type ] = 0;
			}
		}
	}

	ksort( $results );

	return $results;
}

/**
 * Get Table Data
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
 * Generate Table
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

	<table class="top-ten-recipients dataTable">
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
 * Generates and returns HTML table markup for think tank data.
 *
 * @param  string $donation_year
 * @return string HTML table markup.
 */
function generate_think_tanks_table( $donation_year = '' ): string {
	$data = get_think_tanks_data( $donation_year );

	ob_start();
	if ( $data ) :
		?>
	<table class="think-tank-archive dataTable">
		<?php
		if( $donation_year ) :
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
 * Render Table
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
 * Render Table
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
			'year'  => '',
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
