<link rel="stylesheet" href="<?php __e(base_url('assets/vendors/fullcalender/fullcalendar.min.css')) ?>" />
<script typt="text/javascript" src="<?php __e(base_url('assets/vendors/fullcalender/moment.min.js')) ?>" ></script>
<script typt="text/javascript" src="<?php __e(base_url('assets/vendors/fullcalender/fullcalendar.min.js')) ?>" ></script>
<script typt="text/javascript" src="<?php __e(base_url('assets/vendors/fullcalender/gcal.js')) ?>" ></script>
<script typt="text/javascript" src="<?php __e(base_url('assets/vendors/fullcalender/lang-all.js')) ?>" ></script>
<script type="text/javascript">
    $(function () {

        $('#dates').click(function () {
            $('#calendar').fullCalendar({
                // put your options and callbacks here
            });
            $('#popModel').modal();
        })
    });
</script>