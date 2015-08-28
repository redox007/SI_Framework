<div class="row-fluid sortable ui-sortable">
    <div class="box span12">

        <div class="box-header" data-original-title="">
            <h2><i class="halflings-icon user"></i><span class="break"></span><?php __e($panel_heading); ?></h2>
        </div>
        <div class="box-content">
            <?php // debug($agency); ?>
            <table class="table table-bordered table-striped">
                <tbody>
                    <?php if ($view_keys) { ?>
                        <?php foreach ($view_keys as $key => $value) { ?>
                            <tr>
                                <th><?php __e($value); ?></th>
                                <td><?php __ed($key, $view_data); ?></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div><!--/span-->

</div>

