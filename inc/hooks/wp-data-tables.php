<?php
/**
 * wpDataTables Mods.
 *
 * @package ttt
 */

namespace Quincy\ttt;

/**
 * Filter title
 *
 * @param  [type] $table_title
 * @param  [type] $table_id
 * @return string
 */
function filter_table_title( $table_title, $table_id ) : string {
	return $table_title;
}
// add_filter( 'wpdatatables_filter_table_title', __NAMESPACE__ . '\filter_table_title', '', 2 );

function add_description( $table_id ) {
	echo 'wpdatatables_before_get_columns_metadata';
}
// add_action( 'wpdatatables_before_get_columns_metadata', __NAMESPACE__ . '\add_description' );

function filter_table_description( $object, $table_id, $table_instance ) {
	// var_dump( $object );
	return $object;
}
add_filter( 'wpdatatables_filter_table_description', __NAMESPACE__ . '\filter_table_description', '', 3 );

function filter_table_cssClassArray( $classes, $table_id ) {
	// var_dump( $classes );
	return $classes;
}
add_filter( 'wpdatatables_filter_table_cssClassArray', __NAMESPACE__ . '\filter_table_cssClassArray', '', 2 );

function get_system_fonts( $fonts ) {
	$fonts = array(
		'Inter, sans-serif'
	);
	return $fonts;
}
add_filter( 'wpdatatables_get_system_fonts', __NAMESPACE__ . '\get_system_fonts' );

// wpdatatables_before_table( $tableId )
// wpdatatables_before_header( $tableId )
// wpdatatables_before_row( $tableId, $rowIndex )
// wpdatatables_before_first_row( $tableId )
// wpdatatables_before_get_table_metadata( $tableId )
// wpdatatables_before_get_columns_metadata( $tableId )