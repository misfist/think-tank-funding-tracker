<?php
/**
 * Block variations.
 *
 * @package ttt
 */

namespace Quincy\ttt;

/**
 * Register Blocks Styles
 * 
 * @link https://developer.wordpress.org/block-editor/reference-guides/block-api/block-styles/
 */
register_block_style(
    'core/paragraph',
    array(
        'name'         => 'intro',
        'label'        => __( 'Intro', 'ttt' )
    )
);

register_block_style(
    'core/group',
    array(
        'name'         => 'score-0',
        'label'        => __( 'Score 0', 'ttt' )
    )
);
register_block_style(
    'core/group',
    array(
        'name'         => 'score-1',
        'label'        => __( 'Score 1', 'ttt' )
    )
);
register_block_style(
    'core/group',
    array(
        'name'         => 'score-2',
        'label'        => __( 'Score 2', 'ttt' )
    )
);
register_block_style(
    'core/group',
    array(
        'name'         => 'score-3',
        'label'        => __( 'Score 3', 'ttt' )
    )
);
register_block_style(
    'core/group',
    array(
        'name'         => 'score-4',
        'label'        => __( 'Score 4', 'ttt' )
    )
);
register_block_style(
    'core/group',
    array(
        'name'         => 'score-5',
        'label'        => __( 'Score 5', 'ttt' )
    )
);
