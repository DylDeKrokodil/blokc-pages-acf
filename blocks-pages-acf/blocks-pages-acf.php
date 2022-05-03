<?php 
/*
Plugin Name: Blocks Pages ACF
Plugin URI: https://www.goonline.nl/
Description: Gewoon lekker leren.
Author: Go Online, Dylan 
Author URI: https://www.goonline.nl/
Author Email: support@goonline.nl
Version: 1.1.0
License: GPLv2 or later
Text Domain: #
*/


defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

add_action( 'admin_menu', 'add_admin_menu' );
function add_admin_menu() {
    add_menu_page(
        'Dylans Pluginnetje',
        'Dylans Pluginnetje',
        'manage_options',
        plugin_dir_path(__FILE__) . 'admin/view.php',
        null,
        'dashicons-admin-plugins',
        20
    );
}

function fontawesome_dashboard() {
    $plugin_url = plugin_dir_url( __FILE__ );
    $current_screen = get_current_screen();
    $current_screen = $current_screen->base;
    if( $current_screen == 'blocks-pages-acf/admin/view' ) {
        wp_enqueue_style('fontawesome', 'https://use.fontawesome.com/releases/v5.8.1/css/all.css', '', '5.8.1', 'all');
    }
}

add_action('admin_init', 'fontawesome_dashboard');

function utm_user_scripts() {
    $plugin_url = plugin_dir_url( __FILE__ );
    $current_screen = get_current_screen();
    $current_screen = $current_screen->base;
    if( $current_screen == 'blocks-pages-acf/admin/view' ) {
        wp_enqueue_style( 'style',  $plugin_url . "css/blocks-custom-style.css"); 
        wp_enqueue_script( 'script',  $plugin_url . "/js/blocks-custom-js.js"); 
    }
}
add_action( 'admin_print_styles', 'utm_user_scripts' );

