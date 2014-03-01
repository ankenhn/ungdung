<?php echo form_open(); ?>
    <div class="widget ">
        <div class="whead">
            <span class="titleIcon check">
                <input type="checkbox" id="titleCheck" name="titleCheck" />
            </span>
            <h6><?php echo $toolbar_title; ?></h6>
            <div class="clear"></div>
        </div>
        <table width="100%" cellspacing="0" cellpadding="0" id="checkAll" class="tDefault tMedia checkAll check">
            <thead>
            <tr>
                <td><img alt="" src="<?php echo Template::theme_url('images/elements/other/tableArrows.png'); ?>" /></td>
                <td><?php echo lang('Name'); ?></td>
                <td><?php echo lang('URL'); ?></td>
                <td style="width: 10em"><?php echo lang('us_status'); ?></td>
            </tr>
            </thead>
            <?php if (!empty($results)) : ?>
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
                            <input type="submit" value="Apply" class="buttonS bGreen" />
                        </div>
                    </td>
                </tr>
                </tfoot>
            <?php endif; ?>

            <tbody class="sort">
            <?php if (!empty($results)) : ?>
                <?php foreach ($results as $result): ?>
                    <tr id="row_<?php echo $result->id; ?>">
                        <td><input type="checkbox" id="titleCheck2" name="checked[]" value="<?php echo $result->id; ?>" /></td>
                        <td><?php echo anchor(MODULE_URL.'/edit/'. $result->id,$result->name); ?></td>
                        <td><?php echo anchor(site_url($result->url),site_url($result->url)); ?></td>
                        <td><?php echo showStatus($result->active); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" align="center">No item found that match your selection.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php echo form_close(); ?>