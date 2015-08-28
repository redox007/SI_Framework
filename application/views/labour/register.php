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
                            <input type="text" name="labour[name]" class="input-xlarge" id="name" value="<?php __efd('name', $labour); ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="agency_id">Select Agency </label>
                        <div class="controls">
                            <?php __e( form_dropdown('labour[agency_id]', $agencies, __rd('agency_id', $labour),'class="input-xlarge"' )); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="phone">Phone </label>
                        <div class="controls">
                            <input type="tel" maxlength="10" name="labour[phone]" class="input-xlarge" id="phone" value="<?php __efd('phone', $labour); ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="city">City </label>
                        <div class="controls">
                            <input type="text" name="labour[city]" class="input-xlarge" id="city" value="<?php __efd('city', $labour); ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="area">Area </label>
                        <div class="controls">
                            <input type="text" name="labour[area]" class="input-xlarge" id="area" value="<?php __efd('area', $labour); ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="address">Address </label>
                        <div class="controls">
                            <textarea name="labour[address]" class="input-xlarge" id="address"><?php __efd('address', $labour); ?></textarea>
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

