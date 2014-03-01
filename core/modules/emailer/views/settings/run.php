<div class="fluid">

    <div class="widget grid4">

        <div class="whead">
            <h6>Queue Statistics</h6>
            <div class="clear"></div>
        </div>

        <div class="body">
            <ul class="wInvoice">
                <li><h4 class="red"><?php echo $send_success = count(json_decode($result->send_success)); ?></h4><span> success</span></li>
                <li><h4 class="blue"><?php echo $send_failed = count(json_decode($result->send_failed)); ?></h4><span> error</span></li>
                <li><h4 class="green"><?php echo $send_total = count(json_decode($result->to)); ?></h4><span>total email</span></li>
            </ul>
            <div class="contentProgress" style="display: block"><div id="bar" class="barG tipN" style="width: <?php echo round(($send_success + $send_failed)/$send_total*100); ?>%"></div></div>
            <ul class="ruler">
                <li>0</li>
                <li class="textC">50%</li>
                <li class="textR">100%</li>
            </ul>
            <div class="invList fluid">
                <span class="grid6"><img src="<?php echo Template::theme_url('images/elements/loaders/7.gif'); ?>" /> &NonBreakingSpace;</span>
                <a class="buttonS bLightBlue grid6 send_email" title="" href="#">Send Email</a>
            </div>
        </div>
    </div>

    <div class="widget grid8">
        <div class="whead">
            <h6>Queue Error</h6><div class="clear"></div>
        </div>
        <div class="sending">
            <?php $send_error = json_decode($result->send_failed);
            if(!empty($send_error)):
            foreach($send_error as $var): ?>
                <div class="formRow">
                    <div class="grid3"><label>Cant Send To Email:</label></div>
                    <div class="grid9"><?php echo $var; ?></div>
                    <div class="clear"></div>
                    </div>
            <?php endforeach;
            endif; ?>
        </div>
    </div>
</div>