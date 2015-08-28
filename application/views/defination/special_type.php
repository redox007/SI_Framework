<div class="row-fluid">		
    <div class="box span12">
        <div class="box-header" data-original-title>
            <h2><i class="halflings-icon user"></i><span class="break"></span><?php __e($box_header) ?></h2>
        </div>
        <div class="box-content span6">
            <div class="row">
                <table class="table rate_card_table table-striped table-bordered bootstrap-datatable <?php echo (isset($js_sort) && $js_sort) ? 'datatable' : ''; ?>">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Special type name</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($special_types)) { ?>
                            <?php foreach ($special_types as $splt) { ?>
                                <tr>
                                    <td><?php __ed('id',$splt); ?></td>
                                    <td><?php __ed('name',$splt); ?></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table> 
            </div>
        </div>
    </div><!--/span-->
</div><!--/row-->