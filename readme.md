# Introduction

A simple plugin to add summit functionality.

# Usage

- Install the plugin
- Use shortcodes as necessary

# Other Notes

## Available shortcodes:

### `[speaker_list]`

- Displays speaker photo, name, and talk title; accepts these arguments listed below

### `[member_downloads]`

- Displays speaker photo, name, talk title, and link to download (only if a download is specified); accepts these arguments listed below

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


# Changelog

- 1.2
    - Add more `WP_Query` paramaters

- 1.1
    - Add `[member_downloads]` shortcode to list all available downloads
    - Add `offset` paramater support to `[speaker_list]` shortcode

- 1.0
    - Add “summit_speaker” custom post type
    - Add `[speaker_list]` shortcode
