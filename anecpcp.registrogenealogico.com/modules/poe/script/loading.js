 function ajaxindicatorstart(text) {
            if (jQuery('body').find('#resultLoading').attr('id') != 'resultLoading') {
                jQuery('body').append('<div id="resultLoading" style="display:none"><div><img src="../../../img/ajax-loader.gif"><div>' + text + '</div></div><div class="bg"></div></div>');
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
                'width': '100%',
                'height': '100%',
                'position': 'absolute',
                'top': '0'
            });

            jQuery('#resultLoading>div:first').css({
                'width': '250px',
                'height': '75px',
                'text-align': 'center',
                'position': 'fixed',
                'top': '0',
                'left': '0',
                'right': '0',
                'bottom': '0',
                'margin': 'auto',
                'font-size': '16px',
                'z-index': '10',
                'color': '#ffffff'

            });

            jQuery('#resultLoading .bg').height('100%');
            jQuery('#resultLoading').fadeIn(200);
            jQuery('body').css('cursor', 'wait');
        }

        function ajaxindicatorstop() {
            jQuery('#resultLoading .bg').height('100%');
             jQuery('#resultLoading').fadeOut(200);
            jQuery('body').css('cursor', 'default');
        }

        jQuery(document).ajaxStart(function () {
            //show ajax indicator
            ajaxindicatorstart('Obteniendo datos..');
        }).ajaxStop(function () {
            //hide ajax indicator
            ajaxindicatorstop();
        });


 function verificarRows(fila,tabla,cssControl,idControlRef) {
 var indices=[];
    $("."+tabla+" tbody tr:has(input)").each(function (index, value) { 
        $(cssControl , this).each(function() {

        var inputName =  $(this).attr("id");
        
            if(inputName.indexOf(idControlRef)!=-1) {
                var dato=inputName.split('_');
                indices.push(dato[1]);

            }

        });
    });

if(indices.length!=0){
var mayor=0;
var tmp=0;


$.each(indices,function(index,value){

if(parseInt(value)>parseInt(mayor)){
    mayor=value;
    
}
    
});

if(mayor>=fila){
    fila=(parseInt(mayor)+1);
}

}
   return fila;
}