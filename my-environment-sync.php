<?php
/*
Plugin Name: My Environment Sync
Plugin URI: https://github.com/alokjain-lucky/environment-sync
Description: Easily pull and push data and files between different environments using FTP and database credentials.
Version: 1.1
Author: Alok Jain
Author URI: http://hsrtech.com
License: MIT
License URI: https://opensource.org/licenses/MIT
*/

// Include necessary files
include(plugin_dir_path(__FILE__) . 'includes/logger.php'); // Include the logger first
include(plugin_dir_path(__FILE__) . 'admin/settings-page.php');
include(plugin_dir_path(__FILE__) . 'admin/log-viewer-page.php');
include(plugin_dir_path(__FILE__) . 'admin/documentation-page.php');
include(plugin_dir_path(__FILE__) . 'includes/data-sync.php');
include(plugin_dir_path(__FILE__) . 'includes/file-sync.php');

// Register activation hook
register_activation_hook(__FILE__, 'my_environment_sync_activate');
function my_environment_sync_activate() {
    my_environment_sync_log('My Environment Sync plugin activated.');
}

// Register deactivation hook
register_deactivation_hook(__FILE__, 'my_environment_sync_deactivate');
function my_environment_sync_deactivate() {
    my_environment_sync_log('My Environment Sync plugin deactivated.');
}

// Add settings menu in the WordPress admin
add_action('admin_menu', 'my_environment_sync_menu');
function my_environment_sync_menu() {
    // Add a new top-level menu in the admin
    add_menu_page('Environment Sync', 'Environment Sync', 'manage_options', 'my-environment-sync', 'my_environment_sync_settings_page');

    // Add a submenu for the log viewer
    add_submenu_page('my-environment-sync', 'Log Viewer', 'Log Viewer', 'manage_options', 'my-environment-sync-log-viewer', 'my_environment_sync_log_viewer_page');

    // Add a submenu for the documentation
    add_submenu_page('my-environment-sync', 'Documentation', 'Documentation', 'manage_options', 'my-environment-sync-documentation', 'my_environment_sync_documentation_page');
}

// Enqueue JavaScript for AJAX
add_action('admin_enqueue_scripts', 'my_environment_sync_enqueue_scripts');
function my_environment_sync_enqueue_scripts($hook) {
    if (strpos($hook, 'my-environment-sync') === false) {
        return;
    }
    wp_enqueue_script('my-environment-sync-js', plugin_dir_url(__FILE__) . 'assets/js/sync.js', array('jquery'), '1.0', true);
    wp_localize_script('my-environment-sync-js', 'MyEnvironmentSync', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('my_environment_sync_nonce')
    ));
}

// Register AJAX actions for synchronization and credential testing
add_action('wp_ajax_pull_database', 'my_environment_sync_pull_database');
add_action('wp_ajax_pull_files', 'my_environment_sync_pull_files');
add_action('wp_ajax_test_ftp_credentials', 'my_environment_sync_test_ftp_credentials');
add_action('wp_ajax_test_db_credentials', 'my_environment_sync_test_db_credentials');

// Function to test FTP credentials
function my_environment_sync_test_ftp_credentials() {
    check_ajax_referer('my_environment_sync_nonce', 'nonce');

    $ftp_server = sanitize_text_field($_POST['ftp_server']);
    $ftp_user = sanitize_text_field($_POST['ftp_user']);
    $ftp_pass = sanitize_text_field($_POST['ftp_pass']);

    $connection = ftp_connect($ftp_server);
    if ($connection && ftp_login($connection, $ftp_user, $ftp_pass)) {
        ftp_close($connection);
        wp_send_json_success('FTP credentials are valid.');
    } else {
        wp_send_json_error('FTP credentials are invalid.');
    }
}

// Function to test database credentials
function my_environment_sync_test_db_credentials() {
    check_ajax_referer('my_environment_sync_nonce', 'nonce');

    $db_host = sanitize_text_field($_POST['db_host']);
    $db_name = sanitize_text_field($_POST['db_name']);
    $db_user = sanitize_text_field($_POST['db_user']);
    $db_pass = sanitize_text_field($_POST['db_pass']);

    $connection = new mysqli($db_host, $db_user, $db_pass, $db_name);
    if ($connection->connect_error) {
        wp_send_json_error('Database credentials are invalid: ' . $connection->connect_error);
    } else {
        wp_send_json_success('Database credentials are valid.');
    }
}

// Add a link to the GitHub repository documentation in the plugin list
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'my_environment_sync_action_links');
function my_environment_sync_action_links($links) {
    $docs_link = '<a href="https://github.com/alokjain-lucky/environment-sync#readme" target="_blank">Documentation</a>';
    array_unshift($links, $docs_link);
    return $links;
}
?>
