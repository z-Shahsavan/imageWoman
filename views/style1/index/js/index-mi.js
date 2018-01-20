$("#txt-member").click(function() {
    $("#formpassword").addClass("hide");
    $(".form-user-mi").each(function() {
        if (!$(this).hasClass("hide")) {
            $(this).addClass("hide");
        }
    });
    $txt = $(this).data('text');
    $(".form-user-mi2").each(function() {
        if (!$(this).hasClass("hide")) {
            $(this).addClass("hide");
        }
    });
    if ($txt == 3) {
        var that = $(".form-user-mi").first();
        that.removeClass("hide");
    } else {
        $(".form-user-mi").each(function() {
            if ($(this).hasClass("hide")) {
                $(this).removeClass("hide");
            } else {
                $(this).addClass("hide");
            }
        });
    }
    if ($txt == 1) {
        $("#txt-member").text("وارد شوید!");
        $(".border-left").addClass("hide-border-left");
        $('#formlogin').addClass("hide");
        $(".titel-mi span").text("ثبت نام کنید!");
        $("#passforget").text("");
        $(this).data("text", "2");
        chstyl();

    } else if ($txt == 2) {
        $("#txt-member").text("عضو نیستید؟ ثبت نام کنید");
        $(".border-left").removeClass("hide-border-left");
        $('#formreguser').addClass("hide");
        $(this).data("text", "1");
        $("#passforget").text("گذر واژه را فراموش کردم");
        $(".titel-mi span").text("وارد شوید!");
        chstyl();

    } else {
        $("#txt-member").text("عضو نیستید؟ ثبت نام کنید");
        $(".border-left").removeClass("hide-border-left");
        
        $(this).data("text", "1");
        $("#passforget").text("گذر واژه را فراموش کردم");
        $(".titel-mi span").text("وارد شوید!");
    }
});

$("#passforget").click(function() {
    $(".form-user-mi").each(function() {
        if (!$(this).hasClass("hide")) {
            $(this).addClass("hide");
        }
    });
    var that = $(".form-user-mi2").first();
    that.removeClass("hide");
    $("#passforget").text("");
    $(".titel-mi span").text("ارسال مجدد!");
    $("#txt-member").text("وارد شوید!");
    $("#txt-member").data("text", "3");
    $(".border-left").addClass("hide-border-left");
});
function chstyl() {
    if ($(".user-panel-new").hasClass("chstyle")) {
        $(".user-panel-new").removeClass("chstyle")
    } else {
        $(".user-panel-new").addClass("chstyle")
    }
}