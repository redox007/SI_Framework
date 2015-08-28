<div class="row-fluid sortable ui-sortable">
    <div class="box span12">

        <div class="box-header" data-original-title="">
            <h2><i class="halflings-icon user"></i><span class="break"></span><?php __e($panel_heading); ?></h2>
        </div>
        <div class="box-content">
            <?php // debug($vehicle); ?>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>Name</th>
                        <td><?php __ed('name',$vehicle); ?></td>
                    </tr>
                    <tr>
                        <th>Model</th>
                        <td><?php __ed('model',$vehicle); ?></td>
                    </tr>
                    <tr>
                        <th>Reg no.</th>
                        <td><?php __ed('registration_no',$vehicle); ?></td>
                    </tr>
                    <tr>
                        <th>Type</th>
                        <td><?php __ed('special_type',$vehicle); ?></td>
                    </tr>
                    <tr>
                        <th>Tonnage</th>
                        <td><?php __ed('capacity_text',$vehicle); ?></td>
                    </tr>
                    <tr>
                        <th>Created on</th>
                        <td><?php __ed('created_on',$vehicle); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div><!--/span-->

</div>

