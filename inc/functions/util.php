<?php
/**
 * Utilities.
 *
 * @package ttt
 */

namespace Quincy\ttt;

if ( 'local' === wp_get_environment_type() && ! class_exists( '\WP_CLI' ) ) {
	// require_once trailingslashit( get_template_directory() ) . 'vendor/autoload.php';
}

/**
 * Assign transaction data
 *
 * @param  int    $import_id
 * @param  object $import
 * @return void
 */
function assign_transaction_data_after_import( $import_id, $import ): void {
	if ( 8 !== $import_id ) {
		return;
	}
	assign_transaction_data();
}
add_action( 'pmxi_after_xml_import', __NAMESPACE__ . '\assign_transaction_data_after_import', 10, 2 );

/**
 * Save transaction data as postmeta
 *
 * @return void
 */
function assign_transaction_data( $args = array() ): void {
	assign_think_tank_data();
	if ( class_exists( '\WP_CLI' ) ) {
		\WP_CLI::success( __( 'Transactions assigned to think tanks.', 'ttt' ) );
	}

	assign_donor_data();
	if ( class_exists( '\WP_CLI' ) ) {
		\WP_CLI::success( __( 'Transactions assigned to donors.', 'ttt' ) );
	}
}
if ( class_exists( '\WP_CLI' ) ) {
	\WP_CLI::add_command( 'transaction-data all', __NAMESPACE__ . '\assign_transaction_data' );
}

/**
 * Save transaction data as postmeta
 *
 * @return void
 */
function assign_think_tank_data(): void {
	$think_tanks = get_think_tanks();

	if ( ! empty( $think_tanks ) && ! is_wp_error( $think_tanks ) ) {
		foreach ( $think_tanks as $think_tank_id ) {
			$data = get_think_tank_data( $think_tank_id );
			if ( $data ) {
				update_post_meta( $think_tank_id, 'transactions', $data, true );
				$cumulative_data = calculate_data( $think_tank_id, $data );
				update_post_meta( $think_tank_id, 'cumulative_data', $cumulative_data, true );
				foreach ( $cumulative_data as $key => $value ) {
					// $raw_value       = $value;
					// $format          = new \NumberFormatter( 'en', \NumberFormatter::CURRENCY );
					// $formatted_value = $format->formatCurrency( (int) $value, 'USD' );
					// update_post_meta( $think_tank_id, $key . '_cumulative', $formatted_value, true );
					update_post_meta( $think_tank_id, $key . '_cumulative', $value, true );
				}
			}
		}
	}
}
if ( class_exists( '\WP_CLI' ) ) {
	\WP_CLI::add_command( 'transaction-data think-tanks', __NAMESPACE__ . '\assign_think_tank_data' );
}

/**
 * Save transaction data as postmeta
 *
 * @return void
 */
function assign_donor_data(): void {
	$donors = get_donors();

	if ( ! empty( $donors ) && ! is_wp_error( $donors ) ) {
		foreach ( $donors as $donor_id ) {
			$data = get_donor_data( $donor_id );
			if ( $data ) {
				update_post_meta( $donor_id, 'transactions', $data, true );
				$cumulative_data = calculate_data( $donor_id, $data );
				update_post_meta( $donor_id, 'cumulative_data', $cumulative_data, true );
				foreach ( $cumulative_data as $key => $value ) {
					// $raw_value       = $value;
					// $format          = new \NumberFormatter( 'en', \NumberFormatter::CURRENCY );
					// $formatted_value = $format->formatCurrency( (int) $value, 'USD' );
					// update_post_meta( $donor_id, $key . '_cumulative', $formatted_value, true );
					update_post_meta( $donor_id, $key . '_cumulative', $value, true );
				}
			}
		}
	}
}
if ( class_exists( '\WP_CLI' ) ) {
	\WP_CLI::add_command( 'transaction-data donors', __NAMESPACE__ . '\assign_donor_data' );
}

/**
 * Get all think tanks
 *
 * @return array
 */
function get_think_tanks(): array {
	$args = array(
		'post_type'      => 'think_tank',
		'posts_per_page' => -1,
		'fields'         => 'ids',
	);
	return get_posts( $args );
}

/**
 * Get all donors
 *
 * @return array
 */
function get_donors(): array {
	$args = array(
		'post_type'      => 'donor',
		'posts_per_page' => -1,
		'fields'         => 'ids',
	);
	return get_posts( $args );
}

/**
 * Calculate amounts
 *
 * @param  int   $post_id
 * @param  array $data
 * @return array
 */
function calculate_data( $post_id, $data ): array {
	$amount      = wp_list_pluck( $data, 'amount' );
	$amount_min  = wp_list_pluck( $data, 'amount_min' );
	$amount_max  = wp_list_pluck( $data, 'amount_max' );
	$amount_calc = wp_list_pluck( $data, 'amount_calc' );
	$years       = array_filter(
		array_unique( wp_list_pluck( $data, 'year' ) ),
		function ( $year ) {
			return 0 != $year;
		}
	);

	$years_array      = array();
	$years_cumulative = array();
	foreach ( $years as $year ) {
		/**
		 * Filter for $year
		 */
		$years_array[ $year ] = array_filter(
			$data,
			function ( $var ) use ( $year ) {
				return $year == $var['year'];
			}
		);

		/**
		 * Sum amount_calc for $year
		 */
		$years_cumulative[ $year ] = array_sum( wp_list_pluck( $years_array[ $year ], 'amount_calc' ) );
	}

	$domestic = wp_list_pluck(
		array_filter(
			$data,
			function ( $var ) {
				return 'U.S. Government' == $var['type'];
			}
		),
		'amount_calc'
	);

	$foreign = wp_list_pluck(
		array_filter(
			$data,
			function ( $var ) {
				return 'Foreign Government' == $var['type'];
			}
		),
		'amount_calc'
	);

	$defense = wp_list_pluck(
		array_filter(
			$data,
			function ( $var ) {
				return 'Defense Contractor' == $var['type'];
			}
		),
		'amount_calc'
	);

	return array(
		'amount'          => array_sum( $amount ),
		'amount_min'      => array_sum( $amount_min ),
		'amount_max'      => array_sum( $amount_max ),
		'amount_calc'     => array_sum( $amount_calc ),
		'amount_domestic' => array_sum( $domestic ),
		'amount_foreign'  => array_sum( $foreign ),
		'amount_defense'  => array_sum( $defense ),
		'years'           => $years,
		'years_array'     => $years_array,
		'years_amount'    => $years_cumulative,
	);
}

function is_range( $item ) {
	return str_contains( '-', $item );
}

function get_range_values( $item ) {
	$range = explode( '-', $item );
	if ( is_array( $range ) ) {
		return range( $range[0], $range[1] );
	}
	return array();
}

/**
 * Get think tank data output
 *
 * @param  integer $post_id
 * @return string $data output
 */
function get_think_tank_output( $post_id = 0 ) {
	global $post;
	$post_id = ( $post_id ) ? $post_id : get_the_ID();
	$data    = get_think_tank_data( $post_id );

	ob_start();

	if ( ! empty( $data ) ) :
		?>
		<?php
		foreach ( $data as $column ) :
			$donor       = ( $column['donor'] ) ? esc_attr( $column['donor'][0]->name ) : '';
			$donor_link  = ( $donor ) ? sprintf( '<a href="%s">%s</a>', get_term_link( $column['donor'][0]->term_id, 'donor' ), $donor ) : '';
			$amount      = ( $column['amount'] ) ? '$' . $column['amount'] : '-';
			$source      = ( $column['source'] ) ? esc_url( $column['source'] ) : '';
			$source_link = ( $source ) ? sprintf( '<a href="%s" class="tooltip"><i class="dashicons dashicons-admin-links"></i><span class="screen-reader-text">%s</span></a>', $source, $source ) : '';
			?>
			<tr
				data-donor="<?php echo $donor; ?>"
				data-amount="<?php echo esc_attr( $amount ); ?>"
				data-source="<?php echo esc_attr( $source ); ?>"
				data-type="<?php echo esc_attr( $column['type']->name ); ?>"
				data-year="<?php echo esc_attr( $column['year'] ); ?>"
				data-disclosed="<?php echo esc_attr( $column['disclosed'] ); ?>"
			>
				<td><?php echo $donor_link; ?></td>
				<td><?php echo esc_attr( $amount ); ?></td>
				<td><?php echo $source_link; ?></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<?php
		endforeach;
		?>
		
		<?php
	endif;

	return ob_get_clean();
}

/**
 * Get think tank data
 *
 * @param  integer $post_id
 * @return void
 */
function get_think_tank_data( $post_id = 0 ) {
	global $post;
	$post_id      = ( $post_id ) ? $post_id : get_the_ID();
	$post_slug    = get_post_field( 'post_name', $post_id );
	$transactions = get_think_tank_transactions_by_slug( $post_slug );
	return $transactions;
}

/**
 * Get think tank data
 *
 * @param  integer $post_id
 * @return void
 */
function get_donor_data( $post_id = 0 ) {
	global $post;
	$post_id      = ( $post_id ) ? $post_id : get_the_ID();
	$post_slug    = get_post_field( 'post_name', $post_id );
	$transactions = get_donor_transactions_by_slug( $post_slug );
	return $transactions;
}

/**
 * Get the transactions
 *
 * @param  string $post_slug
 * @return array
 */
function get_think_tank_transactions_by_slug( $post_slug ): array {
	$args         = array(
		'post_type'      => 'transaction',
		'posts_per_page' => -1,
		'tax_query'      => array(
			array(
				'taxonomy' => 'think_tank',
				'field'    => 'slug',
				'terms'    => $post_slug,
			),
		),
	);
	$query        = new \WP_Query( $args );
	$transactions = array();
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$transactions[] = get_think_tank_transaction( get_the_ID() );
		}
	}
	return $transactions;
}

/**
 * Get transaction
 *
 * @param  integer $post_id
 * @return array
 */
function get_think_tank_transaction( $post_id = 0 ): array {
	global $post;
	$donation_year = wp_get_post_terms( $post_id, 'year', array( 'number' => 1 ) );
	$post_id       = ( $post_id ) ? $post_id : $post->ID;
	$donor_obj     = wp_get_post_terms( $post_id, 'donor', array( 'number' => 1 ) );
	$donor         = get_post_meta( $post_id, 'donor', true );
	$amount        = get_post_meta( $post_id, 'amount', true );
	$amount_min    = get_post_meta( $post_id, 'amount_min', true );
	$amount_max    = get_post_meta( $post_id, 'amount_max', true );
	$amount_calc   = get_post_meta( $post_id, 'amount_calc', true );
	$data_notes    = get_post_meta( $post_id, 'source_notes', true );
	$disclosed     = get_post_meta( $post_id, 'disclosed', true );
	$source        = get_post_meta( $post_id, 'source', true );
	$type          = get_post_meta( $post_id, 'donor_type', true );
	$type_obj      = wp_get_post_terms( $post_id, 'donor_type', array( 'number' => 1 ) );
	$year          = ( ! empty( $donation_year ) && ! is_wp_error( $donation_year ) ) ? $donation_year : (int) get_post_meta( $post_id, 'year', true );
	$transaction   = array(
		'donor'       => $donor,
		'donor_obj'   => $donor_obj,
		'amount'      => (int) $amount,
		'amount_min'  => (int) $amount_min,
		'amount_max'  => (int) $amount_max,
		'amount_calc' => (int) $amount_calc,
		'type'        => $type,
		'type_obj'    => $type_obj,
		'year'        => $year,
		'disclosed'   => $disclosed,
		'data_notes'  => $data_notes,
		'source'      => $source,
	);
	return $transaction;
}

/**
 * Get the transactions
 *
 * @param  string $post_slug
 * @return array
 */
function get_donor_transactions_by_slug( $post_slug ): array {
	$args         = array(
		'post_type'      => 'transaction',
		'posts_per_page' => -1,
		'tax_query'      => array(
			array(
				'taxonomy' => 'donor',
				'field'    => 'slug',
				'terms'    => $post_slug,
			),
		),
	);
	$query        = new \WP_Query( $args );
	$transactions = array();
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$transactions[] = get_donor_transaction( get_the_ID() );
		}
	}
	return $transactions;
}

/**
 * Get transaction
 *
 * @param  int $post_id
 * @return array
 */
function get_donor_transaction( $post_id ): array {
	global $post;
	$post_id = ( $post_id ) ? $post_id : $post->ID;

	$donation_year  = wp_get_post_terms( $post_id, 'year', array( 'number' => 1 ) );
	$think_tank     = get_post_meta( $post_id, 'think_tank', true );
	$think_tank_obj = wp_get_post_terms( $post_id, 'think_tank', array( 'number' => 1 ) );
	$amount         = get_post_meta( $post_id, 'amount', true );
	$amount_min     = get_post_meta( $post_id, 'amount_min', true );
	$amount_max     = get_post_meta( $post_id, 'amount_max', true );
	$amount_calc    = get_post_meta( $post_id, 'amount_calc', true );
	$data_notes     = get_post_meta( $post_id, 'source_notes', true );
	$disclosed      = get_post_meta( $post_id, 'disclosed', true );
	$source         = get_post_meta( $post_id, 'source', true );
	$type           = get_post_meta( $post_id, 'donor_type', true );
	$type_obj       = wp_get_post_terms( $post_id, 'donor_type', array( 'number' => 1 ) );
	$year           = ( ! empty( $donation_year ) && ! is_wp_error( $donation_year ) ) ? $donation_year : (int) get_post_meta( $post_id, 'year', true );
	$transaction    = array(
		'think_tank'     => $think_tank,
		'think_tank_obj' => $think_tank_obj,
		'amount'         => (int) $amount,
		'amount_min'     => (int) $amount_min,
		'amount_max'     => (int) $amount_max,
		'amount_calc'    => (int) $amount_calc,
		'type'           => $type,
		'type_obj'       => $type_obj,
		'year'           => $year,
		'disclosed'      => $disclosed,
		'data_notes'     => $data_notes,
		'source'         => $source,
	);
	return $transaction;
}

/**
 * Get the transaction
 *
 * @param  array  $source_args
 * @param  object $block_instance
 * @param  string $attribute_name
 * @return void
 */
function think_tank_transactions( array $source_args, $block_instance, string $attribute_name ) {
	global $post;
	$post_id   = $block_instance->context['postId'];
	$post_type = $block_instance->context['postType'];

	$data   = get_think_tank_data( $block_instance->context['postId'] );
	$output = get_think_tank_output( $block_instance->context['postId'] );
	// If no key or user ID argument is set, bail early.
	// if ( ! isset( $source_args['key'] ) || ! isset( $source_args['userId'] ) ) {
	// return null;
	// }

	// // Get the user ID.
	// $user_id = absint( $source_args['userId'] );

	// // Return null if there's no user ID at all.
	// if ( 0 >= $user_id ) {
	// return null;
	// }

	// // Return the data based on the key argument.
	// switch ( $source_args['key'] ) {
	// case 'name':
	// return esc_html( get_the_author_meta( 'display_name', $user_id ) );
	// case 'description':
	// return get_the_author_meta( 'description', $user_id );
	// case 'avatar':
	// return esc_url( get_avatar_url( $user_id ) );
	// default:
	// return 'default';
	// }
	// var_dump( $output );

	return $output;
}
