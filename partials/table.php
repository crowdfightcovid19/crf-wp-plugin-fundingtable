<div id="crf-funding-table">
    <?php if(count($table_data->rows) > 0): ?>
        <?php $idx = 0; ?>
        <?php foreach($table_data->rows as $row): ?>
            <div class="card pb-2">
                <a data-toggle="collapse" data-target="#crf-funding-table-collapse-<?php echo $idx; ?>" aria-expanded="false" aria-controls="crf-funding-table-collapse-<?php echo $idx; ?>" role="button">
                    <div class="card-header" id="crf-funding-table-heading-<?php echo $idx; ?>">
                        <div class="row pb-3">                                            
                            <div class="col-12">
                                <h5 class="mb-0 card-title"><?php echo $row->title; ?></h5>
                            </div>
                            <span class="card-icon">+</span>
                        </div>
                        <?php if(!empty($row->funding_entity)): ?>
                        <div class="row">                
                            <div class="col-12 col-lg-3">
                                <strong><?php echo $table_data->headers->funding_entity; ?></strong>
                            </div>
                            <div class="col-12 col-lg-9">
                                <span><?php echo $row->funding_entity; ?></span>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if(!empty($row->requirements)): ?>
                        <div class="row">                
                            <div class="col-12 col-lg-3">
                                <strong><?php echo $table_data->headers->requirements; ?></strong>
                            </div>
                            <div class="col-12 col-lg-9">
                                <span><?php echo $row->requirements; ?></span>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if(!empty($row->deadline_formatted) || !empty($row->deadline_informal)): ?>
                            <div class="row">                
                                <div class="col-12 col-lg-3">
                                    <strong><?php echo $table_data->headers->deadline_formatted; ?></strong>
                                </div>
                                <div class="col-12 col-lg-9">
                                    <?php $show_separator = false; ?>
                                    <?php if(!empty($row->deadline_formatted)): ?>
                                        <?php
                                            $deadline_with_separator = $row->deadline_formatted;
                                            if(!empty($row->deadline_informal)) {
                                                $deadline_with_separator .= ",";
                                            }
                                        ?>
                                        <span><?php echo $deadline_with_separator; ?></span>
                                    <?php endif; ?>
                                    <?php if(!empty($row->deadline_informal)): ?>                                    
                                        <span><?php echo $row->deadline_informal; ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </a>
                <div id="crf-funding-table-collapse-<?php echo $idx; ?>" class="collapse" aria-labelledby="funding-table-heading-<?php echo $idx; ?>" data-parent="#crf-funding-table">
                    <div class="card-body">
                        <?php if(!empty($row->amount)): ?>
                            <div class="row pt-3">                
                                <div class="col-12 col-lg-3">
                                    <strong><?php echo $table_data->headers->amount; ?></strong>
                                </div>
                                <div class="col-12 col-lg-9">
                                    <span><?php echo $row->amount; ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if(!empty($row->main_link)): ?>
                            <div class="row pt-3">                
                                <div class="col-12 col-lg-3">
                                    <strong><?php echo $table_data->headers->main_link; ?></strong>
                                </div>
                                <div class="col-12 col-lg-9">
                                    <a href="<?php echo $row->main_link; ?>" target="_blank"><?php echo $row->main_link; ?></a>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if(!empty($row->guidelines_link)): ?>
                            <div class="row pt-3">                
                                <div class="col-12 col-lg-3">
                                    <strong><?php echo $table_data->headers->guidelines_link; ?></strong>
                                </div>
                                <div class="col-12 col-lg-9">
                                    <a href="<?php echo $row->guidelines_link; ?>" target="_blank"><?php echo $row->guidelines_link; ?></a>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if(!empty($row->description)): ?>
                            <div class="row pt-3">                
                                <div class="col-12 col-lg-3">
                                    <strong><?php echo $table_data->headers->description; ?></strong>
                                </div>
                                <div class="col-12 col-lg-9">
                                    <span><?php echo $row->description; ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if(!empty($row->who_can_apply)): ?>
                            <div class="row pt-3">                
                                <div class="col-12 col-lg-3">
                                    <strong><?php echo $table_data->headers->who_can_apply; ?></strong>
                                </div>
                                <div class="col-12 col-lg-9">
                                    <span><?php echo $row->who_can_apply; ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if(!empty($row->country_text)): ?>
                            <div class="row pt-3">                
                                <div class="col-12 col-lg-3">
                                    <strong><?php echo $table_data->headers->country_text; ?></strong>
                                </div>
                                <div class="col-12 col-lg-9">
                                    <span><?php echo $row->country_text; ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if(!empty($row->deadline_to_decission)): ?>
                            <div class="row pt-3">                
                                <div class="col-12 col-lg-3">
                                    <strong><?php echo $table_data->headers->deadline_to_decission; ?></strong>
                                </div>
                                <div class="col-12 col-lg-9">
                                    <span><?php echo $row->deadline_to_decission; ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if(!empty($row->other_info)): ?>
                            <hr/>
                            <div class="row pt-3">                
                                <div class="col-12 pb-3">
                                    <strong><?php echo $table_data->headers->other_info; ?></strong>
                                </div>
                                <div class="col-12">
                                    <span><?php echo $row->other_info; ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php $idx += 1; ?>            
        <?php endforeach ?>
    <?php else: ?>
        <p class="p5 text-center">No results found</p>
    <?php endif; ?>
</div>
<script>
    $(document).ready(function(){
        $(".collapse").on('show.bs.collapse', function(){
        	$(this).parent().find(".card-icon").text("-");
        }).on('hide.bs.collapse', function(){
            $(this).parent().find(".card-icon").text("+");
        });
    });
</script>