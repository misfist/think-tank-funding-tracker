<?php
/**
 * Search Form
 *
 * @package ttft
 */

namespace Quincy\ttft;

/**
 * Custom search form
 *
 * @param  array $args
 * @return string
 */
function custom_search_form( $args ): string {
	$filters = array(
		''           => __( 'All', 'ttft' ),
		'think_tank' => __( 'Think Tank', 'ttft' ),
		'donor'      => __( 'Donor', 'ttft' ),
	);

	$description = ( isset( $args['description'] ) && $args['description'] ) ? esc_html( $args['description'] ) : esc_html__( ' Examples: Lockheed Martin, Brookings Institution, US Department of Defense ', 'ttft' );
	$ajax        = ( isset( $args['ajax'] ) && $args['ajax'] ) ? true : false;

	$instance_id = uniqid();
	$entity_type = sanitize_text_field( $_GET['entity_type'] ?? '' );
	ob_start();
	if ( $ajax ) :
		?>
		<div class="wp-block-search__button-inside wp-block-search__icon-button wp-block-search transaction-search-form" style="margin-top:var(--wp--preset--spacing--40);" data-instance-id="<?php echo $instance_id; ?>">
			<?php echo do_shortcode( '[wpdreams_ajaxsearchpro id=1]' ); ?>

			<legend class="has-small-font-size">
				<?php echo $description; ?>
			</legend>
		</div>
		<?php
	else :
		?>
		<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>"
			class="wp-block-search__button-inside wp-block-search__icon-button wp-block-search transaction-search-form" style="margin-top:var(--wp--preset--spacing--40);">
			<label class="wp-block-search__label screen-reader-text" for="search-term">
				<?php esc_html_e( 'Search', 'ttft' ); ?>
			</label>
			<div class="wp-block-search__inside-wrapper " style="width: 100%">
				<label for="taxonomy-filter-<?php echo intval( $instance_id ); ?>" class="screen-reader-text">
					<?php _e( 'Filter by:', 'ttft' ); ?>
				</label>
				<select id="taxonomy-filter-<?php echo intval( $instance_id ); ?>" class="wp-block-search__filters taxonomy-filter" name="entity_type">
					<?php
					foreach ( $filters as $key => $label ) :
						?>
						<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $entity_type, $key ); ?>>
							<?php echo esc_html( $label ); ?>
						</option>
					<?php endforeach; ?>
				</select>
				<input id="search-term" class="wp-block-search__input"
					placeholder="<?php esc_attr_e( 'Search by Think Tank or Donor', 'ttft' ); ?>"
					value="<?php echo get_search_query(); ?>" type="search" name="s">
				
					<button aria-label="Search"
						class="wp-block-search__button has-text-color has-contrast-color has-icon wp-element-button search-submit"
						type="submit">
						<svg class="search-icon" viewBox="0 0 24 24" width="24" height="24">
							<path
								d="M13 5c-3.3 0-6 2.7-6 6 0 1.4.5 2.7 1.3 3.7l-3.8 3.8 1.1 1.1 3.8-3.8c1 .8 2.3 1.3 3.7 1.3 3.3 0 6-2.7 6-6S16.3 5 13 5zm0 10.5c-2.5 0-4.5-2-4.5-4.5s2-4.5 4.5-4.5 4.5 2 4.5 4.5-2 4.5-4.5 4.5z">
							</path>
						</svg>
					</button>
			</div>
			<legend class="has-small-font-size">
				<?php echo $description; ?>
			</legend>
		</form>
		<?php
	endif;

	$form = ob_get_clean();

	return $form;
}

/**
 * Filter display of search form
 *
 * @param  string $form
 * @param  array  $args
 * @return string
 */
function get_search_form( $form, $args ) {
	return custom_search_form( $args );
}
add_filter( 'get_search_form', __NAMESPACE__ . '\get_search_form', '', 2 );

/**
 * Add query var
 *
 * @link https://developer.wordpress.org/reference/hooks/query_vars/
 *
 * @param  array $query_vars
 * @return array
 */
function query_vars( $query_vars ): array {
	$query_vars[] = 'entity_type';
	return $query_vars;
}
add_filter( 'query_vars', __NAMESPACE__ . '\query_vars' );

/**
 * Modify Request
 *
 * @param  array $request
 * @return array
 */
function request( $request ): array {
	if ( isset( $_REQUEST['wdt_search'] ) ) {
		$request['s'] = $_REQUEST['wdt_search'];
	} elseif ( isset( $_REQUEST['s'] ) && ! isset( $_REQUEST['wdt_search'] ) ) {
		// $request['s'] = $_REQUEST['wdt_search'];
		$request['wdt_search'] = $_REQUEST['s'];
	}
	if ( ! isset( $_REQUEST['entity_type'] ) ) {
		$request['entity_type'] = $_REQUEST['think_tank'];
	}
	return $request;
}
// add_filter( 'request', __NAMESPACE__ . '\request' );

/**
 * AJAX Search Pro Settings
 *
 * @link https://knowledgebase.ajaxsearchpro.com/miscellaneous/post-types/showing-the-post-type-name-in-result-title
 *
 * @param  array $results
 * @return array
 */
function asp_show_the_post_type_title( $results ) {
	var_dump( $results );

	foreach ( $results as $k => &$r ) {
		if ( isset( $r->post_type ) ) {
			// Modify the post title
			$post_type_obj = get_post_type_object( $r->post_type );
			$r->title      = sprintf( '%s - %s', $r->title, $post_type_obj->labels->singular_name );
		}
	}

	return $results;
}
// add_filter( 'asp_results', __NAMESPACE__ . '\asp_show_the_post_type_title', 10, 1 );

// function asp_show_the_post_type_content( $results ) {

// foreach ( $results as $k => &$r ) {
// if ( isset( $r->post_type ) ) {
// Modify the post title
// $post_type_obj = get_post_type_object( $r->post_type );
// if( 'donor' === $r->post_type ) {
// $r->content = '{Donor Type}';
// } elseif( 'think_tank' === $r->post_type ) {
// $r->content = '{Transparency Score}';

// }
// }
// }

// return $results;
// }
// add_filter( 'asp_results', __NAMESPACE__ . '\asp_show_the_post_type_content', 10, 1 );

add_filter( 'asp_cpt_results', __NAMESPACE__ . '\asp_cpt_result_filter', 10, 3 );
function asp_cpt_result_filter( $results, $search_id, $args ) {

	// Parse through each result item
	foreach ( $results as $k => &$r ) {
		if ( isset( $r->post_type ) ) {
			$post_type_obj = get_post_type_object( $r->post_type );
			$r->title      = sprintf( '%s - %s', $r->title, $post_type_obj->labels->singular_name );
		}

		$transparency_score = get_post_meta( $r->id, 'transparency_score', true );
		if ( $transparency_score ) {
			$r->content = convert_star_rating( (int) $transparency_score );
		}

		$donor_type = get_post_meta( $r->id, 'donor_type', true );
		if ( $donor_type ) {
			$r->content = get_the_term_list( $r->id, 'donor_type', '', ', ' );
		}
		/**
		 * $r (stdClass object) {
		 *      'id' -> Post or other result object (taxonomy term, user etc..) ID,
			*      'title' -> Result title
			*      'content' -> Result content
			*      'post_type' -> Result post type (if available)
			*      'content_type' -> Content type (pagepost, user, term, attachment etc..)
		 * }
		 */
	}

	return $results;
}
