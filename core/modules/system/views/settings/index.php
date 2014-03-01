<?php if (validation_errors()) : ?>
<div class="nNote error">
    <p>Please fix the following errors :</p>
    <?php echo validation_errors(); ?>
</div>
<?php endif; ?>

<?php echo form_open($this->uri->uri_string(), 'id="validate" autocomplete="off"'); ?>
<div class="fluid" id="webConfig">
    <div class="widget grid12">

        <div class="whead">
            <h6><?php echo lang("Basic Information"); ?></h6>
            <div class="clear"></div>
        </div>

        <div class="formRow">
            <div class="grid3"><label><?php echo lang("Site Name"); ?></label></div>
            <div class="grid9"><input type="text" name="title" id="title" class="validate[required]" value="<?php echo set_value('title',$settings['site.title']); ?>" /></div>
            <div class="clear"></div>
        </div>

        <div class="formRow">
            <div class="grid3"><label><?php echo lang("Meta Keyword"); ?></label></div>
            <div class="grid9"><input type="text" name="keyword" id="keyword" class="validate[required] tags" value="<?php echo set_value('keyword',$settings['meta.keyword']); ?>" /></div>
            <div class="clear"></div>
        </div>

        <div class="formRow">
            <div class="grid3"><label><?php echo lang("Meta Description"); ?></label></div>
            <div class="grid9">
                <textarea name="description" id="description" class="validate[required]"><?php echo set_value('description',$settings['meta.description']); ?></textarea>
            </div>
            <div class="clear"></div>
        </div>

        <div class="formRow">
            <div class="grid12"><input type="submit" name="webConfig" value="<?php echo lang("Submit"); ?>" class="buttonM bBlue formSubmit" /></div><div class="clear"></div>
        </div>
    </div>
</div>

<?php echo form_close(); ?>




<?php echo form_open($this->uri->uri_string().'#maintenance', 'id="validate" autocomplete="off"'); ?>
<div class="fluid" id="maintenance" style="display: none;">
    <div class="widget grid12">

        <div class="whead">
            <h6><?php echo lang("Basic Information"); ?></h6>
            <div class="clear"></div>
        </div>

        <div class="formRow">
            <div class="grid3"><label><?php echo lang("Site Maintenance"); ?></label></div>
            <div class="grid9">
                <select name="opMaintenance" id="opMaintenance" class="validate[required]">
                    <option value="">-- SELECT --</option>
                    <option value="0"><?php echo lang("Online"); ?></option>
                    <option value="1"><?php echo lang("Offline"); ?></option>
                </select>
                <script type="text/javascript">
                    cbo_Selected('opMaintenance','<?php echo set_value('opMaintenance',$settings['site.maintenance']); ?>');
                </script>
            </div>
            <div class="clear"></div>
        </div>

        <div class="formRow">
            <div class="grid3"><label><?php echo lang('Message'); ?>:<span class="req">*</span></label></div>
            <div class="grid9">
                <?php echo $this->ckeditor->editor("maintenance_content",html_entity_decode(set_value('maintenance_content',$settings['site.maintenance_content']))); ?>
            </div>
            <div class="clear"></div>
        </div>


        <div class="formRow">
            <div class="grid12"><input type="submit" name="btnMaintenance" value="<?php echo lang("Submit"); ?>" class="buttonM bBlue formSubmit" /></div><div class="clear"></div>
        </div>
    </div>
</div>

<?php echo form_close(); ?>



<?php echo form_open($this->uri->uri_string().'#emailSystem', 'id="validate" autocomplete="off"'); ?>
<div class="fluid" id="emailSystem" style="display: none;">
    <div class="widget grid12">

        <div class="whead">
            <h6><?php echo lang("Basic Information"); ?></h6>
            <div class="clear"></div>
        </div>

        <div class="formRow">
            <div class="grid3"><label><?php echo lang("Sender Email"); ?></label></div>
            <div class="grid9"><input type="text" name="sender_email" id="sender_email" class="validate[required]" value="<?php echo set_value('sender_email',$settings['sender_email']); ?>" /></div>
            <div class="clear"></div>
        </div>

        <div class="formRow">
            <div class="grid3"><label><?php echo lang("Sender Name"); ?></label></div>
            <div class="grid9"><input type="text" name="sender_name" id="sender_name" class="validate[required]" value="<?php echo set_value('sender_name',$settings['sender_name']); ?>" /></div>
            <div class="clear"></div>
        </div>

        <div class="formRow">
            <div class="grid3"><label><?php echo lang("Protocol"); ?></label></div>
            <div class="grid9">
                <select name="protocol" id="protocol" class="validate[required]">
                    <option value="">-- SELECT --</option>
                    <option value="mail"><?php echo lang("Mail Function"); ?></option>
                    <option value="sendmail"><?php echo lang("Send Mail"); ?></option>
                    <option value="smtp"><?php echo lang("SMTP"); ?></option>
                </select>
                <script type="text/javascript">
                    cbo_Selected('protocol','<?php echo set_value('protocol',$settings['protocol']); ?>');
                </script>
            </div>
            <div class="clear"></div>
        </div>

        <div class="formRow options sendMail">
            <div class="grid3"><label><?php echo lang("Mail Path"); ?></label></div>
            <div class="grid9"><input type="text" name="mailpath" id="mailpath" value="<?php echo set_value('mailpath',$settings['mailpath']); ?>" /></div>
            <div class="clear"></div>
        </div>

        <div class="formRow options SMTP">
            <div class="grid3"><label><?php echo lang("SMTP Host"); ?></label></div>
            <div class="grid9"><input type="text" name="smtp_host" id="smtp_host" value="<?php echo set_value('smtp_host',$settings['smtp_host']); ?>" /></div>
            <div class="clear"></div>
        </div>

        <div class="formRow options SMTP">
            <div class="grid3"><label><?php echo lang("SMTP User"); ?></label></div>
            <div class="grid9"><input type="text" name="smtp_user" id="smtp_user" value="<?php echo set_value('smtp_user',$settings['smtp_user']); ?>" /></div>
            <div class="clear"></div>
        </div>

        <div class="formRow options SMTP">
            <div class="grid3"><label><?php echo lang("SMTP Pass"); ?></label></div>
            <div class="grid9"><input type="password" name="smtp_pass" id="smtp_pass" value="<?php echo md5($settings['smtp_pass']); ?>" /></div>
            <div class="clear"></div>
        </div>

        <div class="formRow options SMTP">
            <div class="grid3"><label><?php echo lang("SMTP Port"); ?></label></div>
            <div class="grid9"><input type="text" name="smtp_port" id="smtp_port" value="<?php echo set_value('smtp_port',$settings['smtp_port']); ?>" /></div>
            <div class="clear"></div>
        </div>

        <div class="formRow options SMTP">
            <div class="grid3"><label><?php echo lang("SMTP Timeout"); ?></label></div>
            <div class="grid9"><input type="text" name="smtp_timeout" id="smtp_timeout" value="<?php echo set_value('smtp_timeout',$settings['smtp_timeout']); ?>" /></div>
            <div class="clear"></div>
        </div>

        <div class="formRow options SMTP">
            <div class="grid3"><label><?php echo lang("SMTP Crypto"); ?></label></div>
            <div class="grid9">
                <select name="smtp_crypto" id="smtp_crypto">
                    <option value="">-- SELECT --</option>
                    <option value="tls">TLS</option>
                    <option value="ssl">SSL</option>
                </select>
                <script type="text/javascript">
                    cbo_Selected('smtp_crypto','<?php  echo set_value('smtp_crypto',$settings['smtp_crypto']); ?>');
                </script>
            </div>
            <div class="clear"></div>
        </div>

        <div class="formRow">
            <div class="grid12"><input type="submit" name="emailSystem" value="<?php echo lang("Submit"); ?>" class="buttonM bBlue formSubmit" /></div><div class="clear"></div>
        </div>
    </div>
</div>

<?php echo form_close(); ?>
