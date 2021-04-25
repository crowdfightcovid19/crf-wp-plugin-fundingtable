<?php
/**
 * Plugin Name: Crowdfight Covid-19 Funding Table
 * Description: Provides a shortcode to render the funding table and configures the webhook.
 * Version: 0.1
 * Author: The Crowdfight Covid-19 Team
 * Author URI: https://crowdfightcovid19.org/
 * License: GPLv2
 * License URI: https://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// Loads the configuration
include_once "crf-wp-plugin-fundingtable-config.php";
// Loads the AJAX definitions
include_once "crf-wp-plugin-fundingtable-ajax.php";
// Loads the shortcodes
include_once "crf-wp-plugin-fundingtable-shortcode.php";


// Register a function to run on plugin activation
register_activation_hook(__FILE__, 'cfcft_initialize_plugin');
function cfcft_initialize_plugin() {    
    // Require plugin WP Webhooks. If it does not exist, show an error.
    if (!is_plugin_active('wp-webhooks/wp-webhooks.php') && current_user_can('activate_plugins')) {
        wp_die('This plugin requires the plugin WP Webhooks. <br><a href="' . admin_url( 'plugins.php' ) . '">&laquo; Return to Plugins</a>');
    }
}

// Configures the webhook
add_filter('wpwhpro/run/actions/custom_action/return_args', 'cfcft_save_table_data', 10, 3);
function cfcft_save_table_data($return_args, $identifier, $response_body) {
    // If the identifier is incorrect, don't execute anything
    if($identifier !== CFCFT_FUNDING_TABLE_WEBHOOK_IDENTIFIER) {
        $return_args['success'] = false;
        $return_args['msg'] = "Invalid webhook identifier";
        return $return_args;
    }
    // Obtains the field data from the request
    $table_data = WPWHPRO()->helpers->validate_request_value($response_body['content'], 'data');

    // Save the data into the option through the options API. DO NOT AUTOLOAD.
    // If the option does not exist, this call creates it.
    $result = update_option(CFCFT_FUNDING_TABLE_DATA_OPTION, $table_data, false);
    if(!$result) {
        $return_args['success'] = false;
        $return_args['msg'] = "Data not stored successfully or the value has not changed";
        return $return_args;
    }
    else {
        $return_args['success'] = true;
        $return_args['msg'] = "Operation completed successfully";
        return $return_args;
    }
    // Return the parameters
    return $return_args;
}

function crf_shortcode_funding_table_get_table_data() {
    $table_json = get_option(CFCFT_FUNDING_TABLE_DATA_OPTION);
    return json_decode($table_json);
} 
