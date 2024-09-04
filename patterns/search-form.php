<?php
/**
 * Title: Search Form
 * Slug: ttt/search-form
 * Categories: Search
 */
$search = get_search_query();
?>
<!-- wp:shortcode -->
<?php echo do_shortcode( "[search_form]", true ); ?>
<!-- /wp:shortcode -->