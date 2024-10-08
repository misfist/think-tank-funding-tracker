<?php
/**
 * Title: Search Results
 * Slug: ttft/search-results
 * Categories: Search
 */
$entity_type = isset( $_GET['entity_type'] ) ? sanitize_text_field( $_GET['entity_type'] ) : 'donor';
$search_term = get_search_query();
