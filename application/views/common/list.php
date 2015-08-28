<div class="row-fluid sortable">
    <?php
    if (!isset($object)) {
        $object = 'object-custom';
    }
    ?>
    <?php
    if (!isset($search_param)) {
        $search_param = array();
    }
    ?>
    <div class="box span12 <?php __e(((isset($box_class)) ? $box_class : $object . '_box')); ?>" id="<?php __e(((isset($box_id)) ? $box_id : $object . '_box')); ?>" >
        <div class="box-header" data-original-title>
            <h2><i class="halflings-icon user"></i><span class="break"></span><?php __e($box_header) ?></h2>
        </div>
        <div class="box-content">
            <?php if (isset($show_search) && !isset($show_ajax_search)) load_view('search-template', 'common', $search_param); ?>         
            <?php if (isset($show_ajax_search)) load_view('ajax-search-template', 'common', $search_param); ?>         
            <?php load_view('list-template', 'common'); ?>         
        </div>
    </div><!--/span-->

</div><!--/row-->