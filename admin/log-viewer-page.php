<?php
// Render the log viewer page
function my_environment_sync_log_viewer_page() {
    ?>
    <div class="wrap">
        <h1>Log Viewer</h1>
        <div id="log-viewer" style="white-space: pre-wrap; background: #f9f9f9; border: 1px solid #ccc; padding: 10px; max-height: 500px; overflow-y: scroll;">
            <?php
            // Read and display the log file contents
            $log_file = plugin_dir_path(__FILE__) . '../logs/my-environment-sync.log';
            if (file_exists($log_file)) {
                echo esc_html(file_get_contents($log_file));
            } else {
                echo 'No log entries found.';
            }
            ?>
        </div>
    </div>
    <?php
}
?>
