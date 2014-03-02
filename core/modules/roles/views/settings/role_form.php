<?php if (validation_errors()) : ?>
    <div class="nNote error">
        <p>Please fix the following errors :</p>
        <?php echo validation_errors(); ?>
    </div>
<?php endif; ?>


<fieldset>
    <div class="fluid">
        <?php echo form_open($this->uri->uri_string(), 'id="validate"'); ?>
        <div class="widget grid4">
            <div class="whead"><h6><?php echo lang('Role Details') ?></h6><div class="clear"></div></div>
            <div class="formRow">
                <div class="grid3"><label><?php echo lang('Role Name'); ?>:<span class="req">*</span></label></div>
                <div class="grid9"><input type="text" value="<?php echo set_value('role_name',isset($role) ? $role->role_name : ''); ?>" class="validate[required]" name="role_name" id="role_name"/></div>
                <div class="clear"></div>
            </div>

            <div class="formRow">
                <div class="grid3"><label><?php echo lang('Login Destination'); ?>:<span class="req">*</span></label></div>
                <div class="grid9"><input type="text" value="<?php echo set_value('login_destination',isset($role) ? $role->login_destination : ''); ?>" class="validate[required]" name="login_destination" id="login_destination"/></div>
                <div class="clear"></div>
            </div>
            <div class="formRow">
                <div class="grid3"><label><?php echo lang('Description'); ?> :</label> </div>
                <div class="grid9">
                    <textarea rows="8" cols="" name="description" class="description" id="description"><?php echo set_value('description',isset($role) ? $role->description : ''); ?></textarea>
                    <span class="note" id="limitingtext">Field limited to 300 characters.</span>
                </div>
                <div class="clear"></div>
            </div>
        </div>

        <div class="widget grid7">
            <div class="whead"><h6>Roles</h6><div class="clear"></div></div>

            <?php echo modules::run('roles/settings/matrix/'.(isset($role) ? $role->role_id : '')); ?>


            <div class="formRow"><input type="submit" name="save" value="Submit" class="buttonM bBlue formSubmit" /><div class="clear"></div></div>
            <div class="clear"></div>
        </div>
        <?php echo form_close(); ?>
    </div>
</fieldset>
