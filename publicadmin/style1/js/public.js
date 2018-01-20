var isMenuShow = false;
var fncscr = true;
var isopsld = 0;
var mins = 0;  //Set the number of minutes you need
var secs = mins * 60;
var currentSeconds = 0;
var currentMinutes = 0;
$(function() {

//$('.button-collapse').sideNav({
//    menuWidth: 180, // Default is 180
//    edge: 'left', // Choose the horizontal origin
//    closeOnClick: false
//}
//);

    var count = $("#notificationcount").text();
    var intcount = parseInt(count);
    if (intcount == 0)
        $("#notificationcount").hide();
    else
        $("#notificationcount").show();
    $(document).mouseup(function(e)
    {
        var container = $("#slide-out");
        var cont2 = $(".button-collapse");
        if (!container.is(e.target) && !cont2.is(e.target)// if the target of the click isn't the container...
                && container.has(e.target).length === 0) // ... nor a descendant of the container
        {
            if (container.hasClass('show')) {
                $('.button-collapse').trigger('click');
                $('#closemodalcompetitions').trigger('click');
            }

        }
    });
    if ($('#hd2fkzxde').length == 0) {
        $('.hd2').css('top', '0px');
        $(".arrow_boxtp").css('margin-top', '97px');
        $(".icosec").css('top', '-97px');
        fncscr = false;
    }

    if (window.location.href.indexOf('#loginlink') != -1) {
        $('#regpg2').slideUp(300);
        $('#regpg3').slideUp(300);
        $('#regdiv').slideUp(300);
        $('#logdiv').slideToggle(300);
    }

    $('.button-collapse').click(function() {
        isMenuShow = !isMenuShow;
        if (isMenuShow) {
            $('.button-collapse').addClass('mgleft');
            $('#slide-out').addClass('show');
        } else {
            $('.button-collapse').removeClass('mgleft');
            $('#slide-out').removeClass('show');
        }
    }
    );
    $('.side-nav.fixed').css('left', '-180px');
    $('#loglnk').click(function() {
        $('#regpg2').slideUp(300);
        $('#regpg3').slideUp(300);
        $('#regdiv').slideUp(300);
        $('#logdiv').slideToggle(300);
        if (isopsld == 0) {
            $(".arrow_boxtp").css('margin-top', '0px');
            isopsld = 1;
        } else {
            $(".arrow_boxtp").css('margin-top', '67px');
            isopsld = 0;
        }

    });
    $('#reglnk').click(function() {
        $('#regpg2').slideUp(300);
        $('#regpg3').slideUp(300);
        $('#logdiv').slideUp(300);
        $('#regdiv').slideToggle(300);
        if (isopsld == 0) {
            $(".arrow_boxtp").css('margin-top', '0px');
            isopsld = 1;
        } else {
            $(".arrow_boxtp").css('margin-top', '67px');
            isopsld = 0;
        }
    });
    $('#licmps').click(function() {
        $('#licomp').slideToggle(0);
        return false;
    });
    $('#lguserbtn').click(function() {
        $('#regpg2').slideUp(300);
        $('#regpg3').slideUp(300);
        $('#logdiv').slideToggle(300);
    });
    $('#formreguserpg2').on('keydown', 'input', function(e) {
        var key = e.which;
        if (key == 13) {
            $('#reguserbtnpg2').trigger('click');
            return false;
        }
    })

    $('#reguserbtnpg2').click(function() {

        var data = $('#formreguserpg2').serialize();
        var url = siteurl + 'active/active'
        $.ajax({url: url,
            data: data,
            type: 'POST',
            dataType: 'json',
            success: function(result) {
                if (result.id > 0) {
                    $('#regpg2').slideToggle(300);
                    $('#regpg3').slideToggle(300);
                    $('#formreguserpg2')[0].reset();
                } else {
                    $('#registererrdivact').html(result.msg);
                    $('#registererrdivact').show();
                }
            }});
    });
    $('.cmpdiv').on('click', '.cnt', function() {
        $(this).parents('.cmpdiv').find('.cmpul').slideToggle(300);
    });
    $('.cmpul').on('click', 'li', function() {
        if ($(this).attr('data-id') != 'back') {

            $(this).parents('.cmpdiv').find('.dtdiv').slideToggle(300);
        } else {
            $(this).parents('.cmpul').slideUp(300);
        }

    });
    $('.dtdiv').on('click', '.back', function() {
        $(this).parents('.cmpul').slideUp(300);
        $(this).parents('.cmpdiv').find('.dtdiv').slideUp(300);
    });
    $('#licomp').on('click', 'li', function() {
        var data = ($(this).attr('id'));
        $.ajax({
            url: siteurl + "index/selmenucomp",
            type: "POST",
            data: {data: data},
            dataType: 'json',
            success: function(result) {
                $('#cntmodalcmp').html(result.msg);
            }
        });
        $('#modalcompetitions').openModal();
    });
    $(window).scroll(function() {
        if (fncscr == true) {
            var scroll = $(window).scrollTop();
            if (scroll <= 10) {
                $("#logotop").attr('src', siteurl + 'images/newico/logobig.svg');
                $('.button-collapse').css('height','91px');
                $(".arrow_boxtp").css('margin-top', '67px');
                $('.hd2').removeClass('small');
            } else {
                $("#logotop").attr('src', siteurl + 'images/newico/logotopsmall.svg');
                $('.button-collapse').css('height','60px');
                $(".arrow_boxtp").css('margin-top', '0px');
                $('.hd2').addClass('small');
            }
        } else {
            var scroll = $(window).scrollTop();
            if (scroll <= 1) {
                $("#logotop").attr('src', siteurl + 'images/newico/logobig.svg');
                $('.button-collapse').css('height','91px');
                $('.hd2').removeClass('small');
            } else {
                $("#logotop").attr('src', siteurl + 'images/newico/logotopsmall.svg');
                $('.button-collapse').css('height','60px');
                $('.hd2').addClass('small');
            }
        }
    });
    $('#formreguser').on('keydown', 'input', function(e) {
        var key = e.which;
        if (key == 13) {
            $('#reguserbtn').trigger('click');
            return false;
        }

    })

    $('#reguserbtn').click(function() {
 
        var data = $('#formreguser').serialize();
        var url = siteurl + 'register/register'
        $.ajax({url: url,
            data: data,
            type: 'POST',
            dataType: 'json',
            success: function(result) {
                if (result.id > 0) {
                    $('#logdiv').slideUp(300);
                    $('#regdiv').slideUp(300);
                    $('#regpg2').slideToggle(300);
                    $('#formreguser')[0].reset();
                    $('#formreguserpg2')[0].reset();
                    $('#msgerr').hide();
                    $('#activecode').addClass('none');
                    $('#activecodetimer').removeClass('none');
                    mins = 2;
                    secs = mins * 60;
                    Decrement();
                } else {

                    $('#registererrdiv').html(result.msg);
                    $('#registererrdiv').show();
                }
            }});
    })



    
//    $('.notificationmore').click(function(evt) {
//        evt.stopPropagation();
//        var link = $(this).data("link");
//        var win = window.open(link, '_blank');
//        win.focus();
//    });



});

function Decrement() {
    currentMinutes = Math.floor(secs / 60);
    currentSeconds = secs % 60;
    if (currentSeconds <= 9)
        currentSeconds = "0" + currentSeconds;
    secs--;
    $('#activecodetimer').html(currentMinutes + ":" + currentSeconds); //Set the element id you need the time put into.
    if (secs !== -1) {
        setTimeout('Decrement()', 1000);

    } else {
        $('#activecodetimer').addClass('none');
        $('#activecode').removeClass('none');
    }
}

function sendcode() {

//            var data = $('#formreg').serialize();
    $.ajax({url: siteurl + 'reactiv/sendactivecod',
        type: 'POST',
        dataType: 'json',
        success: function(result) {
            if (parseInt(result.id) == 1) {
                $('#activecode').addClass('none');
                $('#activecodetimer').removeClass('none');
                $('#registererrdivact').css('display', 'none');
                mins = 2;
                secs = mins * 60;
                Decrement();

//                        location.replace(siteurl + 'active');
            } else if (parseInt(result.id) == 0) {
                $('#msgerr').html(result.msg);
                $('#msgerr').show();
                $('#msgsuc').hide();
            } else if (parseInt(result.id) == 2) {
                $('#msgerr').html(result.msg);
                $('#msgerr').show();
                $('#msgsuc').hide();
            }
        }});

}