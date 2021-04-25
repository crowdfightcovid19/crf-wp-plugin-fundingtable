<?php
// Action for AJAX calls to filter results
// Action name: crf_filter_results

function crf_filter_results_generate_return($success, $data="") {
    $result = array();
    $result['success'] = $success;
    $result['data'] = $data;
    return json_encode($result);
}

function crf_filter_results_remove_closed_calls($table_data) {
    $new_rows = array();
    foreach($table_data->rows as $row) {
        if(strcasecmp($row->is_open, "CLOSED") !== 0) {
            $new_rows[] = $row;
        }
    }
    return $new_rows;
}

function crf_filter_results_apply_filter_who_can_apply_category($table_data, $category) {
    $new_rows = array();
    foreach($table_data->rows as $row) {
        if(in_array($category, $row->who_can_apply_category)) {
            $new_rows[] = $row;
        }
    }
    return $new_rows;
}

function crf_filter_results_apply_filter_country($table_data, $country) {
    $new_rows = array();
    foreach($table_data->rows as $row) {
        if(in_array($country, $row->iso_countries) || in_array("ww", $row->iso_countries)) {              
            $new_rows[] = $row;
        }
    }
    return $new_rows;
}

function crf_filter_results() {
    // Load table data
    $table_data = crf_shortcode_funding_table_get_table_data();
    // Get groups ISO Codes
    $groups_codes = array_keys(get_object_vars($table_data->filters->groups));
    // Get countries ISO Codes
    $country_codes = array_keys(get_object_vars($table_data->filters->regions_names));
    // Load filter values
    $who = $_POST['filter-who-can-apply-category'];
    $country = $_POST['filter-iso-code'];
    $showClosed = filter_var($_POST['filter-show-closed'], FILTER_VALIDATE_BOOLEAN); // We remove the need for validation of this filter this way
    // Validate filter values
    if(!in_array($who, $table_data->filters->who_can_apply_category) && !empty($who)) {        
        echo crf_filter_results_generate_return(false);
        wp_die();
    }
    if((!in_array($country, $country_codes) || in_array($country, $groups_codes)) && !empty($country)) {        
        echo crf_filter_results_generate_return(false);
        wp_die();
    }
    // Filter closed calls if required
    if(!$showClosed) {
        $table_data->rows = crf_filter_results_remove_closed_calls($table_data);
    }
    // Filter table results by "who can apply"
    if(!empty($who)) {
        $table_data->rows = crf_filter_results_apply_filter_who_can_apply_category($table_data, $who);
    }
    // Filter table results by "country"
    if(!empty($country)) {
        $table_data->rows = crf_filter_results_apply_filter_country($table_data, $country);
    }    
    // Generate table
    ob_start();
    include __DIR__ . "/partials/table.php";
    $table = ob_get_clean();
    // Echo response and die
    echo crf_filter_results_generate_return(true, $table);
    wp_die();
}
add_action('wp_ajax_crf_filter_results', 'crf_filter_results');
add_action('wp_ajax_nopriv_crf_filter_results', 'crf_filter_results');