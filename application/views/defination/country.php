<div class="box span6">
    <div class="box-header" data-original-title="">
        <h2><i class="halflings-icon edit"></i><span class="break"></span><?php __e($panel_heading_country); ?></h2>
    </div>
    <div class="box-content">
        <form class="form-horizontal ajax-form" action="<?php __e(base_url('ajax?action=register_country')) ?>" method="post" enctype="multipart/form-data">
            <fieldset> 
                <div class="control-group">
                    <label class="control-label" for="country_name">Country </label>
                    <div class="controls">
                        <?php $state_name = isset($name) ? $name : ''; ?>
                        <input type="text" name="country[name]" required="" value="<?php __e($state_name); ?>" class="input-xlarge" id="country_name">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="country_code">Country code</label>
                    <div class="controls">
                        <?php $code = isset($code) ? $code : ''; ?>
                        <input type="text" name="country[code]" <?php __e($code); ?> class="input-xlarge" id="country_code">
                    </div>
                </div>

                <div class="form-actions">
                    <?php if (isset($id)) { ?>
                        <input type="hidden" name="id" value="<?php __e($id) ?>" />
                    <?php } ?>
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="reset" class="btn">Cancel</button>
                </div>
            </fieldset>
        </form>   

    </div>
</div><!--/span-->