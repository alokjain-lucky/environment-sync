# My Environment Sync

Easily pull and push data and files between different environments using FTP and database credentials.

## Setup Instructions

### 1. Configure FTP

Ensure FTP access is set up between your environments. You will need FTP access to pull and push files from remote environments. Configure FTP credentials in the plugin settings.

### 2. Configure WP-CLI

Install WP-CLI on your WordPress environments if it is not already installed. Follow the official [WP-CLI installation guide](https://wp-cli.org/#installing).

Ensure that WP-CLI is accessible via SSH. You may need to add WP-CLI to the system PATH on the remote server.

```bash
# Check if WP-CLI is installed
wp --info

# Add WP-CLI to the system PATH if needed
export PATH=$PATH:/path/to/wp-cli
