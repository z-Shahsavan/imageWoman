var imgclk;
var imageidcorcmt;
var count = 1;
var tab1 = 1;
var tab2 = 1;
var whichpg;
var wall2, wall, wall1;
$(function() {
    $('.carousel').carousel({
        interval: 12000
    });
    wall = new Freewall(".home");
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
    wall1 = new Freewall(".menu1");
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
    wall2 = new Freewall(".menu2");
    wall2.reset({
        selector: '.brick',
        animate: true,
        cellW: 200,
        cellH: 'auto',
        onGapFound: function() {
            wall2.fitWidth();
        }
    });
    wall2.container.find('.brick img').load(function() {
        wall2.fitWidth();
    });
    $("#myCarousel").on('slid.bs.carousel', function(event) {
        var data = $('#slider').find('.active input').val();
        $.ajax({
            url: siteurl + 'index/numofpics',
            type: "POST",
            data: {
                "cid": data
            },
            dataType: 'json',
            success: function(data) {

                $('#tedadsh').html(data.user + ' ' + 'نفر');
                $('#okphoto').html(data.okpic + ' ' + 'عکس');
                $('#sendphoto').html(data.tedadpic + ' ' + 'عکس');
            },
        });
    });
    $('.tab-content').on('click', '.brick', function() {
//        alert($(this).find('.id').html())
//        alert($('#imgrate').find('.dt').html())
//        alert(1)

        imgclk = $(this);
        var imgid = $(this).find('.id').html();
//        alert(imgid)
        imageidcorcmt = imgid;
        $('#bigimg').attr('src', '');
        $('#bigimg').attr('src', $(this).find('.bgimg').attr('src'));
        if (($(this).find('.pn').html()) != '') {
            $('#imgrate').find('.modal-title').html('نام عکس: ' + $(this).find('.pn').html());
        } else {
            $('#imgrate').find('.modal-title').html('');
        }
        $('#imgrate').find('.img-circle').attr('src', $(this).find('.av').attr('src'));
        $('#imgrate').find('.cmt').html($(this).find('.cmt').html());
        $('#imgrate').find('.dt').html($(this).find('.dt').html());
        $('#imgrate').find('.us').html($(this).find('.us').html());
        $('#imgrate').find('.cmp').html($(this).find('.cmp').html());
        if (parseInt($(this).find('.rt').html()) != 0) {//rating-img
            $('#imgrate').find('.rating-img').removeClass('none');
            $('#imgrate').find('.padding3').html($(this).find('.rt').html());
        } else {
            $('#imgrate').find('.rating-img').addClass('none');
        }
    });

    $('#btnregrep').on('click', function() {
        var pid = imageidcorcmt;
        var data = $('#formreport').serialize();
        //data.push({name: "imgid", value: pid});
        data += "&imgid=" + encodeURIComponent(pid);
        $.ajax({
            url: siteurl + "index/Violation",
            type: "POST",
            data: data,
            dataType: 'json',
            success: function(result) {
                if (result.id > 0) {
                    $("#subjectrep").val('');
                    $("#comment").val('');
                    $("#formreport").trigger('reset');
                    $('#msgsucmod').html(result.msg);
                    $('#msgerrmod').hide();
                    $('#msgsucmod').show();
                    window.setTimeout(function() {
                        $('#modalreport').closeModal();
                    }, 2000);

                } else {
                    $('#msgerrmod').html(result.msg);
                    $('#msgerrmod').show();
                    $('#msgsucmod').hide();
                }

            }
        });
    });
    $('#modal-close').click(function() {
        $('#modal-content').closeModal();
        $('#msgerrmod').hide();
        $('#msgsucmod').hide();
    });
    $('#tabing1').click(function() {
        $('#whichpg').val(1);
        count = 1;
        $.ajax({
            url: siteurl + 'index/selectedpic',
            data: {
                state: 1
            },
            type: 'Post',
            success: function(res) {
                $('.home').html('');
                setTimeout(function() {
                    $('.home').html(res);
                    wall.container.find('.brick img').load(function() {
                        wall.fitWidth();
                    });
                }, 200);
            }
        });
    });
    $('#tabing2').click(function() {
        $('#whichpg').val(2);
        count = 1;
//        if (tab1 < 2) {
        $.ajax({
            url: siteurl + 'index/winnerpic',
            success: function(res) {
                $('.menu1').html('');
                setTimeout(function() {
                    $('.menu1').html(res);
                    wall1.container.find('.brick img').load(function() {
                        wall1.fitWidth();
                    });
                }, 200);
                tab1++;
            }
        });
//        }
    });

    $('#tabing3').click(function() {
        $('#whichpg').val(3);
        count = 1;

//        if (tab2 < 3) {
        $.ajax({
            url: siteurl + 'index/winnerpicmardomi',
            success: function(res) {
                $('.menu2').html('');
                setTimeout(function() {
                    $('.menu2').html(res);
                    wall2.container.find('.brick img').load(function() {
                        wall2.fitWidth();
                    });
                }, 200);




                tab2++;
            }
        });
//        }

    });
    $('#more').click(function() {
        count++;
        var pgid = count;
        whichpg = $('#whichpg').val();
        $('#paging').hide();
        $('#waiting').show();
        $.ajax({
            url: siteurl + 'index/paging',
            data: {
                pgid: pgid, whichpg: whichpg
            },
            type: 'Post',
//           dataType:'json',
            success: function(res) {
                if (whichpg == 1) {
                    $('.home').append(res);
                    wall.container.find('.brick img').load(function() {
                        wall.fitWidth();
                    });

                } else if (whichpg == 2) {
                    $('.menu1').append(res);
                    wall1.container.find('.brick img').load(function() {
                        wall1.fitWidth();
                    });
                } else if (whichpg == 3) {
                    $('.menu2').append(res);
                    wall2.container.find('.brick img').load(function() {
                        wall2.fitWidth();
                    });
                }
                $('#paging').show();
                $('#waiting').hide();
            }
        });
    });
    $('#modal-launcher').click(function() {
        $('#msgerrmod').hide();
        $('#msgsucmod').hide();
    });
    $('#formreg').on('keydown', 'input', function(e) {
        var key = e.which;
        if (key == 13) {
            $('#send').trigger('click');
            return false;
        }
    })
    $('#send').click(function() {
//        alert(22)
        $('#msgerr4').hide();
        $('#msgsuc4').html('لطفا صبر کنید...');
        $('#msgsuc4').show();

        var data = $('#formreg').serialize();
        $.ajax({url: siteurl + 'forgot/sendpass',
            data: data,
            type: 'POST',
            dataType: 'json',
            success: function(result) {

                if (parseInt(result.id) == 1) {
                    $("#formregactivcod").removeClass("hide");
                    $("#formregactivcod").fadeIn(500);
                      //$("#formreg").fadeOut(500);
                       $('#msgerr4').hide();
                       $('#msgsuc4').hide();
                        $('#captcha').attr('src', siteurl + 'captcha/captcha.php?' + Math.random());
                      $("#formreg").addClass("hide");
                  
//                    location.replace(siteurl + 'activecod');
                } else if (parseInt(result.id) == 0) {
                    $('#captcha').attr('src', siteurl + 'captcha/captcha.php?' + Math.random());
                    $('#msgerr4').html(result.msg);
                    $('#msgerr4').show();
                    $('#msgsuc4').hide();
                } else if (parseInt(result.id) == 2) {
                    $('#captcha').attr('src', siteurl + 'captcha/captcha.php?' + Math.random());
                    $('#msgerr4').html(result.msg);
                    $('#msgerr4').show();
                    $('#msgsuc4').hide();
                }
            }});
    })
    $('#formreg').on('keydown', 'input', function(e) {
        var key = e.which;
        if (key == 13) {
            $('#send').trigger('click');
            return false;
        }
    })
    $('#sendactcod').click(function() {
        var data = $('#formregactivcod').serialize();
        $.ajax({url: siteurl + 'activecod/checkcod',
            data: data,
            type: 'POST',
            dataType: 'json',
            success: function(result) {
                if (parseInt(result.id) == 1) {
//                    alert(12);
                      //$("#formregactivcod").fadeOut(2000);
                      $("#formregactivcod").addClass("hide");
                      $("#formpassword").removeClass("hide");
                      $("#formpassword").fadeIn(2000);
//                    location.replace(siteurl + 'newpass');
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

