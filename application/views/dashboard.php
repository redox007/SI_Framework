<div class="row-fluid">
    <div class="box-content">

        <a class="quick-button span2">
            <i class="fa fa-users fa-2x"></i>
            <p>Customers</p>
            <span class="notification blue"><?php __e($user_count); ?></span>
        </a>
        <a class="quick-button span2">
            <i class="fa fa-support fa-fw"></i>
            <p>Drivers</p>
            <span class="notification green"><?php __e($driver_count); ?></span>
        </a>
        <a class="quick-button span2">
            <i class="fa fa-bullhorn fa-2x"></i>
            <p>Orders</p>
            <span class="notification green"><?php __e($order_count); ?></span>
        </a>
        <a class="quick-button span2">
            <i class="fa fa-barcode"></i>
            <p>Bookings</p>
            <span class="notification green"><?php __e($booking_count); ?></span>
        </a>
        <a class="quick-button span2">
            <i class="fa fa-envelope"></i>
            <p>Messages</p>
        </a>
        <a class="quick-button span2">
            <i class="fa fa-calendar"></i>
            <p>Calendar</p>
            <span class="notification red">68</span>
        </a>
        <div class="clearfix"></div>
    </div>		
</div>		
<?php load_view('order_view_dashboard'); ?>