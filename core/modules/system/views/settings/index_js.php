$('#protocol').change(function() {
    setEmailOptions($(this).val());
});
var setEmailOptions = function(option) {
    $('.options').hide();
    console.log(option);
    switch(option) {
        case 'sendmail':
            $('.sendMail').show();
        break;
        case 'smtp':
            $(".SMTP").show();
        break;
    }
};
setEmailOptions('<?php echo $settings['protocol']; ?>');