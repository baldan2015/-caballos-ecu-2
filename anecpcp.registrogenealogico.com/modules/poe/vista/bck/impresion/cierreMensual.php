<?php  session_start();?>
<head>  
  <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>ANECPCP - REPORTE CIERRE MENSUAL :: <?=$_GET["per"]?> - <?=$_GET["mes"]?></title>
        <link  rel="stylesheet" type="text/css" href="../../libs/jquery-ui-1.11.4.custom.green/jquery-ui.css">
<script src="../../libs/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>    
<script src="../../libs/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="../../libs/alertifyjs/css/alertify.css" >
<link rel="stylesheet" type="text/css" href="../../libs/alertifyjs/css/themes/bootstrap.min.css" >    
<script src="../../libs/alertifyjs/alertify.min.js"></script>
        <LINK REL=StyleSheet href="../../libs/bootstrap-3.3.7/css/bootstrap.min.css" TYPE="text/css" MEDIA=screen />
        <script src="../../libs/bootstrap-3.3.7/js/bootstrap.min.js"></script> 

</head> 
<style type="text/css">
 @media print {
    body{
        font-size: 14px;
    }
     .tbDatoMain  th{
         background: #ccc!important;
        height: 30px;
        font-size: 12px;
     }
      th {
        
        background: #ccc!important;
        height: 30px;
        font-size: 12px;
      }
      .num{
        font-size: 16px;
      }
      .tbDatoMain  {
    font-size: 10px;
    border:0 px;
    width:100%  ;
    border-collapse: collapse;
}
    }

</style> 
<?
date_default_timezone_set('UTC');
  /*  include_once("../../logica/EjemplarLogica.php");
    include_once("../../logica/ResenaLogica.php");
    include_once("../../logica/PelajeLogica.php");
    include_once("../../logica/DepartamentoLogica.php");
    include_once("../../entidad/Ejemplar.inc.php");*/
    include_once("../../entidad/Constantes.php");
  /*  include_once("../../logica/ImagenLogica.php");
    include_once("../../logica/ImpresionLogica.php");*/
    include_once("../../constante.php");
    include_once("../../comunes/lib.comun.php");
    


 if(!validarSesion2()){
        echo "<center><br><br><br>".Constantes::K_SESSION_LOGOUT." <a href='#' onclick='return window.close();'>Cerrar esta ventana</a></center> ";
    }else{
?>
 

 <table width="100%" BORDER=0 >
                    
                    <tr>
                        <td  rowspan="2" style=" width: 110px;">   <img src="../../images/logo/anecpcp.png" /></td>

                        <td  >  <center >    <h1>Reporte Cierre Mensual  Periodo : <?=$_GET["per"]?> - <?=$_GET["mes"]?> </h1>

                            <br>
<center >
<div>Resultado del ejercicio de inscripciones y transferencias de ejemplares durante un periodo determinado para la ANECPCP</div> </center >
                        </center></td>
                    </tr>
                     <tr>
                        <td > 
  
  </td> 
                    </tr>
                    <tr>
                        <td style=" height: 30px;"></td>
                    </tr>
                </table>
 <table width="100%" BORDER=0 style=" border-collapse:collapse;">
    <tr><td style="width: 5%;"></td><td>
                <table width="100%" BORDER=1 style=" border-collapse:collapse;">
                    <tr>
                        <th colspan=2 style="background: #ccc; font-weight: bold; text-align:center;">Resumen Inscripciones</th>
                    </tr>
                    <tr>
                        <td>Ejemplares Nacionales:</td><td style=" text-align: right;"><span class="num" id="lblTotalI"></span>&nbsp;</td>
                    </tr>
                     <tr>
                        <td>Ejemplares Importados:</td><td style=" text-align: right;"><span class="num" id="lblTotalII"></span>&nbsp;</td>
                    </tr>
                     <tr>
                        <td style=" text-align:right;font-weight: bold;">TOTAL INSCRITOS: </td>
                        <td style=" text-align: right;font-weight: bold;"><span id="lblTotalA" class="num"></span>&nbsp;</td>
                    </tr>
                </table>
        </td><td  style="width: 5%;">
                 </td><td>
        
                  
                <table width="100%" BORDER=1 style=" border-collapse:collapse;">
                    <tr>
                        <th colspan=2  style="background: #ccc; font-weight: bold; text-align:center;">Resumen Transferencias</th>
                    </tr>
                    <tr>
                        <td>Ejemplares Nacionales:</td><td  style=" text-align: right;"><span class="num" id="lblTotalT"></span>&nbsp;</td>
                    </tr>
                     <tr>
                        <td>Ejemplares Importados:</td><td  style=" text-align: right;"><span  class="num" id="lblTotalTI"></span>&nbsp;</td>
                    </tr>
                     <tr>
                        <td style=" text-align: right;font-weight: bold;">TOTAL TRANSFERIDOS: </td>
                        <td style=" text-align: right;font-weight: bold;"><span id="lblTotalB" class="num"></span>&nbsp;</td>
                    </tr>
                </table>
                 </td><td  style="width: 5%;">
                 </td>
             </tr>
         </table>
<div class="container ">
  
 
        
    


    <div class="row">
         <div class="col-md-12">
          <br> <hr>
                  <h4>Detalle de Inscripciones. </h4>
            </div>
    </div>
     <div class="row">
         <div class="col-md-12">
                <div id="divResult"> </div>
            </div>
    </div>
      <div class="row">
         <div class="col-md-12">
                  <h4>Detalle de Transferencias. </h4>
            </div>
    </div>
     <div class="row">
         <div class="col-md-12">
                <div id="divResultTransfer"> </div>
            </div>
    </div>
</div>
<script>
    
var  param= {
                            opc:'rptCierreCaja',
                            anio:<?=$_GET["per"]?>,
                            mes:<?=$_GET["mes"]?>,
                            origen:'T',
                            castrado:'T',
                            tipoReporte:'I'
                            };

             
               // if(param.tipoReporte=="T")param.opc="rptCierreCajaTransfer";
                
                $.ajax({
                        data: param,
                        url:   '../../ajax/ajaxReporte.php',
                        type:  'post',
                        success:  function (response) {
                            var retorno=JSON.parse(response);
                            if(retorno.result=="1"){
                                    
                                            $("#divResult").html(retorno.html);
                                             $("#lblTotalA").html(retorno.cantidad);
                                             $("#lblTotalI").html(retorno.valorA);
                                             $("#lblTotalII").html(retorno.valorB);
                                             


    param= {
                            opc:'rptCierreCajaTransfer',
                            anio:<?=$_GET["per"]?>,
                            mes:<?=$_GET["mes"]?>,
                            origen:'T',
                            castrado:'T',
                            tipoReporte:'T'
                            };
                
                $.ajax({
                        data: param,
                        url:   '../../ajax/ajaxReporte.php',
                        type:  'post',
                        success:  function (response) {
                            var retorno=JSON.parse(response);
                            if(retorno.result=="1"){
                                            $("#divResultTransfer").html(retorno.html);
                                            $("#lblTotalT").html(retorno.valorA);
                                            $("#lblTotalTI").html(retorno.valorB);
                                             $("#lblTotalB").html(retorno.cantidad);
                                             window.print();
                                             window.close();
                                  
                            }else{       
                                    alertify.error("Ocurrió un error al obtener los datos Transfer.");
                            }
                            
                          },
                         error: function (xhr, ajaxOptions, thrownError) {
                            alertify.error(xhr.status+ ""+thrownError);
                        } 
                });


                                   
                            }else{       
                                    alertify.error("Ocurrió un error al obtener los datos.");
                            }
                            
                          },
                         error: function (xhr, ajaxOptions, thrownError) {
                            alertify.error(xhr.status+ ""+thrownError);
                        } 
                });



</script>
<style type="text/css">
	
	body{
		font-size: 10px;
        font-family: Arial;         
		
	}
	table tr td{
 
		font-size: 14px;
	}
    .capitaliza:first-letter{
        text-transform: capitalize;
    }
    .uppercase{
        text-transform: uppercase;
    }

</style>
 
<script type="text/javascript">

</script>
<?
}
?>