 

$(function(){
    $("#btnSaveCamp").on("click",function (){  insertarCampeonato(); });        
});

/*
function editar(){
    var table = $('#example').DataTable();
    var idxColumnKey ="0";//indice de la columna id
    grlObtieneIdDataTable( table ,idxColumnKey,function(respuesta){
        if(respuesta.result){
                    grlEjecutarAccion(controllers.pelaje, {opc:'get',key:respuesta.key},function(retorno){
                        if(retorno.result===K_ResultadoAjax.exito){
                            var pelaje=retorno.data;

                            if(pelaje!=null){
                                $(controls.txtCodigo).val(pelaje.codigo);
                                $(controls.txtNombre).val(pelaje.nombre);
                              }
                        }else if(retorno.result===K_ResultadoAjax.error){
                             alertify.error(retorno.message);
                        }
                    });
                     resetPopUp();
                     $(controls.modalDialog).modal("show");
        }else{
            alertify.warning(respuesta.message);
        }
    });
 }
 */
 
function eliminarCamp(id){
    alertify.confirm('Advertencia', 'Está seguro de eliminar el registro?', 
                        function(){
                                     
                    
                            grlEjecutarAccion("ajax/ajaxCampeon.php", {opc:'del',keys:id},function(retorno){
                                if(retorno.result===K_ResultadoAjax.exito){
                                    listarCampeonato();
                                    alertify.success(retorno.message);
                                }else if(retorno.result===K_ResultadoAjax.error){
                                     alertify.error(retorno.message);
                                }
                            });
                                        
                        }, 
                        function(){ 
                            //alertify.error('Cancel')
                        }
                    );
 }

 
var insertarCampeonato=function(){
var data={
            opc:'ins',
            anio:$("#txtAnioCamp").val(),
            prefijo:$("#hidPrefCamp").val(),
            ejemplar:$("#hidNombCamp").val(),
            idEjemplar:$("#hidIdCamp").val(),
            propietario:$("#hidPropCamp").val(),
            esSuperCamp:$("#chkSoloCamp").prop('checked')?0:1
          };

          if(data.anio==""){
                            alertify.error("ingrese año del campeonato.");
                            $("#txtAnioCamp").focus();
          }else{
                      grlEjecutarAccion("ajax/ajaxCampeon.php", data,function(retorno){
                            if(retorno.result===K_ResultadoAjax.exito){
                                 alertify.success(retorno.message);
                            }else if(retorno.result===K_ResultadoAjax.error){
                                 alertify.error(retorno.message);
                            }else if(retorno.result===K_ResultadoAjax.warning){
                                 alertify.warning(retorno.message);
                            }
                             listarCampeonato();
                      });
          }
}
 
 var listarCampeonato=function(){

$("#tableLst").html("");
        var data={            opc:'lst',            idEjemplar:$("#hidIdCamp").val()             };
        grlEjecutarAccion("ajax/ajaxCampeon.php", data,function(retorno){
        $("#tableLst").html(retorno);
          },"returnHtml");
}
 
 