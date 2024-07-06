<?php
include_once(plugin_dir_path(__FILE__) . 'logger.php');

// Function to pull database from the specified environment
function pull_database($environment) {
    $options = get_option('my_environment_sync_options');
    $url = '';
    $db_host = '';
    $db_name = '';
    $db_user = '';
    $db_pass = '';

    // Determine the URL and database credentials based on the environment
    switch ($environment) {
        case 'live':
            $url = esc_url_raw($options['live_url']);
            $db_host = sanitize_text_field($options['db_host']);
            $db_name = sanitize_text_field($options['db_name']);
            $db_user = sanitize_text_field($options['db_user']);
            $db_pass = sanitize_text_field($options['db_pass']);
            break;
        case 'staging':
            $url = esc_url_raw($options['staging_url']);
            $db_host = sanitize_text_field($options['db_host']);
            $db_name = sanitize_text_field($options['db_name']);
            $db_user = sanitize_text_field($options['db_user']);
            $db_pass = sanitize_text_field($options['db_pass']);
            break;
        case 'localhost':
            $url = esc_url_raw($options['localhost_url']);
            $db_host = sanitize_text_field($options['db_host']);
            $db_name = sanitize_text_field($options['db_name']);
            $db_user = sanitize_text_field($options['db_user']);
            $db_pass = sanitize_text_field($options['db_pass']);
            break;
    }

    if ($url) {
        // Use WP-CLI to export and import the database
        // Replace 'user' with actual SSH user
        $export_command = escapeshellcmd("wp db export - | ssh user@{$url} 'wp db import -'");
        $result = shell_exec($export_command);

        // Log the result of the command
        if ($result === null) {
            my_environment_sync_log("Database pulled successfully from {$environment} environment.");
            return true;
        } else {
            my_environment_sync_log("Failed to pull database from {$environment} environment: $result", 'ERROR');
            return false;
        }
    }
    return false;
}
?>
