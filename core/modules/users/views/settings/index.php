<div class="widget ">
    <div class="whead">
        <h6><?php echo isset($toolbar_title) ? $toolbar_title : ''; ?></h6>
        <div class="clear"></div>
    </div>
    <table width="100%" cellspacing="0" cellpadding="0" class="tDefault tMedia kTableFull" data-source="<?php echo site_url(MODULE_URL.'/loadTable'); ?>">
        <thead>
        <tr>
            <th data-Keith="__NO__SELECT__full_name"><?php echo lang('Full Name'); ?></th>
            <th data-Keith="email"><?php echo lang('Email'); ?></th>
            <th data-Keith="role_name"><?php echo lang('Role Name'); ?></th>
            <th data-Keith="last_login"><?php echo lang('Last Login'); ?></th>
            <th data-Keith="active" style="width: 11em"></th>
        </tr>
        </thead>

    </table>
</div>