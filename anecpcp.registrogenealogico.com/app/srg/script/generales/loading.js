 function ajaxindicatorstart(text) {
    if (jQuery('body').find('#resultLoading').attr('id') != 'resultLoading') {
        //jQuery('body').append('<div id="resultLoading" style="display:none"><div><img src="../Images/otros/ajax-loader.gif"><div>' + text + '</div></div><div class="bg"></div></div>');
        jQuery('body').append('<div id="resultLoading" style="display:none"><div><div>' + text + '</div></div><div class="bg"></div></div>');
    }

    jQuery('#resultLoading').css({
        'width': '100%',
        'height': '100%',
        'position': 'fixed',
        'z-index': '10000000',
        'top': '0',
        'left': '0',
        'right': '0',
        'bottom': '0',
        'margin': 'auto'
    });

    jQuery('#resultLoading .bg').css({
        'background': '#000000',
        'opacity': '0.3',
        //'width': '100%',
        // 'height': '100%',
        'position': 'absolute',
        'top': '0'
    });

    jQuery('#resultLoading>div:first').css({
        'width': '200px',
        'height': '25px',
        'text-align': 'center',
        'position': 'fixed',
        'top': '0',
        'left': '0',
        'right': '0',
        'bottom': '0',
        'margin-top': '40px',
        'font-size': '14px',
        'z-index': '10',
        'color': '#ffffff',
        'background': '#E88239'

    });

    // jQuery('#resultLoading .bg').height('100%');
    jQuery('#resultLoading').fadeIn(100);
    jQuery('body').css('cursor', 'wait');
}

function ajaxindicatorstop() {
    // jQuery('#resultLoading .bg').height('100%');
    jQuery('#resultLoading').fadeOut(100);
    jQuery('body').css('cursor', 'default');
}

jQuery(document).ajaxStart(function () {
    //show ajax indicator
    ajaxindicatorstart('Procesando..');
}).ajaxStop(function () {
    //hide ajax indicator
    ajaxindicatorstop();
});

