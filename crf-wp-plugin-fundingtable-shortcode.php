<?php

function cfct_shortcode_funding_table_gen($atts) {
    $table_data = crf_shortcode_funding_table_get_table_data();
    ob_start();
    include __DIR__ . "/partials/table.php";
    $content = ob_get_clean();
    return $content;
}
add_shortcode('fundingtable', 'cfct_shortcode_funding_table_gen');

function cfct_shortcode_funding_table_filters_gen($atts) {
    $table_data = crf_shortcode_funding_table_get_table_data();
    $table_data->rows = crf_filter_results_remove_closed_calls($table_data);
    ob_start();
    include __DIR__ . "/partials/filter.php";
    $content = ob_get_clean();
    return $content;
}
add_shortcode('fundingtablefilters', 'cfct_shortcode_funding_table_filters_gen');