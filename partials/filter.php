<div id="crf-funding-table-filters" class="row">
    <div id="crf-funding-table-filters-inner" class="col">
        <form id="crf-funding-table-filters-form">
            <div class="form-group">
                <label id="crf-filter-who-can-apply-category-label" for="crf-filter-who-can-apply-category">Who is applying?</label>
                <select class="form-control" id="crf-filter-who-can-apply-category">
                    <option value="">---</option>
                    <?php foreach($table_data->filters->who_can_apply_category as $item): ?>
                        <option value="<?php echo $item; ?>"><?php echo $item; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label id="crf-filter-iso-countries-label" for="crf-filter-iso-countries">From which country?</label>
                <?php
                    // Convert to array from StdObj so we can "asort" it
                    $country_codes = json_decode(json_encode($table_data->filters->regions_names), true);
                    asort($country_codes, SORT_STRING | SORT_FLAG_CASE);
                    $groups_codes = array_keys(get_object_vars($table_data->filters->groups));
                ?>
                <select class="form-control" id="crf-filter-iso-countries">
                    <option value="">---</option>
                    <?php foreach($country_codes as $value => $name): ?>                        
                        <?php if(strcasecmp($value, "ww") !== 0  && !in_array($value, $groups_codes)): ?>
                            <option value="<?php echo $value; ?>"><?php echo $name; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>                    
                </select>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="crf-filter-closed">                                
                <label class="form-check-label" id="crf-filter-closed-label" for="crf-filter-closed">Show also closed calls?</label>
            </div>
            <div class="mt-3">
                <button id="crf-funding-table-filters-submit" type="submit" class="btn btn-primary btn-lg btn-block">Filter</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#crf-funding-table-filters-submit').click(function(evt) {
            evt.preventDefault();
            if($('#crf-funding-table').length) {
                let ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>';
                let whoCanApplyCategory = $('#crf-filter-who-can-apply-category').val();
                let isoCode = $('#crf-filter-iso-countries').val();
                let showClosed = $('#crf-filter-closed').is(":checked");
                let data = {
                    'action': 'crf_filter_results',
                    'filter-who-can-apply-category': whoCanApplyCategory,
                    'filter-iso-code': isoCode,
                    'filter-show-closed': showClosed,
                };
                $.post(ajaxurl, data, function(response) {
                    let r = JSON.parse(response);
                    if(r.success) {
                        $('#crf-funding-table').replaceWith(r.data);
                    }
                    else {
                        console.warn("Invalid values for filtering.");
                    }
                });
            }
            else {
                console.warn('The funding table does not exist on the current DOM. Using the filters has no effect.');
            }
        });
    });
</script>