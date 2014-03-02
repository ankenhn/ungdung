<?php echo Assets::css(); ?>
<?php echo Assets::js(); ?>
<script type="text/javascript">

    $(document).ready(function() {
        $.ajax({
            url: '<?php echo site_url(SITE_AREA.'/settings/activity/getNotification'); ?>',
            success: function(res) {
                $('#notification ul').append(res);
                $('img.mImage').fakecrop({wrapperWidth:50,wrapperHeight:50});
            }
        });
    });
</script>
</body>
</html>