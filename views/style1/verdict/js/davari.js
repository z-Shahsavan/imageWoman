var thisimag;
var imgid;
var wall;
var crntpg = 1;
$(function() {
    wall = new Freewall("#freewall");
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
    var galleryAddress = $('#galleryaddr').html();
    $('#freewall').on('click', '.brick', function() {
        $('#bigimg').attr('src', '');
        thisimag = $(this);
//        alert(thisimag.html())
        imgid = $(this).find('.id').html();
        $('#bigimg').attr('src', galleryAddress + $(this).find('.adr').html());
        $('#imgrate').find('.id').html($(this).find('.id').html());
        $('#imgrate').find('.modal-title').html($(this).find('.image-name').html());

        if ($(this).find('.issize').html() == 1) {
            $('.issize').addClass('banning');
            $('#divrate').addClass('none');
        } else {
            $('#divrate').removeClass('none');
            $('.issize').removeClass('banning');
            $('#divrate').find('.rating-stars').css('width', ((10 - $(this).find('.rt').html()) * 10) + '%');
        }

    });
    $('#imgrate').on('click', '.down', function() {
//        alert($('#imgrate').find('.id').html())
        var a = $('#imgrate').find('.id').html();
        $.ajax({
            url: siteurl + 'verdict/download',
            data: {"inf": a
            },
            type: 'POST',
            dataType: 'json',
            success: function(result) {
                alert(result.images)
                var win = window.open(eval(result.images), '_blank');
                if (win) {
                    //Browser has allowed it to be opened
                    win.focus();
                } else {
                    //Broswer has blocked it
                    alert('لطفا اجازه باز کردن پنجره جدید را فعال کنید');
                }
                //location.replace(eval(result.images));
            }
        });
    });

    $('#imgrate').on('click', '.issize', function() {
        if ($(this).hasClass('banning')) {
            $(this).removeClass('banning');
            $('#divrate').removeClass('none');
             thisimag.find('.issize').html(0);
             $('#divrate').find('.rating-stars').css('width','100%');
        } else {
            $(this).addClass('banning');
            thisimag.find('.score-image1').find('.rt').html(0);
           thisimag.find('.issize').html(1);
            var data = {idimgrate: imgid, datasize: 1};
            $.ajax({url: siteurl + 'verdict/checkissize',
                data: data,
                type: 'POST',
                dataType: 'json',
                success: function(result) {
                    $('#divrate').addClass('none');
                    thisimag.find('.rt').html('عکس سایز اصلا نیست');

                }
            });
        }


    });
    $('.rating-container-rtl').click(function() {
//        alert(imgid)
        var width = $(this).find('.rating-stars').width();
        var parentWidth = $(this).find('.rating-stars').offsetParent().width();
        var percent = (100 * width / parentWidth) / 10;
//        alert(percent);
        if (percent == 0.9803921568627452) {
            percent = (Math.round(percent, 2));
        } else {
            percent = (Math.floor(percent));
        }
//      

        var rate = (10 - percent);
        //thisimag.find('.score-image1').find('.rt').html(rate);
        var data = {id: imgid, rate: rate};
        $.ajax({
            url: siteurl + 'verdict/saverate',
            data: data,
            type: 'POST',
            dataType: 'json',
            success: function(result) {
                thisimag.find('.score-image1').find('.rt').removeClass('none');
                thisimag.find('.score-image1').find('.rt').html(rate);

            }});
    });
    $('#btnmore').click(function() {
        crntpg++;
        var pgid;
        $("#paging1").hide();
        $("#waiting").show();
        pgid = crntpg;
        $.ajax({
            url: siteurl + "verdict/loadcompg",
            type: "POST",
            data: {
                "pid": pgid
            },
            success: function(data) {
                $("#paging1").show();
                $("#waiting").hide();
                setTimeout(function() {
                    $('#freewall').append(data);
                    wall.container.find('.brick img').load(function() {
                        wall.fitWidth();
                    });
                }, 200);
            },
            error: function() {
                $("#paging1").show();
                $("#waiting").hide();
                //alert("error");//
            }
        });
    });

});
var changeCompatition = function(id) {
    var data = {id: id};
    $.ajax({url: siteurl + 'verdict/loadcompdata',
        data: data,
        type: 'POST',
        dataType: 'json',
        success: function(result) {
            crntpg=1;
            setTimeout(function() {
                $('#freewall').html(result.images);
                wall.container.find('.brick img').load(function() {
                    wall.fitWidth();
                });
            }, 200);
//            $('#divmore').html(' <div id="paging1" class="center-align mgtops load-more-image">'
//                            +'<a id="btnmore" class="bwaves-effect waves-white  btn purple darken-3 more-img">بیشتر</a>'
//                        +'</div>'
//                      + ' <div id="waiting" class="center-align mgtops load-more-image" style="display: none">'
//                         +   '<a id="wait" class="bwaves-effect waves-white  btn purple darken-3 load-img">صبر نمایید</a>'
//                      + ' </div>');
//                $('#thiscompimg').html(result.images);
        }});
}



