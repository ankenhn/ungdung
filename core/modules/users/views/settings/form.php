<?php if (validation_errors()) : ?>
    <div class="nNote error">
        <p>Please fix the following errors :</p>
        <?php echo validation_errors(); ?>
    </div>
<?php endif; ?>

<?php echo form_open($this->uri->uri_string(), 'id="validates"'); ?>
<div class="fluid">
    <div class="widget grid6">
        <div class="whead"><h6><?php echo lang('Basic Information'); ?></h6><div class="clear"></div> </div>

        <div class="formRow">
            <div class="grid3"><label><?php echo lang('First Name'); ?>:<span class="req">*</span></label></div>
            <div class="grid9"><input type="text" name="first_name" id="first_name" class="validate[required]" value="<?php echo set_value('first_name',isset($user) ? $user->first_name : ''); ?>" /></div>
            <div class="clear"></div>
        </div>

        <div class="formRow">
            <div class="grid3"><label><?php echo lang('Last Name'); ?>:<span class="req">*</span></label></div>
            <div class="grid9"><input type="text" name="last_name" id="last_name" class="validate[required]" value="<?php echo set_value('last_name',isset($user) ? $user->last_name : ''); ?>" /></div>
            <div class="clear"></div>
        </div>

        <div class="formRow">
            <div class="grid3"><label><?php echo lang('Email'); ?>:<span class="req">*</span></label></div>
            <div class="grid9"><input type="text" name="email" id="email" class="validate[required,custom[email]]" value="<?php echo set_value('email',isset($user) ? $user->email : ''); ?>" /></div>
            <div class="clear"></div>
        </div>

        <div class="formRow">
            <div class="grid3"><label><?php echo lang('Password'); ?>:</label></div>
            <div class="grid9"><input type="password" name="password" id="password"<?php if(!isset($user)) echo ' class="validate[required]"'; ?> /></div>
            <div class="clear"></div>
        </div>

        <div class="formRow">
            <div class="grid3"><label><?php echo lang('Pass Confirm'); ?>:</label></div>
            <div class="grid9"><input type="password" name="pass_confirm" id="pass_confirm" class="validate[<?php if(!isset($user)) echo 'required,'; ?>equals[password]]" /></div>
            <div class="clear"></div>
        </div>
        <?php if(has_permission('Permission.Users.Manage') AND has_permission('Site.Roles.Manage')): ?>
        <div class="formRow">
            <div class="grid3"><label><?php echo lang('Role Name'); ?>:<span class="req">*</span> </label></div>
            <div class="grid9">
                <select name="role_id" id="role_id" class="validate[required]">
                    <?php foreach($roles as $role):
                    if(has_permission('Site.'.$role->role_name.'.Manage')): ?>
                        <option value="<?php echo $role->role_id; ?>"><?php echo $role->role_name; ?></option>
                    <?php endif;
                        endforeach; ?>
                </select>
                <script type="text/javascript">
                    cbo_Selected('active','<?php echo set_value('active',isset($user) ? $user->active : 1); ?>');
                </script>
            </div>
            <div class="clear"></div>
        </div>
        <?php endif; ?>
        <div class="formRow">
            <div class="grid3"><label><?php echo lang('Active'); ?>:<span class="req">*</span> </label></div>
            <div class="grid9">
                <select name="active" id="active" class="validate[required]">
                    <option value="1"><?php echo lang('Active'); ?></option>
                    <option value="0"><?php echo lang('Deactive'); ?></option>
                </select>
                <script type="text/javascript">
                    cbo_Selected('active','<?php echo set_value('active',isset($user) ? $user->active : 1); ?>');
                </script>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="widget grid6">
        <div class="whead"><h6><?php echo lang('Profile'); ?></h6><div class="clear"></div> </div>

        <div class="formRow">
            <div class="grid3"><label><?php echo lang('Birthday'); ?>:</label></div>
            <div class="grid9"><input type="text" name="birthday" id="birthday" class="datepicker validate[custom[date]]" value="<?php echo set_value('birthday',isset($user) ? dateToStr($user->birthday) : ''); ?>" /></div>
            <div class="clear"></div>
        </div>

        <div class="formRow">
            <div class="grid3"><label><?php echo lang('Avatar'); ?>:</label></div>
            <div class="grid9">
                <input type="button" class="buttonM bBlue" value="<?php echo lang("Upload"); ?>" id="uploader" />
                <input type="hidden" name="avatar" id="avatar" value="<?php echo is_file($file = set_value('avatar',isset($user) ? $user->avatar : false)) ? site_url($file) : ''; ?>" />
                <?php if(is_file($file)): ?>
                    <br /><img class="preview" src="<?php echo site_url($file); ?>" />
                <?php endif; ?>
                <div class="contentProgress mt8"><div class="barB" id="bar"></div></div>
            </div>
            <div class="clear"></div>
        </div>

        <div class="formRow">
            <div class="grid3"><label><?php echo lang('Created By'); ?>:</label></div>
            <div class="grid9">
                <?php echo isset($user) ? anchor(MODULE_URL.'/profile/'.$user->created_by,$this->auth->name($user->created_by)).' at '.datetimeToStr($user->created_on) : ''; ?>
            </div>
            <div class="clear"></div>
        </div>
        <div class="formRow">
            <div class="grid3"><label><?php echo lang('Modify By'); ?>:</label></div>
            <div class="grid9">
                <?php echo isset($user) ? anchor(MODULE_URL.'/profile/'.$user->modify_by,$this->auth->name($user->modify_by)).' at '.datetimeToStr($user->modify_on) : ''; ?>
            </div>
            <div class="clear"></div>
        </div>
        <div class="formRow">
            <div class="grid12"><input type="submit" name="submit" value="<?php echo lang("Save"); ?>" class="buttonM bBlue formSubmit" /></div><div class="clear"></div>
        </div>
    </div>
</div>
<?php echo form_close(); ?>