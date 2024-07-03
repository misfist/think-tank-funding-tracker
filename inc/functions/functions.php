<?php
/**
 * Functions.
 *
 *
 * @package ttt
 */

namespace Quincy\ttt;

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
			// var_dump( $column );

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
	$transactions = get_think_tank_transactions( $post_slug );
	return $transactions;
}

/**
 * Get the transactions
 *
 * @param  string $post_slug
 * @return array
 */
function get_think_tank_transactions( $post_slug ) : array {
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


function get_think_tank_transaction( $post_id = 0 ) {
	global $post;
	$donation_year    = wp_get_post_terms( $post_id, 'year', array( 'number' => 1 ) );
	$post_id          = ( $post_id ) ? $post_id : $post->ID;
	$donor            = wp_get_post_terms( $post_id, 'donor', array( 'number' => 1 ) );
	$amount           = get_post_meta( $post_id, 'actual_calc', true );
	$data_notes       = get_post_meta( $post_id, 'source_notes', true );
	$disclosed        = get_post_meta( $post_id, 'disclosed', true );
	$source           = get_post_meta( $post_id, 'source', true );
	$type             = wp_get_post_terms( $post_id, 'donor_type', array( 'number' => 1 ) );
	$year             = ( ! empty( $donation_year ) && ! is_wp_error( $donation_year ) ) ? $donation_year : (int) get_post_meta( $post_id, 'year', true );
	$formatted_amount = ( $amount ) ? (int) $amount : '-';
	$transaction      = array(
		'donor'      => $donor,
		'amount'     => number_format( (float) $formatted_amount ),
		'type'       => $type,
		'year'       => $year,
		'disclosed'  => $disclosed,
		'data_notes' => $data_notes,
		'source'     => $source,
	);
	return $transaction;
}

function get_think_tank_source( $post_id = 0 ) {
	global $post;
	$post_id = ( $post_id ) ? $post_id : get_the_ID();
}

function get_donor_data() {}

add_action( 'init', __NAMESPACE__ . '\projectslug_register_block_bindings' );

function projectslug_register_block_bindings() {
	register_block_bindings_source(
		'ttt/transactions-think-tank',
		array(
			'label'              => __( 'Think Tank Transactions', 'ttt' ),
			'get_value_callback' => __NAMESPACE__ . '\think_tank_transactions',
		)
	);
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

/**
 * Filter table
 *
 * @param  array $data
 * @return array
 */
function filter_tables( $data ) : array {
	global $post;
	$title = get_post_field( 'post_title', $post );

	if ( 'think_tank' === $post->post_type ) {
		$data['filter']        = $title;
		$data['filter_column'] = 'transactionthinktank';
		// $data['columns']       = 'transactiondonor,transactiondonationyear,actual_calc,transactiondonortype,data_notes,source';
	} elseif ( 'donor' === $post->post_type ) {
		$data['filter']        = $title;
		$data['filter_column'] = 'transactiondonor';
		// $data['columns']       = 'transactionthinktank,transactiondonationyear,actual_calc,transactiondonortype,data_notes,source';
	}

	return $data;
}
add_filter( 'ninja_tables_shortcode_data', __NAMESPACE__ . '\filter_tables' );

/**
 * Format calculation field
 *
 * @param  array $formatted_data
 * @param  int   $table_id
 * @return array
 */
function format_number_values( $formatted_data, $table_id ) : array {
	foreach ( $formatted_data as $index => $value ) {
		if ( isset( $value['actual_calc'] ) && '#N/A' != $value['actual_calc'] ) {
			$amount                                  = (int) $value['actual_calc'];
			$formatted_data[ $index ]['actual_calc'] = ( $amount > 0 ) ? '$' . number_format( (float) $amount ) : '';
		}
	}
	return $formatted_data;
}
add_filter( 'ninja_tables_get_public_data', __NAMESPACE__ . '\format_number_values', '', 2 );


add_filter(
	'breadcrumb_block_get_breadcrumb_trail',
	function ( $markup, $args, $breadcrumbs_instance ) {
		// var_dump( $markup, $args );
		return $markup;
	},
	10,
	3
);

add_filter(
	'breadcrumb_block_get_items',
	function ( $items, $breadcrumbs_instance ) {
		// var_dump( $items, $breadcrumbs_instance );
		return $items;
	},
	10,
	2
);

function data_filter( $query, $table_id ) {
	var_dump( $query );
	return $query;
}
add_filter( 'ninja_table_own_data_filter_query', __NAMESPACE__ . '\data_filter', 10, 2 );


add_filter(
	'breadcrumb_block_get_item',
	function ( $item_args, $context, $breadcrumbs_instance ) {
		// Ignore items without context.
		if ( ! $context || ! ( $context['object'] ?? false ) ) {
			// var_dump( $context );
		}

		// // Eg: remove a term.
		// if ( 'term' === ( $context['type'] ?? '' ) && 'term-slug' === $context['object']->slug ) {
		// return false;
		// }

		// // Eg: Change the title of a page.
		// if ( 'page' === ( $context['type'] ?? '' ) && page_id_to_change === $context['object']->ID ) {
		// $item_args[0] = 'Make it shorter';
		// }

		return $item_args;
	},
	10,
	3
);

function filter_query( $query, $table_id ) {
	global $post;
	if ( $post && is_a( $post, '\WP_Post' ) ) {
		$find      = '%%';
		$replace   = "%{$post->post_title}%";
		$new_query = str_replace( $find, $replace, $query );
		// var_dump( $new_query );

		return $new_query;
	}
	// var_dump( $query );

	return $query;
}
add_filter( 'wpdatatables_filter_mysql_query', __NAMESPACE__ . '\filter_query', '', 2 );
