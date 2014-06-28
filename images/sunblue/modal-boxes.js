/*
Modal Boxes JS
@author Euan T. <euan@euantor.com>
*/

jQuery.noConflict();

jQuery(document).ready(function($)
{
    // Make the jQuery modal login redirect you back to the page you're currently on //
    $('#loginModal input[name="url"]').attr("value", window.location);
    // /Login redirect //

    // Modal Boxes //
    $('a[name="modal"]').on('click', function(event)
    {
        event.preventDefault();
        
        var target = $(this).attr('rel');
        
        // Set up the shadowing
        var maskHeight = $(document).height();
        var maskWidth = $(window).width();
        $('#mask').css({'width': maskWidth, 'height': maskHeight});
        $('#mask').fadeIn(1000);    
        $('#mask').fadeTo("slow", 0.8);  
        
        // Position the actual modal
        var winH = $(window).height();
        var winW = $(window).width();
        $(target).css('top',  (winH / 2) - ($(target).height() / 2));
        $(target).css('left', (winW / 2) - ($(target).width() / 2));
        $(target).fadeIn(2000); 
    });
    
    $('.modalBox a[rel="closeModal"]').on('click', function(event)
    {
        event.preventDefault();
        $('#mask, .modalBox').hide();
    }); 
    
    $('#mask').on('click', function ()
    {
        $(this).hide();
        $('.modalBox').hide();
    }); 
    // /Modal Boxes //
});