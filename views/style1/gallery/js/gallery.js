var crntpg = 1;
var imageidcorcmt;
var wall;
$(function() {
    wall = new Freewall(".free-wall");
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
//        alert($(this).find('.id').html())
//        alert($('#imgrate').find('.dt').html())
//        alert(1)
        imgclk = $(this);
        var star = $(this).find('#shorno').val();
//        alert(star);
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
        var imgid = $(this).find('.id').html();
        imageidcorcmt = imgid;
        $('#bigimg').attr('src', '');
        $('#bigimg').attr('src', $(this).find('.bgimg').attr('src'));
        if (($(this).find('.pn').html()) != '') {
            $('#imgrate').find('.modal-title').html('نام عکس: ' + $(this).find('.pn').html());
        }else{
             $('#imgrate').find('.modal-title').html('');
        }
        $('#imgrate').find('.img-circle').attr('src',$(this).find('.av').attr('src'));
        $('#imgrate').find('.cmt').html($(this).find('.cmt').html());
        $('#imgrate').find('.dt').html($(this).find('.dt').html());
        $('#imgrate').find('.us').html($(this).find('.us').html());
        $('#imgrate').find('.cmp').html($(this).find('.cmp').html());
//        $('#imgrate').find('.padding3').html($(this).find('.rt').html());
    });
//    $('.modal-trigger').leanModal({
//        dismissible: true
//    });
//    //Gallery
//    $('#gallery').mixItUp({
//        load: {
//            filter: '.populer'
//        }
//    });
//    $('.gallery-control a').click(function(event) {
//        event.preventDefault();
//    });
//
//    $('#gallery').on('click', '.userlink', function(evt) {
//        evt.stopPropagation();
//    });

//    $('#gallery').on('click', '.isusermix', function() {
//        imgclk = $(this);
//        var star = $(this).find('#shorno').val();
//        if (star == 1) {
//            $('#itemrate').removeClass('none');
//        } else {
//            $('#itemrate').addClass('none');
//        }
//        $('#bigimg').attr('src', '');
//        var imgid = $(this).find('.id').html();
//        imageidcorcmt = imgid;
//        $('#imgrate').find('.cntlnk').attr('href', $(this).find('.cntlnk').html());
//        $('#bigimg').attr('src', '');
//        $('#bigimg').attr('src', $(this).find('.bgimg').attr('src'));
//        $('#imgrate').find('.id').html($(this).find('.id').html());
//        $('#imgrate').find('.cmt').html($(this).find('.cmt').html());
//        $('#imgrate').find('.winner').html($(this).find('.winner').html());
//        $('#imgrate').find('.dt span').html($(this).find('.dt').html());
//        $('#imgrate').find('.us').html($(this).find('.us').html());
//        $('#imgrate').find('.tl').html($(this).find('#tll').html());
//        $('#imgrate').find('.cmp').html($(this).find('.dt1').html());
//        //*************************************************
//        //Set Rate
//        $('#itemrate').raty('score', parseFloat($(this).find('.rt').html()) / 2);
//        $('#imgrate').find('.av').attr('src', $(this).find('.av').attr('src'));
//        $('body').css({'overflow-y': 'hidden'});
//        $('#modalgallery').delay(200).fadeIn(300);
//    });

//    $('#gallery').on('click', '.isusermix', function() {
//        $('#bigimg').attr('src', '');
//        var imgid = $(this).find('.id').html();
//        imageidcorcmt = imgid;
//        $('#imgrate').find('.cntlnk').attr('href', $(this).find('.cntlnk').html());
//        $('#bigimg').attr('src', '');
//        $('#bigimg').attr('src', $(this).find('.bgimg').attr('src'));
//        $('#imgrate').find('.id').html($(this).find('.id').html());
//        $('#imgrate').find('.cmt').html($(this).find('.cmt').html());
//        $('#imgrate').find('.dt span').html($(this).find('.dt').html());
//        $('#imgrate').find('.us').html($(this).find('.us').html());
//        $('#imgrate').find('.tl').html($(this).find('.tl').html());
//        $('#imgrate').find('.cmp').html($(this).find('.cmp').html());
//        //*************************************************
//        //Set Rate
//    $('#itemrate').raty('score', parseFloat($(this).find('.rt').html()) / 2);
//        $('#imgrate').find('.av').attr('src', $(this).find('.av').attr('src'));
//        $('body').css({'overflow-y': 'hidden'});
//        $('#modalgallery').delay(200).fadeIn(300);
//    });
//
//    $('#modal-close').click(function() {
//        $('#modal-content').closeModal();
//        $('#msgerrmod').hide();
//        $('#msgsucmod').hide();
//    });

    $('#btnmore').click(function() {
        crntpg++;
        var pgid;
        $("#pagingsearch").hide();
        $("#waiting").show();
        pgid = crntpg;
        $.ajax({
            url: siteurl + "gallery/paging",
            type: "POST",
            data: {
                "pid": pgid
            },
            success: function(data) {
                $("#pagingsearch").show();
                $("#waiting").hide();
                $("#freewall").append(data);
                wall.container.find('.brick img').load(function() {
                    wall.fitWidth();
                });
//                setPageItems(data)
            },
            error: function() {
                $("#paging").show();
                $("#waiting").hide();
                //alert("error");//
            }
        });
    });
//    function setPageItems(items) {
//        var olditem = $('#gallery').html();
//        $('#gallery').mixItUp('destroy');
//        $('#gallery').html(olditem + items);
//        var flt
//        $('#gallery').mixItUp({
//            load: {
//                filter: flt
//            }
//        });
//    }
//    $('.gallery-control').on('click', 'li', function() {
//        currtabgal = parseInt($(this).attr('data-index'));
//    });
//    //Report Popup
//    $('#btnshowrep').on('click', function() {
//        $('#idformreport').val($('#imgrate').find('.id').html());
//
//        $('#modalreport').openModal();
//    });
//    //Rating
//    $('#itemrate').raty({
//        path: siteurl + 'images/icons',
//        cancel: true,
//        cancelOff: 'cancel-off.png',
//        cancelOn: 'cancel-on.png',
//        half: true,
//        starHalf: 'star-half.png',
//        starOff: 'star-off.png',
//        starOn: 'star-on.png',
//        click: function(score, evt) {
////            alert('id:' + $('#imgrate').find('.id').html() + ' Rate:' + $('#ratevalue').val());
//            var a = [];
//            a[0] = $('#imgrate').find('.id').html();
//
//            if ($('#ratevalue').val() == "Cancel this rating!") {
//                a[1] = 0;
//            } else {
//                a[1] = $('#ratevalue').val();
//            }
//            $.ajax({
//                url: siteurl + 'comp/saverate/' + a[0] + '/' + a[1],
//                type: "POST",
//                dataType: 'json',
//                success: function(result) {
//                    //$('.resultrate').find('span').html(result.msg); 
//                    //alert(12);
//                    imgclk.find('.resultrate').find('span').text(result.msg);
//                    imgclk.find('.rt').html(a[1]);
//                    imgclk.find('img').addClass('show');
//                    imgclk.find('img').removeClass('none');
//                }});
//        },
//        target: 1,
//        hints: [
//            ['1', '2'],
//            ['3', '4'],
//            ['5', '6'],
//            ['7', '8'],
//            ['9', '10']
//        ],
//    });
    $('.btn-takhalof').click(function() {
        $('#msgerrmod').hide();
        $('#msgsucmod').hide();
    });
    $('#btnregrep').on('click', function() {
        var pid = imageidcorcmt;
        var data = $('#formreport').serialize();
        //data.push({name: "imgid", value: pid});
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

    $('#btncloserep').click(function() {
        $('#modalreport').closeModal();
        $('#msgerrmod').hide();
        $('#msgsucmod').hide();
    });
    wall.container.find('.brick img').load(function() {
        wall.fitWidth();
    });
    $('.rating-container-rtl').click(function() {//alert(1)
        var width = $(this).find('.rating-stars').width();
        var parentWidth = $(this).find('.rating-stars').offsetParent().width();
        var percent = (100 * width / parentWidth) / 10;
        if (percent == 0.9803921568627452) {
            percent = ((Math.round(percent, 2)));
        } else {
            percent = ((Math.floor(percent)));
        }
        var value = 10 - percent;
        $.ajax({
            url: siteurl + 'comp/saverate/' + imageidcorcmt + '/' + value,
            dataType: 'json',
            success: function(result) {
                imgclk.find('.score-image1').find('span').text(result.msg);
                imgclk.find('.rt').html(value);
                imgclk.find('img').addClass('show');
                imgclk.find('img').removeClass('none');
            }});
    });
});
