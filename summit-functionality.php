<?php
/*
 * Plugin Name: Summit Functionality
 * Plugin URI: https://bitbucket.org/pressedsolutions/summit-functionality
 * Description: Summit functionality including speakers, date-restricted video access, and more
 * Version: 1.0
 * Author: Pressed Solutions
 * Author URI: https://pressedsolutions.com
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
/**
 * Add custom post type
 */
if ( ! function_exists('summit_speaker_cpt') ) {
    function summit_speaker_cpt() {
        $labels = array(
            'name'                  => 'Summit Speakers',
            'singular_name'         => 'Summit Speaker',
            'menu_name'             => 'Summit Speakers',
            'name_admin_bar'        => 'Summit Speaker',
            'archives'              => 'Speaker Archives',
            'attributes'            => 'Speaker Attributes',
            'parent_item_colon'     => 'Parent Speaker:',
            'all_items'             => 'All Summit Speakers',
            'add_new_item'          => 'Add New Summit Speaker',
            'add_new'               => 'Add New',
            'new_item'              => 'New Summit Speaker',
            'edit_item'             => 'Edit Summit Speaker',
            'update_item'           => 'Update Summit Speaker',
            'view_item'             => 'View Summit Speaker',
            'view_items'            => 'View Summit Speakers',
            'search_items'          => 'Search Summit Speaker',
            'not_found'             => 'Not found',
            'not_found_in_trash'    => 'Not found in Trash',
            'featured_image'        => 'Featured Image',
            'set_featured_image'    => 'Set featured image',
            'remove_featured_image' => 'Remove featured image',
            'use_featured_image'    => 'Use as featured image',
            'insert_into_item'      => 'Insert into summit speaker',
            'uploaded_to_this_item' => 'Uploaded to this summit speaker',
            'items_list'            => 'Summit speakers list',
            'items_list_navigation' => 'Summit speakers list navigation',
            'filter_items_list'     => 'Filter summit speakers list',
        );
        $rewrite = array(
            'slug'                  => 'summit-speaker',
            'with_front'            => false,
            'pages'                 => true,
            'feeds'                 => true,
        );
        $args = array(
            'label'                 => 'Summit Speaker',
            'description'           => 'Summit Speakers',
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'page-attributes', ),
            'taxonomies'            => array( 'category', 'post_tag' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-businessman',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => 'summit-speakers',
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'rewrite'               => $rewrite,
            'capability_type'       => 'page',
            'show_in_rest'          => true,
        );
        register_post_type( 'summit-speaker', $args );

    }
    add_action( 'init', 'summit_speaker_cpt', 0 );
}

/**
 * Set ACF local JSON save directory
 * @param  string $path ACF local JSON save directory
 * @return string ACF local JSON save directory
 */
add_filter( 'acf/settings/save_json', 'sf_acf_json_save_point' );
function sf_acf_json_save_point( $path ) {
    return plugin_dir_path( __FILE__ ) . '/acf-json';
}

/**
 * Set ACF local JSON open directory
 * @param  array $path ACF local JSON open directory
 * @return array ACF local JSON open directory
 */
add_filter( 'acf/settings/load_json', 'sf_acf_json_load_point' );
function sf_acf_json_load_point( $path ) {
    $paths[] = plugin_dir_path( __FILE__ ) . '/acf-json';
    return $paths;
}
