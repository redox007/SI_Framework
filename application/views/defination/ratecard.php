<div class="row-fluid">		
    <div class="box span12">
        <div class="box-header" data-original-title>
            <h2><i class="halflings-icon user"></i><span class="break"></span><?php __e($box_header) ?></h2>
        </div>
        <div class="box-content span6">
            <div class="row">
                <form action="" method="post" class="ajax-form" data-clear="<?php __e(($action == 'update') ? "off" : '') ?>">
                    <table class="table rate_card_table table-striped table-bordered bootstrap-datatable <?php echo (isset($js_sort) && $js_sort) ? 'datatable' : ''; ?>">
                        <tbody>
                            <?php $i = 0; ?>
                            <?php foreach ($list_headers as $key => $val): ?>
                                <tr id="<?php __e($key); ?>" class="<?php odd_even(( ++$i)); ?>">
                                    <th><?php __e($val); ?></th>
                                    <td class="center" id="<?php __e($object . '-' . $i . '-' . $key) ?>"><?php __ed($key, $rate_card) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table> 
                </form>
            </div>
        </div>
    </div><!--/span-->
</div><!--/row-->