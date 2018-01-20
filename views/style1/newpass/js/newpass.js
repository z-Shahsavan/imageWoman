$(function() {
    $('#changepasssend').click(function() {
        var data = $('#formpassword').serialize();
        $.ajax({url: siteurl + 'newpass/newpass',
            data: data,
            type: 'POST',
            dataType: 'json',
            success: function(result) {
                if (result.id >0) {
                    window.location = (siteurl + 'index#loginlink');
                    window.location.href = (siteurl + 'index#loginlink');
                } else {
                    $('#errpass').html(result.msg);
                    $('#errpass').show();
                    $('#msgpass').hide();
                } 
            }});
    })
})