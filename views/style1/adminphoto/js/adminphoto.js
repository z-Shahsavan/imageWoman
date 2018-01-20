var maxWP = gallerymaxpg;
var isFirstWP = true;
var maxCP = 15;
var isFirstCP = true;
var winitem;
var here;
var crntpg = 1;
var that;
var tedad;

$(function() {
    that = $('#catall');
    $('select').not(".disabled").material_select();

    $('.tooltipped').tooltip({delay: 50});

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
            if ($(this).attr('href') === '#taeednashode-content') {
                loaddavari();
            } else if ($(this).attr('href') === '#competition-content') {
                loadpeople();
            }
        }
    });
    var winuser = 0;
    var winitem;
    var monitem;
    var monuser = 0;
    $('#divtaeednashode').on('click', '.monbtn2', function() {
        var moit = $(this);
        var id = $(this).parents('.pitem').find('.id').html();
        id = id.substring(2, id.length);
        if ($(this).parents('.pitem').find('.iswin').html() == 2) {
            moit.parents('.pitem').find('.iswin').html(0);
        } else if ($(this).parents('.pitem').find('.iswin').html() == 5) {
            moit.parents('.pitem').find('.iswin').html(3);
        }
        $(this).html('<i class="mdi-action-done right"></i>منتخب داوری');
        $(this).removeClass('monbtn2');
        $(this).addClass('monbtn');
        moit.parents('.btnsdiv').find('.winbtn').removeClass('none');
        $.post(siteurl + "adminphoto/delrate/", {id: id, status: moit.parents('.pitem').find('.iswin').html(), type: 1});
    });
    $('#divtaeednashode').on('click', '.winbtn2', function() {
        var winit = $(this);
        var id = $(this).parents('.pitem').find('.id').html();
        id = id.substring(2, id.length);
        if ($(this).parents('.pitem').find('.iswin').html() == 1) {
            winit.parents('.pitem').find('.iswin').html(0);
        } else if ($(this).parents('.pitem').find('.iswin').html() == 4) {
            winit.parents('.pitem').find('.iswin').html(3);
        }
        $(this).html('<i class="mdi-action-done right"></i>برنده داوری');
        $(this).removeClass('winbtn2');
        $(this).addClass('winbtn');
        winit.parents('.btnsdiv').find('.monbtn').removeClass('none');
        $.post(siteurl + "adminphoto/delrate/", {id: id, status: winit.parents('.pitem').find('.iswin').html(), type: 0});
    });
    $('#divtaeednashode').on('click', '.monbtn', function() {
        monitem = $(this);
        var mon = $(this).parents('.pitem').find('.id').html();
        mon = mon.substring(2, mon.length);
        monuser = $(this).parents('.pitem').find('.us').attr('id');
        monuser = monuser.substring(2, monuser.length);
        winuser = 0;
        winu = 0
        $('#idformwinner').val(mon);
        if ($(this).parents('.pitem').find('.iswin').html() == 0) {
            $('#winstatus').val(2);
        } else if ($(this).parents('.pitem').find('.iswin').html() == 3) {
            $('#winstatus').val(5);
        }
        $('#comment').val('');
        $('#grade').val('');
        $('#grd').addClass('none');
        $('#jayeze').val('');
        $('.msgerr').hide();
        $('.msgok').hide();
        $('#modalwinner').openModal();
    });
    $('#divtaeednashode').on('click', '.winbtn', function() {
      
        winitem = $(this);
        var windv = $(this).parents('.pitem').find('.id').html();
        windv = windv.substring(2, windv.length);
        winuser = $(this).parents('.pitem').find('.us').attr('id');
        winuser = winuser.substring(2, winuser.length);
         
        monuser = 0;
        winu = 0;
        $('#idformwinner').val(windv);
        if ($(this).parents('.pitem').find('.iswin').html() == 0) {
            $('#winstatus').val(1);
        } else if ($(this).parents('.pitem').find('.iswin').html() == 3) {
            $('#winstatus').val(4);
        }
        $('#comment').val('');
        $('#grade').val('');
        $('#jayeze').val('');
        $('.msgerr').hide();
        $('.msgok').hide();
        $('#modalwinner').openModal();
    });
    $('#modalwinner').on('click', '#submitwinner', function() {///
        var data = $('#formwinner').serialize();
        if (monuser != 0) {
            data += '&winuser=' + winuser;
            data += '&wintype=1';// win po
            $.ajax({url: siteurl + 'adminphoto/saverate',
                data: data,
                type: 'POST',
                dataType: 'json',
                success: function(result) {
                    if (result.id > 0) {
                        monitem.parents('.pitem').find('.iswin').html($('#winstatus').val());
                        monitem.parents('.btnsdiv').find('.winbtn').addClass('none')
                        monitem.html('<i class="mdi-action-done right"></i>انصراف از اعلام بعنوان منتخب');
                        monitem.addClass('monbtn2');
                        monitem.removeClass('monbtn');
                        $('.msgok').html(result.msg);
                    } else {
                        $('.msgerr').html(result.msg);
                        $('.msgerr').show();
                        $('.msgok').hide();
                    }
                }});
        } else if (winuser != 0) {
            data += '&winuser=' + winuser;
            data += '&wintype=0';
            $.ajax({url: siteurl + 'adminphoto/saverate',
                data: data,
                type: 'POST',
                dataType: 'json',
                success: function(result) {
                    if (result.id > 0) {
                        winitem.parents('.pitem').find('.iswin').html($('#winstatus').val());
                        winitem.parents('.btnsdiv').find('.monbtn').addClass('none')
                        winitem.html('<i class="mdi-action-done right"></i>انصراف از اعلام بعنوان برنده');
                        winitem.addClass('winbtn2');
                        winitem.removeClass('winbtn');
                        $('.msgok').html(result.msg);
                    } else {
                        $('.msgerr').html(result.msg);
                        $('.msgerr').show();
                        $('.msgok').hide();
                    }
                }});
        } else if (winu != 0) {
            data += '&winuser=' + winu;
            data += '&wintype=2';
            $.ajax({url: siteurl + 'adminphoto/saverate',
                data: data,
                type: 'POST',
                dataType: 'json',
                success: function(result) {
                    if (result.id > 0) {
                        winitempo.parents('.pitem').find('.poiswin').html($('#winstatus').val());
                        winitempo.html('<i class="mdi-action-done right"></i>انصراف از اعلام بعنوان برنده مردمی');
                        winitempo.addClass('winbtn2');
                        winitempo.removeClass('winbtn');
                        $('.msgok').html(result.msg);
                    } else {
                        $('.msgerr').html(result.msg);
                        $('.msgerr').show();
                        $('.msgok').hide();
                    }
                }});
        }
    });

    $('#modalwinner').on('click', '.btncancel', function() {
        $('#modalwinner').closeModal();
    });
//    var galleryAddress = $('#galleryaddr').html();
//    $('#divtaeednashode,#divcompetition').on('click', '.zoomimg', function() {
////        $('#bigimg').attr('src', '');
//        $('#bigimg').attr('src',$(this).parents('.pitem').find('.cnt').find('.adr').html());
//        $('body').css({'overflow-y': 'hidden'});
//        $('#modalgallery').delay(200).fadeIn(300);
//    });

    $('#modalgallery').on('click', '.closemd', function() {
        $('body').delay(200).css({'overflow-y': 'inherit'});
        $('#modalgallery').fadeOut(300);
    });
    //Paging photo
    $('#btnmore').click(function() {
        tedad=($('#divcatitems').find('.pitem').length);
        crntpg++;
        $("#pagingall").hide();
        $("#waiting").show();
        var pgid = crntpg;
        $.ajax({
            url: siteurl + "adminphoto/paging",
            type: "POST",
            data: {
                "pid": pgid
            },
            dataType: 'json',
            success: function(data) {
                if(parseInt(data.noapp)==0){
                $('#divcatitems').append(data.list);
                $("#pagingall").show();
                $("#waiting").hide();
            }else{
                $('#divcatitems').html(data.list);
                $("#pagingall").show();
                $("#waiting").hide();
            }
            },
            error: function() {
                $("#pagingall").show();
                $("#waiting").hide();
      
            }
        });
    });
    //Taeed Photo
    //Ok
    $('#divcatitems').on('click', '.okcmt', function() {
        var data = {pid: ($(this).parents('.pitem').find('.id').html()), pconf: ($(this).parents('.pitem').find('.confirm').html())};
        $(this).parents('.pitem').remove();
        $.ajax({url: siteurl + 'adminphoto/confirmphoto',
            data: data,
            type: 'POST',
        });
    });
    //Delete
    $('#divtaeednashode').on('click', '.delcmt', function() {
        $(this).parents('.pitem').remove();
    });
    //Competition Photo
    //Win
    var winitempo;
    var winu = 0;
    $('#divcompetition').on('click', '.winbtn', function() {
        winitempo = $(this);
        var powin = $(this).parents('.pitem').find('.id').html();
        powin = powin.substring(2, powin.length);
        winu = $(this).parents('.pitem').find('.us').attr('id');
        winu = winu.substring(2, winu.length);
        monuser = 0;
        winuser = 0;
        if ($(this).parents('.pitem').find('.poiswin').html() == 0) {
            $('#winstatus').val(3);
        } else if ($(this).parents('.pitem').find('.poiswin').html() == 1) {
            $('#winstatus').val(4);
        } else if ($(this).parents('.pitem').find('.poiswin').html() == 2) {
            $('#winstatus').val(5);
        }
        $('#idformwinner').val(powin);
        $('#comment').val('');
        $('#grade').val('');
        $('#jayeze').val('');
        $('.msgerr').hide();
        $('.msgok').hide();
        $('#modalwinner').openModal();
    });
    $('#divcompetition').on('click', '.winbtn2', function() {
        var winitpo = $(this);
        var id = $(this).parents('.pitem').find('.id').html();
        id = id.substring(2, id.length);
        if ($(this).parents('.pitem').find('.poiswin').html() == 3) {
            winitpo.parents('.pitem').find('.poiswin').html(0);
        } else if ($(this).parents('.pitem').find('.poiswin').html() == 4) {
            winitpo.parents('.pitem').find('.poiswin').html(1);
        } else if ($(this).parents('.pitem').find('.poiswin').html() == 5) {
            winitpo.parents('.pitem').find('.poiswin').html(2);
        }
        $(this).html('<i class="mdi-action-done right"></i>برنده مردمی');
        $(this).removeClass('winbtn2');
        $(this).addClass('winbtn');
        $.post(siteurl + "adminphoto/delrate/", {id: id, status: winitpo.parents('.pitem').find('.poiswin').html(), type: 2});
    });

    //published photo
    $('#divcatitems').on('click', '.delcmt', function() {
        here = $(this);
        $('#idformdeny').val($(this).parents('.pitem').find('.id').html());
        $('#modaldeny').openModal();
    });
    $('#modaldeny').on('click', '#btnclosedeny', function() {
        $('#modaldeny').closeModal();
    });
    $('#submitdeny').click(function() {
        var data = $('#formdeny').serialize();
        here.parents('.pitem').remove();
        $.ajax({url: siteurl + 'adminphoto/dltphoto',
            data: data,
            type: 'POST', 
            success: function() {
              window.setTimeout(function() {
                         $('#modaldeny').closeModal();
                    }, 2000);
            }
        });
    });
    //Competition Photo
    //Win

    //**********************************************
    $('#divcompetition').on('click', '.pitem .cnt', function() {
        if ($(this).parents('.pitem').hasClass('active')) {
            $(this).parents('.pitem').removeClass('active');
        }
        else {
            $(this).parents('.pitem').addClass('active');
        }
    });
    $('#downimages').click(function() {
        var selax = [];
        var i = 0;
        var ax;
        $('#divcompetition').find('.pitem.active').each(function(index) {
            ax = $(this).find('.id').html();
            ax = ax.substring(2, ax.length);
            selax[i++] = ax;
        });
        $.ajax({
            url: siteurl + 'adminphoto/fordown',
            type: "POST",
            dataType: 'json',
            data: {
                "selax[]": selax
            },
            success: function(result) {
                if (result.id == 1) {
                    $('#linkdownimages').removeClass('none');
                    $('#linkdownimages').attr('href', result.add);
                } else if (result.id == 0) {
                }
            }
        });
        //Remove Active Class
        $('#divcompetition').find('.pitem').removeClass('active');
    });
    $('#divtaeednashode').on('click', '.pitem .cnt', function() {
        if ($(this).parents('.pitem').hasClass('active')) {
            $(this).parents('.pitem').removeClass('active');
        }
        else {
            $(this).parents('.pitem').addClass('active');
        }
    });
    $('#downimagestn').click(function() {
        var selax = [];
        var i = 0;
        var ax;
        $('#divtaeednashode').find('.pitem.active').each(function(index) {
            ax = $(this).find('.id').html();
            ax = ax.substring(2, ax.length);
            selax[i++] = ax;
        });
        $.ajax({
            url: siteurl + 'adminphoto/fordown',
            type: "POST",
            dataType: 'json',
            data: {
                "selax[]": selax
            },
            success: function(result) {
                if (result.id == 1) {
                    $('#linkdownimagestn').removeClass('none');
                    $('#linkdownimagestn').attr('href', result.add);
                } else if (result.id == 0) {
                    //alert(result.add)
                }
            }
        });
        //Remove Active Class
        $('#divtaeednashode').find('.pitem').removeClass('active');
    });
    //Category
    $('#cat-content').on('click', '.cattab', function() {
        crntpg = 1;
        var data = ($(this).attr('id'));
        that = $(this);
        $('#divcatitems').html('');
        $.ajax({
            url: siteurl + "adminphoto/loadphoto",
            type: "POST",
            data: {data: data},
            dataType: 'json',
            success: function(result) {
                $('#divcatitems').html(result.msg);
                $('#cat-content').find('.cattab').removeClass('active');
                that.addClass('active');
                ($('#cat-content').find('#formsearchphoto').find('#pidhide').val(data));
            },
            error: function() {
            }
        });

    });
    $('#formsearchphoto').on('click', '#submitphotosearch', function() {
        var searchinf = $('#formsearchphoto').serialize();
        $.ajax({url: siteurl + 'adminphoto/searchphoto',
            data: searchinf,
            type: 'POST',
            dataType: 'json',
            success: function(res) {
                $('#divcatitems').html(res.msg);
            },
            error: function() {
            }
        });
    });
});

var changeCompatition = function() {
    $("#divtaeednashode").html('');
    $.ajax({url: siteurl + 'adminphoto/loadselpeople/' + $('#competition').val(),
        type: 'POST',
        dataType: 'json',
        success: function(result) {
            $("#divcompetition").html(result.list2);
            $("#competition").material_select('destroy');
            $("#competition").html(result.comps);
            $("#competition").material_select();
        }});
}

var changeDavComp = function() {
    $("#divtaeednashode").html('');
    $.ajax({url: siteurl + 'adminphoto/loadseldav/' + $('#davaricomp').val(),
        type: 'POST',
        dataType: 'json',
        success: function(result) {
            $("#divtaeednashode").html(result.list1);
            $("#davaricomp").material_select('destroy');
            $("#davaricomp").html(result.comps);
            $("#davaricomp").material_select();
        }});
}
function loaddavari() {
    $("#divtaeednashode").html('');
    $.ajax({url: siteurl + 'adminphoto/loadseldav',
        type: 'POST',
        dataType: 'json',
        success: function(result) {
            $("#divtaeednashode").html(result.list1);
            $("#davaricomp").material_select('destroy');
            $("#davaricomp").html(result.comps);
            $("#davaricomp").material_select();
        }});
}
function loadpeople() {
    $.ajax({url: siteurl + 'adminphoto/loadselpeople',
        type: 'POST',
        dataType: 'json',
        success: function(result) {
            $("#divcompetition").html(result.list2);
            $("#competition").material_select('destroy');
            $("#competition").html(result.comps);
            $("#competition").material_select();
        }});
}
