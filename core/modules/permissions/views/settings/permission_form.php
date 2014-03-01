<?php if (validation_errors()) : ?>
    <div class="nNote error">
        <p>Please fix the following errors :</p>
        <?php echo validation_errors(); ?>
    </div>
<?php endif; ?>

<?php echo form_open($this->uri->uri_string(), 'id="validate"'); ?>
    <div class="fluid">
        <div class="widget grid12">
            <div class="whead"><h6>Basic Information</h6><div class="clear"></div> </div>

            <div class="formRow">
                <div class="grid3"><label>Permission:<span class="req">*</span></label></div>
                <div class="grid9"><input type="text" name="name" id="name" class="validate[required]" value="<?php echo set_value('name',isset($result) ? $result->name : ''); ?>" /></div>
                <div class="clear"></div>
            </div>

            <div class="formRow">
                <div class="grid3"><label>Description:</label></div>
                <div class="grid9">
                    <textarea name="description" id="description"><?php echo set_value('description',isset($result) ? $result->description : ''); ?></textarea>
                </div>
                <div class="clear"></div>
            </div>

            <div class="formRow">
                <div class="grid12"><input type="submit" name="submit" value="Submit" class="buttonM bBlue formSubmit" /></div><div class="clear"></div>
            </div>
        </div>
    </div>
<?php echo form_close(); ?>