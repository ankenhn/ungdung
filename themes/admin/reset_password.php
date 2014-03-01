<?php echo theme_view('parts/header'); ?>
<?php Assets::add_js('files/login.js'); ?>


    <div class="loginWrapper">

        <!-- Current user form -->
        <?php echo form_open($this->uri->uri_string(),'id="validate"'); ?>
        <div class="loginPic">
            <div class="logo_shop"><img src="<?php echo $this->auth->userProfile($user->id)->avatar; ?>" style="max-width: 236px;max-height: 236px;;" /></div>
            <span> </span>
            <div class="loginActions">
            </div>
        </div>

        <input type="password" name="password" id="password" placeholder="New Password" class="loginPassword validate[required,minSize[8]]" />
        <input type="password" name="pass_confirm" id="pass_confirm" placeholder="Password Confirm" class="loginPassword validate[required,equals[password]]" />

        <div class="logControl">
            <input type="submit" name="submit" value="<?php echo lang("Save New Password"); ?>" class="buttonM bBlue" />
            <div class="clear"></div>
        </div>
        <?php echo form_close(); ?>

    </div>


    <div class="copyright">Developed by <?php echo anchor("http://jupitech.sg","Jupitech Solutions Pte. Ltd.","target='_blank'"); ?></div>


<?php echo theme_view('parts/footer'); ?>