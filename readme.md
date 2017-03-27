# Introduction

A simple plugin to add summit functionality.

This plugin provides a “Summit Speakers” custom post type and adds a bunch of custom fields. add a category for each day of the summit, and specify the date in each category’s custom term meta.

Each speaker’s video and download link will show up only on the specified day for free users, and will show up on the specified day and thereafter for users who purchase access.

# Usage

- Install the plugin
- Add a category termm for the various event days, and add the date in the ACF date field on each category item
- Add speakers under the “Summit Speakers” CPT menu item
- Use the [supplied shortcodes](#available-shortcodes) as necessary to display speakers, downloads, etc.

# Other Notes

## Speaker Pages

To preview speaker’s pages with the protected content, log in as an administrator or editor and add the `?admin_preview=true` parameter to the URL.

## Available shortcodes:

### `[speaker_list]`

- Displays speaker photo, name, and talk title; accepts the arguments listed below

### `[member_downloads]`

- Displays speaker photo, name, talk title, and link to download (only if a download is specified); accepts the arguments listed below

### `[today_speakers]`

- Displays speaker photo, name, and talk title for speakers in today’s category; accepts the arguments listed below
- Supplies the `sf_purchase_link` filter for modifying the purchase page URL; defaults to `get_home_url() . '/purchase/'`

## Shortcode arguments

If no default is listed here, the parameter defaults to NULL. For more info, see [WP_Query reference](https://developer.wordpress.org/reference/classes/wp_query/).

- [`post_type`](https://developer.wordpress.org/reference/classes/wp_query/#post-type-parameters) (defaults to 'summit_speaker')
- [`p`](https://developer.wordpress.org/reference/classes/wp_query/#post-page-parameters)
- [`name`](https://developer.wordpress.org/reference/classes/wp_query/#post-page-parameters)
- [`post_parent`](https://developer.wordpress.org/reference/classes/wp_query/#post-page-parameters)
- [`post_parent__in`](https://developer.wordpress.org/reference/classes/wp_query/#post-page-parameters)
- [`post_parent_not__in`](https://developer.wordpress.org/reference/classes/wp_query/#post-page-parameters)
- [`post__in`](https://developer.wordpress.org/reference/classes/wp_query/#post-page-parameters)
- [`post__not_in`](https://developer.wordpress.org/reference/classes/wp_query/#post-page-parameters)
- [`post_name__in`](https://developer.wordpress.org/reference/classes/wp_query/#post-page-parameters)
- [`cat`](https://developer.wordpress.org/reference/classes/wp_query/#category-parameters)
- [`category_name`](https://developer.wordpress.org/reference/classes/wp_query/#category-parameters)
- [`category__in`](https://developer.wordpress.org/reference/classes/wp_query/#category-parameters)
- [`tag`](https://developer.wordpress.org/reference/classes/wp_query/#tag-parameters)
- [`tag_id`](https://developer.wordpress.org/reference/classes/wp_query/#tag-parameters)
- [`tag__in`](https://developer.wordpress.org/reference/classes/wp_query/#tag-parameters)
- [`tag_slug__in`](https://developer.wordpress.org/reference/classes/wp_query/#tag-parameters)
- [`orderby`](https://developer.wordpress.org/reference/classes/wp_query/#order-orderby-parameters) (defaults to the post title)
- [`order`](https://developer.wordpress.org/reference/classes/wp_query/#order-orderby-parameters) (defaults to 'ASC')
- [`posts_per_page`](https://developer.wordpress.org/reference/classes/wp_query/#pagination-parameters) (defaults to -1 to show all)
- [`offset`](https://developer.wordpress.org/reference/classes/wp_query/#pagination-parameters)


## Filters

- `sf_purchase_link`: purchase page URL; defaults to `get_home_url() . '/purchase/'`
- `sf_purchase_access_image`: purchase image shown at the bottom of each summit_speaker content; defaults to `get_stylesheet_directory_uri() . '/img/sales.png'`


# Changelog

- 1.4
    - Add time settings for content access
    - Improve access control using `memb_hasMembershipLevel` with a specified level instead of relying on `is_user_logged_in`

- 1.3
    - Add `[today_speakers]` shortcode

- 1.2
    - Add more `WP_Query` paramaters

- 1.1
    - Add `[member_downloads]` shortcode to list all available downloads
    - Add `offset` paramater support to `[speaker_list]` shortcode

- 1.0
    - Add “summit_speaker” custom post type
    - Add `[speaker_list]` shortcode
