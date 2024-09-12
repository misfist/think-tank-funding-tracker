/**
 * Add Search Attribute to Search
 * Learn more: https://developer.wordpress.org/news/2023/08/29/an-introduction-to-block-variations/
 */

function addSearchProp( props ) {
    return {
        ...props,
        query: { 
            wdt_search: ''
        },
    };
}

wp.hooks.addFilter(
    'blocks.getSaveContent.extraProps',
    'core/search',
    addSearchProp
);
