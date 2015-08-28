<div class="pagination ajax-pagination <?php __echeck(isset($ajax_pagi) AND $ajax_pagi, 'ajax-pagination', ''); ?>">
    <?php __e($links); ?>
    <nav class="pull-right">
        <span>Showing <strong><?php __e($start); ?></strong> to <strong><?php __e($end); ?></strong> results of <strong><?php __e($total); ?></strong></span>
    </nav>
    <div class="clearfix"></div>
</div>