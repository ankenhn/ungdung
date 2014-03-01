$('.forgot_pass').click(function() {
    $('#form_login').slideUp(300,function() {
        $('#form_forgot').slideDown(300);
    });
});
$('.flip_login').click(function() {
    $('#form_forgot').slideUp(300,function(){
        $('#form_login').slideDown(300);
    });
});

$('#frmsend_info').click(function() {
    $.ajax({
        type:'post',
        url : 'forgot_password',
        data: { email: $('#email').val() },
        success: function(response) {
            $.jGrowl(response);
        }
    });
});