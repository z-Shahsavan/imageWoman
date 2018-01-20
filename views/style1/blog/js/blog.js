var isFirst = true;
var imageidcorcmt;
var max = gallerymaxpg;
var index1 = 0, index2 = 0, index3 = 0
var currtabgal = 1;
var crntpg = 1;
var wall2, wall, wall1;
$(function() {
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
    $('#freewall').on('click', '.isusermix', function() {
        imgclk = $(this);
        var star = $(this).find('#shorno').val();
        if (star == 1) {
            $('#itemrate').removeClass('none');
            $('.rating-container-rtl').find('.rating-stars').width((10-$(this).find('.score-image1 span').html())*10+'%');
            $('#imgrate').find('.onestar').addClass('none');
        } else {
            $('#itemrate').addClass('none');
            if (parseInt($(this).find('.rt').html()) != 0) {
                $('#imgrate').find('.padding3').html($(this).find('.rt').html());
                $('#imgrate').find('.onestar').removeClass('none');
            }else{
                $('#imgrate').find('.onestar').addClass('none');
            }
        }
        if (($(this).find('.pn').html()) != '') {
            $('#imgrate').find('.modal-title').html('نام عکس: ' + $(this).find('.pn').html());
        }else{
            $('#imgrate').find('.modal-title').html(''); 
        }
        var imgid = $(this).find('.id').html();
        imageidcorcmt = imgid;
        $('#bigimg').attr('src', '');
        $('#bigimg').attr('src', $(this).find('.bgimg').attr('src'));
        $('#imgrate').find('.cmt').html($(this).find('.cmt').html());
        $('#imgrate').find('.id').html($(this).find('.id').html());
        $('#imgrate').find('.dt').html($(this).find('.dt').html());
        $('#imgrate').find('.cmp').html($(this).find('.cmp').html());

    });
//Rating
//    
    $('.rating-container-rtl').click(function() {
        var width = $(this).find('.rating-stars').width();
        var parentWidth = $(this).find('.rating-stars').offsetParent().width();
        var percent = (100 * width / parentWidth) / 10;
        if (percent == 0.9803921568627452) {
            percent = (Math.round(percent, 2));
        } else {
            percent = (Math.floor(percent));
        }
        var a = [];
        a[0] = imageidcorcmt;
        a[1] = (10 - percent);
        $.ajax({
            url: siteurl + 'comp/saverate/' + a[0] + '/' + a[1],
//            type: "POST",
            dataType: 'json',
            success: function(result) {
                imgclk.find('.score-image1').find('span').text(result.msg);
                imgclk.find('.rt').html(a[1]);
                imgclk.find('img').addClass('show');
                imgclk.find('img').removeClass('none');
            }});
    });
    $('#populer').on('click', function() {
        var data = 1;
        $.ajax({
            url: siteurl + "blog/loadimagesforgall",
            type: "post",
            data: {
                "tab": data
            },
            success: function(res) {
                crntpg = 1;
                $('#freewall').html('');
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
    $('#latest').on('click', function() {
        var data = 2;
        $.ajax({
            url: siteurl + "blog/loadimagesforgall",
            type: "post",
            data: {
                "tab": data
            },
            success: function(res) {
                crntpg = 1;
                $('#freewall').html('');
                setTimeout(function() {
                    $('#freewall').html(res);
                    wall.container.find('.brick img').load(function() {
                        wall.fitWidth();
                    });
                }, 200);
                $('#populer').removeClass('active');
                $('#latest').addClass('active');
            }
        });
    });
    $('#btnregrep').on('click', function() {
        var pid = imageidcorcmt;
        var data = $('#formreport').serialize();
        data += "&imgid=" + encodeURIComponent(pid);
        $.ajax({
            url: siteurl + "gallery/Violation",
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
    $('#btnmore').click(function() {
        crntpg++;
        var pgid;
        $("#paging1").hide();
        $("#waiting").show();
        pgid = crntpg;
        $.ajax({
            url: siteurl + "blog/paging",
            type: "POST",
            data: {
                "pid": pgid
            },
            success: function(data) {
                $("#paging1").show();
                $("#waiting").hide();
                $("#freewall").append(data);
            },
            error: function() {
                $("#paging1").show();
                $("#waiting").hide();
            }
        });
    });
    $('.btn-takhalof').on('click', function() {
        $('#msgerrmod').hide();
        $('#msgsucmod').hide();
    })
    $('#btnflw').click(function() {
        var idfl = $(this).data('userid');
        $.ajax({url: siteurl + 'blog/savefollow',
            data: {idfl: idfl},
            type: 'POST',
            dataType: 'json',
            success: function(result) {
                if (parseInt(result.id) > 0) {
                    $('#btnflw').html('دنبال نکردن');
                } else {
                    $('#btnflw').html('دنبال کردن');
                }
            }});
    })
   // $('.modal-trigger').leanModal();
});
