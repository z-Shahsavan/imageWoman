$(function() {
    $('#formreg').on('keydown', 'input', function(e) {
        var key = e.which;
        if (key == 13) {
            $('#send').trigger('click');
            return false;
        }
    })
    $('#send').click(function() {
        $('#msgerr4').hide();
        $('#msgsuc4').html('لطفا صبر کنید...');
        $('#msgsuc4').show();

        var data = $('#formreg').serialize();
        $.ajax({url: siteurl + 'forgot/sendpass',
            data: data,
            type: 'POST',
            dataType: 'json',
            success: function(result) {

                if (parseInt(result.id) == 1) {
                    location.replace(siteurl + 'activecod');
                } else if (parseInt(result.id) == 0) {
                    $('#captcha').attr('src', siteurl + 'captcha/captcha.php?' + Math.random());
                    $('#msgerr4').html(result.msg);
                    $('#msgerr4').show();
                    $('#msgsuc4').hide();
                } else if (parseInt(result.id) == 2) {
                    $('#captcha').attr('src', siteurl + 'captcha/captcha.php?' + Math.random());
                    $('#msgerr4').html(result.msg);
                    $('#msgerr4').show();
                    $('#msgsuc4').hide();
                }
            }});
    })
})