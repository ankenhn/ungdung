<ul >
    <li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
        <a href="<?php echo site_url(SITE_AREA .'/settings/permissions') ?>"><i class="icos-list"></i><?php echo lang('All Permissions'); ?></a>
    </li>
    <li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?>>
        <a href="<?php echo site_url(SITE_AREA .'/settings/permissions/create') ?>" id="create_new"><i class="icos-create"></i><?php echo lang('Create'); ?></a>
    </li>
    <li>
        <a href="<?php echo site_url(SITE_AREA .'/settings/roles/permission_matrix') ?>" ><?php echo lang('Permissions Matrix'); ?></a>
    </li>
</ul>
