<?php echo theme_view('parts/header'); ?>
<?php Assets::add_js('files/login.js'); ?>


    <!-- Login wrapper begins -->
    <div class="loginWrapper">

        <!-- Current user form -->
        <?php echo form_open($this->uri->uri_string(),'id="validate"'); ?>
        <div id="form_login">
            <div class="loginPic">
                <div class="logo_shop"><?php echo Template::message(); ?></div>
                <span> </span>
                <div class="loginActions">
                </div>
            </div>

            <input type="text" name="login" id="login" placeholder="<?php echo lang("Email"); ?>" class="loginUsername validate[required,custom[email]]" />
            <input type="password" name="password" id="password" placeholder="<?php echo lang("Password"); ?>" class="loginPassword validate[required]" />

            <div class="logControl">
                <div class="memory">
                    <div style="float: left;">
                        <input type="checkbox" checked="checked" class="check" id="remember1" name="remember_me" value="1" /><label for="remember1"><?php echo lang("Remember me"); ?></label>
                    </div>
                    <div style="position: absolute; right: -10px;">
                        <a href="#" class="forgot_pass"><?php echo lang("Forgot Password"); ?>?</a>
                    </div>
                    <div class="clear"></div>
                </div>

                <input type="submit" name="submit" style="margin-top: 35px;" value="<?php echo lang("Login"); ?>" class="buttonM bBlue" />
                <div class="clear"></div>
            </div>
        </div>
        <?php echo form_close(); ?>

        <?php echo form_open(); ?>
        <div id="form_forgot" style="display: none;">
            <input type="text" name="email" id="email" placeholder="<?php echo lang("Email"); ?>" class="validate[custom[email]]" />
            <div class="logControl">
                <div class="memory">
                    <label><a class="flip_login"><?php echo lang("Login"); ?></a></label>
                </div>
                <a href="#" id="frmsend_info" class="buttonM bBlue"><?php echo (lang("Send")); ?></a>
                <div class="clear"></div>
            </div>
        </div>
        <?php echo form_close(); ?>

    </div>
    <!-- Login wrapper ends -->


    <div class="copyright"><?php echo lang('Developed by'); ?> <?php echo anchor(lang('author_url'),lang('author_name'),"target='_blank'"); ?></div>


<?php echo theme_view('parts/footer'); ?>