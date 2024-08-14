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
