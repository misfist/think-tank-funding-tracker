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
function get_years( $name, $type = 'donor' ) : array {
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
function print_years( $name = '', $type = 'donor', $column = 2 ) : void {
	global $post;
	$post_id = $post->ID;
	$type    = $post->post_type;
	$name    = ( $name ) ? $name : $post->post_title;
	$years   = get_years( $name, $type );

	if ( $years ) {
		?>
		<ul>
			<li data-year="all"><a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>"><?php esc_html_e( 'All', 'ttt' ); ?></a><li>
			<?php
			foreach ( $years as $year ) :
				$url = esc_url( add_query_arg( "wdt_column_filter[$column]", $year, get_permalink( $post_id ) ) );
				?>
				<li data-year="<?php echo esc_attr( $year ); ?>"><a href="<?php echo $url; ?>"><?php echo esc_html( $year ); ?></a><li>
				<?php
			endforeach;
			?>
		</ul>
		
		<?php
	}
}
