<?php

/**
 * List speakers
 * @param  array  $attributes shortcode attributes
 * @return string HTML content string
 */
add_shortcode( 'speaker_list', 'sf_speaker_list' );
function sf_speaker_list( $attributes ) {
    $shortcode_attributes = shortcode_atts( array (
        'post_type'         => 'summit_speaker',
        'cat'               => NULL,
        'category_name'     => NULL,
        'category__in'      => array(),
        'tag'               => NULL,
        'tag_id'            => NULL,
        'tag__in'           => array(),
        'tag_slug__in'      => array(),
        'orderby'           => 'post_title',
        'order'             => 'ASC',
        'posts_per_page'    => -1,
    ), $attributes );

    // set up query
    $list_args = array(
        'post_type'         => $shortcode_attributes['post_type'],
        'cat'               => $shortcode_attributes['cat'],
        'category_name'     => $shortcode_attributes['category_name'],
        'category__in'      => $shortcode_attributes['category__in'],
        'tag'               => $shortcode_attributes['tag'],
        'tag_id'            => $shortcode_attributes['tag_id'],
        'tag__in'           => $shortcode_attributes['tag__in'],
        'tag_slug__in'      => $shortcode_attributes['tag_slug__in'],
        'orderby'           => $shortcode_attributes['orderby'],
        'order'             => $shortcode_attributes['order'],
        'posts_per_page'    => $shortcode_attributes['posts_per_page'],
    );

    $list_query = new WP_Query( $list_args );

    // loop
    ob_start();
    if ( $list_query->have_posts() ) {
        echo '<section class="speaker-wrapper ' . implode( ' ', get_post_class() ) . '">';
        while ( $list_query->have_posts() ) {
            $list_query->the_post();
            include( plugin_dir_path( __FILE__ ) . '../templates/individual-speaker.php' );
        }
        echo '</section>';
    }
    $shortcode_content = ob_get_clean();
    wp_reset_postdata();

    return $shortcode_content;
}

/**
 * List downloads
 * @param  array  $attributes shortcode attributes
 * @return string HTML content string
 */
add_shortcode( 'member_downloads', 'sf_member_downloads' );
function sf_member_downloads( $attributes ) {
    $shortcode_attributes = shortcode_atts( array (
        'post_type'         => 'summit_speaker',
        'cat'               => NULL,
        'category_name'     => NULL,
        'category__in'      => array(),
        'tag'               => NULL,
        'tag_id'            => NULL,
        'tag__in'           => array(),
        'tag_slug__in'      => array(),
        'orderby'           => 'post_title',
        'order'             => 'ASC',
        'posts_per_page'    => -1,
    ), $attributes );

    // set up query
    $downloads_args = array(
        'post_type'         => $shortcode_attributes['post_type'],
        'cat'               => $shortcode_attributes['cat'],
        'category_name'     => $shortcode_attributes['category_name'],
        'category__in'      => $shortcode_attributes['category__in'],
        'tag'               => $shortcode_attributes['tag'],
        'tag_id'            => $shortcode_attributes['tag_id'],
        'tag__in'           => $shortcode_attributes['tag__in'],
        'tag_slug__in'      => $shortcode_attributes['tag_slug__in'],
        'orderby'           => $shortcode_attributes['orderby'],
        'order'             => $shortcode_attributes['order'],
        'posts_per_page'    => $shortcode_attributes['posts_per_page'],
        'meta_query'    => array(
            array(
                'key'      => 'video_download_url',
                'compare'  => 'EXISTS',
            ),
            array(
                'key'      => 'video_download_url',
                'value'    => '',
                'compare'  => '!=',
            ),
    ),
    );

    $downloads_query = new WP_Query( $downloads_args );

    // loop
    ob_start();
    if ( $downloads_query->have_posts() ) {
        echo '<section class="speaker-wrapper ' . implode( ' ', get_post_class() ) . '">';
        while ( $downloads_query->have_posts() ) {
            $downloads_query->the_post();
            $download = true;
            include( plugin_dir_path( __FILE__ ) . '../templates/individual-speaker.php' );
        }
        echo '</section>';
    }
    $shortcode_content = ob_get_clean();
    wp_reset_postdata();

    return $shortcode_content;
}
