<?php
include_once(plugin_dir_path(__FILE__) . 'logger.php');

// Function to pull files from the specified environment
function pull_files($environment) {
    $options = get_option('my_environment_sync_options');
    $url = '';
    $ftp_server = '';
    $ftp_user = '';
    $ftp_pass = '';

    // Determine the URL and FTP credentials based on the environment
    switch ($environment) {
        case 'live':
            $url = esc_url_raw($options['live_url']);
            $ftp_server = sanitize_text_field($options['ftp_server']);
            $ftp_user = sanitize_text_field($options['ftp_user']);
            $ftp_pass = sanitize_text_field($options['ftp_pass']);
            break;
        case 'staging':
            $url = esc_url_raw($options['staging_url']);
            $ftp_server = sanitize_text_field($options['ftp_server']);
            $ftp_user = sanitize_text_field($options['ftp_user']);
            $ftp_pass = sanitize_text_field($options['ftp_pass']);
            break;
        case 'localhost':
            $url = esc_url_raw($options['localhost_url']);
            $ftp_server = sanitize_text_field($options['ftp_server']);
            $ftp_user = sanitize_text_field($options['ftp_user']);
            $ftp_pass = sanitize_text_field($options['ftp_pass']);
            break;
    }

    if ($url) {
        // Use FTP to pull files from the server
        $connection = ftp_connect($ftp_server);
        if ($connection && ftp_login($connection, $ftp_user, $ftp_pass)) {
            ftp_pasv($connection, true);
            $local_path = '/path/to/local/wordpress/wp-content/uploads/';
            $remote_path = '/path/to/remote/wordpress/wp-content/uploads/';
            $result = ftp_sync($connection, $remote_path, $local_path);

            ftp_close($connection);

            if ($result) {
                my_environment_sync_log("Files pulled successfully from {$environment} environment.");
                return true;
            } else {
                my_environment_sync_log("Failed to pull files from {$environment} environment.", 'ERROR');
                return false;
            }
        } else {
            my_environment_sync_log("Failed to connect to FTP server for {$environment} environment.", 'ERROR');
            return false;
        }
    }
    return false;
}

// Function to recursively synchronize files using FTP
function ftp_sync($connection, $remote_path, $local_path) {
    if (!is_dir($local_path)) {
        mkdir($local_path, 0755, true);
    }

    $files = ftp_nlist($connection, $remote_path);

    foreach ($files as $file) {
        $remote_file = $remote_path . '/' . $file;
        $local_file = $local_path . '/' . $file;

        if (ftp_size($connection, $remote_file) == -1) {
            // If it's a directory, recursively sync
            ftp_sync($connection, $remote_file, $local_file);
        } else {
            // If it's a file, download it
            ftp_get($connection, $local_file, $remote_file, FTP_BINARY);
        }
    }

    return true;
}
?>
