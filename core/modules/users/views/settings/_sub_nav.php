<?php if (has_permission('Permission.Users.Manage')):?>
    <ul>
        <li><a href="<?php echo site_url(MODULE_URL) ?>" title=""><i class="icos-list"></i><span><?php echo lang('Users Manage'); ?></span></a></li>
        <li><a href="<?php echo site_url(MODULE_URL.'/create') ?>" title=""><i class="icos-add"></i><span><?php echo lang('Create User'); ?></span></a></li>
    </ul>
<?php endif;?>