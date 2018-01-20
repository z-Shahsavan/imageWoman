var fledahanam;
$(function() {

    // getElementById
    function $id(id) {
        return document.getElementById(id);
    }
    $('#frmupload').on('keydown', 'input', function(e) {
        var key = e.which;
        if (key == 13) {
            $('#send').trigger('click');
            return false;
        }
    })
    $('#send').on('click', function() {
        var data = $('#frmupload').serialize();
        $.ajax({url: siteurl + 'contact/saveform',
            data: data,
            type: 'POST',
            dataType: 'json',
            success: function(result) {
                if (result.id > 0) {
                    $('#msgsuc2').html(result.msg);
                    $('#msgerr2').hide();
                    $('#frmupload')[0].reset();
                    $('#msgsuc2').show();
                } else {
                    $('#msgerr2').html(result.msg);
                    $('#msgerr2').show();
                    $('#msgsuc2').hide();
                }
            }});
    });
})();
