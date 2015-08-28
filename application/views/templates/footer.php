
<!-- start: JavaScript-->

<script src="<?php echo base_url(); ?>assets/js/jquery-migrate-1.0.0.min.js"></script>

<script src="<?php echo base_url(); ?>assets/js/jquery-ui-1.10.0.custom.min.js"></script>

<script src="<?php echo base_url(); ?>assets/js/jquery.ui.touch-punch.js"></script>

<script src="<?php echo base_url(); ?>assets/js/modernizr.js"></script>

<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>

<script src="<?php echo base_url(); ?>assets/js/jquery.cookie.js"></script>

<script src='<?php echo base_url(); ?>assets/js/fullcalendar.min.js'></script>

<script src='<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js'></script>

<script src="<?php echo base_url(); ?>assets/js/excanvas.js"></script>

<script src="<?php echo base_url(); ?>assets/js/jquery.flot.js"></script>

<script src="<?php echo base_url(); ?>assets/js/jquery.flot.pie.js"></script>

<script src="<?php echo base_url(); ?>assets/js/jquery.flot.stack.js"></script>

<script src="<?php echo base_url(); ?>assets/js/jquery.flot.resize.min.js"></script>

<script src="<?php echo base_url(); ?>assets/js/jquery.chosen.min.js"></script>

<script src="<?php echo base_url(); ?>assets/js/jquery.uniform.min.js"></script>

<script src="<?php echo base_url(); ?>assets/js/jquery.cleditor.min.js"></script>

<script src="<?php echo base_url(); ?>assets/js/jquery.elfinder.min.js"></script>

<script src="<?php echo base_url(); ?>assets/js/jquery.raty.min.js"></script>

<script src="<?php echo base_url(); ?>assets/js/jquery.iphone.toggle.js"></script>

<script src="<?php echo base_url(); ?>assets/js/jquery.uploadify-3.1.min.js"></script>

<script src="<?php echo base_url(); ?>assets/js/jquery.gritter.min.js"></script>

<script src="<?php echo base_url(); ?>assets/js/jquery.imagesloaded.js"></script>

<script src="<?php echo base_url(); ?>assets/js/jquery.masonry.min.js"></script>

<script src="<?php echo base_url(); ?>assets/js/jquery.knob.modified.js"></script>

<script src="<?php echo base_url(); ?>assets/js/jquery.sparkline.min.js"></script>

<script src="<?php echo base_url(); ?>assets/js/counter.js"></script>

<script src="<?php echo base_url(); ?>assets/js/retina.js"></script>

<script src="<?php echo base_url(); ?>assets/js/custom.js"></script>

<!-- end: JavaScript-->

<?php load_js('assets/custom/js/bootstrap-datepicker.min.js'); ?>

<?php load_js('assets/custom/js/jquery.blockUI.js'); ?>

<?php load_js('assets/custom/js/jquery.form.min.js'); ?>

<?php load_js('assets/custom/js/custom-scripts.js'); ?>

<?php load_js('assets/vendors/bootstrap-timepicker.js'); ?>

<?php load_view('noty', 'common'); ?>

<?php
if (isset($_auto_load_scripts_footer)) {
    foreach ($_auto_load_scripts_footer as $script) {
        __e($script);
    }
}
?>
<script type="text/javascript" >
    $(function () {
        $('.sidebar-nav li a.dropmenu').click(function () {
            $(this).find('.dropper-icon i').toggleClass('fa-arrow-circle-o-right');
            $(this).find('.dropper-icon i').toggleClass('fa-arrow-circle-o-down');
        });
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });
        $('body').on('click','.ajax-pagination ul#pagination a',function(e){
            e.preventDefault();
            if($(this).parent().hasClass('active')){
                return false;
            }
            var parent_list_container = $(this).parent().parent().parent().parent().parent();
            blockUi(parent_list_container,"loading");
            var href = $(this).attr('href');
            parent_list_container.load(href + ' #list');
            unBlockUi(parent_list_container);
        });
        $('.search-button').click(searchme);
        function searchme(e){
            e.preventDefault();
            var search_type = $(this).parent().find('.search-box').data('search_type');
            var result = $(this).parent().find('.search-box').data('result');
            var action = $(this).parent().find('.search-box').data('action');
            var val = $(this).parent().find('.search-box').val();
            
            var href = action + '?search_type=' + search_type+'&s='+val; 
            
            var parent_list_container = $(this).parent().next('.list-item-container');
            if(result){
                parent_list_container = $('#'+result);
            }
            blockUi(parent_list_container,"loading");
            parent_list_container.load(href + ' #list');
            unBlockUi(parent_list_container);
        }
    });
</script>

</body>
</html>