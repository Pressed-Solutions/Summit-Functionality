#Introduction

A simple plugin to add summit functionality.

#Usage

- Install the plugin
- Use shortcodes as necessary

#Other Notes

##Available shortcodes:

###`[speaker_list]`

- Displays speaker photo, name, and talk title; accepts these arguments listed below

###`[member_downloads]`

- Displays speaker photo, name, talk title, and link to download (only if a download is specified); accepts these arguments listed below

##Shortcode arguments

If no default is listed here, the parameter defaults to NULL. For more info, see [WP_Query reference](https://developer.wordpress.org/reference/classes/wp_query/).

    - `post_type` (defaults to 'summit_speaker')
    - `p`
    - `title`
    - `pagename`
    - `post_parent`
    - `post_parent__in`
    - `post_parent_not__in`
    - `post__in`
    - `post__not_in`
    - `post_name__in`
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

- 1.2
    - Add more `WP_Query` paramaters

- 1.1
    - Add `[member_downloads]` shortcode to list all available downloads
    - Add `offset` paramater support to `[speaker_list]` shortcode

- 1.0
    - Add “summit_speaker” custom post type
    - Add `[speaker_list]` shortcode
