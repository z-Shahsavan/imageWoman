var maxWP = 20;
var isFirstWP = true;
var maxCP = 15;
var isFirstCP = true;
$(function() {

    $('.row,nav,form').addClass('rtl');
    $('.container,#formreg,#cntmndiv').removeClass('rtl');

    $('.modal-trigger').leanModal({
        dismissible: true
    });

    $('#sidemenu a').on('click', function(e) {
        e.preventDefault();
        if ($(this).hasClass('open')) {
        } else {
            var oldcontent = $('#sidemenu a.open').attr('href');
            var newcontent = $(this).attr('href');

            $(oldcontent).fadeOut('fast', function() {
                $(newcontent).fadeIn().removeClass('hidden');
                $(oldcontent).addClass('hidden');
            });


            $('#sidemenu a').removeClass('open');
            $(this).addClass('open');
        }
    });

    //See A New Contact
    $('#itemsdivnew').on('click', '.delcmt', function() {
        var agree = confirm('Are you sure read?');
        if (agree) {
            var id;
            id = ($(this).parents('.pitem').find('.id').html());
            $.ajax({
                url: "admincontact/updcmnt",
                type: "POST",
                data: {
                    "dlt": id
                }
            });
            $(this).parents('.pitem').remove();
        } else {
            // row shouldn't be deleted
            return false;
        }
    });
});
$(function() {
    $('#formedit').on('keydown', 'input', function(e) {
        var key = e.which;
        if (key == 13) {
            $('#send').trigger('click');
            return false;
        }
    })
    $('#send').on('click', function() {

        var data = $('#formreg').serialize();
        $.ajax({url: siteurl + 'admincontact/editcontact',
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
    $('#loadnewmsg').click(function() {
        $.ajax({
            url: siteurl + 'admincontact/loadunreadmessage',
            type: 'POST',
            dataType: 'json',
            success: function(result) {
                $('#itemsdivnew').html(result.msg);
            }
        });
    })
    $('#readmsg').click(function() {
        $.ajax({
            url: siteurl + 'admincontact/loadreadmessage',
            type: 'POST',
            dataType: 'json',
            success: function(result) {
                $('#itemsdivviewed').html(result.msg);
            }
        });
    })
})

