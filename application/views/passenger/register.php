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
                        <label class="control-label" for="full_name">Name </label>
                        <div class="controls">
                            <input type="text" name="user[full_name]" class="input-xlarge" id="full_name" value="<?php __efd('full_name', $user); ?>">
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
<!--                    <div class="control-group">
                        <label class="control-label" for="file">Profile Pic </label>
                        <div class="controls">
                            <input type="file" name="profile_pic">
                        </div>
                    </div>-->
                    <?php if ($action == 'insert') { ?>
                        <div class="control-group">
                            <label class="control-label" for="password">Password </label>
                            <div class="controls">
                                <input type="password" name="user[password]" autocomplete="off" class="input-xlarge" id="password" value="<?php __efd('password', $user); ?>">
                            </div>
                        </div>
                    <?php } ?>
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

