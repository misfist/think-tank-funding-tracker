<?php
/**
 * Ninja Tables Mods.
 *
 * @package ttt
 */

namespace Quincy\ttt;


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
		if ( isset( $value['amount_calc'] ) && '#N/A' != $value['amount_calc'] ) {
			$amount                                  = (int) $value['amount_calc'];
			$formatted_data[ $index ]['amount_calc'] = ( $amount > 0 ) ? '$' . number_format( (float) $amount ) : '';
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
