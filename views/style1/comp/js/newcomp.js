//
//var isFirst = true;
//var imageidcorcmt;
//var max = gallerymaxpg;
////var index1 = 0, index2 = 0, index3 = 0
//var currtabgal = 1;
//var that;
//var imgclk;
//var crntpg = 1;
//
//var wall1 = new Freewall("#gallery");
//wall1.reset({
//    selector: '.brick',
//    animate: true,
//    cellW: 200,
//    cellH: 'auto',
//    onResize: function() {
//        wall1.fitWidth();
//    }
//});
//wall1.container.find('.brick img').load(function() {
//    wall1.fitWidth();
//});
//
//$(function() {
//    setTimeout(function() {
//        wall1.container.find('.brick img').load(function() {
//            wall1.fitWidth();
//        });
//    }, 200);
//    $('#gallery').on('click', '.isusermix', function() {
//        imgclk = $(this);
//        $('#bigimg').attr('src', '');
//        var imgid = $(this).find('.id').html();
//        imageidcorcmt = imgid;
//        $('#imgrate').find('.cntlnk').attr('href', $(this).find('.cntlnk').html());
//        $('#bigimg').attr('src', '');
//        $('#bigimg').attr('src', $(this).find('.bgimg').attr('src'));
//        $('#imgrate').find('.id').html($(this).find('.id').html());
//        $('#imgrate').find('.cmt').html($(this).find('.cmt').html());
////        $('#imgrate').find('.winner').html($(this).find('.winner').html());
//        $('#imgrate').find('.dt').html($(this).find('.dt').html());
//        $('#imgrate').find('.us').html($(this).find('.us').html());
////        $('#imgrate').find('.tl').html($(this).find('#tl').html());
//        $('#imgrate').find('.cmp').html($(this).find('#cmp').html());
//        //*************************************************
//        //Set Rate
//        $('#itemrate').raty('score', parseFloat($(this).find('.rt').html()) / 2);
//        $('#imgrate').find('.av').attr('src', $(this).find('.av').attr('src'));
//        $('body').css({'overflow-y': 'hidden'});
//        $('#modalgallery').delay(200).fadeIn(300);
//    });
//    $('#cat-content').on('click', '.filter', function() {
//        crntpg = 1;
//        var data = ($(this).attr('id'));
//        that = $(this);
//        $('#gallery').html('');
//        $.ajax({
//            url: siteurl + "comp/loadphoto",
//            type: "POST",
//            data: {data: data},
//            dataType: 'json',
//            success: function(result) {
//                setTimeout(function() {
//                    $('#gallery').html(result.msg);
//                    wall1.container.find('.brick img').load(function() {
//                        wall1.fitWidth();
//                    });
//                }, 200);
//            },
//            error: function() {
//                //alert("error");//
//            }
//        });
//    });
//    $('#btnmore').click(function() {
//        crntpg++;
//        $("#paging1").hide();
//        $("#waiting").show();
//        var pgid = crntpg;
//        $.ajax({
//            url: siteurl + "comp/paging",
//            type: "POST",
//            dataType: 'json',
//            data: {pid: pgid},
//            success: function(result) {
//                alert(1);
//                setTimeout(function() {
//                    $('#gallery').html(result.msg);
//                    wall1.container.find('.brick img').load(function() {
//                        wall1.fitWidth();
//                    });
//                }, 200);
////                setPageItems(result.msg);
////                $('#typebarande').html(result.win);
////                if (parseInt(result.rate) == 0) {
////                    $('#itemrate').addClass('none');
////                } else {
////                    $('#itemrate').removeClass('none');
////                }
////                flt = '.populer';
////                $('#gallery').mixItUp({
////                    load: {
////                        filter: flt
////                    }
////                });
////                $('#cat-content').find('.filter').removeClass('active');
////                that.addClass('active');
//                $("#paging1").show();
//                $("#waiting").hide();
//            },
//            error: function() {
//                $("#paging1").show();
//                $("#waiting").hide();
//            }
//        });
//    });
//
//});