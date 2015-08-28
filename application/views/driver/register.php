<div class="row-fluid sortable ui-sortable">
    <div class="box span12">

        <div class="box-header" data-original-title="">
            <h2><i class="halflings-icon edit"></i><span class="break"></span><?php __e($panel_heading); ?></h2>
        </div>
        <div class="box-content">
            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <fieldset> 
                    <div class="control-group">
                        <label class="control-label" for="full_name">Name </label>
                        <div class="controls">
                            <input type="text" name="user[full_name]" class="input-xlarge" id="full_name" value="<?php __efd('full_name', $user); ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="license_no">License no </label>
                        <div class="controls">
                            <input type="tel" name="user[license_no]" maxlength="10" class="input-xlarge" id="license_no" value="<?php __efd('license_no', $user); ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="phone_no">Phone </label>
                        <div class="controls">
                            <input type="tel" name="user[phone_no]" maxlength="10" class="input-xlarge" id="phone_no" value="<?php __efd('phone_no', $user); ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="email_id">Email </label>
                        <div class="controls">
                            <input type="email" name="user[email_id]" autocomplete="off" class="input-xlarge" id="email_id" value="<?php __efd('email_id', $user); ?>">
                        </div>
                    </div>
                    <?php if ($action == 'insert') { ?>
                        <div class="control-group">
                            <label class="control-label" for="password">Password </label>
                            <div class="controls">
                                <input type="password" name="user[password]" autocomplete="off" class="input-xlarge" id="password" value="<?php __efd('password', $user); ?>">
                            </div>
                        </div>
                    <?php } ?>
                    <div class="control-group">
                        <label class="control-label" for="dob">Dob </label>
                        <div class="controls">
                            <input type="text" name="user[dob]" autocomplete="off" class="input-xlarge datepicker" data-date-format="yyyy-mm-dd" id="dob" value="<?php __efd('dob', $user, array('0000-00-00' => '')); ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="city">City </label>
                        <div class="controls">
                            <input type="text" name="user[city]" autocomplete="off" class="input-xlarge" id="city" value="<?php __efd('city', $user); ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="area">Area </label>
                        <div class="controls">
                            <input type="text" name="user[area]" autocomplete="off" class="input-xlarge" id="area" value="<?php __efd('area', $user); ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="pin">Pin </label>
                        <div class="controls">
                            <input type="text" name="user[pin]" autocomplete="off" class="input-xlarge" id="pin" value="<?php __efd('pin', $user); ?>">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="address">Address </label>
                        <div class="controls">
                            <textarea name="user[address]" autocomplete="off" class="input-xlarge" id="address" ><?php __efd('address', $user); ?></textarea>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="bank_name">Bank Name </label>
                        <div class="controls">
                            <input type="text" name="user[bank_name]" maxlength="17" autocomplete="off" class="input-xlarge" id="bank_name" value="<?php __efd('bank_name', $user); ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="bank_account_no">A/C no </label>
                        <div class="controls">
                            <input type="text" name="user[bank_account_no]" autocomplete="off" class="input-xlarge" id="bank_account_no" value="<?php __efd('bank_account_no', $user); ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="bank_ifsc_code">IFSC code </label>
                        <div class="controls">
                            <input type="text" name="user[bank_ifsc_code]" autocomplete="off" class="input-xlarge" id="bank_ifsc_code" value="<?php __efd('bank_ifsc_code', $user); ?>">
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

