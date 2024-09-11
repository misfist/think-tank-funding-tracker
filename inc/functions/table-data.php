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

	<table class="transaction-table dataTable">
		<thead>
			<tr>
				<th class="column-think-tank"><?php esc_html_e( 'Think Tank', 'ttt' ); ?></th>
				<th class="column-min-amount column-numeric"><?php esc_html_e( 'Min Amount', 'ttt' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $data as $row ) : ?>
				<tr>
					<td class="column-think-tank">
						<a href="<?php echo esc_url( get_term_link( $row['think_tank'], 'think_tank' ) ); ?>"><?php echo esc_html( $row['think_tank'] ); ?></a>
					</td>
					<td class="column-min-amount column-numeric"><?php echo number_format( $row['total_amount'], 0 ); ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<?php
	return ob_get_clean();
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
 * Shortcode to display the transaction table.
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
