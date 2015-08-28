<div class="list-item-container">
    <div class="list-items" id="list">
        <?php
        if (!isset($object)) {
            $object = 'object-custom';
        }
        ?>
        <table class="table table-striped table-bordered bootstrap-datatable list-table <?php echo (isset($js_sort) && $js_sort) ? 'datatable' : ''; ?>">
            <!-- apply class datatable to sortusing javascript -->
            <thead>
                <tr>
                    <?php
                    if ($list_headers) {
                        foreach ($list_headers as $key => $value) {
                            ?>
                            <th><?php __e($value); ?></th>
                            <?php
                        }
                    }
                    ?>
                </tr>
            </thead>   
            <tbody>
                <?php if (isset($list) && !empty($list)): ?>
                    <?php
                    foreach ($list as $k => $list_item):
                        $id = isset($list_item['id']) ? $list_item['id'] : $k;
                        ?>
                        <tr id="<?php __e("list-{$object}-{$id}"); ?>" class="<?php odd_even(($k + 1)); ?> ">
                            <?php foreach ($list_headers as $key => $val): ?>
                                <td class="center" id="<?php __e($object . '-' . $id . '-' . $key) ?>"><?php __ed($key, $list_item) ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr class="odd" >
                        <td colspan="<?php echo count($list_headers) + 1; ?>">No <?php echo $object; ?> found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table> 
        <?php if (isset($pagination)) { ?>
            <?php __e($pagination); ?>
        <?php } ?>
    </div>
</div>