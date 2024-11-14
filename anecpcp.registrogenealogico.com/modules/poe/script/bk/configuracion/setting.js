var controllers={
    reporteADN:'ajax/ajaxReporte.php',
    ejemplarJQGRID:'ajax/ajaxEjemplarJQgrid.php'
}
$(function(){
 
$("#btnXls").on("click", function(){ 
 $("#mvExportar").modal("show");

  	});
  $("#mvExportar").on('show.bs.modal', function(){
    $("#xls").prop("src","vista/configuracion/dataXls.php");
 
  });
});
 

 function exportarADNXls(){
  $.ajax({
                                   data:  {opc:'xlsEjem'},
                                    url:   controllers.reporteADN,
                                    type:  'post',
                                    success:  function (response) {
                                      window.open('data:application/vnd.ms-excel,' + encodeURIComponent(response));
                                      console.log(response);
                                    /*  
                                        var resultado= JSON.parse(response) ;
                                         if(resultado.result=="1"){
                                            window.open('data:application/vnd.ms-excel,' + encodeURIComponent(resultado.html));
                                            alertify.success(resultado.message);
                                        }
                                         else       
                                            alertify.error(resultado.message);*/
                                    }
                                });
 }
 