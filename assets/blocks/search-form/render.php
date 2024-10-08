<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 * 
 * PHP file to use when rendering the block type on the server to show on the front end. The following variables are exposed to the file:
 * 
 * $attributes (array): The block attributes.
 * $content (string): The block default content.
 * $block (\WP_Block): The block instance.
 */
use function Quincy\ttft\custom_search_form;

$description = $attributes['description'] ?? '';
$args = array(
	'description' => $description,
);
?>

<div <?php echo get_block_wrapper_attributes(); ?>>
	<?php echo custom_search_form( $args ); ?>
</div>
