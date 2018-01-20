/*
 Theme Name: Image Sharing
 Author: rahasoft-amin
 Description: Share photos Women 1394.
 Version: 1.0
 */

/*
 * Table of content
 *=================
 *
 *	1.
 *
 *=================
 */


/*=============
 *   1.
 ===============*/
var count = 1;
var whichpg;
$(function() {
    $('.marginbottom40').on('click','[id="show"]', function() {
        $(this).parents('.maindiv').find('.card-reveal').slideToggle('slow');
    });
    $('.marginbottom40').on('click','[class="close"]', function() {
        $(this).parents('.card-reveal').slideToggle('slow');
    });
//paging
    $('#more').click(function() {
        count++;
        var pgid = count;
        whichpg = $('.whpg').html();
        $('#paging').hide();
        $('#waiting').show();
        $.ajax({
            url: siteurl + 'complist/paging',
            data: {
                pgid: pgid, whichpg: whichpg
            },
            type: 'Post',
            dataType: 'json',
            success: function(res) {
//                if (whichpg == 1) {
                $('.marginbottom40').append(res.items);
//                } else if (whichpg == 2) {
//                    $('.menu1').append(res);
//                } else if (whichpg == 3) {
//                    $('.menu2').append(res);
//                }
                $('#paging').show();
                $('#waiting').hide();
            }, error: function() {
                $('#paging').show();
                $('#waiting').hide();
            }
        });
    });
});
