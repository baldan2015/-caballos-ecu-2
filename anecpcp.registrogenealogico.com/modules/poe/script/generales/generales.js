var K_ResultadoAjax={ exito:1,error:0,warning:2,duplicate:999}
var K_TOKEN_NAME="Authorization";

function validarSesion(callback) {
    $.ajax({
        url: 'ajax/ajaxGeneral.php',data:{ opc:'valSession'}, type: 'POST',
        success: function (response) {
            var retorno=JSON.parse(response);
            callback(retorno.isRedirect);
            validarRedirect(retorno);

        }
    });
    return callback;;
}

function ObtenerUrl(callback) {
  //  console.log(callback);
    $.ajax({
        url: '../ajax/ajaxGeneral.php',data:{ opc:'valUrl'}, type: 'POST',
        success: function (response) {
            var retorno=JSON.parse(response);
           // console.log(retorno.data);
           // callback(retorno.isRedirect);
           callback(retorno.data);
        }
    });
    return callback;
}
function validarRedirect(retorno) {
    if (retorno.isRedirect) {
        alertify.error(retorno.message); setTimeout(function () { document.location.href = retorno.redirectUrl; }, 2000);
    }
}
/*
FUNCION GENERICA PARA SELECCIONAR UN ITEM DE UNA GRILLA DATATABLE
Y SELECCIONAR UN ITEM PARA EDICION,ELIMINACION O CONSULTA DEL REGISTRO
*/
function grlObtieneIdDataTable(table,idxCellId,callback)    {
    var retorno={result:0,key:0};

    if ( ! table.data().count() ) {
            retorno.message="tabla vacia";
            retorno.result=0;
            retorno.key=0;
    }else{
                var countItemSel=table.rows( '.selected' ).count();
                //console.log('filas seleccionadas.. ' + countItemSel);
               //var itemSels=table.rows('.selected').data();
                //   console.log(itemSels);
                if(countItemSel==1)
                {
                   var itemSel=table.rows('.selected').data();
                 //  console.log(itemSel);
                  var key=(itemSel[0])[idxCellId];
                    /*
                     $.each(itemSel[0],function(index,value){
                        console.log(" index " + index);
                        console.log(" value " + value);
                        console.log(" ******* ");
                     });
                  */

                     retorno.result=1;
                     retorno.key=key;
                     retorno.message="OK";


                }else if(countItemSel==0){
                    retorno.message="seleccione una fila";
                    retorno.result=0;
                    retorno.key=0;
                }else{
                    retorno.message="seleccione sólo una fila";
                    retorno.result=0;
                    retorno.key=0;}
        }

    callback(retorno);

    return callback;
}
/*
FUNCION GENERICA PARA SELECCIONAR VARIOS ITEMS DE UNA GRILLA DATATABLE
Y SELECCIONAR UN ITEM PARA EDICION,ELIMINACION O CONSULTA DEL REGISTRO
*/
function grlObtieneIdsDataTable(table,idxCellId,callback)    {
   var  codes=[];

    var retorno={result:0,key:codes};

    if ( ! table.data().count() ) {
            retorno.message="tabla vacia";
            retorno.result=0;
            retorno.keys=[];
    }else{
                var countItemSel=table.rows('.selected' ).count();
                if(countItemSel>=1)
                {
                  var itemSel=table.rows('.selected').data();
                  for (var i = 0; i <= countItemSel-1; i++) {codes.push(itemSel[i][0]);}
                     retorno.result=1;
                     retorno.keys=codes;
                     retorno.message="OK";
                }else if(countItemSel==0){
                    retorno.message="seleccione una o varios registros";
                    retorno.result=0;
                    retorno.keys=codes;
                }else{
                    retorno.message="seleccione sólo una fila";
                    retorno.result=0;
                    retorno.keys=codes;
                }
        }
    callback(retorno);
    return callback;
}
/*

*/
function grlEjecutarAccion(purl, pdata, callback,returnHtml) {
    $.ajax({
        data: pdata,
        url: purl,
        type: 'POST',
        beforeSend: function(request) {
          request.setRequestHeader(K_TOKEN_NAME, localStorage.getItem(K_TOKEN_NAME));
        },             
        success: function (response) {
              if(returnHtml===undefined){
                var dato = JSON.parse(response);
                validarRedirect(dato);
                callback(dato);
              }else{
                callback(response);
              }
        }
    });

    return callback;
};
function grlValidarRedirect(retorno) {
    if (retorno.isRedirect) {
        alertify.error("La sesion actual ha expirado."); 
        setTimeout(function () { document.location.href = retorno.redirectUrl; }, 2000);
    }
   
}

function grlClosePopup(){


}

function GetQueryStringParams(sParam) {
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) {
            return sParameterName[1];
        }
    }
}

//var grlValidarObligatorio = function (contenedor) {
function grlValidarObligatorio(contenedor) {
    var error = 0;
    var elementos =[];
    var valores = [];
    $(contenedor + ' .requerido').each(function (i, elem) {
        if ($.trim($(elem).val()) == '') {
            $(elem).css({ 'border': '1px solid red' });
            elementos.push(elem);
            valores.push($.trim($(elem).val()));
            error++;
        } else {
            $(elem).css({ 'border': '1px solid #ccc' });
        }
    });
    $(contenedor + ' .requeridoE').each(function (i, elem) {
        if ($.trim($(elem).val()) == '') {
            $(elem).css({ 'border': '1px solid red' });
            elementos.push(elem);
            valores.push($.trim($(elem).val()));
            error++;
        } else {
            $(elem).css({ 'border': '1px solid #ccc' });
        }
    });
    $(contenedor + ' .requeridoLst').each(function (i, elem) {
        /// alert($(elem).val() );
        if ($(elem).val() == '000' || $(elem).val() == '00000' || $(elem).val() == '0' || $(elem).val() == 0) {
            $(elem).css({ 'border': '1px solid red' });
            elementos.push(elem);
            valores.push($.trim($(elem).val()));
            error++;
        } else {
            $(elem).css({ 'border': '1px solid #ccc' });
        }
    });
      $(contenedor + ' .requeridoHtml').each(function (i, elem) {
        if ($.trim($(elem).html()) == '') {
            $(elem).css({ 'border': '1px solid red' });
            valores.push($.trim($(elem).val()));
            elementos.push(elem);
            error++;
        } else {
            $(elem).css({ 'border': '1px solid #ccc' });
        }
    });
      $(contenedor + ' .requeridoLabel').each(function (i, elem) {
        if ($.trim($(elem).text()) == '') {
            $(elem).css({ 'border': '1px solid red' });
            valores.push($.trim($(elem).val()));
            elementos.push(elem);
            error++;
        } else {
            $(elem).css({ 'border': '1px solid #ccc' });
        }
    });
    if (error > 0) {
        //console.log(elementos);
        //console.log(valores);
        alertify.error("Debe ingresar los campos requeridos ");
        return false;
    } else {
        //msgErrorB(contenedor, "");
        return true;
    }
};
//var grlLimpiarObligatorio = function (contenedor) {
function grlLimpiarObligatorio(contenedor) {
    $(contenedor + ' .requerido').each(function (i, elem) {$(elem).css({ 'border': '1px solid  #ccc' });});
    $(contenedor + ' .requeridoLst').each(function (i, elem) {$(elem).css({ 'border': '1px solid  #ccc' });});
};

 /**
   * Opens window screen centered.
   * @param windowWidth the window width in pixels (integer)
   * @param windowHeight the window height in pixels (integer)
   * @param windowOuterHeight the window outer height in pixels (integer)
   * @param url the url to open
   * @param wname the name of the window
   * @param features the features except width and height (status, toolbar, location, menubar, directories, resizable, scrollbars)
   */
  function grlCenterWindow(windowWidth, windowHeight, windowOuterHeight, url, wname, features) {
    var centerLeft = parseInt((window.screen.availWidth - windowWidth) / 2);
    var centerTop = parseInt(((window.screen.availHeight - windowHeight) / 2) - windowOuterHeight);
 
    var misc_features;
    if (features) {
      misc_features = ', ' + features;
    }
    else {
      misc_features = ', status=no, location=no, scrollbars=yes, resizable=yes';
    }
    var windowFeatures = 'width=' + windowWidth + ',height=' + windowHeight + ',left=' + centerLeft + ',top=' + centerTop + misc_features;
    var win = window.open(url, wname, windowFeatures);
    win.focus();
    return win;
  }
 

function grlObtenerIdSelJQGrid(idGrilla,callback){

var retorno={result:0,key:0};
var key = $(idGrilla).jqGrid('getGridParam',"selrow");

if (key){
        retorno.key=key;
        retorno.result=1;
 }else{
        alertify.warning("Seleccione elemento de la grilla");        
}

    callback(retorno);
}

 function coloresHTML (){
    var colores=new Array();    
    var r = new Array("00","33","66","99","CC","FF"); 
    var g = new Array("00","33","66","99","CC","FF"); 
    var b = new Array("00","33","66","99","CC","FF"); 
    var idx=0;
    for (i=0;i<r.length;i++) { 
        for (j=0;j<g.length;j++) { 
            for (k=0;k<b.length;k++) { 
                colores[idx] = "#" + r[i] + g[j] + b[k]; 
                idx++;
            } 
        } 
    }
    var color=colores[aleatorio(1,215)];
    return  color;
}
function aleatorio(a,b) {
         return Math.round(Math.random()*(b-a)+parseInt(a));
}