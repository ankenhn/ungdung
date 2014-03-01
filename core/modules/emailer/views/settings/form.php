<?php if (validation_errors()) : ?>
    <div class="nNote error">
        <p>Please fix the following errors :</p>
        <?php echo validation_errors(); ?>
    </div>
<?php endif; ?>

<?php echo form_open($this->uri->uri_string(), 'id="validate" autocomplete="off"'); ?>

<div class="fluid">
    <div class="widget grid12">

        <div class="whead">
            <h6><?php echo lang("Basic Information"); ?></h6>
            <div class="clear"></div>
        </div>

        <div class="formRow">
            <div class="grid3"><label><?php echo lang('To'); ?>:<span class="req">*</span></label></div>
            <div class="grid9">
                <input type="text" id="to" name="to" class="tags" value="<?php echo set_value('to',isset($result) ? implode(",",json_decode($result->to)) : ''); ?>" />
            </div>
            <div class="clear"></div>
        </div>

        <div class="formRow">
            <div class="grid3"><label><?php echo lang('Subject'); ?>:<span class="req">*</span></label></div>
            <div class="grid9">
                <input type="text" value="<?php echo set_value('subject',isset($result) ? $result->subject : ''); ?>" class="validate[required]" name="subject" id="subject"/>
            </div>
            <div class="clear"></div>
        </div>

        <div class="formRow">
            <div class="grid3"><label><?php echo lang('Message'); ?>:<span class="req">*</span></label></div>
            <div class="grid9">
                <?php echo $this->ckeditor->editor("textarea name","default textarea value"); ?>
            </div>
            <div class="clear"></div>
        </div>


        <div class="formRow">
            <div class="grid12"><input type="submit" name="submit" value="<?php echo lang("Submit"); ?>" class="buttonM bBlue formSubmit" /></div><div class="clear"></div>
        </div>

    </div>
</div>
<?php echo form_close(); ?>