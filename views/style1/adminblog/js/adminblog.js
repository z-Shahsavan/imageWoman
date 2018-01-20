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
    $('#edcont').click(function() {
        $('#formreg').reset();
    })
    var editid = 0;
    $('#itemsdiv').on('click', '.editcmp', function() {
        $('#idformedit').val($(this).parents('.pitem').find('.id').html());
        $('#subjectedit').val($(this).parents('.pitem').find('.sbj').find('span').html());
        $('#commentedit').val($(this).parents('.pitem').find('.cmt').find('span').html());
        $("label[for='subjectedit']").addClass('active');
        $("label[for='commentedit']").addClass('active');
        editid = $(this).parents('.pitem').find('.id').html();
        $('#modaledit').openModal();
    });
    $('#btncloseedit').click(function() {
        $('#modaledit').closeModal();
    });
    //Delete
    $('#itemsdiv').on('click', '.delcmt', function() {
        var rowid = $(this).parents('.pitem').find('.id').html();
        var agree = confirm("آیا از حذف اعلان و فایل مربوطه اطمینان دارید؟");
        if (agree) {
            $.post(siteurl + "adminblog/del", {id: rowid});
            $(this).parents('.pitem').remove();
        }
    });
    $('#editup').on('click', function() {
        var func = $('#formedit').attr('action');
        var formData = new FormData($('#formedit')[0]);
        $.ajax({
            url: func,
            type: 'POST',
            data: formData,
            async: false,
            dataType: 'json',
            success: function(res) {
                if (res.id === 0) {
                    $('#erredit').html(res.msg);
                } else {
                    $('#okedit').html(res.msg);
                    var item = $('#it' + editid);
                    item.find('.sbj span').html($('#subjectedit').val());
                    item.find('.cmt span').html($('#commentedit').val());
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
    });
    $('#formedit').on('keydown', 'input', function(e) {
        var key = e.which;
        if (key == 13) {
            $('#sendup').trigger('click');
            return false;
        }
    })
    $('#sendup').on('click', function() {
        $("#formreg").ajaxForm(
                {dataType: 'json',
                    success: function(res) {
                        if (res.id == 0) {
                            $('#okmsg').html('');
                            $('#errmsg').html(res.msg);
                        } else if (res.id == 1) {
                            $('#errmsg').html('');
                            $('#okmsg').html(res.msg);
                            var item = '<div class="pitem" id="it' + res.fid + '">\n\
                            <div class="id none">' + res.fid + '</div>\n\
                            <div class="cnt col s12">\n\
                                <h3 class="sbj hd">موضوع: <span>' + $('#subject').val() + '</span></h3>\n\
                                <h3 class="cmt hd">توضیحات : <span>' + $('#comment').val() + '</span></h3>\n\
                            </div>\n\
                            <div class="btnsdiv col s12">\n\
                                <a class="editcmp bwaves-effect waves-white teal darken-3 right btn"><i class="mdi-editor-mode-edit right"></i>ویرایش</a>\n\
                                <a class="delcmt bwaves-effect waves-white pink darken-4 right btn mgright"><i class="mdi-action-delete right"></i>حذف</a>\n\
                            </div>\n\
                        </div>';
                            $('#itemsdiv').append(item);
                        }
                    }
                }).submit();
    });
});

