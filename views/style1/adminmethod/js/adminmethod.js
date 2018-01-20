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

    $('#itemsdiv').on('click', '.editcmp', function() {
        $('#idformedit').val($(this).parents('.pitem').find('.id').html());
        $('#subjectedit').val($(this).parents('.pitem').find('.sbj').find('span').html());
        $('#commentedit').val($(this).parents('.pitem').find('.cmt').find('span').html());
        $("label[for='subjectedit']").addClass('active');
        $("label[for='commentedit']").addClass('active');
        $("#edit").on('click', function() {
            var a = $('#formedit').serialize();
            $.ajax({
                url: siteurl + "adminmethod/edemethod",
                type: "POST",
                data: a,
                dataType: 'json',
                success: function(result) {
                    if (result.id > 0) {
                        var row = $("#id" + $('[id="idformedit"]').val());
                        row.find('.id').html($("#modetitle").val());
                        row.find('.sbj').find('span').html($("#subjectedit").val());
                        row.find('.cmt').find('span').html($("#commentedit").val());
                        $('#msgsucmod').html(result.msg);
                        $('#msgerrmod').hide();
                        $('#msgsucmod').show();
                    } else {
                        $('#msgerrmod').html(result.msg);
                        $('#msgerrmod').show();
                        $('#msgsucmod').hide();
                    }
                },
                error: function() {
                    //alert("error");//
                }
            });
        })
        $('#modaledit').openModal();
    });

    $('#btncloseedit').click(function() {
        $('#modaledit').closeModal();
    });

    //Delete
    $('#itemsdiv').on('click', '.delcmt', function() {
        var agree = confirm('Are you sure to delete?');
        if (agree) {
            var id;
            id = ($(this).parents('.pitem').find('.id').html());

            $.ajax({
                url: "adminmethod/dltcmnt",
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

        $.ajax({url: siteurl + 'adminmethod/savemethod',
            data: data,
            type: 'POST',
            dataType: 'json',
            success: function(result) {
                if (result.id > 0) {
                    $('#msgsuc').html(result.msg);
                    $('#msgerr').hide();
                    $('#msgsuc').show();
                    $('#formreg')[0].reset();
                } else {
                    $('#msgerr').html(result.msg);
                    $('#msgerr').show();
                    $('#msgsuc').hide();
                }
            }});
    });
    $('#editmethodhead').click(function() {
        $.ajax({
            url: siteurl + 'adminmethod/loadmethod',
            type: 'POST',
            dataType: 'json',
            success: function(result) {
                $('#itemsdiv').html(result.msg);
            }
        });
    })
})

