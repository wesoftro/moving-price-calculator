<?php
/*
Plugin Name: Moving Price Calculator
Description: Price calculator for House Moving
Version: 1.0
Author: Wesoft.ro
*/


if (!defined('ABSPATH')) {
    exit; // Ieșire dacă este accesat direct
}

// Includeți fișierele necesare
require_once plugin_dir_path(__FILE__) . 'includes/admin-page.php';
require_once plugin_dir_path(__FILE__) . 'includes/form-handler.php';

// Funcție pentru inițializarea pluginului
function mpc_init() {
    // Cod de inițializare
}
add_action('init', 'mpc_init');

// Function to enqueue admin styles
function mpc_enqueue_admin_styles($hook) {
    // Check if we're on the correct admin page
    if ('toplevel_page_mpc-settings' !== $hook) {
        return;
    }

    // Get the file path of the CSS file
    $css_file_path = plugin_dir_path(__FILE__) . 'css/admin-styles.css';

    // Check if the file exists
    if (!file_exists($css_file_path)) {
        return; // Exit if the file doesn't exist
    }

    // Use filemtime to get the last modified time of the CSS file for cache busting
    $version = filemtime($css_file_path);

    // Enqueue the style with the dynamic version
    wp_enqueue_style(
        'mpc-admin-styles', 
        plugins_url('css/admin-styles.css', __FILE__), 
        array(), 
        $version, 
        'all'
    );
}
add_action('admin_enqueue_scripts', 'mpc_enqueue_admin_styles');



// Funcție pentru afișarea formularului
function mpc_display_form() {
    ob_start();
    ?>
    <form id="moving-price-calculator">
        <div>
            <label for="pickup_address">Pickup Adress:</label>
            <input type="text" id="pickup_address" name="pickup_address" required>
        </div>
        <div>
            <label for="delivery_address">Delivery Adress:</label>
            <input type="text" id="delivery_address" name="delivery_address" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" required>
        </div>
        <div>
            <label for="move_date">Moving date:</label>
            <input type="date" id="move_date" name="move_date" required>
        </div>
        <div>
            <button type="submit">Get Quote</button>
        </div>
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('moving_price_calculator', 'mpc_display_form');

// Funcție pentru înregistrarea stilurilor și scripturilor
function mpc_enqueue_scripts() {
    wp_enqueue_style('mpc-styles', plugins_url('css/styles.css', __FILE__));
    wp_enqueue_script('mpc-script', plugins_url('js/script.js', __FILE__), array('jquery'), '1.0', true);
    wp_localize_script('mpc-script', 'mpc_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'mpc_enqueue_scripts');

// Funcție pentru crearea meniului de administrare
function mpc_admin_menu() {
    add_menu_page(
        'Moving Price Calculator Settings',
        'Moving Calculator',
        'manage_options',
        'mpc-settings',
        'mpc_admin_page_content',
        'dashicons-calculator',
        20
    );
}
add_action('admin_menu', 'mpc_admin_menu');

// Funcție pentru inițializarea setărilor
function mpc_register_settings() {
    $fields = create_price_per_miles_settings();
    foreach ($fields as $label => $id) {
        register_setting('mpc_settings', $id);
    }
    add_settings_section('mpc_price_per_miles_section', '', null, 'mpc-settings');
}
add_action('admin_init', 'mpc_register_settings');

