<div class="box span6">
    <div class="box-header" data-original-title="">
        <h2><i class="halflings-icon edit"></i><span class="break"></span><?php __e($panel_heading_city); ?></h2>
    </div>
    <div class="box-content">
        <form class="form-horizontal ajax-form" action="<?php __e(base_url('ajax?action=register_city')) ?>" method="post" enctype="multipart/form-data">
            <fieldset> 
                <div class="control-group">
                    <label class="control-label" for="city_name">City name </label>
                    <div class="controls">
                        <?php $city_name = isset($name) ? $name : ''; ?>
                        <input type="text" required="" name="city[name]" class="input-xlarge" value="<?php __e($city_name); ?>" id="city_name">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="city_state">State </label>
                    <div class="controls">
                        <?php $state = isset($state) ? $state : ''; ?>
                        <?php __e(form_dropdown('city[state]', $states, $state, 'required="" class="input-xlarge" id="city_state"')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="city_country">Country </label>
                    <div class="controls">
                        <?php $country = isset($country) ? $country : ''; ?>
                        <?php __e(form_dropdown('city[country]', $countries, $country, 'required="" class="input-xlarge" id="city_country"')); ?>
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