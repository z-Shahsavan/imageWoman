$(function (){
    
    $('#formlogin').on('keydown', 'input', function(e) {
        var key = e.which;
        if (key == 13) {
            $('#btnlogin').trigger('click');
            return false;
        }
    })
    
    
     $('#btnlogin').click( function() {
//        $('#btnlogin').addClass('none');
//        $('.logfrmdiv').append('<img src="'+siteurl+'images/icons/loading.gif" id="loadingpic" >');
        if (($('#username').val().trim()).length == 0 || ($('#password').val().trim()).length == 0){
            return ;
        }
        var data = {uid: $('#username').val(), pass: $('#password').val()};
        $.ajax({url: siteurl + 'login/login/',
            data: data,
            type: 'POST',
            dataType: 'json',
            success: function(result) {
                if (parseInt(result.id) > 0) {
                    switch (parseInt(result.rol)) {
                        case 1:
                            window.location = (siteurl + 'blog/id/'+result.userid);
                            window.location.href = (siteurl +  'blog/id/'+result.userid);
                            break;
                        case 2:
                            window.location = (siteurl + 'verdict/index');
                            window.location.href = (siteurl + 'verdict/index');
                            break;
                        case 3:
                            window.location = (siteurl + 'bazbin/index');
                            window.location.href = (siteurl + 'bazbin/index');
                            break;
                        case 4:
                            window.location = (siteurl + 'adminuser/index');
                            window.location.href = (siteurl + 'adminuser/index');
                            break;
                        default :
                            window.location = (siteurl + 'index/index');
                            window.location.href = (siteurl + 'index/index');
                    }
                } else {
                    $('#btnlogin').removeClass('none');
                    $('#loadingpic').remove();
                    $('#msgloginerr').html(result.msg);
                    $('#msgloginerr').show();
                }
            }});
    });
});