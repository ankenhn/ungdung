<?php if (has_permission('Emailer.Queue.Update') || has_permission('Emailer.Queue.Run') ):?>
    <ul>
        <li><a href="<?php echo site_url(MODULE_URL) ?>" title=""><i class="icos-list"></i><span>All Email Queue</span></a></li>
        <?php if(has_permission('Emailer.Queue.Update')): ?>
        <li><a href="<?php echo site_url(MODULE_URL.'/create') ?>" title=""><i class="icos-add"></i><span>Add Email Queue</span></a></li>
        <?php endif; ?>
    </ul>
<?php endif;?>