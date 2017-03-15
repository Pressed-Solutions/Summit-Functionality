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
