var maxTaeedShode = okuserimage;
var maxTaeedNashodeShode = penuserimage;
var that;
var whichpg;
var crntpg = 1;
/*=============
 *   1.Images Competition
 ===============*/

var wall = new Freewall("#freewall");
wall.reset({
    selector: '.brick',
    animate: true,
    cellW: 200,
    cellH: 'auto',
    onResize: function() {
        wall.fitWidth();
    }
});
wall.container.find('.brick img').load(function() {
    wall.fitWidth();
});

var wall1 = new Freewall("#pendimages");
wall1.reset({
    selector: '.brick',
    animate: true,
    cellW: 200,
    cellH: 'auto',
    onGapFound: function() {
        wall1.fitWidth();
    }
});
wall1.container.find('.brick img').load(function() {
    wall1.fitWidth();
});
$('#okpic').on('click', function() {
    $('#whichpg').val(1);
    var data = 1;
    $.ajax({
        url: siteurl + "setting/loadokimages",
        type: "post",
        data: {
            "tab": data
        },
        success: function(res) {
            crntpg = 1;
            setTimeout(function() {
                $('#freewall').html(res);
                wall.container.find('.brick img').load(function() {
                    wall.fitWidth();
                });
            }, 200);
            $('#latest').removeClass('active');
            $('#populer').addClass('active');
        }
    });
});
$('#notokpic').on('click', function() {
    $('#whichpg').val(2);
    var data = 2;
    $.ajax({
        url: siteurl + "setting/loadokimages",
        type: "post",
        data: {
            "tab": data
        },
        success: function(res) {
            crntpg = 1;
            setTimeout(function() {
                $('#pendimages').html(res);
                wall1.container.find('.brick img').load(function() {
                    wall1.fitWidth();
                });
            }, 1000);
            $('#populer').removeClass('active');
            $('#latest').addClass('active');
        }
    });
});
$('#btnmore').click(function() {
    crntpg++;
    var pgid;
    whichpg = $('#whichpg').val();
    $("#paging1").hide();
    $("#waiting").show();
    pgid = crntpg;
    $.ajax({
        url: siteurl + "setting/paging",
        type: "POST",
        data: {
            "pid": pgid, whichpg: whichpg
        },
        success: function(data) {
            if (whichpg == 1) {
                $('#freewall').append(data);
                wall.container.find('.brick img').load(function() {
                    wall.fitWidth();
                });

            } else if (whichpg == 2) {
                $('#pendimages').append(data);
                wall1.container.find('.brick img').load(function() {
                    wall1.fitWidth();
                });
            }
            $("#paging1").show();
            $("#waiting").hide();

        },
        error: function() {
            $("#paging1").show();
            $("#waiting").hide();
        }
    });
});
$("#tabing1").click(function() {
    $('html, body').animate({
        scrollTop: $("#sctab").offset().top
    }, 1000);
});
$("#tabing2").click(function() {
    $('html, body').animate({
        scrollTop: $("#sctab").offset().top
    }, 1000);
});
$("#tabing3").click(function() {
    $('html, body').animate({
        scrollTop: $("#sctab").offset().top
    }, 1000);
});
$(window).scroll(function() {
    if ($(this).scrollTop()) {
        $('#scrolltop').fadeIn();
    } else {
        $('#scrolltop').fadeOut();
    }
});
$("#scrolltop").click(function() {
    $('html, body').animate({
        scrollTop: $("html").offset().top
    }, 1000);
});


$(function()
{
    $('#delav').click(function() {
        $.ajax({url: siteurl + 'setting/delav',
            type: 'POST',
            success: function(imgpath) {
                $('#delav').hide();
                $(".bdradius").attr('src', siteurl + 'images/avatar/' + imgpath);
                $("#imgavatar").attr('src', siteurl + 'images/avatar/' + imgpath);
            }});
    });
    $('#formeditgal').click(function() {
        var data = $("#formeditgal").serialize();
        $.ajax({url: siteurl + 'setting/editimage',
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

    $('#taeednashode-content').on('click', '#delitm', function() {
        that = $(this).parents('.brick');

        var imgid = $(this).closest('.image-head').find('.id').html();
        var r = confirm("آیا میخواهید فایل حذف شود؟");
        if (r == true) {
            that.remove();
            $.ajax({url: siteurl + 'setting/delimage',
                data: {id: imgid},
                type: 'POST',
                dataType: 'json',
                success: function() {
                }});
        } else {

        }
    });
    $('#formuserinfo').on('keydown', 'input', function(e) {
        var key = e.which;
        if (key == 13) {
            $('#edituserinfo').trigger('click');
            return false;
        }
    })
    $('#edituserinfo').click(function() {
        $('#edituserinfo').addClass('none');
        $('.loadingdivedituser').append('<img src="' + siteurl + 'images/icons/loading.gif" id="loadingpic" >');
        var data = $("#formuserinfo").serialize();
        //check mobile is new
        $.ajax({url: siteurl + 'setting/checknewmob',
            data: data,
            type: 'POST',
            dataType: 'json',
            success: function(result) {
                if (result.id == 0) {
                    $('#msguser').html(result.msg);
                    $('#erruser').hide();
                    $('#msguser').show();
                } else if (result.id == 1) {
                    $("#mobile").prop("readonly", true);
                    $('#modaltaeedchnagemobile').modal();
                    $('#erruser').html(result.msg);
                    $('#erruser').show();
                    $('#msguser').hide();
                } else if (result.id == 2) {
                    $.ajax({url: siteurl + 'setting/changeinfo',
                        data: data,
                        type: 'POST',
                        dataType: 'json',
                        success: function(result) {
                            if (result.id > 0) {
                                $('#msguser').html(result.msg);
                                $('#erruser').hide();
                                $('#msguser').show();
                            } else {
                                $('#erruser').html(result.msg);
                                $('#erruser').show();
                                $('#msguser').hide();
                            }
                        }});
                }
            }});
        $('#edituserinfo').removeClass('none');
        $('#loadingpic').remove();
    });

    $('#btncancelchangemob').click(function() {
        $('#modaltaeedchnagemobile').closeModal();
    })

    $('#btntaeedchangemob').click(function() {
        var reccode = $('#taeedtaghirmob').val();
        $.ajax({url: siteurl + 'setting/chackcodechange',
            data: {reccode: reccode},
            type: 'POST',
            dataType: 'json',
            success: function(result) {
                if (result.id > 0) {
                    $('#edituserinfo').trigger('click');
                    $('#modaltaeedchnagemobile').closeModal();
                } else {
                    $('#msgerrchangemob').html(result.msg);
                    $('#msgerrchangemob').show();
                }
            }});
    })
    $('#formpassword').on('keydown', 'input', function(e) {
        var key = e.which;
        if (key == 13) {
            $('#changepasssend').trigger('click');
            return false;
        }
    })
    $('#changepasssend').click(function() {
        $('#changepasssend').addClass('none');
        $('.loadingdivchangepass').append('<img src="' + siteurl + 'images/icons/loading.gif" id="loadingpic" >');
        var data = $("#formpassword").serialize();
        $.ajax({url: siteurl + 'setting/changepass',
            data: data,
            type: 'POST',
            dataType: 'json',
            success: function(result) {
                if (result.id > 0) {
                    $('#msgpass').html(result.msg);
                    $('#errpass').hide();
                    $('#msgpass').show();
                    window.setTimeout(function() {
                        window.location = (siteurl + 'index/index#loginlink');
                        window.location.href = (siteurl + 'index/index#loginlink');
                    }, 2000);
                } else {
                    $('#errpass').html(result.msg);
                    $('#errpass').show();
                    $('#msgpass').hide();
                }
            }});
        $('#changepasssend').removeClass('none');
        $('#loadingpic').remove();
    });


    $('#sidemenu a').on('click', function(e) {
        e.preventDefault();
        if ($(this).attr('href') != '#gallery-content' && $(this).attr('href') != '#taeednashode-content') {
            if (!$('#btnmore').hasClass('hidden')){
                $('#btnmore').addClass('hidden')
            }
        }else{
            if ($('#btnmore').hasClass('hidden')){
                $('#btnmore').removeClass('hidden')
            }
        }
        if ($(this).attr('href') == '#header-content') {
            loadavatar();
        } else if ($(this).attr('href') == '#home-content') {
            loadinfo();
        }
        if ($(this).hasClass('open')) {
            // do nothing because the link is already open
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

    $('#iscomp').click(function() {
        if ($('#iscomp').is(':checked')) {
            $('#divcomp').fadeIn(300);
        }
        else {
            $('#divcomp').fadeOut(300);
        }
    })

    $('body').on('click', '#edititm', function() {
//        ($(this).parents('.brick').find('.id').html())
        $('#idformeditgal').val($(this).parents('.brick').find('.id').html());
        $('#name').val($(this).parents('.brick').find('.tl').html());
        $('#comment').val($(this).parents('.brick').find('.cmt').html());
        $('#date').val($(this).parents('.brick').find('.dt').html());
        $('#subject').val($(this).parents('.brick').find('.tg').html());
        $("#mozu option[value=" + parseInt($(this).parents('.brick').find('.mozuval').html()) + "]").attr('selected', 'selected');
        $("#competition option[value=" + parseInt($(this).parents('.brick').find('.cmp').html()) + "]").attr('selected', 'selected');
    });


    $('#btndsblacc').click(function() {
        $.ajax({url: siteurl + 'setting/senddeactive',
            type: 'POST',
            dataType: 'json',
            success: function(result) {
                if (result.id > 0) {
                    $('#modaltaeed').modal();
                } else {
                    $('#errpassdc').html(result.msg);
                    $('#errpassdc').show();
                    $('#modaltaeed').modal();
                }
            }});


    })

    $('#btntaeeddsblacc').click(function() {
        var regactcode = $('#deactivecode').val();
        $.ajax({url: siteurl + 'setting/makedeactive',
            data: {regactcode: regactcode},
            type: 'POST',
            dataType: 'json',
            success: function(result) {
                if (result.id > 0) {
                    window.location = (siteurl + 'index/index');
                    window.location.href = (siteurl + 'index/index');

                } else {
                    $('#errpassdc').html(result.msg);
                    $('#errpassdc').show();
                    $('#modaltaeed').modal();
                }
            }});


    })
});

function submitUser() {
    var requires = '';
    $('#formuserinfo .req').parents('.input-field').find('input').each(function() {
        if ($(this).val().length == 0) {
            requires += "<li class='pink-text text-darken-4'>" + $(this).parents('.input-field').find('label').html() + "</li>";
        }
    });
    if (requires.length > 0) {
        $('#modalmsg').find('ul').html(requires);
        $('#modalmsg').modal();
    }
}
//
function submitPassword() {
    var requires = '';
    $('#formpassword .req').parents('.input-field').find('input').each(function() {
        if ($(this).val().length == 0) {
            requires += "<li class='pink-text text-darken-4'>" + $(this).parents('.input-field').find('label').html() + "</li>";
        }
    });
    if (requires.length > 0) {
        $('#modalmsg').find('ul').html(requires);
        $('#modalmsg').modal();
    }
}

function loadavatar() {
    $.ajax({url: siteurl + 'setting/loadavatar',
        type: 'POST',
        dataType: 'json',
        success: function(result) {
            $("#imagePreview").css("background-image", "url(" + result.header + ")");
            $("#imgavatar").attr('src', result.vatar);
            $("#descriptionuser").val(result.userinfo);
            if (result.userinfo != '') {
                $("#descriptionuserbody").addClass('active');
            }
            if (result.hasav == 0) {
                $("#delav").hide();
            } else {
                $("#delav").show();
            }
        }});
}
function loadinfo() {
    $.ajax({url: siteurl + 'setting/loadinfo',
        type: 'POST',
        dataType: 'json',
        success: function(result) {
            if (result.name != '') {
                $("#lbluname").addClass('active');
            }
            if (result.username != '') {
                $("#lblusername").addClass('active');
            }
            if (result.family != '') {
                $("#lblastname").addClass('active');
            }
            if (result.tel != '') {
                $("#lbltel").addClass('active');
            }
            if (result.mobile != '') {
                $("#lblmobile").addClass('active');
            }
            if (result.melicode != '') {
                $("#lblmelicode").addClass('active');
            }
            if (result.postcode != '') {
                $("#lblpostcode").addClass('active');
            }
            if (result.address != '') {
                $("#lbladdress").addClass('active');
            }
            if (result.mail != '') {
                $("#lblmail").addClass('active');
            }
            $('#uname').val(result.name);
            $('#lastname').val(result.family);
            $('#username').val(result.username);
            $('#tel').val(result.tel);
            $('#mobile').val(result.mobile);
            $('#melicode').val(result.melicode);
            $('#postcode').val(result.postcode);
            $('#address').val(result.address);
            $('#email').val(result.mail);
        }});
}