<?php
/**
 * Search Form
 *
 * @package ttft
 */

namespace Quincy\ttft;

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
