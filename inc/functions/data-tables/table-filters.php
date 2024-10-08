<?php
/**
 * Functions.
 *
 * @package ttft
 */

namespace Quincy\ttft;

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
 * Generate filter markup
 *
 * @param  array $years
 * @return string
 */
function generate_year_filters( $years ): string {
	ob_start();

	if ( $years ) {
		$input_type = 'radio';
		$input_name = 'year-filter';
		$selected   = $context[ $state_key ];
		$options    = $context['options'];
		$all        = array( 'all', __( 'All', 'ttft-data-tables' ) );
		array_unshift( $years, 'all' );
		?>
		<div 
			data-wp-interactive="<?php echo APP_NAMESPACE; ?>"
			class="filter-group year"
			data-wp-watch="callbacks.log"
			data-wp-bind--year='state.donationYear'
		>
			<?php
			foreach ( $years as $year ) :
				$input_id = "{$input_type}-{$year}";
				?>
				<input 
					type=<?php echo $input_type; ?> 
					id=<?php echo $input_id; ?> 
					name=<?php echo $input_name; ?> 
					class="filter-checkbox" 
					value="<?php echo esc_attr( trim( $year ) ); ?>"
					data-wp-bind--checked="state.isSelected"
					data-wp-bind--year='state.donationYear'
					data-query-var=<?php echo add_query_arg( 'donation_year', $year ); ?> 
					data-wp-on--click="actions.updateYear"
					data-wp-interactive-key="<?php echo esc_attr( 'donationYear' ); ?>"
				/>
				<label for="filter-year-<?php echo esc_attr( trim( $year ) ); ?>">
					<?php echo strtoupper( esc_attr( trim( $year ) ) ); ?>
				</label>
				<?php
			endforeach;
			?>
		</div>
		<?php
	}

	$output = ob_get_clean();

	$processed_output = wp_interactivity_process_directives( $output );

	return $processed_output;
}

/**
 * Generate filter markup
 *
 * @param  array $types
 * @return string
 */
function generate_type_filters( $types ): string {
	ob_start();

	if ( $types ) {
		$all   = array( 'all', __( 'All', 'ttft-data-tables' ) );
		$types = $all + $types;
		?>
		<div 
			class="filter-group type"
			data-wp-interactive="<?php echo APP_NAMESPACE; ?>"
			data-wp-watch="callbacks.log"
			data-wp-bind--year='state.donorType'
		>
			<?php
			foreach ( $types as $type ) :
				?>
				<input 
					type="radio" 
					id="filter-<?php echo esc_attr( $type->slug ); ?>" 
					name="filter-type" 
					class="filter-checkbox" 
					value="<?php echo esc_attr( $type->slug ); ?>" 
					data-query-var="donor_type='<?php echo esc_attr( $type->slug ); ?>'" 
					data-wp-on--click="actions.updateType"
					data-wp-interactive-key="<?php echo esc_attr( 'donorType' ); ?>"
					data-wp-interactive-value="<?php echo esc_attr( $type->slug ); ?>"
				/>
				<label for="filter-<?php echo esc_attr( $type->slug ); ?>">
					<?php echo esc_html( $type->name ); ?>
				</label>
				<?php
			endforeach;
			?>
			</div>
		<?php
	}

	$output = ob_get_clean();

	return $output;
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

	echo generate_year_filters( $years );
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

	echo generate_year_filters( $years );
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

	echo generate_type_filters( $types );
}
