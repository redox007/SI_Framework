<div class="row-fluid sortable ui-sortable">
    <div class="box span12">

        <div class="box-header" data-original-title="">
            <h2><i class="halflings-icon user"></i><span class="break"></span><?php __e($panel_heading); ?></h2>
        </div>
        <div class="box-content">
            <?php // debug($user); ?>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>Name</th>
                        <td><?php __ed('full_name',$user); ?></td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td><?php __ed('phone_no',$user); ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?php __ed('email_id',$user); ?></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td><?php __ed('status',$user); ?></td>
                    </tr>
                    <tr>
                        <th>Created On</th>
                        <td><?php __ed('created_on',$user); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div><!--/span-->

</div>

