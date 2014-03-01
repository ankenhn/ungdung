<div class="widget ">
    <div class="whead">
        <h6><?php echo isset($toolbar_title) ? $toolbar_title : ''; ?></h6>
        <div class="clear"></div>
    </div>
    <table width="100%" cellspacing="0" cellpadding="0" class="tDefault tMedia kTable" data-source="<?php echo site_url(MODULE_URL.'/loadTable'); ?>">
        <thead>
        <tr>
            <th data-Keith="role_name"><?php echo lang("Role Name"); ?></th>
            <th data-Keith="__NO__SELECT__total_user" style="width: 11em"><?php echo lang("Total Users"); ?></th>
        </tr>
        </thead>

    </table>
</div>