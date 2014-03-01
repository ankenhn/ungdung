$('.send_email').click(function() {
    $('.invList img').show();
    sendEmail();
});

var sendEmail = function() {
    $.ajax({
        type: 'post',
        url : '<?php echo site_url(MODULE_URL.'/send_email'); ?>',
        data: { queue_id: '<?php echo $this->uri->segment(5); ?>' },
        dataType : 'json',
        success: function(res) {
            var run_no_failed = parseInt($('.blue').html());
            var run_no_success = parseInt($('.red').html());
            if(res.status) {
                $('.red').html(run_no_success+1);
                $.jGrowl("Send email to "+res.email+" success");
            }
            else {
                $('.blue').html(run_no_failed+1);
                $('.sending').append('<div class="formRow">' +
                        '<div class="grid3"><label>Cant Send To Email:</label></div>' +
                        '<div class="grid9">'+res.email+'</div>' +
                        '<div class="clear"></div>' +
                    '</div>');
            }
            var Total = parseInt($('.green').html());
            var process = (run_no_failed+run_no_success+1)/Total*100;
            $('#bar').width(process+'%');
            if(typeof res.next =='undefined') {
                $('.invList img').hide();
                return false;
            }
            sendEmail();
        }
    });
}