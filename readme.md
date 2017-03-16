#Introduction

A simple plugin to add summit functionality.

#Usage

- Install the plugin
- Use shortcodes as necessary

#Other Notes

Available shortcodes:

##`[speaker_list]`

- displays speaker photo, name, and talk title; accepts these arguments (see [WP_Query reference](https://developer.wordpress.org/reference/classes/wp_query/) for more info on defaults not specified here):
    - `post_type` (defaults to 'summit_speaker')
    - `cat`
    - `category_name`
    - `category__in`
    - `tag`
    - `tag_id`
    - `tag__in`
    - `tag_slug__in`
    - `orderby` (defaults to the post title)
    - `order` (defaults to 'ASC')
    - `posts_per_page` (defaults to -1 to show all)


#Changelog

- 1.0
    - Add “summit_speaker” custom post type
    - Add `[speaker_list]` shortcode
