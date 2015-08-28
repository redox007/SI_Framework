<div class="container-fluid-full">
    <div class="row-fluid">

        <div class="row-fluid">
            <div class="login-box">
                <div class="icons">
                    <a href="index.html"><i class="halflings-icon home"></i></a>
                    <a href="#"><i class="halflings-icon cog"></i></a>
                </div>
                <?php echo $action_messages; ?>
                <h2>Login to your account</h2>
                <form class="form-horizontal" action="" method="post">
                    <fieldset>
                        <div class="input-prepend" title="Username">
                            <span class="add-on"><i class="halflings-icon user"></i></span>
                            <input class="input-large span10" name="username" id="username" type="text" placeholder="type username"/>
                        </div>
                        <div class="clearfix"></div>

                        <div class="input-prepend" title="Password">
                            <span class="add-on"><i class="halflings-icon lock"></i></span>
                            <input class="input-large span10" name="password" id="password" type="password" placeholder="type password"/>
                        </div>
                        <div class="clearfix"></div>

                        <!--<label class="remember" for="remember"><input type="checkbox" id="remember" />Remember me</label>-->

                        <div class="button-login">
                            <input type="hidden" name="login" value="1" />
                            <input type="hidden" name="redirect" value="<?php __e($redirect); ?>" />
                            <button type="submit" name="submit" class="btn btn-primary">Login</button>
                            
                        </div>
                        
                        <div class="clearfix"></div>
                    </fieldset>
                </form>
                <hr>
                <h3>Forgot Password?</h3>
                <p>
                    No problem, <a href="#">click here</a> to get a new password.
                </p>	
            </div><!--/span-->
        </div><!--/row-->


    </div><!--/.fluid-container-->

</div><!--/fluid-row-->