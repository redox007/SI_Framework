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
                        <label class="control-label" for="name">Name </label>
                        <div class="controls">
                            <input type="text" name="vehicle[name]" class="input-xlarge" id="name" value="<?php __efd('name', $vehicle); ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="model">Model No </label>
                        <div class="controls">
                            <input type="text" name="vehicle[model]" maxlength="10" class="input-xlarge" id="model" value="<?php __efd('model', $vehicle); ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="registration_no">Reg. no </label>
                        <div class="controls">
                            <input type="text" name="vehicle[registration_no]" autocomplete="off" class="input-xlarge" id="registration_no" value="<?php __efd('registration_no', $vehicle); ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="capacity">Tonnage</label>
                        <div class="controls">
                            <?php __e( form_dropdown('vehicle[capacity]', $tonnage_array, __rd('capacity', $vehicle),'class="input-xlarge"' )); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="type">Special Type</label>
                        <div class="controls">
                            <?php __e( form_dropdown('vehicle[type]', $special_types, __rd('type', $vehicle),'class="input-xlarge"' )); ?>
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

