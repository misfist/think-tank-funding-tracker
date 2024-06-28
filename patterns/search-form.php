<?php
/**
 * Title: Search Form
 * Slug: ttt/search-form
 * Categories: Search
 */
?>

<!-- wp:group {
    "metadata": {
        "name": "Search Wrapper"
    },
    "style": {
        "spacing": {
            "padding": {
                "top": "var:preset|spacing|20",
                "bottom": "var:preset|spacing|20",
                "left": "var:preset|spacing|20",
                "right": "var:preset|spacing|20"
            }
        }
    },
    "backgroundColor": "base",
    "layout": {
        "type": "default"
    }
} -->
<div class="wp-block-group has-base-background-color has-background" style="padding-top:var(--wp--preset--spacing--20);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20);padding-left:var(--wp--preset--spacing--20)">
    <!-- wp:search {
        "label": "",
        "placeholder": "<?php echo esc_attr_e( 'Search by Think Tank or Donor', 'ttt' ); ?>",
        "width": 100,
        "widthUnit": "%",
        "buttonText": "Search",
        "buttonPosition": "button-inside",
        "buttonUseIcon": true,
        "style": {
            "border": {
                "radius": "0px"
            },
            "elements": {
                "link": {
                    "color": {
                        "text": "var:preset|color|contrast"
                    }
                }
            }
        },
        "backgroundColor": "base-2",
        "textColor": "contrast"
    } /-->

    <!-- wp:paragraph {
        "style": {
            "elements": {
                "link": {
                    "color": {
                        "text": "var:preset|color|contrast-2"
                    }
                }
            },
            "spacing": {
                "margin": {
                    "top": "0"
                }
            }
        },
        "textColor": "contrast-2",
        "fontSize": "small"
    } -->
    <p class="has-contrast-2-color has-text-color has-link-color has-small-font-size" style="margin-top:0">
        <?php esc_html_e( 'Examples: Lockheed Martin, Mitsubishi, United Arab Emirates, U.S. Government', 'ttt' ); ?>
    </p>
    <!-- /wp:paragraph -->
</div>
<!-- /wp:group -->