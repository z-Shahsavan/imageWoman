$(function() {
    $('#formreg').on('keydown', 'input', function(e) {
        var key = e.which;
        if (key == 13) {
            $('#send').trigger('click');
            return false;
        }
    })
    $('#send').click(function() {
        var data = $('#formreg').serialize();
        $.ajax({url: siteurl + 'activecod/checkcod',
            data: data,
            type: 'POST',
            dataType: 'json',
            success: function(result) {
                if (parseInt(result.id) == 1) {
                    location.replace(siteurl + 'newpass');
                } else if (parseInt(result.id) == 0) {
                    $('#msgerrs').html(result.msg);
                    $('#msgerrs').show();
                    $('#msgsucs').hide();
                } else if (parseInt(result.id) == 2) {
                    $('#msgerrs').html(result.msg);
                    $('#msgerrs').show();
                    $('#msgsucs').hide();
                } else if (parseInt(result.id) == 3) {
                    $('#msgerrs').html(result.msg);
                    $('#msgerrs').show();
                    $('#msgsucs').hide();
                }
            }});
    })
})
