var wall = new Freewall("#freewall");
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
$("#tabing1").click(function() {
    $('html, body').animate({
        scrollTop: $("#sctab").offset().top
    }, 1000);
});
$("#tabing2").click(function() {
    $('html, body').animate({
        scrollTop: $("#sctab").offset().top
    }, 1000);
});
$("#tabing3").click(function() {
    $('html, body').animate({
        scrollTop: $("#sctab").offset().top
    }, 1000);
});
$(window).scroll(function() {
    if ($(this).scrollTop()) {
        $('#scrolltop').fadeIn();
    } else {
        $('#scrolltop').fadeOut();
    }
});
$("#scrolltop").click(function() {
    $('html, body').animate({
        scrollTop: $("html").offset().top
    }, 1000);
});

$(function() {
    $nav = $('.nav-new ul');

    $('.menu-icon').click(function() {
        $nav.slideToggle();
    });

    $(window).resize(function() {
        if ($(window).width() >= 992) {
            $nav.show();
        } else {
            $nav.hide();
        }
    });

});
$(function() {
    $("#modal-launcher, #modal-background, #modal-close").click(function() {
        $("#modal-content,#modal-background").toggleClass("active");
    });
});
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
});
$(function() {
    $('#listreg').on('click', function() {
//        alert(12)
        $('#lione').removeClass('active');
        $('#litwo').addClass('active');
        $('#register').addClass('active');
        $('#login').removeClass('active');
    });
    $('#listlog').on('click', function() {
//        alert(12)
        $('#litwo').removeClass('active');
        $('#lione').addClass('active');
        $('#register').removeClass('active');
        $('#login').addClass('active');

    });
});

/*=============
*   5.Dropdown Navigation
===============*/
$(function(){
    $(".dropdown").hover(
        function() {
            $('.dropdown-menu', this).stop( true, true ).fadeIn("fast");
            $(this).toggleClass('open');
            $('b', this).toggleClass("caret caret-up");
            $('.dropdown-menu').css("height","initial");          
        },
        function() {
            $('.dropdown-menu', this).stop( true, true ).fadeOut("fast");
            $(this).toggleClass('open');
            $('b', this).toggleClass("caret caret-up");                
    });
});