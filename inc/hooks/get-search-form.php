<?php
/**
 * Search Form
 *
 * @package ttt
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
	remove_filter( 'the_content', 'wpautop' );
	$filters     = array(
		''           => __( 'All', 'ttft' ),
		'think_tank' => __( 'Think Tank', 'ttft' ),
		'donor'      => __( 'Donor', 'ttft' ),
	);
	$instance_id = uniqid();
	$entity_type = sanitize_text_field( $_GET['entity_type'] );
	ob_start();
	?>
	<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>"
		class="wp-block-search__button-inside wp-block-search__icon-button wp-block-search transaction-search-form"><label class="wp-block-search__label screen-reader-text" for="search-term">
			<?php esc_html_e( 'Search', 'ttft' ); ?>
		</label>
		<div class="wp-block-search__inside-wrapper " style="width: 100%">
			<label for="taxonomy-filter-<?php echo intval( $instance_id ); ?>" class="screen-reader-text">
				<?php _e( 'Filter by:', 'ttft' ); ?>
			</label>
			<select id="taxonomy-filter-<?php echo intval( $instance_id ); ?>" class="wp-block-search__filters taxonomy-filter" name="entity_type">
				<?php foreach ( $filters as $key => $label ) : ?>
				<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $entity_type, $key ); ?>>
					<?php echo esc_html( $label ); ?>
				</option>
				<?php endforeach; ?>
			</select>
			<input id="search-term" class="wp-block-search__input"
				placeholder="<?php esc_attr_e( 'Search by Think Tank or Donor', 'ttft' ); ?>"
				value="<?php echo get_search_query(); ?>" type="search" name="s">
				<input id="table-search-term" value="<?php echo get_search_query(); ?>" type="search" name="wdt_search" hidden><button aria-label="Search"
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
			<?php esc_html_e( 'Examples: Lockheed Martin, Mitsubishi, United Arab Emirates, U.S. Government', 'ttft' ); ?>
		</legend>
	</form>
	<?php
	$form = ob_get_clean();

	add_filter( 'the_content', 'wpautop' );

	return $form;
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
	$query_vars[] = 'wdt_search';
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
