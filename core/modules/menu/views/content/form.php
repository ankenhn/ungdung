<?php if (validation_errors()) : ?>
    <div class="nNote error">
        <p>Please fix the following errors :</p>
        <?php echo validation_errors(); ?>
    </div>
<?php endif; ?>

<?php echo form_open($this->uri->uri_string(), 'id="validate" autocomplete="off"'); ?>
<fieldset>
    <div class="fluid">
        <div class="widget grid12">

            <div class="whead">
                <h6><?php echo lang("Basic Information"); ?></h6>
                <div class="clear"></div>
            </div>

            <div class="formRow">
                <div class="grid3"><label><?php echo lang('Name'); ?>:<span class="req">*</span></label></div>
                <div class="grid9">
                    <input type="text" value="<?php echo set_value('name', isset($result) ? $result->name : ''); ?>" class="validate[required]" name="name" id="name"/>
                </div>
                <div class="clear"></div>
            </div>

            <div class="formRow">
                <div class="grid3"><label><?php echo lang('URL'); ?>:<span class="req">*</span></label></div>
                <div class="grid9">
                    <input type="text" value="<?php echo set_value('url', isset($result) ? $result->url : ''); ?>" class="validate[required]" name="url" id="url"/>
                </div>
                <div class="clear"></div>
            </div>

            <div class="formRow">
                <div class="grid3"><label><?php echo lang('Parent'); ?>:<span class="req">*</span></label></div>
                <div class="grid9"><select name="parent" id="parent">
                        <option value="0"><?php echo lang("SELECT"); ?></option>
                        <?php if (!empty($menu)):
                                foreach ($menu as $param): ?>
                                <option value="<?php echo $param->id; ?>"><?php echo $param->name; ?></option>
                                <?php endforeach;
                        endif; ?>
                    </select>
                    <script type="text/javascript">
                        cbo_Selected('parent', '<?php echo set_value("parent",isset($result) ? $result->parent : ""); ?>');
                    </script>
                </div>
                <div class="clear"></div>
            </div>


            <div class="formRow">
                <div class="grid3"><label>Image:</label></div>
                <div class="grid9">
                    <input type="button" class="buttonM bBlue" value="Upload" id="uploader" />
                    <input type="hidden" name="image" id="image" value="<?php echo set_value('image',isset($result) ? $result->image : false); ?>" />
                <?php if(is_file(set_value('image',isset($result) ? $result->image : false))): ?>
                    <br /><img class="preview" src="<?php echo site_url(set_value('image',isset($result) ? $result->image : false)); ?>" />
                <?php endif; ?>
                    <div class="contentProgress mt8"><div class="barB" id="bar"></div></div>
                </div>
                <div class="clear"></div>
            </div>

            <div class="formRow">
                <div class="grid3"><label><?php echo lang("Roles"); ?>:</label></div>
                <div class="grid9"><select class="multiple validate[required]" name="roles[]" id="roles" multiple="multiple">
                    <?php if (!empty($roles)):
                        if (isset($result)) {
                            $rl = json_decode($result->roles);
                        }
                        foreach ($roles as $k => $var): ?>
                        <option value="<?php echo $var->role_id; ?>"<?php if(in_array($var->role_id, isset($rl) ? $rl : array())) echo ' selected="selected"'; ?>><?php echo $var->role_name; ?></option>                        <?php endforeach;                        endif; ?>
                    </select>
                </div>
                <div class="clear"></div>
            </div>

            <div class="formRow">
                <div class="grid3"><label><?php echo lang("Target"); ?>:<span class="req">*</span></label></div>
                <div class="grid9"><select name="target" id="target">
                        <option value="_self">Self</option>
                        <option value="_blank">Blank</option>
                        <option value="_top">Top</option>
                    </select>
                    <script type="text/javascript">
                        cbo_Selected('target', '<?php echo set_value('target',isset($result) ? $result->target : ''); ?>');
                    </script>
                </div>
                <div class="clear"></div>
            </div>

            <div class="formRow">
                <div class="grid3"><label><?php echo lang("Status"); ?>:<span class="req">*</span></label></div>
                <div class="grid9"><select name="active" id="active">
                        <option value="1"><?php echo lang("Active"); ?></option>
                        <option value="0"><?php echo lang("Deactive"); ?></option>
                    </select></div>
                <div class="clear"></div>
            </div>

            <div class="formRow">
                <input type="submit" name="submit" value="<?php echo lang("Submit"); ?>" class="buttonM bBlue formSubmit"/>
                <div class="clear"></div>
            </div>

            <div class="clear"></div>
        </div>
    </div>
    <?php echo form_close(); ?>


    <?php echo form_open(site_url(MODULE_URL)); ?>
    <div class="fluid">
        <div class="widget gird12">
            <div class="whead"><h6><?php echo lang("Sub Menu"); ?></h6>
                <div class="clear"></div>
            </div>
            <table width="100%" cellspacing="0" cellpadding="0" id="checkAll" class="tDefault tMedia checkAll check">
                <thead>
                <tr>
                    <td><img alt="" src="<?php echo Template::theme_url('images/elements/other/tableArrows.png'); ?>"/>
                    </td>
                    <td><?php echo lang('Name'); ?></td>
                    <td><?php echo lang('URL'); ?></td>
                    <td style="width: 10em"><?php echo lang('us_status'); ?></td>
                </tr>
                </thead>

                <?php if (!empty($sub_menu)) : ?>
                <tfoot>
                <tr>
                    <td colspan="8">
                        <div class="itemActions">
                            <label>Apply action:</label>
                            <select name="action" id="action">
                                <option value="">Select action...</option>
                                <option value="Active">Active</option>
                                <option value="Deactive">Deactive</option>
                                <option value="Delete">Delete</option>
                            </select>
                            <input type="submit" value="<?php echo lang("Apply"); ?>" class="buttonS bGreen"/></div>
                    </td>
                </tr>
                </tfoot>
                <?php endif; ?>

                <tbody
                    class="sort">
                    <?php if (!empty($sub_menu)) : ?>
                        <?php foreach ($sub_menu as $var): ?>
                        <tr id="row_<?php echo ($var->id); ?>">
                            <td><input type="checkbox" id="titleCheck2" name="checked[]" value="<?php echo $var->id; ?>" /></td>
                            <td><?php echo anchor(MODULE_URL . '/edit/' . $var->id,$var->name); ?></td>
                            <td><?php echo anchor(site_url($var->url),site_url($var->url)); ?></td>
                            <td><?php echo showStatus($var->active); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="10" align="center"><?php echo lang("No item found that match your selection"); ?>.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php echo form_close(); ?>
</fieldset>