var isFirst = true;
var imageidcorcmt;
var max = gallerymaxpg;
var currtabgal = 1;
var that;
var imgclk;
var crntpg = 1;
var wall1;
var endcomp = 0;
$(function() {
    wall1 = new Freewall("#freewall");
    wall1.reset({
        selector: '.brick',
        animate: true,
        cellW: 200,
        cellH: 'auto',
        onResize: function() {
            wall1.fitWidth();
        }
    });
    wall1.container.find('.brick img').load(function() {
        wall1.fitWidth();
    });
//   allpic
    $('#gallery').on('click', '.userlink', function(evt) {
        evt.stopPropagation();
    });
    var numofli = 0;
    $('#cat-content .gallery-control li').each(function() {
        numofli++;
    })
    if (numofli == 3) {
        $('.gallery-control').css('margin-right', '30%');
    }
    that = $('#allpic');
    $('.gallery-control a').click(function(event) {
        event.preventDefault();
    });
    $('#gallery').on('click', '.isusermix', function() {
        imgclk = $(this);
        $('#bigimg').attr('src', '');
        var imgid = $(this).find('.id').html();
        imageidcorcmt = imgid;
        $('#imgrate').find('.cntlnk').attr('href', $(this).find('.cntlnk').html());
        $('#bigimg').attr('src', '');
        $('#bigimg').attr('src', $(this).find('.bgimg').attr('src'));
        $('#imgrate').find('.id').html($(this).find('.id').html());
        $('#imgrate').find('.cmt').html($(this).find('.cmt').html());
        $('#imgrate').find('.winner').html($(this).find('.winner').html());
        $('#imgrate').find('.dt span').html($(this).find('.dt').html());
        $('#imgrate').find('.us').html($(this).find('.us').html());
        $('#imgrate').find('.tl').html($(this).find('#tll').html());
        $('#imgrate').find('.cmp').html($(this).find('#cmp').html());
        //*************************************************
        //Set Rate
        $('#itemrate').raty('score', parseFloat($(this).find('.rt').html()) / 2);
        $('#imgrate').find('.av').attr('src', $(this).find('.av').attr('src'));
        $('body').css({'overflow-y': 'hidden'});
        $('#modalgallery').delay(200).fadeIn(300);
    });

    $('#modalgallery').on('click', '.closemd', function() {
        $('body').delay(200).css({'overflow-y': 'inherit'});
        $('#modalcomment').closeModal();
        $('#modalgallery').fadeOut(300);
    });
    //Paging photo
    $('#btnmore').click(function() {
        crntpg++;
        $("#paging1").hide();
        $("#waiting").show();
        var pgid = crntpg;
        $.ajax({
            url: siteurl + "comp/paging",
            type: "POST",
            dataType: 'json',
            data: {
                "pid": pgid
            },
            success: function(result) {
                if (parseInt(result.rate) == 0) {
                    $('#itemrate').addClass('none');
                } else {
                    $('#itemrate').removeClass('none');
                }
                flt = '.populer';
                $('#cat-content').find('.filter').removeClass('active');
                that.addClass('active');
                $('#freewall').append(result.msg);
                wall1.container.find('.brick img').load(function() {
                    wall1.fitWidth();
                });
                $("#paging1").show();
                $("#waiting").hide();
            },
            error: function() {
                $("#paging1").show();
                $("#waiting").hide();
            }
        });

    });
    $('#allpic').addClass('active');
    $('#cat-content').on('click', '.filter', function() {
        crntpg = 1;
        var data = ($(this).attr('id'));
        that = $(this);
        $('#freewall').html('');
        $.ajax({
            url: siteurl + "comp/loadphoto",
            type: "POST",
            data: {data: data},
            dataType: 'json',
            success: function(result) {
                if (data=='prices'){
                    $('body').find('.hidddddvid').removeClass('hidden');
                    $('body').find('.hidddddvid').html(result.hidddddvid)
                }else{
                    if(!$('body').find('.hidddddvid').hasClass('hidden')){
                        $('body').find('.hidddddvid').addClass('hidden') 
                    }
                }
                endcomp = result.endcomp;
                $('#freewall').html(result.msg);
                if (parseInt(result.rate) == 0) {
                    $('#score-image1').addClass('none');
                } else {
                    $('#score-image1').removeClass('none');
                }
                
                $('#cat-content').find('.filter').removeClass('active');
                that.addClass('active');
                $('#freewall').html('');
                setTimeout(function() {
                    $('#freewall').html(result.msg);
                    wall1.container.find('.brick img').load(function() {
                        wall1.fitWidth();
                    });
                }, 200);
            },
            error: function() {
            }
        });

    });

    //Report Popup
    $('#modalreport').on('click', '#btncloserep', function() {
        $('#modalreport').closeModal();
        $('#msgerrmod').hide();
        $('#msgsucmod').hide();
    });
    $('#modalgallery').on('click', '#btnshowrep', function() {
        $('#subjectrep').val('');
        $('#comment').val('');
        $('#msgerrmod').hide();
        $('#msgsucmod').hide();
        $('#idformreport').val($('#imgrate').find('.id').html());
        $('#modalreport').openModal();
    });

    $('#btnregrep').on('click', function() {
        var pid = imageidcorcmt;
        var data = $('#formreport').serialize();
        data += "&imgid=" + encodeURIComponent(pid);
        $.ajax({
            url: siteurl + "comp/Violation",
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

    var galleryAddress = $('#galleryaddr').html();
    $('#gallery').on('click', '.isusermix2', function() {
        imgclk = $(this);
        var imgid = $(this).find('.id').html();
        imageidcorcmt = imgid;
        $('#modalgallery2').find('#bigimg').attr('src', galleryAddress + $(this).find('.adr').html());
        $('body').css({'overflow-y': 'hidden'});
        $('#modalgallery2').delay(200).fadeIn(300);
    });
    $('body').on('click', '.openprizemodal', function() {
        var img=$(this).find('.adr').html();
        $('#prizeModal1').find('img').attr('src',siteurl+'prize/image/'+img);
         $('body').css({'overflow-y': 'hidden'});
        $('#prizeModal1').delay(200).fadeIn(300);
    });

    $('#modalgallery2').on('click', '.closemd', function() {
        $('body').delay(200).css({'overflow-y': 'inherit'});
        $('#modalcomment').closeModal();
        $('#modalgallery2').fadeOut(300);
    });
    $('.free-wall').on('click', '.isusermix', function() {
        $('#imgrate').find('.modal-title').html('');
        imgclk = $(this);
        var star = $(this).find('#shorno').val();
        if (star == 1) {
            $('#itemrate').removeClass('none');
            $('.rating-container-rtl').find('.rating-stars').width((10 - $(this).find('.score-image1 span').html()) * 10 + '%');
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
        var imgid = $(this).find('#idpic').val();
        imageidcorcmt = imgid;
        $('#bigimg').attr('src', '');
        $('#bigimg').attr('src', $(this).find('.bgimg').attr('src'));
        if (($(this).find('.pn').html()) != '') {
            $('#imgrate').find('.modal-title').html('نام عکس: ' + $(this).find('.pn').html());
        }else{
             $('#imgrate').find('.modal-title').html('');
        }
        if (endcomp == 1) {
            if (parseInt($(this).find('.rt').html()) == 0) {
                $('#imgrate').find('.onestar').addClass('none');
            } else {
                $('#imgrate').find('.padding3').html($(this).find('.rt').html());
                $('#imgrate').find('.onestar').removeClass('none');
            }

        } else if (endcomp == 2) {//onestar
            $('#imgrate').find('.onestar').addClass('none');
            $('#imgrate').find('#winnername').html($(this).find('.winner').html());
            $('#imgrate').find('.wname').removeClass('none');
        }
        $('#imgrate').find('.cmt').html($(this).find('.cmt').html());
        $('#imgrate').find('.img-circle').attr('src', $(this).find('.av').attr('src'));
        $('#imgrate').find('.dt').html($(this).find('.dt').html());
        $('#imgrate').find('.us').html($(this).find('.us').html());
        $('#imgrate').find('#cmp').html($(this).find('#cmp').html());
    });
    $('.btn-takhalof').click(function() {
        $('#msgerrmod').hide();
        $('#msgsucmod').hide();
    });
    $('.rating-container-rtl').click(function() {
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
                if(result.msg==0){
                   imgclk.find('.score-image1').addClass('none');
                }else{
                   imgclk.find('.score-image1').find('span').text(result.msg);
                }
                imgclk.find('.rt').html(value);
                imgclk.find('img').addClass('show');
                imgclk.find('img').removeClass('none');
            }});
    });
});
