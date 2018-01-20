$(function() {
    $('#formuppr').on('keydown', 'input', function(e) {
        var key = e.which;
        if (key == 13) {
            $('#sendup').trigger('click');
            return false;
        }
    })

    $('select').material_select();
    $('.row,nav,form').addClass('rtl');
    $('#sendup').on('click', function() {
        var formData = new FormData($('#formuppr')[0]);
        // alert(siteurl + "adminprize/upload")
        $.ajax({
            url: siteurl + "adminprize/upload",
            type: 'POST',
            data: formData,
            async: false,
            dataType: 'json',
            success: function(res) {
                if (res.id > 0) {
                    $('#errmsg').html('');
                    $('#okmsg').html(res.msg);
                } else {
                    $('#errmsg').html(res.msg);
                    $('#okmsg').html('');
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
    });
});