<?php
/**
 * Search Form
 *
 * @package ttt
 */

namespace Quincy\ttt;

function get_search_form( string $form, array $args ): string {
	ob_start();
	?>

	<form role="search" method="get" action="<?php echo get_home_url(); ?>"
		class="wp-block-search__button-inside wp-block-search__icon-button wp-block-search">
		<label class="wp-block-search__label screen-reader-text" for="wp-block-search__input-3"><?php esc_html_e( 'Search', 'ttt' ); ?></label>
		<div class="wp-block-search__inside-wrapper " style="width: 100%">
			<select id="search-filters" class="wp-block-search__filters" name="filter-options">
				<option value=""><?php esc_attr_e( 'All', 'ttt' ); ?></option>
				<option value="think_tank"><?php esc_attr_e( 'Think Tanks', 'ttt' ); ?></option>
				<option value="donor"><?php esc_attr_e( 'Donors', 'ttt' ); ?></option>
			</select>
			<input class="wp-block-search__input" id="wp-block-search__input-3" placeholder="<?php esc_attr_e( 'Search by Think Tank or Donor', 'ttt' ); ?>"
				value="" type="search" name="s" required="" style="border-radius: 0px">
			<button aria-label="Search"
				class="wp-block-search__button has-text-color has-contrast-color has-icon wp-element-button" type="submit"
				style="border-radius: 0px">
				<svg class="search-icon" viewBox="0 0 24 24" width="24" height="24">
					<path
						d="M13 5c-3.3 0-6 2.7-6 6 0 1.4.5 2.7 1.3 3.7l-3.8 3.8 1.1 1.1 3.8-3.8c1 .8 2.3 1.3 3.7 1.3 3.3 0 6-2.7 6-6S16.3 5 13 5zm0 10.5c-2.5 0-4.5-2-4.5-4.5s2-4.5 4.5-4.5 4.5 2 4.5 4.5-2 4.5-4.5 4.5z">
					</path>
				</svg>
			</button>

		</div>
		<legend class="has-small-font-size"><?php esc_html_e( 'Examples: Lockheed Martin, Mitsubishi, United Arab Emirates, U.S. Government', 'ttt' ); ?></legend>
	</form>

	<?php
	$form = ob_get_clean();

	return $form;
}
add_filter( 'get_search_form', __NAMESPACE__ . '\get_search_form', '', 2 );
