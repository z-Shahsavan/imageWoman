
$(function() {
    Calendar.setup({
        inputField: "date_input_1", // id of the input field
        button: "date_btn_1", // trigger for the calendar (button ID)
        ifFormat: "%Y-%m-%d", // format of the input field
        dateType: 'jalali',
        weekNumbers: false
    });
    // $('input').tagsinput({
    //     typeahead: {
    //         source: function(query) {
    //             return $.getJSON('citynames.0json');
    //         }
    //     }
    // });

    $('select').material_select();
    $('.row,nav,form').addClass('rtl');

    if (window.location.href.indexOf('#id') != -1) {
        var strRequestVars = window.location.href.substr(window.location.href.indexOf("#id") + 3);
        $('select').material_select('destroy');
        $("#competition option[value=" + parseInt(strRequestVars) + "]").attr('selected', 'selected');
        $('select').material_select();
    }

    //********************************************
    //Auto Complete
    $("#select3").tagsinput({
        json_url: siteurl + 'upload/hashtagha',
        addontab: true,
        maxitems: 10,
        input_min_size: 0,
        height: 10,
        cache: true,
        newel: true,
        select_all_text: "select",
        width: '100%',
    });
    $('#divtag').find('.select-wrapper input.select-dropdown,i').hide(0);
    
    Calendar.setup({
        inputField: "date_input_1", // id of the input field
        button: "date_btn_1", // trigger for the calendar (button ID)
        ifFormat: "%Y-%m-%d", // format of the input field
        dateType: 'jalali',
        weekNumbers: false
    });
});

function makeactive() {
    $('#dateicon').addClass('active');
    $('#lbldate').addClass('active');
}