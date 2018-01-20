var isFirstAll = true;
var maxAll = gallerymaxpg;//[VARIMAGECOUNT]
var isFirstAC = true;
var maxAC = okuserimage//[VARUSEROKIMAGECOUNT]
var isFirstDN = true;
var maxDN = penuserimage;//[VARSERPENIMAGECOUNT]
var denyItem;
var pghead1 = 1, pghead2 = 1, pghead3 = 1;
var crntpg = 1;
var autoload = true;
var imgclk;

$(function() {


  //  $('select').not(".disabled").material_select();

    $('.tooltipped').tooltip({delay: 50});

    // $('.modal-trigger').leanModal({
    //     dismissible: true
    // });

    t = setInterval(
            function() {
                if (autoload == true) {
                    $.ajax({
                        url: siteurl + 'bazbin/findnew',
                        type: "Post",
                        success: function(data) {
                            $('#divcatitems').html(data);
                            crntpg = 1;
                        }
                    });
                }
            }, 5000);


    var galleryAddress = $('#galleryaddr').html();
    $('#all-content,#accepted-content,#deny-content').on('click', '.zoomimg', function() {
        $('#bigimg').attr('src', '');
        $('#bigimg').attr('src', galleryAddress + $(this).parents('.pitem').find('.cnt').find('.adr').html());
        $('body').css({'overflow-y': 'hidden'});
        $('#modalgallery2').delay(200).fadeIn(300);
    });

    $('#modalgallery').on('click', '.closemd', function() {
        $('body').delay(200).css({'overflow-y': 'inherit'});
        $('#modalgallery2').fadeOut(300);
    });

    //All Tab
    function checkRemainingAll() {
        var rem = parseInt($('#remdiv').html());
        if (rem > 0) {
            $('#remdiv').html(rem - 1);
            return true;
        }
        else {
            Materialize.toast('تعداد باقیمانده شما به اتمام رسیده است', 4000);
            return false;
        }
    }
    $('.alldiv').on('click', '.okcmt', function(e) {
        //Check Remainig
        if (checkRemainingAll()) {
            $(this).parents('.pitem').remove();
            var vo = $(this).parents('#vote').find('#vo').html();
            vo = vo.substring(2, vo.length);
            $(this).parents('#vote').remove();
            $.ajax({
                url: siteurl + 'bazbin/okfunc/' + vo,
                type: "POST",
            });
        }
    });
//    var galleryAddress = $('#galleryaddr').html();
//    $('.pitem').on('click', '.img', function() {
////        alert(12)
//
//        imgclk = $(this);
////        $('#bigimg').attr('src', '');
//        var imgid = $(this).find('.id').html();
//        imageidcorcmt = imgid;
//        $('#modalgallery2').find('#bigimg').attr('src', galleryAddress + $(this).find('.adr').html());
////        $('#imgrate').find('.cntlnk').attr('href', $(this).find('.cntlnk').html());
//
////        $('#bigimg').attr('src', $(this).find('.bgimg').attr('src'));
//        $('body').css({'overflow-y': 'hidden'});
//        $('#modalgallery2').delay(200).fadeIn(300);
//    });
    var notokid = 0;
    $('.alldiv').on('click', '.delcmt', function() {
        //Check Remainig
        denyItem = $(this).parents('.pitem');
        $('#idformwinner').val($(this).parents('.pitem').find('.id').html());
        $('#comment').val('');
        // $('select').material_select('destroy');
        $("#mozuedit option[value=" + $(this).parents('.pitem').find('.sbjid').html() + "]").attr('selected', 'selected');
        // $('select').material_select();
        $('#modaldeny').modal();
        var vo = $(this).parents('#vote').find('#vo').html();
        notokid = vo.substring(2, vo.length);
        xx = 0;
        denyItem = $(this).parents('.pitem');
        $('#idformwinner').val($(this).parents('.pitem').find('.id').html());
        $('#comment').val('');
        // $('select').material_select('destroy');
        // $('select').material_select();
        $('#modaldeny').modal();
    });

    //Accepted Tab
    $('.accepteddiv').on('click', '.rejectbtn', function(e) {
        var ata = $(this).parents('#okvo').find('#ok').html()
        ata = ata.substring(2, ata.length);
        $.post(siteurl + "bazbin/addtoall", {id: ata});
        $(this).parents('.pitem').remove();
        $('span#remdiv').html((parseInt($('span#remdiv').html()) + 1));
    });
    var xx = 0;
    $('#accepted-content').on('click', '.delcmt', function() {
        var o = $(this).parents('#okvo').find('#ok').html();
        xx = o.substring(2, o.length);
        notokid = 0;
        denyItem = $(this).parents('.pitem');
        $('#idformdeny').val($(this).parents('.pitem').find('.id').html());
        $('#comment').val('');
        // $('select').material_select('destroy');
        // $('select').material_select();
        $('#modaldeny').openModal();
    });

    //Deny Tab
    $('.denydiv').on('click', '.okcmt', function(e) {
        if (checkRemainingAll()) {
            var no = ($(this).parents('#novo').find('#no').html());
            no = no.substring(2, no.length);
            $.post(siteurl + "bazbin/addtook", {id: no});
            $(this).parents('.pitem').remove();
        }
    });

    $('.denydiv').on('click', '.rejectbtn', function(e) {
        var no = ($(this).parents('#novo').find('#no').html());
        no = no.substring(2, no.length);
        $.post(siteurl + "bazbin/addtoall", {id: no});
        $(this).parents('.pitem').remove();
    });

    //Deny Popup
    $('#modaldeny').on('click', '#submitdeny', function() {
        if ($('#selwhydeny').attr("class") !== "none") {//related publish tab
            if (($("input[type='radio'][name='whydeny']:checked").val()).length == 0) {
                return;
            }
            var upda = 0;
            var score = 0;
            if (whichcat == 0) {
                upda = 2;
            } else if (whichcat == 1) {
                upda = 2;
                score = -50;
            } else if (whichcat == 2) {
                upda = 0;
            }
            $.post(siteurl + "bazbin/publish/", {id: pubid, score: score,
                up: upda,
                whydeny: $("input[type='radio'][name='whydeny']:checked").val()});
        } else {//related to bazbin tabs
            var a = [];
            a[1] = $('#comment').val();
            if (a[1] == '') {
                a[1] = 'فاقد توضیحات';
            }
            // a[2] = $('#mozuedit').val();
            if (notokid == 0 && xx != 0) {
                $(this).parents('#okvo').remove();
                $('span#remdiv').html((parseInt($('span#remdiv').html()) + 1));
                $.ajax({
                    url: siteurl + 'bazbin/reject/' + xx + '/' + a[1], //+'/'+a[2],
                    type: "POST",
                });
            } else {
                a[0] = notokid;
                $(this).parents('#vote').remove();
                $.ajax({
                    url: siteurl + 'bazbin/notokfunc/' + notokid + '/' + a[1], //+'/'+a[2],
                    type: "POST",
                });
            }
        }
        denyItem.remove();
        $('#modaldeny').modal('hide');
    });

    $('#modaldeny').on('click', '.btncancel', function() {
        $('#modaldeny').modal('hide');
    });

    //Paging all
    $('#btnmore').click(function() {
        crntpg++;
        $("#pagingall").hide();
        $("#waiting1").show();
        var pgid = crntpg;
        $.ajax({
            url: siteurl + "bazbin/pagingforpublishtab",
            type: "POST",
            data: {
                "pid": pgid
            },
            success: function(data) {
                if (parseInt(data.noapp) == 0) {
                    $('#axs').append(data.list);
                    $("#pagingall").show();
                    $("#waiting1").hide();
                } else {
                    $('#axs').html(data.list);
                    $("#pagingall").show();
                    $("#waiting1").hide();
                }
            },
            error: function() {
                $("#pagingall").show();
                $("#waiting1").hide();
                //alert("error");//
            }
        });
    });
    //Paging comp
    $('#btnmorecomp').click(function() {
        crntpg++;
        $("#pagingallcomp").hide();
        $("#waiting2").show();
        var pgid = crntpg;
        $.ajax({
            url: siteurl + "bazbin/pagingloadphotos",
            type: "POST",
            data: {
                "pidcomp": pgid
            },
            success: function(data) {
                if (parseInt(data.noapp) == 0) {
                    $('#axs').append(data.list);
                    $("#pagingallcomp").show();
                    $("#waiting2").hide();
                } else {
                    $('#axs').html(data.list);
                    $("#pagingallcomp").show();
                    $("#waiting2").hide();
                }
            },
            error: function() {
                $("#pagingallcomp").show();
                $("#waiting2").hide();
                //alert("error");//
            }
        });
    });
    //Paging accepted
    $('#btnmoreaccepted').click(function() {
        crntpg++;
        $("#pagingaccepted").hide();
        $("#waiting3").show();
        var pgid = crntpg;
        $.ajax({
            url: siteurl + "bazbin/pagingloadoks",
            type: "POST",
            data: {
                "pidoks": pgid
            },
            success: function(data) {
                if (parseInt(data.noapp) == 0) {
                    $('#divcatitems').append(data.list);
                    $("#pagingaccepted").show();
                    $("#waiting3").hide();
                } else {
                    $('#divcatitems').html(data.list);
                    $("#pagingaccepted").show();
                    $("#waiting3").hide();
                }
            },
            error: function() {
                $("#pagingaccepted").show();
                $("#waiting3").hide();
                //alert("error");//
            }
        });
    });//Paging deny
    $('#btnmorenos').click(function() {
        crntpg++;
        $("#pagingdeny").hide();
        $("#waiting4").show();
        var pgid = crntpg;
        $.ajax({
            url: siteurl + "bazbin/pagingloadnos",
            type: "POST",
            data: {
                "pidnos": pgid
            },
            success: function(data) {
                if (parseInt(data.noapp) == 0) {
                    $('#deny').append(data.list);
                    $("#pagingdeny").show();
                    $("#waiting4").hide();
                } else {
                    $('#deny').html(data.list);
                    $("#pagingdeny").show();
                    $("#waiting4").hide();
                }
            },
            error: function() {
                $("#pagingdeny").show();
                $("#waiting4").hide();
                //alert("error");//
            }
        });
    });


    function pageAllCallback(page_index, jq) {
        if (isFirstAll != true) {
            pghead1 = page_index + 1;
            loadphotos(1, page_index + 1, pghead1);
        }
        else {
            isFirstAll = false;
        }

    }

    //Category
    $('#cat-content').on('click', '.cattab', function() {//loadforpublishtab
        crntpg = 1;
        $('#cat-content').find('.cattab').removeClass('active');
        $(this).addClass('active');
    });
    var whichcat = 0;
    $('#cat-content').on('click', '#catall', function() {
        autoload = true;
        whichcat = 0;
        $.ajax({url: siteurl + 'bazbin/loadforpublishtab/0/1',
            type: 'POST',
            success: function(result) {
                $("#divcatitems").html(result);
            }});
    });
    $('#cat-content').on('click', '#catviewd', function() {
        autoload = false;
        whichcat = 1;
        $.ajax({url: siteurl + 'bazbin/loadforpublishtab/1/1',
            type: 'POST',
            success: function(result) {
                $("#divcatitems").html(result);
            }});
    });
    $('#cat-content').on('click', '#catarchive', function() {
        autoload = false;
        whichcat = 2;
        $.ajax({url: siteurl + 'bazbin/loadforpublishtab/2/1',
            type: 'POST',
            success: function(result) {
                $("#divcatitems").html(result);
            }});
    });
    $('.catdiv').on('click', '.okcmt', function(e) {
        var upda = 0;
        var score = 0;
        if (whichcat == 0) {
            upda = 1;
            score = +50;
        } else if (whichcat == 1) {
            upda = 0;
            score = -50;
        } else if (whichcat == 2) {
            upda = 1;
        }
        $.post(siteurl + "bazbin/publish/", {id: $(this).parents('.pitem').find('.id').html(), up: upda, score: score});
        $(this).parents('.pitem').remove();

    });
    var pubid = 0;
    $('.catdiv').on('click', '.overview', function() {
        $.post(siteurl + "bazbin/publish/", {id: $(this).parents('.pitem').find('.id').html(), up: 0,
            norelate: $(this).parents('.pitem').find('#confirm').html()});
        $(this).parents('.pitem').find('#confirm').html("0")
        $(this).parents('.pitem').remove();
    });
    $('.catdiv').on('click', '.delcmt', function() {
        if (checkRemainingAll) {
            pubid = $(this).parents('.pitem').find('.id').html();
            denyItem = $(this).parents('.pitem');
            $('#modcomm').attr("class", "none");
            $('#selwhydeny').attr("class", "col-xs-12");
            // $('select').material_select('destroy');
            // $('select').material_select();
            $('#modaldeny').modal();
        }
    });
    $('#axs').on('click', '.delcmt', function() {
        if (checkRemainingAll) {
            pubid = $(this).parents('.pitem').find('.id').html();
            denyItem = $(this).parents('.pitem');
            $('#modcomm').attr("class", "col-xs-12");
            $('#selwhydeny').attr("class", "none");
            // $('select').material_select('destroy');
            // $('select').material_select();
            $('#modaldeny').modal();
        }
    });
    $('#accepteddivres').on('click', '.delcmt', function() {
//        alert (12343454)
        if (checkRemainingAll) {
            pubid = $(this).parents('.pitem').find('.id').html();
            denyItem = $(this).parents('.pitem');
            $('#modcomm').attr("class", "col-xs-12");
            $('#selwhydeny').attr("class", "none");
            // $('select').material_select('destroy');
            // $('select').material_select();
            $('#modaldeny').modal();
        }
    });
    $('#sidemenu a').on('click', function(e) {
        crntpg = 1;
        e.preventDefault();
        if ($(this).attr('href') === '#all-content') {
            autoload = false;
            loadphotos(1, 0, pghead1);
        } else if ($(this).attr('href') === '#accepted-content') {
            autoload = false;
            loadoks(0, pghead2);
        } else if ($(this).attr('href') === '#deny-content') {
            autoload = false;
            loadnos(0, pghead3);
        } else if ($(this).attr('href') === '#cat-content') {
            autoload = true;
        }
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
    $('#divcatitems').on('click', 'img', function() {
        imgclk = $(this).parents('.pitem');
//                alert( $(this).html());
        var imgid = $(this).find('.id').html();
//        alert (imgid);
//        imageidcorcmt = imgid;
        $('#modalgallery2').find('#bigimg1').attr('src',$(this).parents('.pitem').find('.responsive-img').attr('src'));
        $('body').css({'overflow-y': 'hidden'});
        $('#modalgallery2').delay(200).fadeIn(300);
    });
    $('#axs').on('click', 'img', function() {
        imgclk = $(this).parents('.pitem');
//                alert( $(this).html());
        var imgid = $(this).find('.id').html();
//        alert (imgid);
//        imageidcorcmt = imgid;
        $('#modalgallery2').find('#bigimg1').attr('src','');
        var address=($(this).parents('.pitem').find('.adr').html());
        $('#modalgallery2').find('#bigimg1').attr('src',address);
        $('body').css({'overflow-y': 'hidden'});
        $('#modalgallery2').delay(200).fadeIn(300);
    });
    $('#accepteddivres').on('click', 'img', function() {//alert($(this).parents('.pitem').find('.adr').html())
        imgclk = $(this).parents('.pitem');
//                alert( $(this).html());
        var imgid = $(this).find('.id').html();
//        alert (imgid);
//        imageidcorcmt = imgid;
        $('#modalgallery2').find('#bigimg1').attr('src','');
        var address=($(this).parents('.pitem').find('.adr').html());
        $('#modalgallery2').find('#bigimg1').attr('src',address);
        $('body').css({'overflow-y': 'hidden'});
        $('#modalgallery2').delay(200).fadeIn(300);
    });
$('#deny').on('click', 'img', function() {//alert($(this).parents('.pitem').find('.adr').html())
        imgclk = $(this).parents('.pitem');
//                alert( $(this).html());
        var imgid = $(this).find('.id').html();
//        alert (imgid);
//        imageidcorcmt = imgid;
        $('#modalgallery2').find('#bigimg1').attr('src','');
        var address=($(this).parents('.pitem').find('.adr').html());
        $('#modalgallery2').find('#bigimg1').attr('src',address);
        $('body').css({'overflow-y': 'hidden'});
        $('#modalgallery2').delay(200).fadeIn(300);
    });

    $('#modalgallery2').on('click', '.closemd', function() {
        $('body').delay(200).css({'overflow-y': 'inherit'});
        $('#modalcomment').modal();
        $('#modalgallery2').fadeOut(300);
    });
});
function loadoks(sel, last) {
    $("#accepted-content").find(".col").html('');
    var da = {lastpg: last, selpg: sel};
    $.ajax({url: siteurl + 'bazbin/loadoks',
        type: 'POST',
        data: da,
        dataType: 'json',
        success: function(result) {
            $("#accepted-content").find(".accepteddiv").html(result.list1);
            // $("#competition").material_select('destroy');
            $("#competition").html(result.comps);
            // $("#competition").material_select();
        }});
}
function loadnos(sel, last) {
    $("#deny-content").find(".col").html('');
    var da = {lastpg: last, selpg: sel};
    $.ajax({url: siteurl + 'bazbin/loadnos',
        type: 'POST',
        data: da,
        dataType: 'json',
        success: function(result) {
            $("#deny-content").find("#deny").html(result.list2);
            // $("#competition").material_select('destroy');
            $("#competition").html(result.comps);
            // $("#competition").material_select();
        }});
}
function loadphotos(ar, sel, last) {//ar=1 means request from ajax loadphotos
    var da = {ajaxreq: ar, lastpg: last, selpg: sel};
    $.ajax({url: siteurl + 'bazbin/loadphotos',
        type: 'POST',
        data: da,
        dataType: 'json',
        success: function(result) {
            $("#all-content").find(".alldiv").html(result.list);
            // $("#competition").material_select('destroy');
            $("#competition").html(result.comps);
            // $("#competition").material_select();
            $("span#remdiv").html(result.divimg);
        }});
}
var currcomp = 0;
var changeCompatition = function() {
    $("#axs").html('');
    $.ajax({url: siteurl + 'bazbin/loadselcomps/' + $('#competition').val(),
        type: 'POST',
        dataType: 'json',
        success: function(result) {
            // $("#competition").material_select('destroy');
            $("#competition").html(result.comps);
            // $("#competition").material_select();
            $("#axs").html(result.list);
            $("span#remdiv").html(result.divimg);
        }});
};
var changepubComp = function() {
    window.location.href = siteurl + 'bazbin/index/' + $('#pubcmp').val();
};