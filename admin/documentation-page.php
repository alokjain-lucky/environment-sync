<?php
// Render the documentation page
function my_environment_sync_documentation_page() {
    ?>
    <div class="wrap">
        <h1>Documentation</h1>
        <h2>Setup Instructions</h2>
        <p>Follow these steps to set up and use the My Environment Sync plugin:</p>
        <h3>1. Configure FTP</h3>
        <p>Ensure FTP access is set up between your environments. You will need FTP access to pull and push files from remote environments. Configure FTP credentials in the plugin settings.</p>

        <h3>2. Configure WP-CLI</h3>
        <p>Install WP-CLI on your WordPress environments if it is not already installed. Follow the official <a href="https://wp-cli.org/#installing">WP-CLI installation guide</a>.</p>
        <p>Ensure that WP-CLI is accessible via SSH. You may need to add WP-CLI to the system PATH on the remote server.</p>
        <pre><code>
# Check if WP-CLI is installed
wp --info

# Add WP-CLI to the system PATH if needed
export PATH=$PATH:/path/to/wp-cli
        </code></pre>

        <h3>3. Plugin Settings</h3>
        <p>Go to the Environment Sync settings page in the WordPress admin and configure the URLs and credentials for your live, staging, and localhost environments.</p>

        <h2>Usage</h2>
        <h3>1. Pull Database</h3>
        <p>To pull the database from one environment to another, click the corresponding button on the settings page:</p>
        <ul>
            <li><strong>Pull Database from Live:</strong> Pulls the database from the live environment to the current environment.</li>
            <li><strong>Pull Database from Staging:</strong> Pulls the database from the staging environment to the current environment.</li>
            <li><strong>Pull Database from Localhost:</strong> Pulls the database from the localhost environment to the current environment.</li>
        </ul>

        <h3>2. Pull Files</h3>
        <p>To pull files from one environment to another, click the corresponding button on the settings page:</p>
        <ul>
            <li><strong>Pull Files from Live:</strong> Pulls the files from the live environment to the current environment.</li>
            <li><strong>Pull Files from Staging:</strong> Pulls the files from the staging environment to the current environment.</li>
            <li><strong>Pull Files from Localhost:</strong> Pulls the files from the localhost environment to the current environment.</li>
        </ul>

        <h3>3. Test Credentials</h3>
        <p>You can test the FTP and database credentials by clicking the corresponding buttons on the settings page.</p>

        <h3>4. View Logs</h3>
        <p>You can view the logs of synchronization actions by navigating to the Log Viewer page under the Environment Sync menu.</p>
    </div>
    <?php
}
?>
