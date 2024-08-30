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
			
				<input type="radio" name="filter-year" id="filter-all" class="filter-checkbox" value="all" data-index="<?php echo intval( $column ); ?>" checked />
				<label for="filter-all">
					<?php esc_html_e( 'All', 'ttt' ); ?>
				</label>
			<?php
			foreach ( $years as $year ) :
				$url = esc_url( add_query_arg( "wdt_column_filter[$column]", $year, get_permalink( $post_id ) ) );
				?>
				
					<input type="radio" id="filter-<?php echo esc_attr( $year ); ?>" name="filter-year" class="filter-checkbox" value="<?php echo esc_attr( $year ); ?>" data-query-var="wdt_column_filter[<?php echo intval( $column ); ?>]=<?php echo esc_attr( $year ); ?>" data-index="<?php echo intval( $column ); ?>" />
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
			<input type="radio" id="filter-type-all" name="filter-type" class="filter-checkbox" value="all" data-index="<?php echo intval( $column ); ?>" checked />
			<label for="filter-type-all">
				<?php esc_html_e( 'All', 'ttt' ); ?>
			</label>
			<?php
			foreach ( $types as $type ) :
				?>
				<input type="radio" id="filter-<?php echo esc_attr( $type->name ); ?>" name="filter-type" class="filter-checkbox" value="<?php echo esc_attr( $type->name ); ?>" data-query-var="wdt_column_filter[<?php echo intval( $column ); ?>]='<?php echo esc_attr( $type->name ); ?>'" data-index="<?php echo intval( $column ); ?>" />
				<label for="filter-<?php echo esc_attr( $type->name ); ?>">
					<?php echo esc_html( $type->name ); ?>
				</label>
				<?php
			endforeach;
			?>
		</div>
		
		<?php
	}
}