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
$(function() {
    $('[id=show]').on('click',function() {  
        $(this).closest('.card').find('.card-reveal').slideToggle('slow');
       // $('.card-reveal').slideToggle('slow');
    });
    $('.card-reveal .close').on('click',function() {
        $(this).closest('.card-reveal').slideToggle('slow');
        //$('.card-reveal').slideToggle('slow');
    });
});