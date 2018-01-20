var mins = 0;  //Set the number of minutes you need
var secs = mins * 60;
var currentSeconds = 0;
var currentMinutes = 0;
$(function() {
    $('#formreguser').on('keydown', 'input', function(e) {
        var key = e.which;
        if (key == 13) {
            $('#reguserbtn').trigger('click');
            return false;
        }

    })

    $('#reguserbtn').click(function() {
//        alert(12)
//         $('#activecode').addClass('none');
        var data = $('#formreguser').serialize();
        var url = siteurl + 'register/register'
        $.ajax({url: url,
            data: data,
            type: 'POST',
            dataType: 'json',
            success: function(result) {
                if (result.id > 0) {
                    $("#regdiv").fadeOut(1000);
                    $("#regpg2").fadeIn(500);
                    $("#regpg2").attr("style", "display: inline !important");
                    $("#regdiv").removeClass('show');
                    $("#regpg2").addClass('show');
                      $("#formreguserpg2").removeClass("hide");
                      $("#formreguserpg2").fadeIn(500);
                      $("#formreguser").fadeOut(500);
                      $("#formreguser").addClass("hide");

                    $('#registererrdiv').hide();
                    $('#formreguser')[0].reset();
                    $('#formreguserpg2')[0].reset();
                    $('#activecode').css("display", "none")
                    $('#activecodetimer').css('display', 'show');

                    mins = 2;
                    secs = mins * 60;
                    Decrement();
                } else {

                    $('#registererrdiv').html(result.msg);
                    $('#registererrdiv').show();
                }
            }});
    })

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
//                    $('#accountModal1').slideToggle(300);
//                    $('#accountModal2').slideToggle(300);
//                    $('#accountModal1').modal('toggle');

                    $('#formreguserpg2')[0].reset();

                    window.location = (siteurl + 'index/index');
                    window.location.href = (siteurl + 'index/index');

                } else {
                    $('#registererrdivact').html(result.msg);
                    $('#registererrdivact').show();
                }
            }});
    });
})


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
        $('#activecodetimer').css("display", "none");
        $('#activecode').show();
    }
}

function sendcode() {

//            var data = $('#formreg').serialize();
    $.ajax({url: siteurl + 'reactiv/sendactivecod',
        type: 'POST',
        dataType: 'json',
        success: function(result) {
            if (parseInt(result.id) == 1) {
                $('#activecode').css("display", "none");
                $('#activecodetimer').show();
                $('#registererrdivact').css("display", "none");
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