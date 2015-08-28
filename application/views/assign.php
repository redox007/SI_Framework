<div class="row-fluid">
    <div class="box span12 order-info">
        <div class="box-header">
            <h2><i class="halflings-icon align-justify"></i><span class="break"></span>Order info</h2>
        </div>
        <div class="box-content">
            <table class="table table-bordered bootstrap-datatable">
                <tbody>
                    <tr>
                        <td>
                            <table class="table table-striped table-bordered bootstrap-datatable">
                                <tr>
                                    <td>From</td>
                                    <td><?php __ed('pickup_address', $booking); ?></td>
                                </tr>
                                <tr>
                                    <td>To</td>
                                    <td><?php __ed('drop_address', $booking); ?></td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table class="table  table-striped table-bordered bootstrap-datatable">
                                <tr>
                                    <td>Pickup Date</td>
                                    <td>
                                        <?php __e(implode(', ', __rd('dates', $booking))); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Pickup time</td>
                                    <td><?php __echeck(__rd('pickup_type', $booking) == 2, __rd('flex_time', $booking), __rd('booking_time', $booking)); ?></td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table class="table  table-striped table-bordered bootstrap-datatable">
                                <tr>
                                    <td>Estimated Distance</td>
                                    <td><?php __ed('estimated_distance', $booking); ?> KM</td>
                                </tr>
                                <tr>
                                    <td>Estimated cost</td>
                                    <td>Rs <?php __ed('estimated_cost', $booking); ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<form action="<?php __e(base_url('assign_booking/assign_to_booking')); ?>" method="post" >
    <div class="row-fluid">
        <div class="box span12">
            <a href="<?php  __e(admin_base_url('dashboard', false)); ?>" class="btn btn-primary" >Return to list</a>
            <button type="submit" id="assign-me" class="btn btn-primary pull-right" name="assign" value="assign" >Assign</button>
        </div>
    </div>
    <div class="row-fluid">
        <div class="box span6" id="drivers-list">
            <div class="box-header">
                <h2><i class="halflings-icon align-justify"></i><span class="break"></span>Drivers</h2>
            </div>
            <div class="box-content">
                <?php // load_view('search-template', 'common', array('search_type' => 'driver')); ?>
                <?php load_view('ajax-search-template', 'common', array('search_type' => 'driver', 'ajax_action' => base_url('assign_booking/drivers'))); ?>
                <?php load_view('list-template', 'common', $driver); ?> 
            </div>
        </div>
        <div class="box span6" id="agency-list">
            <div class="box-header">
                <h2><i class="halflings-icon align-justify"></i><span class="break"></span>Agency</h2>
            </div>
            <div class="box-content">
                <?php // load_view('search-template', 'common', array('search_type' => 'agency')); ?>
                <?php load_view('ajax-search-template', 'common', array('search_type' => 'agency', 'ajax_action' => base_url('assign_booking/agencies'))); ?> 
                <?php load_view('list-template', 'common', $agency); ?> 
            </div>
        </div>
    </div>
    <input type="hidden" value="<?php __e($booking_id); ?>" name="booking_id" />
    <input type="hidden" value="assign_booking" name="assign_booking" />
</form>