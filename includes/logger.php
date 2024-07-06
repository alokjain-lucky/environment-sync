<?php
/**
 * Logs messages to a custom log file with timestamps.
 *
 * @param string $message The message to log.
 * @param string $level The log level (INFO, ERROR, etc.).
 */
function my_environment_sync_log($message, $level = 'INFO') {
    $log_file = plugin_dir_path(__FILE__) . '../logs/my-environment-sync.log';
    $timestamp = date('Y-m-d H:i:s');
    $formatted_message = "[$timestamp] [$level] $message" . PHP_EOL;

    // Write the log message to the log file
    file_put_contents($log_file, $formatted_message, FILE_APPEND);
}
?>
