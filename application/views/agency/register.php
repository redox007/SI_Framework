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
                            <input type="text" name="agency[name]" class="input-xlarge" id="name" value="<?php __efd('name', $agency); ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="registration_no">Registration no </label>
                        <div class="controls">
                            <input type="text" name="agency[registration_no]" class="input-xlarge" id="registration_no" value="<?php __efd('registration_no', $agency); ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="owner_no">Owner user </label>
                        <div class="controls">
                            <input type="text" name="agency[owner_name]" class="input-xlarge" id="owner_no" value="<?php __efd('owner_name', $agency); ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="owner_name">Owner Name </label>
                        <div class="controls">
                            <input type="text" name="agency[owner_no]" class="input-xlarge" id="owner_name" value="<?php __efd('owner_no', $agency); ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="owner_contact_name">Owner Contact name </label>
                        <div class="controls">
                            <input type="text" name="agency[owner_contact_name]" class="input-xlarge" id="owner_contact_name" value="<?php __efd('owner_contact_name', $agency); ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="owner_contact_no">Owner Contact no </label>
                        <div class="controls">
                            <input type="text" name="agency[owner_contact_no]" class="input-xlarge" id="owner_contact_no" value="<?php __efd('owner_contact_no', $agency); ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="city">City </label>
                        <div class="controls">
                            <input type="text" name="agency[city]" class="input-xlarge" id="city" value="<?php __efd('city', $agency); ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="area">Area </label>
                        <div class="controls">
                            <input type="text" name="agency[area]" class="input-xlarge" id="registration_no" value="<?php __efd('area', $agency); ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="pin_code">Pin Code </label>
                        <div class="controls">
                            <input type="text" name="agency[pin_code]" class="input-xlarge" id="pin_code" value="<?php __efd('pin_code', $agency); ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="agency_bank_name">Agency Bank name </label>
                        <div class="controls">
                            <input type="text" name="agency[agency_bank_name]" class="input-xlarge" id="agency_bank_name" value="<?php __efd('agency_bank_name', $agency); ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="agency_bank_accont_no">Agency bank A/C </label>
                        <div class="controls">
                            <input type="text" name="agency[agency_bank_accont_no]" class="input-xlarge" id="agency_bank_accont_no" value="<?php __efd('agency_bank_accont_no', $agency); ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="agency_bank_ifsc">Agency bank IFSC</label>
                        <div class="controls">
                            <input type="text" name="agency[agency_bank_ifsc]" class="input-xlarge" id="agency_bank_ifsc" value="<?php __efd('agency_bank_ifsc', $agency); ?>">
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

