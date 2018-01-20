$(function() {
    $('.row,nav,form').addClass('rtl');

});

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
        $.ajax({url: siteurl + 'adminupload/configupload',
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
})();
