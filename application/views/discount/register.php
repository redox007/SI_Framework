<div class="row-fluid sortable ui-sortable">
    <div class="box span12">

        <div class="box-header" data-original-title="">
            <h2><i class="halflings-icon edit"></i><span class="break"></span><?php __e($panel_heading); ?></h2>
            <!--            <div class="box-icon">
                            <a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
                            <a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
                            <a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
                        </div>-->
        </div>
        <div class="box-content">
            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <fieldset> 
                    <div class="control-group">
                        <label class="control-label" for="coupon_code">Discount Code </label>
                        <div class="controls">
                            <div class="input-append">
                                <input id="coupon_code" size="16" readonly="" name="discount[coupon_code]" <?php echo ($action == 'update') ? 'readonly=""' : ''; ?>  value="<?php __efd('coupon_code', $discount); ?>" type="text">
                                <button class="btn" id="generate_coupon" <?php echo ($action == 'update') ? 'disabled=""' : ''; ?> type="button">Generate</button>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="discount_persent">Discount percent </label>
                        <div class="controls">
                            <input type="number" name="discount[discount_persent]" class="input-xlarge" id="name" value="<?php __efd('discount_persent', $discount); ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="discount_persent">Discount amount </label>
                        <div class="controls">
                            <input type="number" name="discount[discount_amount]" class="input-xlarge" id="discount_amount" value="<?php __efd('discount_amount', $discount); ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="validity">Discount validity </label>
                        <div class="controls">
                            <input type="number" name="discount[validity]" class="input-xlarge" id="validity" value="<?php __efd('validity', $discount,7); ?>">
                        </div>
                    </div>

                    <div class="form-actions">
                        <input type="hidden" name="action" value="<?php __e($action, 'insert'); ?>" />
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        <button type="reset" class="btn">Cancel</button>
                    </div>
                </fieldset>
            </form>   

        </div>
    </div><!--/span-->

</div>
<script type="text/javascript">
    jQuery(function ($) {
        $('#generate_coupon').click(function () {
            var bt = $(this);
            bt.attr('disabled', 'disabled');
            $.get(ajax_url, {action: 'generate_coupon'}, function (data) {
                $('input[name="discount[coupon_code]"]').val(data);
                bt.removeAttr('disabled');
            })
        });
    });
</script>
