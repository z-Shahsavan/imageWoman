var maxWP = 0;
var isFirstWP = true;
var maxCP = 15;
var isFirstCP = true;
var crntpos;
$(function() {

    Calendar.setup({
        inputField: "startdate", // id of the input field  modaleditcomp
        button: "date_btn_1", // trigger for the calendar (button ID)
        ifFormat: "%Y/%m/%d", // format of the input field
        dateType: 'jalali',
        weekNumbers: false
        
    });
    Calendar.setup({
        inputField: "enddate", // id of the input field
        button: "date_btn_2", // trigger for the calendar (button ID)
        ifFormat: "%Y/%m/%d", // format of the input field
        dateType: 'jalali',
        weekNumbers: false
    });
    Calendar.setup({
        inputField: "startdatecmp", // id of the input field
        button: "date_btn_3", // trigger for the calendar (button ID)
        ifFormat: "%Y/%m/%d", // format of the input field
        dateType: 'jalali',
        weekNumbers: false
    });
    Calendar.setup({
        inputField: "enddatecmp", // id of the input field
        button: "date_btn_4", // trigger for the calendar (button ID)
        ifFormat: "%Y/%m/%d", // format of the input field
        dateType: 'jalali',
        weekNumbers: false
    });

    $('.row,nav,form').addClass('rtl');
    $('.container,#formregcomp,#cntmndiv').removeClass('rtl');

    $("label[for='startdatecmp']").addClass('active');
    $("label[for='enddatecmp']").addClass('active');

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
        }
    });

    //Paging Taeed Nashodeha
    var optInit = {
        callback: pageCPCallback,
        items_per_page: 1,
        num_display_entries: 4,
        current_page: 0,
        num_edge_entries: 2,
        link_to: "#",
        prev_text: null,
        next_text: null,
        ellipse_text: "...",
        prev_show_always: true,
        next_show_always: true
    };
    $('#pagingcompetition').pagination(maxWP, optInit);

    function pageCPCallback(page_index, jq) {
        if (isFirstWP != true) {
            //alert(page_index + 1)
        }
        else {
            isFirstWP = false;
        }

    }

    $('#compsdiv').on('click', '.editcmp', function() {
        $('#idformedit').val($(this).parents('.pitem').find('.id').html());
        $('#nameedit').val($(this).parents('.pitem').find('.tl').find('span').html());
        $('#commentedit').val($(this).parents('.pitem').find('.cmt').find('span').html());
        $('#sath').val($(this).parents('.pitem').find('.sath').find('span').html());
        $('#startdate').val($(this).parents('.pitem').find('.sdt').find('span').html());
        $('#enddate').val($(this).parents('.pitem').find('.edt').find('span').html());
        $('#modwinno').val($(this).parents('.pitem').find('.cntw').find('span').html());
        $('#modselno').val($(this).parents('.pitem').find('.cntm').find('span').html());
        $('#moddavarino').val($(this).parents('.pitem').find('.cntd').find('span').html());
        $('#jayeze').val($(this).parents('.pitem').find('.jz').find('span').html());
        var people = $(this).parents('.pitem').find('.isppl').html();
        if (people == 1) {
            $('#ispeopleedit').prop('checked', true);
            $('#divpeopleedit').slideDown(300);
            $('#peoplecountedit').val($(this).parents('.pitem').find('.cntppl').find('span').html());
            $('#jayezeppledit').val($(this).parents('.pitem').find('.jzppl').find('span').html());
        } else {
            $('#ispeopleedit').prop('checked', false);
            $('#divpeopleedit').slideUp(300);
        }
        $('select').material_select('destroy');
        $('select').material_select();
        //Set Davaran
        $('#davarandivedit').html($(this).parents('.pitem').find('.dv').html());
        var str='';
        var i=0;
        $(this).parents('.pitem').find('.dv li').each(function(){
           str += $(this).find('.dvid').html()+'*';
           i++;
        }); 
        str= str.substring(0, str.length - 1);
        $('#iddavs').val(str);
        //Set Bazbin
        $('#bazbinhadivedit').html($(this).parents('.pitem').find('.bz').html());
        var strb='';
        var j=0;
        $(this).parents('.pitem').find('.bz li').each(function(){
            strb += $(this).find('.idbz').html()+'*';
            j++;
        });
        strb= strb.substring(0, strb.length-1);
        $('#idbazs').val(strb);
        if (parseInt($(this).parents('.pitem').find('.status').html()) == 1) {
            $('#isactiveedit').prop('checked', true);
        }
        else {
            $('#isactiveedit').removeAttr('checked');
        }

        $("label[for='idformedit']").addClass('active');
        $("label[for='nameedit']").addClass('active');
        $("label[for='commentedit']").addClass('active');
        $("label[for='sath']").addClass('active');
        $("label[for='startdate']").addClass('active');
        $("label[for='enddate']").addClass('active');
        $("label[for='jayeze']").addClass('active');
        $("label[for='modwinno']").addClass('active');
        $("label[for='modselno']").addClass('active');
        $("label[for='moddavarino']").addClass('active');
        $("label[for='peoplecountedit']").addClass('active');
        $("label[for='jayezeppledit']").addClass('active');
        $('#msgerrmod').hide();
        $('#msgsucmod').hide();
        $('#iddavs').val();
        crntpos=$(window).scrollTop();
        $(window).scrollTop(91);
        $('#modaleditcomp').openModal();
    });

    $('#btncloseedit').click(function() {
         $('body').scrollTop(crntpos);
        $('#modaleditcomp').closeModal();
    })
    $('#savecomp').click(function() {
        if (parseInt($('#winno').val()) + parseInt($('#selno').val()) > parseInt($('#davarino').val())) {
            alert("مجموع تعداد برندگان و منتخبین باید از تعداد راه یافتگان به بخش داوری کمتر باشد.");
            return true;
        }
        if ($('#winno').val() < 0 || $('#selno').val() < 0 || $('#davarino').val() < 0 || $('#peoplecount').val() < 0) {
            alert("اعداد را مثبت وارد کنید.");
            return true;
        }
        var formData = new FormData($('#formregcomp')[0]);
         $.ajax({
            url: siteurl + 'admincomp/savecomp',
            type: 'POST',
            data: formData,
            async: false,
            dataType: 'json',
            success: function(res) {
                if (res.id == 0) {
//                    alert(res.id)
//                    alert(res.msg)
                    $('#msgerr').html(res.msg);
                    $('#msgerr').show();
                    $('#msgsuc').hide();
                } else {
//                    alert(res.id)
//                    alert(res.msg)
                    $('#formregcomp')[0].reset();
                    $('#davarandiv').html('');
                    $('#bazsdiv').html('');
                    $('#msgsuc').html(res.msg);
                    $('#msgsuc').show();
                    $('#msgerr').hide();
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
        
      //  var data = $('#formregcomp').serialize();
//        if (parseInt($('#winno').val()) + parseInt($('#selno').val()) > parseInt($('#davarino').val())) {
//            alert("مجموع تعداد برندگان و منتخبین باید از تعداد راه یافتگان به بخش داوری کمتر باشد.");
//            return true;
//        }
//        if ($('#winno').val() < 0 || $('#selno').val() < 0 || $('#davarino').val() < 0 || $('#peoplecount').val() < 0) {
//            alert("اعداد را مثبت وارد کنید.");
//            return true;
//        }
//        $.ajax({url: siteurl + 'admincomp/savecomp',
//            data: data,
//            type: 'POST',
//            dataType: 'json',
//            success: function(result) {
//                if (result.id == 0) {
//                    $('#msgerr').html(result.msg);
//                    $('#msgerr').show();
//                    $('#msgsuc').hide();
//                } else {
//                    $('#formregcomp')[0].reset();
//                    $('#davarandiv').html('');
//                    $('#bazsdiv').html('');
//                    $('#msgsuc').html(result.msg);
//                    $('#msgsuc').show();
//                    $('#msgerr').hide();
//                }
//            }});
    });
    $('#editcomp').click(function() {
        var data = $('#formeditgal').serialize();
        if (parseInt($('#modwinno').val()) + parseInt($('#modselno').val()) > parseInt($('#moddavarino').val())) {
            alert("مجموع تعداد برندگان و منتخبین باید از تعداد راه یافتگان به بخش داوری کمتر باشد.");
            return true;
        }
        if ($('#modwinno').val() < 0 || $('#modselno').val() < 0 || $('#moddavarino').val() < 0 || $('#peoplecountedit').val() < 0) {
            alert("اعداد را مثبت وارد کنید.");
            return true;
        }
        $.ajax({url: siteurl + 'admincomp/editcomp',
            data: data,
            type: 'POST',
            dataType: 'json',
            success: function(result) {
                if (result.id == 0) {
                    $('#msgerrmod').html(result.msg);
                    $('#msgerrmod').show();
                    $('#msgsucmod').hide();
                } else {
                    var row = $("#id" + $('[id="idformedit"]').val());
                    row.find('.id').html($("#modetitle").val());
                    row.find('.tl').find('span').html($("#nameedit").val());
                    row.find('.cmt').find('span').html($("#commentedit").val());
                    row.find('.sath').find('span').html($("#sath").val());
                    row.find('.sdt').find('span').html($("#startdate").val());
                    row.find('.edt').find('span').html($("#enddate").val());
                    row.find('.cntw').find('span').html($("#modwinno").val());
                    row.find('.cntm').find('span').html($("#modselno").val());
                    row.find('.cntd').find('span').html($("#moddavarino").val());
                        var isppled = $('#ispeopleedit').prop('checked');
                        if (isppled) {
                            row.find('.isppl').html(1);
                            row.find('.cntppl').html('تعداد برندگان مسابقه مردمی : <span>'+$("#peoplecountedit").val()+'</span>');
                            row.find('.jzppl').html('جوایز مسابقه مردمی : <span>'+$("#divpeopleedit").val()+'</span>');
                        }else{
                            row.find('.isppl').html(0);
                            row.find('.cntppl').html('');
                            row.find('.jzppl').html('');
                    }
                    var isact = $('#isactiveedit').prop('checked');
                    var isact2;
                    var stat = 0;
                    if (isact === true) {
                        isact2 = 'فعال';
                        row.find('#competmam').remove();
                        row.find('.btnsdiv').append('<a id="competmam" class="bwaves-effect waves-white purple darken-3 right btn mgright"><i class="mdi-action-exit-to-app right"></i>اتمام مسابقه</a>');
                        stat = 1;
                    } else if (isact === false) {
                        isact2 = 'آینده';
                        row.find('#competmam').remove();
                        stat = 0;
                    }

                    row.find('#statuseach').html(stat);
                    row.find('.st').find('span').html(isact2);
                    row.find('.jz').find('span').html($("#jayeze").val());
                    row.find('.dv').html($("#davarandivedit").html());
                    row.find('.bz').html($("#bazbinhadivedit").html());
                    $('#msgsucmod').html(result.msg);
                    $('#msgsucmod').show();
                    $('#msgerrmod').hide();
                }
            }});
    });

    $('#editcomphead').click(function() {
        $.ajax({url: siteurl + 'admincomp/ajaxselectcomps',
            type: 'POST',
            dataType: 'json',
            success: function(result) {
                $('#compsdiv').html(result.msg);
            }});
    })
    $('#endforever').click(function() {
        $.ajax({url: siteurl + 'admincomp/loadfinishcomp',
            type: 'POST',
            success: function(result) {
                $('#compsfinish').html(result);
            }});
    })
    $('#archives').click(function() {
        $.ajax({url: siteurl + 'admincomp/loadarchv',
            type: 'POST',
            success: function(result) {
                $('#archvcmp').html(result);
            }});
    })


    $('#endcomp').on('click', '#competmam', function() {
        var agree = confirm('Are you sure to endcomp?');
        if (agree) {
            var id = $(this).parents('.pitem').find('.id').html();
            var cname=$(this).parents('.pitem').find('.tl span').html();
            var data = {id: id,cname:cname};
            $.ajax({url: siteurl + 'admincomp/endcomp',
                data: data,
                type: 'POST',
                dataType: 'json',
                success: function(result) {
                    if (result.id == 0) {
                        
                    } else {
                        alert('مسابقه '+cname+' پایان یافت.');
                    }
                }});
            $(this).parents('.pitem').remove();
        } else {
            // row shouldn't be deleted
            return false;
        }
    });

    //Davaran Popup
    function checkSelectedDavaran(davardv) {
        $('#modaldavaran >.modal-content').find('.lstdavaran').find('li').each(function() {
            $(this).removeClass('active');
        });
        $('#' + davardv).find('li').each(function() {
            var itm = $(this);
            $('#modaldavaran >.modal-content').find('.lstdavaran').find('li').each(function() {
                if ($(this).find('.id').html() == itm.find('.dvid').html()) {
                    $(this).addClass('active');
                }

            });
        });
    }
    //Bazs Popup
    function checkSelectedBaz(bazdv) {
        $('#modalbazs >.modal-content').find('.lstbazs').find('li').each(function() {
            $(this).removeClass('active');
        });
        $('#' + bazdv).find('li').each(function() {
            var itm = $(this);
            $('#modalbazs >.modal-content').find('.lstbazs').find('li').each(function() {
                if ($(this).find('.id').html() == itm.find('.idbz').html()) {
                    $(this).addClass('active');
                }

            });
        });
        
        
    }

    $('#seldavar').on('click', function() {
        //Check Selected Davaran
        checkSelectedDavaran('davarandiv');
        $('#modaldavaran >.modal-content').find('.type').html('1');
        $('#modaldavaran').openModal();
    });
    $('#selbazbin').on('click', function() {
        //Check Selected baz
        checkSelectedBaz('bazsdiv');
        $('#modalbazs >.modal-content').find('.type').html('1');
        $('#modalbazs').openModal();
    });

    $('#seldavaredit').on('click', function() {
        //Check Selected Davaran
        checkSelectedDavaran('davarandivedit');
        $('#modaldavaran >.modal-content').find('.type').html('2');
        $('#modaldavaran').openModal();
    });
    $('#selbazedit').on('click', function() {
        //Check Selected Bazs
        checkSelectedBaz('bazbinhadivedit');
        $('#modalbazs >.modal-content').find('.type').html('2');
        $('#modalbazs').openModal();
    });

    $('#btnclosedavar').click(function() {
        $('#modaldavaran').closeModal();
    })
    $('#btnclosebaz').click(function() {
        $('#modalbazs').closeModal();
    })
    var dids = '';
    $('#btnchangedavar').click(function() {
        var items = '';
        dids = '';
        $(".lstdavaran").children('li').each(function() {
            if ($(this).hasClass('active') == true) {
                items += '<li>' + $(this).html().replace('id','dvid') + '</li>';
                dids += $(this).find('.id').html() + '*';
            }
        });
        dids = dids.substring(0, dids.length - 1);
        $('#idds').val(dids);
        $('#iddavs').val(dids);
        if ($(this).parents('.modal-content').find('.type').html() == '1') {
            $('#davarandiv').html(items);
        }
        else {
            $('#davarandivedit').html(items);
        }

        $('#modaldavaran').closeModal();
    })
    var bids = '';
    $('#btnchangebaz').click(function() {
        var items = '';
        bids = '';
        $(".lstbazs").children('li').each(function() {
            if ($(this).hasClass('active') == true) {
                items += '<li>' + $(this).html().replace('id','idbz') + '</li>';
                bids += $(this).find('.id').html() + '*';
            }
        });
        bids = bids.substring(0, bids.length-1);
        $('#idbs').val(bids);
        $('#idbazs').val(bids);
        if ($(this).parents('.modal-content').find('.type').html() == '1') {
            $('#bazsdiv').html(items);
        }
        else {
            $('#bazbinhadivedit').html(items);
        }
        $('#modalbazs').closeModal();
    })

    $('.lstdavaran').on('click', 'li', function() {
        $(this).toggleClass('active');
    });
    $('.lstbazs').on('click', 'li', function() {
        $(this).toggleClass('active');
    });
    $('#ispeople').click(function() {
        if ($(this).prop('checked')) {
            $('#divpeople').slideDown(300);
        }
        else {
            $('#divpeople').slideUp(300);
        }
    })

    $('#ispeopleedit').click(function() {
        if ($(this).prop('checked')) {
            $('#divpeopleedit').slideDown(300);
        }
        else {
            $('#divpeopleedit').slideUp(300);
        }
    })
});

