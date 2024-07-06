<?php
// Render the settings page
function my_environment_sync_settings_page() {
    ?>
    <div class="wrap">
        <h1>Environment Sync Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('my_environment_sync_options_group');
            do_settings_sections('my-environment-sync');
            submit_button();
            ?>
        </form>
        <h2>Sync Actions</h2>
        <button id="sync-db-live" class="button button-primary">Pull Database from Live</button>
        <button id="sync-files-live" class="button button-primary">Pull Files from Live</button>
        <button id="sync-db-staging" class="button button-secondary">Pull Database from Staging</button>
        <button id="sync-files-staging" class="button button-secondary">Pull Files from Staging</button>
        <button id="sync-db-localhost" class="button button-secondary">Pull Database from Localhost</button>
        <button id="sync-files-localhost" class="button button-secondary">Pull Files from Localhost</button>
        <div id="sync-result"></div>
    </div>
    <?php
}

// Register settings, sections, and fields
add_action('admin_init', 'my_environment_sync_settings_init');
function my_environment_sync_settings_init() {
    register_setting('my_environment_sync_options_group', 'my_environment_sync_options', 'my_environment_sync_options_validate');

    add_settings_section('my_environment_sync_main', 'Main Settings', 'my_environment_sync_section_text', 'my-environment-sync');

    add_settings_field('my_environment_sync_live_url', 'Live Environment URL', 'my_environment_sync_live_url_input', 'my-environment-sync', 'my_environment_sync_main');
    add_settings_field('my_environment_sync_staging_url', 'Staging Environment URL', 'my_environment_sync_staging_url_input', 'my-environment-sync', 'my_environment_sync_main');
    add_settings_field('my_environment_sync_localhost_url', 'Localhost Environment URL', 'my_environment_sync_localhost_url_input', 'my-environment-sync', 'my_environment_sync_main');

    add_settings_section('my_environment_sync_ftp', 'FTP Settings', 'my_environment_sync_ftp_section_text', 'my-environment-sync');
    add_settings_field('my_environment_sync_ftp_server', 'FTP Server', 'my_environment_sync_ftp_server_input', 'my-environment-sync', 'my_environment_sync_ftp');
    add_settings_field('my_environment_sync_ftp_user', 'FTP Username', 'my_environment_sync_ftp_user_input', 'my-environment-sync', 'my_environment_sync_ftp');
    add_settings_field('my_environment_sync_ftp_pass', 'FTP Password', 'my_environment_sync_ftp_pass_input', 'my-environment-sync', 'my_environment_sync_ftp');

    add_settings_section('my_environment_sync_db', 'Database Settings', 'my_environment_sync_db_section_text', 'my-environment-sync');
    add_settings_field('my_environment_sync_db_host', 'Database Host', 'my_environment_sync_db_host_input', 'my-environment-sync', 'my_environment_sync_db');
    add_settings_field('my_environment_sync_db_name', 'Database Name', 'my_environment_sync_db_name_input', 'my-environment-sync', 'my_environment_sync_db');
    add_settings_field('my_environment_sync_db_user', 'Database Username', 'my_environment_sync_db_user_input', 'my-environment-sync', 'my_environment_sync_db');
    add_settings_field('my_environment_sync_db_pass', 'Database Password', 'my_environment_sync_db_pass_input', 'my-environment-sync', 'my_environment_sync_db');
}

// Callback functions for settings section and fields
function my_environment_sync_section_text() {
    echo '<p>Enter your environment details below.</p>';
}

function my_environment_sync_live_url_input() {
    $options = get_option('my_environment_sync_options');
    echo "<input id='my_environment_sync_live_url' name='my_environment_sync_options[live_url]' type='text' value='" . esc_attr($options['live_url']) . "' />";
}

function my_environment_sync_staging_url_input() {
    $options = get_option('my_environment_sync_options');
    echo "<input id='my_environment_sync_staging_url' name='my_environment_sync_options[staging_url]' type='text' value='" . esc_attr($options['staging_url']) . "' />";
}

function my_environment_sync_localhost_url_input() {
    $options = get_option('my_environment_sync_options');
    echo "<input id='my_environment_sync_localhost_url' name='my_environment_sync_options[localhost_url]' type='text' value='" . esc_attr($options['localhost_url']) . "' />";
}

function my_environment_sync_ftp_section_text() {
    echo '<p>Enter your FTP credentials below.</p>';
}

function my_environment_sync_ftp_server_input() {
    $options = get_option('my_environment_sync_options');
    echo "<input id='my_environment_sync_ftp_server' name='my_environment_sync_options[ftp_server]' type='text' value='" . esc_attr($options['ftp_server']) . "' />";
}

function my_environment_sync_ftp_user_input() {
    $options = get_option('my_environment_sync_options');
    echo "<input id='my_environment_sync_ftp_user' name='my_environment_sync_options[ftp_user]' type='text' value='" . esc_attr($options['ftp_user']) . "' />";
}

function my_environment_sync_ftp_pass_input() {
    $options = get_option('my_environment_sync_options');
    echo "<input id='my_environment_sync_ftp_pass' name='my_environment_sync_options[ftp_pass]' type='password' value='" . esc_attr($options['ftp_pass']) . "' />";
}

function my_environment_sync_db_section_text() {
    echo '<p>Enter your database credentials below.</p>';
}

function my_environment_sync_db_host_input() {
    $options = get_option('my_environment_sync_options');
    echo "<input id='my_environment_sync_db_host' name='my_environment_sync_options[db_host]' type='text' value='" . esc_attr($options['db_host']) . "' />";
}

function my_environment_sync_db_name_input() {
    $options = get_option('my_environment_sync_options');
    echo "<input id='my_environment_sync_db_name' name='my_environment_sync_options[db_name]' type='text' value='" . esc_attr($options['db_name']) . "' />";
}

function my_environment_sync_db_user_input() {
    $options = get_option('my_environment_sync_options');
    echo "<input id='my_environment_sync_db_user' name='my_environment_sync_options[db_user]' type='text' value='" . esc_attr($options['db_user']) . "' />";
}

function my_environment_sync_db_pass_input() {
    $options = get_option('my_environment_sync_options');
    echo "<input id='my_environment_sync_db_pass' name='my_environment_sync_options[db_pass]' type='password' value='" . esc_attr($options['db_pass']) . "' />";
}

// Validate and sanitize input
function my_environment_sync_options_validate($input) {
    $new_input['live_url'] = esc_url_raw($input['live_url']);
    $new_input['staging_url'] = esc_url_raw($input['staging_url']);
    $new_input['localhost_url'] = esc_url_raw($input['localhost_url']);
    $new_input['ftp_server'] = sanitize_text_field($input['ftp_server']);
    $new_input['ftp_user'] = sanitize_text_field($input['ftp_user']);
    $new_input['ftp_pass'] = sanitize_text_field($input['ftp_pass']);
    $new_input['db_host'] = sanitize_text_field($input['db_host']);
    $new_input['db_name'] = sanitize_text_field($input['db_name']);
    $new_input['db_user'] = sanitize_text_field($input['db_user']);
    $new_input['db_pass'] = sanitize_text_field($input['db_pass']);
    return $new_input;
}
?>
