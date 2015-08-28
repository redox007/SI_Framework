<div class="box span6">
    <div class="box-header" data-original-title="">
        <h2><i class="halflings-icon edit"></i><span class="break"></span><?php __e($panel_heading_state); ?></h2>
    </div>
    <div class="box-content">
        <form class="form-horizontal ajax-form" action="<?php __e(base_url('ajax?action=register_state')) ?>" method="post" enctype="multipart/form-data">
            <fieldset> 
                <div class="control-group">
                    <label class="control-label" for="state_name">State info </label>
                    <div class="controls">
                        <?php $state_name = isset($name) ? $name : ''; ?>
                        <input type="text" name="state[name]" required="" value="<?php __e($state_name); ?>" class="input-xlarge" id="state_name">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="state_country">Country </label>
                    <div class="controls">
                        <?php $country = isset($country) ? $country : ''; ?>
                        <?php __e(form_dropdown('state[country]', $countries, $country, 'required="" class="input-xlarge" id="state_country"')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="state_code">Code </label>
                    <div class="controls">
                        <?php $code = isset($code) ? $code : ''; ?>
                        <input type="text" name="state[code]" class="input-xlarge" value="<?php __e($code); ?>" id="state_code">
                    </div>
                </div>
                <?php if (isset($id)) { ?>
                    <input type="hidden" name="id" value="<?php __e($id) ?>" />
                <?php } ?>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="reset" class="btn">Cancel</button>
                </div>
            </fieldset>
        </form>   

    </div>
</div><!--/span-->