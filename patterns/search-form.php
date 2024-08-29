<?php
/**
 * Title: Search Form
 * Slug: ttt/search-form
 * Categories: Search
 */
$search = get_search_query();
?>

<!-- wp:group {
	"metadata": {
		"name": "Search Wrapper"
	},
	"backgroundColor": "base-2",
	"layout": {
		"type": "default"
	}
} -->
<div class="wp-block-group has-base-2-background-color has-background">

	<?php get_search_form(); ?>
	
</div>
<!-- /wp:group -->