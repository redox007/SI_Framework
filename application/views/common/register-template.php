<?php $object_data = isset($object_data) ? $object_data : array(); ?>
<div class="row-fluid" id="register_form_id_<?php __e(isset($object) ? $object :''); ?>">		
    <div class="box span12">
        <div class="box-header" data-original-title>
            <h2><i class="halflings-icon user"></i><span class="break"></span><?php __e(isset($register_header) ? $register_header : "Register") ?></h2>
        </div>
        <div class="box-content span6">
            <div class="row">
                <form action="<?php __e(isset($action_url) ? $action_url : ''); ?>" method="post" class="ajax-form" data-clear="<?php __e((isset($action) && $action == 'update') ? "off" : '') ?>">
                    <table class="table rate_card_table table-striped table-bordered bootstrap-datatable <?php echo (isset($js_sort) && $js_sort) ? 'datatable' : ''; ?>">
                        <tbody>
                            <?php $i = 0; ?>
                            <?php if (isset($key_headers)): ?>
                                <?php foreach ($key_headers as $key => $val): ?>
                                    <tr id="<?php __e($key); ?>" class="<?php odd_even(( ++$i)); ?>">
                                        <th><?php __e($val); ?></th>
                                        <td class="center" id="<?php __e($object . '-' . $i . '-' . $key) ?>"><?php __ed($key, $object_data) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table> 
                </form>
            </div>
        </div>
    </div><!--/span-->
</div><!--/row-->