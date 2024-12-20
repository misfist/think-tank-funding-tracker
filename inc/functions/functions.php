<?php
/**
 * Functions.
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
function custom_search_form( $args = array() ): string {
    $defaults = array(
        'description' => esc_html__( 'Examples: Lockheed Martin, Brookings Institution, US Department of Defense ', 'ttft' ),
        'ajax'        => true,
    );

    $args = wp_parse_args( $args, $defaults );

	$description = esc_html( $args['description'] );
	$ajax        = $args['ajax'];

	$instance_id = uniqid();
	$entity_type = sanitize_text_field( $_GET['entity_type'] ?? '' );
    
	ob_start();
    
	if ( ! $args['ajax'] || ! function_exists( 'wpd_get_terms' ) ) :
		?>

        <?php echo custom_search_form_default( $args ); ?>
       
		<?php
	else :
		?>
		
        <?php echo custom_search_form_ajax( $args ); ?>

		<?php
	endif;

	$form = ob_get_clean();

	return $form;
}

/**
 * Retun search form with ajax
 *
 * @param  array $args
 * @return string
 */
function custom_search_form_ajax( $args ): string {
    $instance_id = uniqid();
	$description = ( isset( $args['description'] ) ) ? esc_html( $args['description'] ) : '';
    ob_start();
    ?>
        <div 
            id="search-<?php echo $instance_id; ?>" 
            class="wp-block-search__button-inside wp-block-search__icon-button wp-block-search transaction-search-form" 
            style="margin-top:var(--wp--preset--spacing--40);" 
            data-instance-id="<?php echo $instance_id; ?>"
        >
			<?php echo do_shortcode( '[wd_asp id=1]' ); ?>

			<legend class="has-small-font-size screen-reader-text">
				<?php echo $description; ?>
			</legend>
		</div>
    <?php
    $form = ob_get_clean();

    return $form;
}

/**
 * Return search form with default
 *
 * @param  array $args
 * @return string
 */
function custom_search_form_default( $args ): string {
	$filters = array(
		''           => __( 'All', 'ttft' ),
		'think_tank' => __( 'Think Tank', 'ttft' ),
		'donor'      => __( 'Donor', 'ttft' ),
	);
	
    $instance_id = uniqid();
	$entity_type = sanitize_text_field( $_GET['entity_type'] ?? '' );
    ob_start();
    ?>
         <form 
            id="search-<?php echo $instance_id; ?>" 
            role="search" 
            method="get" 
            action="<?php echo esc_url( home_url( '/' ) ); ?>"
			class="wp-block-search__button-inside wp-block-search__icon-button wp-block-search transaction-search-form" 
            style="margin-top:var(--wp--preset--spacing--40);"
        >
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
			<?php
			if ( ! empty( $args['description'] ) ) :
				?>
				<legend class="has-small-font-size">
					<?php echo esc_html( $args['description'] ); ?>
				</legend>
				<?php 
			endif; 
			?>
		</form>
    <?php
    $form = ob_get_clean();

    return $form;
}
