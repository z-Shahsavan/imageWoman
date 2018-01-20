
$(function() {
    $('#formreg').on('keydown', 'input', function(e) {
        var key = e.which;
        if (key == 13) {
            $('#send').trigger('click');
            return false;
        }
    })
    $('#send').on('click', function() {

        var data = $('#formreg').serialize();
        $.ajax({url: siteurl + 'adminabout/editaboutus',
            data: data,
            type: 'POST',
            dataType: 'json',
            success: function(result) {
                if (result.id > 0) {
                    $('#msgsuc').html(result.msg);
                    $('#msgerr').hide();
                    $('#msgsuc').show();
                } else {
                    $('#msgerr').html(result.msg);
                    $('#msgerr').show();
                    $('#msgsuc').hide();
                }
            }});
    });
})

