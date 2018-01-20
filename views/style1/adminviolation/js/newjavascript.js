var crntpg = 1;
$(function() {
    $('#divcatitems').on('click', '.delcmt', function() {
        var here = $(this);
        var a = $(this).closest('.pitem').find('#uuid').val();
        here.parents('.pitem').remove();
        $.ajax({
            url: siteurl + 'adminviolation/dltviolate',
            data: {"inf": a
            },
            type: 'POST',
            dataType: 'json'
        });
    });
    $('#btnmore').click(function() {
        crntpg++;
        var pgid;
        pgid = crntpg;
        $.ajax({
            url: siteurl + "adminviolation/paging",
            type: "POST",
            data: {
                "pid": pgid
            },
            success: function(data) {
                $('#divcatitems').append(data);
            }
        });

    });
    function setPageItems(items) {
        var olddata = $('#divcatitems').html();
        $('#divcatitems').mixItUp('destroy');
        $('#divcatitems').html(olddata+items);
        var flt
        $('#divcatitems').mixItUp({
            load: {
                filter: flt
            }
        });
    }
});
