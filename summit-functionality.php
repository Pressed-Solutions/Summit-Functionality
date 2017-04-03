<?php
/*
 * Plugin Name: Summit Functionality
 * Plugin URI: https://bitbucket.org/pressedsolutions/summit-functionality
 * Description: Summit functionality including speakers, date-restricted video access, and more
 * Version: 1.4
 * Author: Pressed Solutions
 * Author URI: https://pressedsolutions.com
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Include shortcodes
 */
require_once( 'inc/shortcodes.php' );

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
            'slug'                  => 'speaker',
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
        register_post_type( 'summit_speaker', $args );

    }
    add_action( 'init', 'summit_speaker_cpt', 0 );
}

/**
 * Add options page
 */
if( function_exists( 'acf_add_options_page' ) ) {
    acf_add_options_page( array(
        'page_title' 	=> 'Summit Settings',
        'menu_title'	=> 'Summit Settings',
        'menu_slug' 	=> 'summit-settings',
        'capability'	=> 'edit_others_posts',
        'redirect'		=> false,
    ));
}

/**
 * Enqueue assets
 */
add_action( 'wp_enqueue_scripts', 'sf_enqueue_scripts' );
function sf_enqueue_scripts() {
    wp_enqueue_style( 'summit-speaker', plugin_dir_url( __FILE__ ) . 'assets/css/summit-speakers.min.css' );
}

/**
 * Set ACF local JSON save directory
 *
 * @param  string $path ACF local JSON save directory
 * @return string ACF local JSON save directory
 */
add_filter( 'acf/settings/save_json', 'sf_acf_json_save_point' );
function sf_acf_json_save_point() {
    return plugin_dir_path( __FILE__ ) . 'acf-json';
}

/**
 * Set ACF local JSON open directory
 *
 * @param  array $path ACF local JSON open directory
 * @return array ACF local JSON open directory
 */
add_filter( 'acf/settings/load_json', 'sf_acf_json_load_point' );
function sf_acf_json_load_point( $paths ) {
    $paths[] = plugin_dir_path( __FILE__ ) . 'acf-json';
    return $paths;
}

/**
 * Flush rewrite rules on activation
 */
register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );
register_activation_hook( __FILE__, 'sf_flush_rewrites' );
function sf_flush_rewrites() {
    summit_speaker_cpt();
    flush_rewrite_rules();
}

/**
 * Locate template.
 *
 * Locate the called template.
 * Search Order:
 * 1. /themes/theme/$template_name
 * 2. /plugins/summit-functionality/templates/$template_name.
 *
 * @param 	string 	$template_name			Template to load.
 * @param 	string 	$string $template_path	Path to templates.
 * @param 	string	$default_path			Default path to template files.
 * @return 	string 							Path to the template file.
 */

function sf_locate_template( $template_name, $template_path = '', $default_path = '' ) {

    // Set default plugin templates path.
    if ( ! $default_path ) :
        $default_path = plugin_dir_path( __FILE__ ) . 'templates/'; // Path to the template folder
    endif;

    // Search template file in theme folder.
    $template = locate_template( array(
        $template_path . $template_name,
        $template_name
    ) );

    // Get plugins template file.
    if ( ! $template ) :
        $template = $default_path . $template_name;
    endif;

    return apply_filters( 'sf_locate_template', $template, $template_name, $template_path, $default_path );
}

/**
 * Get template.
 *
 * Search for the template and include the file.
 *
 * @see sf_locate_template()
 *
 * @param string 	$template_name			Template to load.
 * @param array 	$args					Args passed for the template file.
 * @param string 	$string $template_path	Path to templates.
 * @param string	$default_path			Default path to template files.
 */
function sf_get_template( $template_name, $args = array(), $tempate_path = '', $default_path = '' ) {

    if ( is_array( $args ) && isset( $args ) ) :
        extract( $args );
    endif;

    $template_file = sf_locate_template( $template_name, $tempate_path, $default_path );

    if ( ! file_exists( $template_file ) ) :
        printf( '<code>%s</code> does not exist.', $template_file );
        return;
    endif;

    include $template_file;
}

/**
 * Template loader.
 *
 * The template loader will check if WP is loading a template
 * for a specific Post Type and will try to load the template
 * from out 'templates' directory.
 *
 * @param	string	$template	Template file that is being loaded.
 * @return	string				Template file that should be loaded.
 */
function sf_template_loader( $template ) {

    $find = array();
    $file = '';

    if ( is_singular( 'summit_speaker' ) ) :
        $file = 'individual-speaker-page.php';
    endif;

    if ( $file && file_exists( sf_locate_template( $file ) ) ) :
        $template = sf_locate_template( $file );
    endif;

    return $template;

}
add_filter( 'template_include', 'sf_template_loader' );

/**
 * Determine if user has access to content based on membership and current date
 *
 * @param  string  $content_date_start Ymd-formatted date string when content becomes available
 * @param  string  $content_date_end   Ymd-formatted date string when content becomes unavailable; defaults to 1 day after $content_date_start
 * @param  integer $time               hour of day when content becomes available/unavailable; defaults to 10
 * @param  string  $timezone           timezone string; defaults to EST
 * @param  string  $membership_level   string of Memberium membership level for determining access
 * @return boolean user does/doesn't have access
 */
function get_access_permissions( $content_date_start, $content_date_end = NULL, $time = '10', $timezone = 'EST', $membership_level = NULL ) {
    // content begin date
    $content_date_start = date_create_from_format( 'Ymd H:i:s T', $content_date_start . '00:00:00 ' . $timezone );
    $content_date_start = date_add( $content_date_start, date_interval_create_from_date_string( $time . ' hours' ) );

    // content end date
    if ( $content_date_end && $content_date_end != NULL ) {
        $content_date_end = date_create_from_format( 'Ymd H:i:s T', $content_date_end . '00:00:00 ' . $timezone );
        $content_date_end = date_add( $content_date_end, date_interval_create_from_date_string( $time . ' hours' ) );
    } else {
        $content_date_end = date_create_from_format( 'U', $content_date_start->format( 'U' ) );
        $content_date_end = date_add( $content_date_end, date_interval_create_from_date_string( '1 day' ) );
    }

    // current date
    $current_date = new DateTime();
    $current_date = date_timezone_set( $current_date, timezone_open( $timezone ) );

    if ( memb_hasMembership( $membership_level ) ) {
        return true;
    } elseif ( ( $current_date->format( 'Y-m-d H:i:s' ) >= $content_date_start->format( 'Y-m-d H:i:s' ) ) && ( $current_date->format( 'Y-m-d H:i:s' ) <= $content_date_end->format( 'Y-m-d H:i:s' ) ) ) {
        return true;
    }

    if ( $_GET['admin_preview'] && current_user_can( 'edit_others_posts' ) ) {
        return true;
    }
    return false;
}
