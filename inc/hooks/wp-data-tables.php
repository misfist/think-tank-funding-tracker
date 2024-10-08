<?php
/**
 * wpDataTables Mods.
 *
 * @package ttft
 */

namespace Quincy\ttft;

/**
 * Replace placeholders in description
 *
 * %VAR1% = think_tank
 * %VAR2% = donor
 * %VAR3% = donation_year
 * %VAR4% = donor_type
 * %VAR5% = limit
 *
 * @param  string $text
 * @return string
 */
function filter_table_description_text( string $text ): string {
	global $wdtVar1, $wdtVar2, $wdtVar3, $wdtVar4, $wdtVar5;
	if ( str_contains( $text, '%VAR1%' ) && $wdtVar1 ) {
		$text = str_replace( '%VAR1%', $wdtVar1, $text );
	}
	if ( str_contains( $text, '%VAR2%' ) && $wdtVar2 ) {
		$text = str_replace( '%VAR2%', $wdtVar2, $text );
	}
	if ( str_contains( $text, '%VAR3%' ) && $wdtVar3 ) {
		$text = str_replace( '%VAR3%', $wdtVar3, $text );
	}
	if ( str_contains( $text, '%VAR4%' ) && $wdtVar4 ) {
		$text = str_replace( '%VAR4%', $wdtVar4, $text );
	}
	if ( str_contains( $text, '%VAR5%' ) && $wdtVar5 ) {
		$text = str_replace( '%VAR5%', $wdtVar5, $text );
	}
	return $text;
}
add_filter( 'wpdatatables_filter_table_description_text', __NAMESPACE__ . '\filter_table_description_text' );

/**
 * Get query vars
 *
 * %VAR1% = think_tank
 * %VAR2% = donor
 * %VAR3% = donation_year
 * %VAR4% = donor_type
 * %VAR5% = limit
 *
 * @return array
 */
function get_vars(): array {

	$placeholder_vars = array(
		'think_tank' => 'wdt_var1',
		'donor'      => 'wdt_var2',
		'year'       => 'wdt_var3',
		'type'       => 'wdt_var4',
		'limit'      => 'wdt_var5',
	);

	$vars = array();

	foreach ( $placeholder_vars as $key => $value ) {
		if ( isset( $_GET[ $value ] ) ) {
			$vars[ $key ] = urldecode( sanitize_text_field( $_GET[ $value ] ) );
		}
	}

	return $vars;
}

/**
 * Modify fonts available
 *
 * @param  array $fonts
 * @return array
 */
function get_system_fonts( array $fonts ): array {
	$fonts = array(
		'Inter, sans-serif',
	);
	return $fonts;
}
add_filter( 'wpdatatables_get_system_fonts', __NAMESPACE__ . '\get_system_fonts' );

/**
 * Modify table classes
 *
 * @param  array $classes
 * @param  int   $table_id
 * @return array
 */
function filter_table_cssClassArray( array $classes, $table_id ): array {
	/**
	 * Top 10
	 */
	if ( 9 === $table_id ) {
		$classes[] = 'top-10';
	}
	return $classes;
}
add_filter( 'wpdatatables_filter_table_cssClassArray', __NAMESPACE__ . '\filter_table_cssClassArray', '', 2 );

/**
 * Undocumented function
 *
 * @link https://wpdatatables.com/documentation/information-for-developers/filters/#wpdatatables_filter_cell_val_val_tableId
 *
 * @param  mixed $val
 * @param  int   $table_id
 * @return mixed
 */
function filter_cell_val( $val, $table_id ) {
	return $val;
}
add_filter( 'wpdatatables_filter_cell_val', __NAMESPACE__ . '\filter_cell_val', '', 2 );

/**
 * Filter title
 *
 * @param  [type] $table_title
 * @param  [type] $table_id
 * @return string
 */
function filter_table_title( $table_title, $table_id ): string {
	return $table_title;
}
// add_filter( 'wpdatatables_filter_table_title', __NAMESPACE__ . '\filter_table_title', '', 2 );

function add_description( $table_id ) {
	echo 'wpdatatables_before_get_columns_metadata';
}
// add_action( 'wpdatatables_before_get_columns_metadata', __NAMESPACE__ . '\add_description' );

function filter_table_description( $object, $table_id, $table_instance ) {
	return $object;
}
// add_filter( 'wpdatatables_filter_table_description', __NAMESPACE__ . '\filter_table_description', '', 3 );





// wpdatatables_before_table( $tableId )
// wpdatatables_before_header( $tableId )
// wpdatatables_before_row( $tableId, $rowIndex )
// wpdatatables_before_first_row( $tableId )
// wpdatatables_before_get_table_metadata( $tableId )
// wpdatatables_before_get_columns_metadata( $tableId )
