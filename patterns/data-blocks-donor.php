<?php
/**
 * Title: Data Blocks - Donor
 * Slug: ttt/data-blocks-donor
 * Categories: transparency
 * Inserter: false
 */
$post_id         = get_the_ID();
$donor_term      = wp_get_post_terms( $post_id, 'donor' );
$donor_type_term = wp_get_post_terms( $post_id, 'donor_type' );
