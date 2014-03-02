<?php if(!empty($activities)):
foreach($activities as $activity): ?>
    <li class="notificationRow">
        <div class="grid3"><img class="mImage" src="<?php echo getAvatar($activity->avatar); ?>" /></div>
        <div class="grid9">
            <strong><?php echo $activity->first_name . ' ' . $activity->last_name; ?></strong> <?php echo $activity->action; ?>
            <span class="relative_time"><?php echo relative_time($activity->created_on); ?></span>
        </div>
        <div class="clear"></div>
    </li>
<?php endforeach;
else: ?>
    <li class="notificationRow">
        <div class="grid12 noActivity"><?php echo lang('No New Activity'); ?></div>
        <div class="clear"></div>
    </li>
<?php endif; ?>