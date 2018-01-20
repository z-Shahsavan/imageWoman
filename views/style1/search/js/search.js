var crntpg = 1;
var imageidcorcmt;
var wall;
var activebtnmore = thisuserpgid;
$(function() {
    if(activebtnmore==0){
        $('#btnmore').addClass('none');
    }else{
        $('#btnmore').removeClass('none');
    }
    $('#imgModal').modal('hide');
    $('#name-search').hide();
    $('#date-search').hide();
    $('#compmatch').change(function() {
        if ($('#compmatch').val() == '3') {
            $('#name-search').show();
        } else {
            $('#name-search').hide();
        }
        if ($('#compmatch').val() == '4') {
            $('#date-search').show();
        } else {
            $('#date-search').hide();
        }
    });


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
    Calendar.setup({
        inputField: "date_input_1", // id of the input field
        button: "date_btn_1", // trigger for the calendar (button ID)
        ifFormat: "%Y-%m-%d", // format of the input field
        dateType: 'jalali',
        weekNumbers: false
    });
    Calendar.setup({
        inputField: "date_input_2", // id of the input field
        button: "date_btn_1", // trigger for the calendar (button ID)
        ifFormat: "%Y-%m-%d", // format of the input field
        dateType: 'jalali',
        weekNumbers: false
    });
    $('#divadvance').on('keydown', 'input', function(e) {
        var key = e.which;
        if (key == 13) {
            advancesearch();
            return false;
        }
    })
//    $('#divsearch').on('click', function() {
//        alert(12)
//        imgclk = $(this);
//        var star = $(this).find('#shorno').val();
//        if (star == 1) {
//            $('#itemrate').css('display', 'block');
//        } else {
//            $('#itemrate').css('display', 'none');
//        }
//        $('#bigimg').attr('src', '');
//        var imgid = $(this).find('.id').html();
//        imageidcorcmt = imgid;
//        $('#imgrate').find('.cntlnk').attr('href', $(this).find('.cntlnk').html());
//        $('#bigimg').attr('src', '');
//        $('#bigimg').attr('src', $(this).find('.bgimg').attr('src'));
//        $('#imgrate').find('.id').html($(this).find('.id').html());
//        $('#imgrate').find('.cmt').html($(this).find('.cmt').html());
//        $('#imgrate').find('.dt ').html($(this).find('.dt').html());
//        $('#imgrate').find('.us').html($(this).find('.us').html());
//        $('#imgrate').find('.tl').html($(this).find('.tl').html());
//        $('#imgrate').find('.cmp').html($(this).find('.sbj').html());
//        //*************************************************
//        //Set Rate
//        $('#itemrate').raty('score', parseFloat($(this).find('.rt').html()) / 2);
//        $('#imgrate').find('.av').attr('src', $(this).find('.av').attr('src'));
//        $('body').css({'overflow-y': 'hidden'});
//        $('#modalgallery').delay(200).fadeIn(300);
//    });
//    $('#modalgallery').on('click', '.closemd', function() {
//        $('body').delay(200).css({'overflow-y': 'inherit'});
//        $('#modalcomment').closeModal();
//        $('#modalgallery').fadeOut(300);
//    });
    $('#btnshowrep').on('click', function() {
        $('#idformreport').val($('#imgrate').find('.id').html());

        $('#modalreport').openModal();
    });
    //Rating

    $('#modalreport').on('click', '#btncloserep', function() {
        $('#modalreport').closeModal();
        $('#msgerrmod').hide();
        $('#msgsucmod').hide();
    });
    $('#btnregrep').on('click', function() {
        var pid = imageidcorcmt;
        var data = $('#formreport').serialize();
        //data.push({name: "imgid", value: pid});
        data += "&imgid=" + encodeURIComponent(pid);
        $.ajax({
            url: siteurl + "search/Violation",
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

    $('.btn-takhalof').click(function() {
        $('#msgerrmod').hide();
        $('#msgsucmod').hide();
    });

    $('#searchname').focus();

    $('input[name="searchby"]:radio').change(
            function() {
                switch (parseInt($(this).val())) {
                    case 2:
                        {
                            $('#divname,#divsubjects,#divpics,#divhashtag,#divuser,#divplace').fadeOut(0);
                            $('#divcompetition').fadeIn();
                            break;
                        }

                    case 4:
                        {
                            $('#divname,#divcompetition,#divsubjects,#divpics,#divuser,#divplace').fadeOut(0);
                            $('#divhashtag').fadeIn();
                            break;
                        }
                    case 5:
                        {
                            $('#divname,#divcompetition,#divsubjects,#divpics,#divplace,#divhashtag').fadeOut(0);
                            $('#divuser').fadeIn();
                            break;
                        }
                    case 6:
                        {
                            $('#divname,#divcompetition,#divsubjects,#divpics,#divuser,#divhashtag').fadeOut(0);
                            $('#divplace').fadeIn();
                            break;
                        }
                        //*************************************************
                }
            }
    );




    //Paging
    $('#btnmore').click(function() {
        crntpg++;
        var pgid;
        $("#paging1").hide();
        $("#waiting").show();
        pgid = crntpg;
        $.ajax({
            url: siteurl + "search/paging",
            type: "POST",
            data: {
                "pid": pgid
            },
            success: function(data) {
                $("#paging1").show();
                $("#waiting").hide();
                $('#freewall').append(data);
                wall.container.find('.brick img').load(function() {
                    wall.fitWidth();
                });
            },
            error: function() {
                $("#paging1").show();
                $("#waiting").hide();
                //alert("error");//
            }
        });

    });
//    var optInit = {
//        callback: pageSHCallback,
//        items_per_page: 1,
//        num_display_entries: 4,
//        current_page: 0,
//        num_edge_entries: 2,
//        link_to: "#",
//        prev_text: null,
//        next_text: null,
//        ellipse_text: "...",
//        prev_show_always: true,
//        next_show_always: true
//    };
//    $('#pagingsearch').pagination(maxSH, optInit);

//    function pageSHCallback(page_index, jq) {
//        if (isFirstSH != true) {
//            var pgid;
//            pgid=(page_index + 1);
//            $.ajax({
//                url: siteurl +"search/paging",
//                type: "POST",
//                data: {
//                    "pid": pgid
//                },
//                success: function(data) {
//                    $('#divsearch').html(data);
//                }
//            });
//        }
//        else {
//            isFirstSH = false;
//        }
//    }
    //*************************************************
    $('#dropcomptype').change(function() {
        $('#divcompnames').hide(0);
        $('#divcompdate').hide(0);

        switch (parseInt($(this).val())) {
            case 3:
                {
                    $('#divcompnames').show(300);
                    break;
                }
            case 4:
                {
                    $('#divcompdate').show(300);
                    break;
                }
        }
    });
    wall.container.find('.brick img').load(function() {
        wall.fitWidth();
    });


    $('.free-wall').on('click', '.isusermix', function() {
        $('#imgrate').find('.modal-title').html('');
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
        var imgid = $(this).find('#idpic').val();
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
        $('#imgrate').find('#cmp').html($(this).find('.cmp').html());
//        $('#imgrate').find('.padding3').html($(this).find('.rt').html());
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
//                type: "POST",
            dataType: 'json',
            success: function(result) {
                //$('.resultrate').find('span').html(result.msg); 
                //alert(12);
                imgclk.find('.score-image1').find('span').text(result.msg);
                imgclk.find('.rt').html(value);
                imgclk.find('img').addClass('show');
                imgclk.find('img').removeClass('none');
            }});
    });
});
function advancesearch() {
    document.getElementById("formchangerole").submit();
}
