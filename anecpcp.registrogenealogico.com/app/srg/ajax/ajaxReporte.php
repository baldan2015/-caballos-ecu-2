<?php  session_start();


    include_once ("../logica/EjemplarLogica.php");
    include_once ("../logica/ReporteLogica.php");
    include_once ("../entidad/Pelaje.inc");
    include_once ("../entidad/Resultado.inc.php");    
    include_once ("../constante.php");     

    
    include_once ("../comunes/lib.comun.php"); 
    if (file_exists("../entidad/Constantes.php")) {
        include_once("../entidad/Constantes.php");
    }
     
   

    if(isset($_GET["opc"])){
        
        if($_GET["opc"]=="lstAdn"){
            echo reporteADN();
        }
         if($_GET["opc"]=="lstAdnXls"){
            $retorno=new Resultado();
            $retorno->html= reporteADNXls();
            $retorno->result=1;
            $retorno->message="Exportación exitosa.";
            echo json_encode($retorno);
        }  
        if($_GET["opc"]=="listTMPADN"){
            echo reporteTMPADN();
        }   
                
    }
    if(isset($_POST["opc"])){
        
        if($_POST["opc"]=="tmpAdn"){
            
            $retorno=new Resultado();
            $retorno=addTmpAdn($_POST["id"]);
            echo json_encode($retorno);
        }
        if($_POST["opc"]=="clsTmp"){
             unset($_SESSION["tmpADNXls"]);
            $retorno=new Resultado();
            $retorno->result=1;
            $retorno->message="Reporte ADN generado finalizado.";
            echo json_encode($retorno);
        }
        if($_POST["opc"]=="quitTmpAdn"){
            
            $retorno=new Resultado();
            $retorno=quitTmpAdn($_POST["id"]);
            echo json_encode($retorno);
        }
         if($_POST["opc"]=="rptNumNacCriador"){
            $desde=$_POST["desde"];
            $hasta=$_POST["hasta"];
            $criador=$_POST["nombre"];
            $retorno=new Resultado();
            if(isset($_POST["xls"])&& $_POST["xls"]=1){
               echo rptNumEjemXCriador_Xls($desde,$hasta,$criador);
            }else{
               echo rptNumEjemXCriador($desde,$hasta,$criador);
            }
         }
         if($_POST["opc"]=="rptNumNacTipo"){
            $desde=$_POST["desde"];
            $hasta=$_POST["hasta"];
            $metodo=$_POST["metodo"];
            $retorno=new Resultado();

            if(isset($_POST["xls"])&& $_POST["xls"]=1){
              $metodoDes=$_POST["metodoDes"];
               echo rptNumNacXMetodo_Xls($desde,$hasta,$metodo,$metodoDes);
            }else{
               echo rptNumNacXMetodo($desde,$hasta,$metodo);
            }
         }
         if($_POST["opc"]=="rptPrefCria"){
     
            $nombre =$_POST["nombre"];
            $pref=$_POST["pref"];
            $retorno=new Resultado();
            if(isset($_POST["xls"])&& $_POST["xls"]=1){
               echo rptCriadorPrefijo_Xls($nombre,$pref);
            }else{
               echo rptCriadorPrefijo($nombre,$pref);
            }
           }
          if($_POST["opc"]=="rptNumServY"){
            $desde=$_POST["desde"];
            $hasta=$_POST["hasta"];
            $retorno=new Resultado();

            if(isset($_POST["xls"])&& $_POST["xls"]=1){
               echo rptNumServYegua_Xls($desde,$hasta);
            }else{
               echo rptNumServYegua($desde,$hasta);
            }
         }
          if($_POST["opc"]=="rptNumServYDet"){
            $anio=$_POST["anio"];
            $nombre=$_POST["nombre"];
            $retorno=new Resultado();

            if(isset($_POST["xls"])&& $_POST["xls"]=1){
               echo rptNumServYeguaDet_Xls($anio,$nombre);
            }else{
               echo rptNumServYeguaDet($anio,$nombre);
            }
         }

         if($_POST["opc"]=="rptNumServP"){
            $desde=$_POST["desde"];
            $hasta=$_POST["hasta"];
            $retorno=new Resultado();

            if(isset($_POST["xls"])&& $_POST["xls"]=1){
               echo rptNumServPotro_Xls($desde,$hasta);
            }else{
               echo rptNumServPotro($desde,$hasta);
            }
         }
          if($_POST["opc"]=="rptNumServPDet"){
            $anio=$_POST["anio"];
            $nombre=$_POST["nombre"];
            $retorno=new Resultado();

            if(isset($_POST["xls"])&& $_POST["xls"]=1){
               echo rptNumServPotroDet_Xls($anio,$nombre);
            }else{
               echo rptNumServPotroDet($anio,$nombre);
            }
         }
            if($_POST["opc"]=="rptCriaXDpto"){
     
            $nombre =$_POST["nombre"];
            $dpto=$_POST["idDpto"];
            $isProp=$_POST["isProp"];
            $retorno=new Resultado();
            if(isset($_POST["xls"])&& $_POST["xls"]=1){
               echo rptCriadorPorDpto_Xls($nombre,$dpto,$isProp);
            }else{
               echo rptCriadorPorDpto($nombre,$dpto,$isProp);
            }
           }
          if($_POST["opc"]=="rptCierreCaja"){
            $anio =$_POST["anio"];
            $mes=$_POST["mes"];
            $origen=$_POST["origen"];
            $castrado=$_POST["castrado"];
            $tipoReporte=$_POST["tipoReporte"];

            $retorno=new Resultado();

            if(isset($_POST["xls"])&& $_POST["xls"]=1){
               echo rptCierreCaja_Xls($anio,$mes,$origen,$castrado,$tipoReporte);
            }else{
               echo rptCierreCaja($anio,$mes,$origen,$castrado,$tipoReporte);
            }
           }
           if($_POST["opc"]=="rptCierreCajaTransfer"){
            $anio =$_POST["anio"];
            $mes=$_POST["mes"];
            $origen=$_POST["origen"];
            $castrado=$_POST["castrado"];
            $tipoReporte=$_POST["tipoReporte"];

            $retorno=new Resultado();

            if(isset($_POST["xls"])&& $_POST["xls"]=1){
               echo rptCierreCajaTransfer_Xls($anio,$mes,$origen,$castrado,$tipoReporte);
            }else{
               echo rptCierreCajaTransfer($anio,$mes,$origen,$castrado,$tipoReporte);
            }
           }
          if($_POST["opc"]=="xlsEjem"){
            
            $retorno=new Resultado();

          
               echo rptEjemplar_Xls();
            }


           
    }
     
    function reporteADN(){
    $page = $_GET['page']; // Obtiene la petición de la página a mostrar
    $limit = $_GET['rows']; // Obtiene cuantas filas queremos tener dentro de la rejilla
    $sidx = $_GET['sidx']; // Obtiene el campo indice "index" para ordenar los datos
    $sord = $_GET['sord']; // Obtiene la forma de ordenamiento
     /*FILTROS DE BUSQUEDA*/
    $idEjemplar= $_GET['id']; 
    $nombre=addslashes($_GET['nombre']);
    $idPadre=$_GET['idPadre']; 
    $nomPadre=addslashes($_GET['nomPadre']);
    $idMadre=$_GET['idMadre'];
    $nomMadre=addslashes($_GET['nomMadre']);
    $idProp=$_GET['idProp'];
    $idEnte=$_GET['idEnte'];
  

    if(!$sidx) $sidx =1;
   
     $ejemplarServicio= new EjemplarLogica();
    // Cantidad de registros para la paginación
    $count = $ejemplarServicio->numeroRegistroRptAdn($idEjemplar,$nombre,$idPadre,$nomPadre,$idMadre,$nomMadre,$idProp,$idEnte);//$row['count'];
    // echo $count." ..<br>";
    if( $count >0 )
    { $total_pages = ceil($count/$limit); }
    else { $total_pages = 0; }
     
    if ($page > $total_pages) $page=$total_pages;
         
    $start = $limit*$page - $limit;
 
    // Se declara la variable objeto la cual va imprimir los datos
    $responce = new stdClass;
    $responce->page = $page;
    $responce->total = $total_pages;
    $responce->records = $count;
    $i=0;
     
     $resultado=$ejemplarServicio->buscarSearchRptAdn($idEjemplar,$nombre,$idPadre,$nomPadre,$idMadre,$nomMadre,$idProp,$idEnte,$start,$limit,$sidx,$sord);
//echo "<pre>";     print_r($resultado);
     foreach ($resultado as $key => $fila) {
        $responce->rows[$i]['id']=$fila->id;
        $responce->rows[$i]['cell']=array($fila->id,
                                          $fila->nombre,
                                          $fila->fecNace,
                                          $fila->sexo,              
                                          $fila->pelaje,
                                          $fila->idPadre,
                                          $fila->nomPadre,
                                          $fila->idMadre,
                                          $fila->nomMadre,       
                                          $fila->propietario,
                                          $fila->capado
                                          );
        $i++;
     }
 
    // Se devuelven los datos a mostrar en la rejilla   
    return json_encode($responce);    




    }

    function reporteADNXls(){
header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
header("Content-Disposition: filename=ficheroExcel.xls");
header("Pragma: no-cache");
header("Expires: 0");        
  
     $ejemplarServicio= new EjemplarLogica();
     
    $start=0;
    $limit=1;
    $sidx=1;
    $sord=1;


        $html="<table border=1><tr>";
        $html.="<td style='background:#ccc;font-weight:bold;'>Id</td>";
        $html.="<td style='background:#ccc;font-weight:bold;'>Nombre</td>";
        $html.="<td style='background:#ccc;font-weight:bold;'>Fec. Nace</td>";
        $html.="<td style='background:#ccc;font-weight:bold;'>Sexo</td>";
        $html.="<td style='background:#ccc;font-weight:bold;'>Pelaje</td>";
        $html.="<td style='background:#ccc;font-weight:bold;'>Id Padre</td>";
        $html.="<td style='background:#ccc;font-weight:bold;'>Padre</td>";
        $html.="<td style='background:#ccc;font-weight:bold;'>Id Madre</td>";
        $html.="<td style='background:#ccc;font-weight:bold;'>Madre</td>";
        $html.="<td style='background:#ccc;font-weight:bold;'>propietario</td>"; 
        $html.="</tr>"; 

$datos=$_SESSION["tmpADNXls"];

     if(is_array($datos)){
            foreach ($datos as $key => $value) {
            $resultado=$ejemplarServicio->buscarSearchRptAdn($value,'','','','','',0,0,$start,$limit,$sidx,$sord);
             foreach ($resultado as $key => $fila) {
                $html.="<tr>";
                $html.="<td>$fila->id</td>";
                $html.="<td>".htmlentities($fila->nombre)."</td>";
                $html.="<td>$fila->fecNace</td>";
                $html.="<td>$fila->sexo</td>";
                $html.="<td>".htmlentities($fila->pelaje)."</td>";
                $html.="<td>$fila->idPadre</td>";
                $html.="<td>".htmlentities($fila->nomPadre)."</td>";
                $html.="<td>$fila->idMadre</td>";
                $html.="<td>".htmlentities($fila->nomMadre)."</td>";
                $html.="<td>".htmlentities($fila->propietario)."</td>"; 
                $html.="</tr>";                            
             }
            }
        }
       $html.="</table>";

    return $html;    
    }
 
 function addTmpAdn($id){

            $retorno=new Resultado();
             
            if(isset($_SESSION["tmpADNXls"])){
                $existe=1;
                 foreach ($_SESSION["tmpADNXls"] as $key => $value) {
                        if($id==$value){
                            $existe++;
                        }
                 }
                 if($existe==1){
                        $datos=$_SESSION["tmpADNXls"];
                        $datos[]=$id;
                        $_SESSION["tmpADNXls"]= $datos;

                        $retorno->result=1;
                        $retorno->message="Ejemplar $id agregado correctamente";
                    }else{
                        $retorno->result=0;
                        $retorno->message="Ejemplar $id ya existe.";
                    }
            }else{
               $_SESSION["tmpADNXls"]=array($id);
               $retorno->result=1;
               $retorno->message="Ejemplar $id agregado correctamente";
            }
            

            return $retorno;

 }
 function quitTmpAdn($id){

            $retorno=new Resultado();
             
            if(isset($_SESSION["tmpADNXls"])){
                $existe=1;
                 foreach ($_SESSION["tmpADNXls"] as $key => $value) {
                        if($id==$value){
                            unset($_SESSION["tmpADNXls"][$key]);
                            $existe=0;    
                        }
                 }
                 if($existe==1){
                        $retorno->result=0;
                        $retorno->message="Ejemplar $id no se encuentra en la lista preliminar.";
                    }else{
                        $retorno->result=1;
                        $retorno->message="Ejemplar $id eliminado del reporte.";
                    }
            }else{
               
               $retorno->result=0;
               $retorno->message="Ejemplar $id no se encuentra en la lista preliminar.";
            }
            
            return $retorno;

 }
   function reporteTMPADN(){
 
    $responce = new stdClass;
    $responce->page = $page;
    $responce->total = $total_pages;
    $responce->records = $count;
    $i=0;

    $sord=1;
    $sidx =1;
    $start=0;
    $limit=1;

    $ejemplarServicio= new EjemplarLogica();
    $datos=$_SESSION["tmpADNXls"];

     if(is_array($datos)){
            foreach ($datos as $key => $value) {
                $resultado=$ejemplarServicio->buscarSearchRptAdn($value,'','','','','',0,0,$start,$limit,$sidx,$sord);
                        foreach ($resultado as $key => $fila) {
                            $responce->rows[$i]['id']=$fila->id;
                            $responce->rows[$i]['cell']=array($fila->id,
                                                  $fila->nombre,
                                                  $fila->fecNace,
                                                  $fila->sexo,              
                                                  $fila->pelaje,
                                                  $fila->idPadre,
                                                  $fila->nomPadre,
                                                  $fila->idMadre,
                                                  $fila->nomMadre,       
                                                  $fila->propietario,
                                                  $fila->capado
                                                  );
                            $i++;
                        }
            }
     }
     return json_encode($responce);    




    }

/*begin addon RC 20190310*/

function rptNumEjemXCriador($desde,$hasta,$criador)
{
    $retorno = new Resultado();
    $retorno->html=$html;
    $retorno->cantidad=0;
    $objRpt = new ReporteLogica();
    $datos=$objRpt-> reportNumNacidoXCriador($desde,$hasta,$criador);
    $dataFill=grillaRptaCantEjemXCriador($desde,$hasta,$datos);
    $retorno->html=$dataFill->html;
    $retorno->cantidad=$dataFill->registros;
    $retorno->result=1;

    return    json_encode($retorno);    
  } 

function rptNumEjemXCriador_Xls($desde,$hasta,$criador){
    header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
    header("Content-Disposition: filename=ficheroExcel.xls");
    header("Pragma: no-cache");
    header("Expires: 0");  
    $retorno = new Resultado();
    
    $objRpt = new ReporteLogica();
    $datos=$objRpt-> reportNumNacidoXCriador($desde,$hasta,$criador);
    $dataFill=grillaRptaCantEjemXCriador($desde,$hasta,$datos);

    $htmlCab=" <img src='".K_PATH_DOMAIN_MAIN."images/logo/logo.jpg' ><table>";
    $htmlCab.="<tr><td colspan=".($dataFill->colspan+3)." >&nbsp;&nbsp;</td></tr>";
    $htmlCab.="<tr><td colspan=".($dataFill->colspan+3)." >&nbsp;&nbsp;</td></tr>";
    $htmlCab.="<tr><td colspan=".($dataFill->colspan+3)." >&nbsp;&nbsp;</td></tr>";
    $htmlCab.="<tr><td colspan=".($dataFill->colspan+3)." style='text-align:center;font-weight:bold; font-size:24px;'>REPORTE DE CANTIDAD DE EJEMPLARES NACIDOS POR CRIADOR.</td></tr>";
    $htmlCab.="<tr><td>Desde: $desde  </td></tr>
              <tr><td>Hasta: $hasta </td></tr>
              <tr><td>Criador: $criador </td></tr>
              </table>";

    $retorno->html= $htmlCab.$dataFill->html;
    $retorno->cantidad=$dataFill->registros; 
    $retorno->result=1;
    
    return    json_encode($retorno);    
  }
function grillaRptaCantEjemXCriador($desde,$hasta,$datos)
{
$data=new stdClass();
$data->html="";
$data->registros=0;

    $min=$desde;
    $max=$hasta;
    $colspanAnio=($max-$min)+1;
    $html="<table border=1  class='tbDatoMain'>";
    $html.="<tr>
    <th><b>CRIADOR  </b></th>
    <th><b>PREFIJO</b></th>
    <th colspan=$colspanAnio><b> AÑOS / CANTIDAD  </b></th>
    <th><b>Total</b></th>
    </tr>";
    $idLast=0;
    $i=1;
    $totalNac=0;
    $registros=0;
 if(is_array($datos)){
      foreach ($datos as $key => $value) {
      $cantidad=$value->cantidad==0?' - ':"<div class='tdHasValue'>".$value->cantidad."</div>";
      if($value->id!=$idLast ){
         $html.="<tr $bg >";
           $html.="<td width=30% class='borderCell'  >".$value->nombre."</td>
                   <td class='borderCell'  >".$value->prefijo."</td>
                   <td class='borderCell'  >
                       <table class='tbValor'>
                       <tr><td class='tdAnio'>".$value->anio."</td>         </tr>
                       <tr><td class='tdValor'>".$cantidad."</td></tr>
                       </table>
                   </td> ";
                   if($max==$value->anio){
                     $html.="<td class='tdTotal'>".($totalNac==0?"-":$totalNac)."</td> ";    
                     $totalNac=0; 
                     $registros++; 
                   }
      }else{
         $html.=" <td class='borderCell' > 
                     <table class='tbValor'>
                     <tr><td class='tdAnio'>".$value->anio."</td>         </tr>
                     <tr><td class='tdValor'>".$cantidad."</td>         </tr>
                     </table> 
                  </td> ";
                  if($max==$value->anio){
                     $html.="<td class='tdTotal'>".($totalNac==0?"-":$totalNac)."</td> ";     
                     $totalNac=0; 
                     $registros++;
                   }
      }
       $i++;
       $idLast=$value->id;
       $totalNac= $totalNac+$value->cantidad;
    }
  }else
  {
      $html.="<td style='border:1px solid #cd6a51;'><center>&nbsp;NO HAY DATOS &nbsp;  </center></td> ";
  }
    $html.="</table>";

    $data->html=$html;
    $data->registros=$registros;
    $data->colspan=$colspanAnio;
    return  $data ;
  } 

  function rptNumNacXMetodo($desde,$hasta,$metodo)
{
    $retorno = new Resultado();
    $retorno->html=$html;
    $retorno->cantidad=0;
    $objRpt = new ReporteLogica();

    $datos=$objRpt->reportNumNacidoXMetodo($desde,$hasta,$metodo);
    $dataFill=grillaRptNumNacXMetodo( $datos);

    $retorno->html=$dataFill->html;
    $retorno->cantidad=$dataFill->registros;
    $retorno->result=1;
    $retorno->data=$datos;

    return    json_encode($retorno);    
  }  
  function rptNumNacXMetodo_Xls($desde,$hasta,$metodo,$metodoDes){
    header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
    header("Content-Disposition: filename=ficheroExcel.xls");
    header("Pragma: no-cache");
    header("Expires: 0");  
    $retorno = new Resultado();
    
    $objRpt = new ReporteLogica();
    $datos=$objRpt->reportNumNacidoXMetodo($desde,$hasta,$metodo);
    $dataFill=grillaRptNumNacXMetodo( $datos);

    
    $htmlCab=" <img src='".K_PATH_DOMAIN_MAIN."images/logo/logo.jpg' ><table>";
    $htmlCab.="<tr><td colspan=2 >&nbsp;&nbsp;</td></tr>";
    $htmlCab.="<tr><td colspan=2 >&nbsp;&nbsp;</td></tr>";
    $htmlCab.="<tr><td colspan=2 >&nbsp;&nbsp;</td></tr>";
    $htmlCab.="<tr><td colspan=4 style='text-align:center;font-weight:bold; font-size:24px;'>
              REPORTE  EJEMPLARES NACIDOS POR METODO:  $metodoDes</td></tr>";
    $htmlCab.="<tr><td>Desde: $desde  </td></tr>
              <tr><td>Hasta: $hasta </td></tr>
              <tr><td>M&eacute;todo:  $metodoDes </td></tr>
              </table>";

    $retorno->html= $htmlCab.$dataFill->html;
    $retorno->cantidad=$dataFill->registros; 
    $retorno->result=1;

    
    return    json_encode($retorno);    
  }
function grillaRptNumNacXMetodo($datos)
{
$data=new stdClass();
$data->html="";
$data->registros=0;

    $html="<table border=1  class='tbDatoMain'>";
    $html.="<tr>    <th><b>A&Ntilde;O  </b></th>    <th><b>Cantidad</b></th>    </tr>";
    
    $registros=0;
    $tot=0;
 if(is_array($datos)){
      foreach ($datos as $key => $value) {

          $html.="<tr  >";
          $html.="<td class='borderCell'  >".$value->anio."</td>
                   <td class='borderCell'  >".$value->cantidad."</td>";
          $html.="</tr>";
          $registros++;
          $tot=$tot+$value->cantidad;

       
    }
    $html.="<tr  >";
          $html.="<td class='borderCellResu'  >Total</td>
                   <td class='borderCellResu'     >".$tot."</td>";
          $html.="</tr>";
  }else
  {
      $html.="<td style='border:1px solid #cd6a51;'><center>&nbsp;NO HAY DATOS &nbsp;  </center></td> ";
  }
    $html.="</table>";

    $data->html=$html;
    $data->registros=$registros;

 
    return  $data ;
  }  
function rptCriadorPrefijo($nombre,$pref)
{

$retorno = new Resultado();
    $retorno->html=$html;
    $retorno->cantidad=0;
    $objRpt = new ReporteLogica();
    $datos=$objRpt->reportCriadorPrefijo($nombre,$pref);
    $dataFill=grillaRptCriadorPrefijo($datos);
    $retorno->html=$dataFill->html;
    $retorno->cantidad=$dataFill->registros;
    $retorno->result=1;
    return    json_encode($retorno);    
  } 
  function rptCriadorPrefijo_Xls($nombre,$pref)
{
    header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
    header("Content-Disposition: filename=ficheroExcel.xls");
    header("Pragma: no-cache");
    header("Expires: 0");  
$retorno = new Resultado();
    $retorno->html=$html;
    $retorno->cantidad=0;
    $objRpt = new ReporteLogica();
    $datos=$objRpt->reportCriadorPrefijo($nombre,$pref);
    $dataFill=grillaRptCriadorPrefijo($datos);

    $htmlCab=" <img src='".K_PATH_DOMAIN_MAIN."images/logo/logo.jpg' ><table>";
    $htmlCab.="<tr><td colspan=2 >&nbsp;&nbsp;</td></tr>";
    $htmlCab.="<tr><td colspan=2 >&nbsp;&nbsp;</td></tr>";
    $htmlCab.="<tr><td colspan=2 >&nbsp;&nbsp;</td></tr>";
    $htmlCab.="<tr><td colspan=2 style='text-align:center;font-weight:bold; font-size:24px;'>
              REPORTE  CRIADOR - PREFIJO</td></tr>";
    $htmlCab.="<tr><td>Nombre: $nombre  </td></tr>
              <tr><td>Prefijo: $pref </td></tr>
              </table>";

    $retorno->html= $htmlCab.$dataFill->html;
    $retorno->cantidad=$dataFill->registros; 
    $retorno->result=1;
 
    return    json_encode($retorno);    
  } 
function grillaRptCriadorPrefijo($datos)
{
$data=new stdClass();
$data->html="";
$data->registros=0;

    $html="<table border=1  class='tbDatoMain'>";
    $html.="<tr>    <th><b>CRIADOR  </b></th>    <th><b>PREFIJO</b></th>    </tr>";
    $registros=0;

 if(is_array($datos)){
      foreach ($datos as $key => $value) {

          $html.="<tr  >";
          $html.="<td class='borderCell' style='width:50%;' >".$value->criador."</td>
                   <td class='borderCell'  >".$value->prefijo."</td>";
          $html.="</tr>";
          $registros++;
    }
    
  }else
  {
      $html.="<td style='border:1px solid #cd6a51;'><center>&nbsp;NO HAY DATOS &nbsp;  </center></td> ";
  }
    $html.="</table>";

    $data->html=$html;
    $data->registros=$registros;

 
    return  $data ;
  }  




   function rptNumServYegua($desde,$hasta)
{
    $retorno = new Resultado();
    $retorno->html=$html;
    $retorno->cantidad=0;
    $objRpt = new ReporteLogica();

    $datos=$objRpt->reportNumServicioYegua($desde,$hasta);
    $dataFill=grillaRptServicioYegua( $datos);

    $retorno->html=$dataFill->html;
    $retorno->cantidad=$dataFill->registros;
    $retorno->result=1;
    $retorno->data=$datos;

    return    json_encode($retorno);    
  }  
  function rptNumServYegua_Xls($desde,$hasta){
    header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
    header("Content-Disposition: filename=ficheroExcel.xls");
    header("Pragma: no-cache");
    header("Expires: 0");  
    $retorno = new Resultado();
    
    $objRpt = new ReporteLogica();
    $datos=$objRpt->reportNumServicioYegua($desde,$hasta);
    $dataFill=grillaRptServicioYegua( $datos);

    
    $htmlCab=" <img src='".K_PATH_DOMAIN_MAIN."images/logo/logo.jpg' ><table>";
    $htmlCab.="<tr><td colspan=2 >&nbsp;&nbsp;</td></tr>";
    $htmlCab.="<tr><td colspan=2 >&nbsp;&nbsp;</td></tr>";
    $htmlCab.="<tr><td colspan=2 >&nbsp;&nbsp;</td></tr>";
    $htmlCab.="<tr><td colspan=4 style='text-align:center;font-weight:bold; font-size:24px;'>
              REPORTE SERVICIOS DE YEGUA POE - ANUAL</td></tr>";
    $htmlCab.="<tr><td>Desde: $desde  </td></tr>
              <tr><td>Hasta: $hasta </td></tr>
              </table>";

    $retorno->html= $htmlCab.$dataFill->html;
    $retorno->cantidad=$dataFill->registros; 
    $retorno->result=1;

    
    return    json_encode($retorno);    
  }
function grillaRptServicioYegua($datos)
{
$data=new stdClass();
$data->html="";
$data->registros=0;

    $html="<table border=1  class='tbDatoMain'>";
    $html.="<tr><th><b>A&Ntilde;O POE </b></th>   
                <th><b>NUM REGISTRO POE  </b></th>    
                <th><b>NUM NACIDO A&Ntilde;O  SIGUIENTE - SGE  </b></th> 
                <th><b>DIFERENCIA %</b></th>    
            </tr>";
    
    $registros=0;
    $totPOE=0;
    $totSGE=0;
    $totDIF=0;
 if(is_array($datos)){
      foreach ($datos as $key => $value) {
          $html.="<tr  >";
          $html.="<td class='borderCell'  ><a href=# onclick=viewDeta($value->anio);>".$value->anio."</td>
                   <td class='borderCell'  >".$value->cantidadPOE."</td> 
                   <td class='borderCell'  >".$value->cantidadSGE."</td>
                   <td class='borderCell'  >".$value->diferencia."</td>";
          $html.="</tr>";
          $registros++;
          $totPOE=$totPOE+$value->cantidadPOE;
          $totSGE=$totSGE+$value->cantidadSGE;
          $totDIF=$totDIF+$value->diferencia;

       
    }
    $html.="<tr  >";
          $html.="<td class='borderCellResu'  >Total</td>
          <td class='borderCellResu'     >".$totPOE."</td>
          <td class='borderCellResu'     >".$totSGE."</td>
                   <td class='borderCellResu'     > </td>";
          $html.="</tr>";
  }else
  {
      $html.="<td style='border:1px solid #cd6a51;'><center>&nbsp;NO HAY DATOS &nbsp;  </center></td> ";
  }
    $html.="</table>";

    $data->html=$html;
    $data->registros=$registros;

 
    return  $data ;
  } 
   function rptNumServYeguaDet($anio,$nombre)
{
    $retorno = new Resultado();
    $retorno->html=$html;
    $retorno->cantidad=0;
    $objRpt = new ReporteLogica();

    $datos=$objRpt->reportNumServicioYeguaDet($anio,$nombre);
    $dataFill=grillaRptServicioYeguaDet( $datos);

    $retorno->html=$dataFill->html;
    $retorno->cantidad=$dataFill->registros;
    $retorno->result=1;
    $retorno->data=$datos;

    return    json_encode($retorno);    
  } 

   function rptNumServYeguaDet_Xls($anio,$nombre){
    header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
    header("Content-Disposition: filename=ficheroExcel.xls");
    header("Pragma: no-cache");
    header("Expires: 0");  
    $retorno = new Resultado();
    
    $objRpt = new ReporteLogica();
    $datos=$objRpt->reportNumServicioYeguaDet($anio,$nombre);
    $dataFill=grillaRptServicioYeguaDet( $datos);

    
    $htmlCab=" <img src='".K_PATH_DOMAIN_MAIN."images/logo/logo.jpg' ><table>";
    $htmlCab.="<tr><td colspan=2 >&nbsp;&nbsp;</td></tr>";
    $htmlCab.="<tr><td colspan=2 >&nbsp;&nbsp;</td></tr>";
    $htmlCab.="<tr><td colspan=2 >&nbsp;&nbsp;</td></tr>";
    $htmlCab.="<tr><td colspan=6 style='text-align:center;font-weight:bold; font-size:24px;'>
              DETALLE SERVICIO YEGUAS A&Ntilde;O: $anio</td></tr>  
              </table>";

    $retorno->html= $htmlCab.$dataFill->html;
    $retorno->cantidad=$dataFill->registros; 
    $retorno->result=1;

    
    return    json_encode($retorno);    
  }  
function grillaRptServicioYeguaDet($datos)
{
$data=new stdClass();
$data->html="";
$data->registros=0;

    $html="<table border=1  class='tbDatoMain'>";
    $html.="<tr><th><b>ID </b></th>   
                <th><b>PREFIJO </b></th>    
                <th><b>NOMBRE </b></th>    
                <th><b>NUM REGISTRO POE  </b></th>    
                <th><b>NUM REGISTRO SGE  </b></th> 
                <th><b>DIFERENCIA </b></th>    
            </tr>";
    
    $registros=0;
    $totPOE=0;
    $totSGE=0;
    $totDIF=0;
 if(is_array($datos)){
      foreach ($datos as $key => $value) {
          $html.="<tr  >";
          $html.="<td class='borderCell'  >".$value->id."</td>
                  <td class='borderCell'  >".$value->prefijo."</td> 
                  <td class='borderCell'  >".$value->nombre."</td> 
                   <td class='borderCell'  >".$value->cantidadPOE."</td> 
                   <td class='borderCell'  >".$value->cantidadSGE."</td>
                   <td class='borderCell'  >".$value->diferencia."</td>";
          $html.="</tr>";
          $registros++;
          $totPOE=$totPOE+$value->cantidadPOE;
          $totSGE=$totSGE+$value->cantidadSGE;
          $totDIF=$totDIF+$value->diferencia;

       
    }
    $html.="<tr  >";
          $html.="<td class='borderCellResu' colspan=3  >Total</td>
          <td class='borderCellResu'     >".$totPOE."</td>
          <td class='borderCellResu'     >".$totSGE."</td>
                   <td class='borderCellResu'     >".$totDIF."</td>";
          $html.="</tr>";
  }else
  {
      $html.="<td style='border:1px solid #cd6a51;'><center>&nbsp;NO HAY DATOS &nbsp;  </center></td> ";
  }
    $html.="</table>";

    $data->html=$html;
    $data->registros=$registros;

 
    return  $data ;
  }  



   function rptNumServPotro($desde,$hasta)
{
    $retorno = new Resultado();
    $retorno->html="";
    $retorno->cantidad=0;
    $objRpt = new ReporteLogica();

    $datos=$objRpt->reportNumServicioPotro($desde,$hasta);
    $dataFill=grillaRptServicioPotro( $datos);

    $retorno->html=$dataFill->html;
    $retorno->cantidad=$dataFill->registros;
    $retorno->result=1;
    $retorno->data=$datos;

    return    json_encode($retorno);    
  }  
  function rptNumServPotro_Xls($desde,$hasta){
    header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
    header("Content-Disposition: filename=ficheroExcel.xls");
    header("Pragma: no-cache");
    header("Expires: 0");  
    $retorno = new Resultado();
    
    $objRpt = new ReporteLogica();
    $datos=$objRpt->reportNumServicioPotro($desde,$hasta);
    $dataFill=grillaRptServicioPotro( $datos);

    
    $htmlCab=" <img src='".K_PATH_DOMAIN_MAIN."images/logo/logo.jpg' ><table>";
    $htmlCab.="<tr><td colspan=2 >&nbsp;&nbsp;</td></tr>";
    $htmlCab.="<tr><td colspan=2 >&nbsp;&nbsp;</td></tr>";
    $htmlCab.="<tr><td colspan=2 >&nbsp;&nbsp;</td></tr>";
    $htmlCab.="<tr><td colspan=4 style='text-align:center;font-weight:bold; font-size:24px;'>
              REPORTE SERVICIOS DE POTROS POE - ANUAL</td></tr>";
    $htmlCab.="<tr><td>Desde: $desde  </td></tr>
              <tr><td>Hasta: $hasta </td></tr>
              </table>";

    $retorno->html= $htmlCab.$dataFill->html;
    $retorno->cantidad=$dataFill->registros; 
    $retorno->result=1;

    
    return    json_encode($retorno);    
  }
function grillaRptServicioPotro($datos)
{
$data=new stdClass();
$data->html="";
$data->registros=0;

    $html="<table border=1  class='tbDatoMain'>";
    $html.="<tr><th><b>A&Ntilde;O POE </b></th>   
                <th><b>NUM REGISTRO POE  </b></th>    
                <th><b>NUM NACIDO A&Ntilde;O  SIGUIENTE - SGE  </b></th> 
                <th><b>DIFERENCIA %</b></th>    
            </tr>";
    
    $registros=0;
    $totPOE=0;
    $totSGE=0;
    $totDIF=0;
 if(is_array($datos)){
      foreach ($datos as $key => $value) {
          $html.="<tr  >";
          $html.="<td class='borderCell'  ><a href=# onclick=viewDeta($value->anio);>".$value->anio."</td>
                   <td class='borderCell'  >".$value->cantidadPOE."</td> 
                   <td class='borderCell'  >".$value->cantidadSGE."</td>
                   <td class='borderCell'  >".$value->diferencia."</td>";
          $html.="</tr>";
          $registros++;
          $totPOE=$totPOE+$value->cantidadPOE;
          $totSGE=$totSGE+$value->cantidadSGE;
          $totDIF=$totDIF+$value->diferencia;

       
    }
    $html.="<tr  >";
          $html.="<td class='borderCellResu'  >Total</td>
          <td class='borderCellResu'     >".$totPOE."</td>
          <td class='borderCellResu'     >".$totSGE."</td>
                   <td class='borderCellResu'     > </td>";
          $html.="</tr>";
  }else
  {
      $html.="<td style='border:1px solid #cd6a51;'><center>&nbsp;NO HAY DATOS &nbsp;  </center></td> ";
  }
    $html.="</table>";

    $data->html=$html;
    $data->registros=$registros;

 
    return  $data ;
  } 
   function rptNumServPotroDet($anio,$nombre)
{
    $retorno = new Resultado();
    $retorno->html="";
    $retorno->cantidad=0;
    $objRpt = new ReporteLogica();

    $datos=$objRpt->reportNumServicioPotroDet($anio,$nombre);
    $dataFill=grillaRptServicioPotroDet( $datos);

    $retorno->html=$dataFill->html;
    $retorno->cantidad=$dataFill->registros;
    $retorno->result=1;
    $retorno->data=$datos;

    return    json_encode($retorno);    
  } 

   function rptNumServPotroDet_Xls($anio,$nombre){
    header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
    header("Content-Disposition: filename=ficheroExcel.xls");
    header("Pragma: no-cache");
    header("Expires: 0");  
    $retorno = new Resultado();
    
    $objRpt = new ReporteLogica();
    $datos=$objRpt->reportNumServicioPotroDet($anio,$nombre);
    $dataFill=grillaRptServicioYeguaDet( $datos);

    
    $htmlCab=" <img src='".K_PATH_DOMAIN_MAIN."images/logo/logo.jpg' ><table>";
    $htmlCab.="<tr><td colspan=2 >&nbsp;&nbsp;</td></tr>";
    $htmlCab.="<tr><td colspan=2 >&nbsp;&nbsp;</td></tr>";
    $htmlCab.="<tr><td colspan=2 >&nbsp;&nbsp;</td></tr>";
    $htmlCab.="<tr><td colspan=6 style='text-align:center;font-weight:bold; font-size:24px;'>
              DETALLE SERVICIO POTROS A&Ntilde;O: $anio</td></tr>  
              </table>";

    $retorno->html= $htmlCab.$dataFill->html;
    $retorno->cantidad=$dataFill->registros; 
    $retorno->result=1;

    
    return    json_encode($retorno);    
  }  
function grillaRptServicioPotroDet($datos)
{
$data=new stdClass();
$data->html="";
$data->registros=0;

    $html="<table border=1  class='tbDatoMain'>";
    $html.="<tr><th><b>ID </b></th>   
                <th><b>PREFIJO </b></th>    
                <th><b>NOMBRE </b></th>    
                <th><b>NUM REGISTRO POE  </b></th>    
                <th><b>NUM REGISTRO SGE  </b></th> 
                <th><b>DIFERENCIA </b></th>    
            </tr>";
    
    $registros=0;
    $totPOE=0;
    $totSGE=0;
    $totDIF=0;
 if(is_array($datos)){
      foreach ($datos as $key => $value) {
          $html.="<tr  >";
          $html.="<td class='borderCell'  >".$value->id."</td>
                  <td class='borderCell'  >".$value->prefijo."</td> 
                  <td class='borderCell'  >".$value->nombre."</td> 
                   <td class='borderCell'  >".$value->cantidadPOE."</td> 
                   <td class='borderCell'  >".$value->cantidadSGE."</td>
                   <td class='borderCell'  >".$value->diferencia."</td>";
          $html.="</tr>";
          $registros++;
          $totPOE=$totPOE+$value->cantidadPOE;
          $totSGE=$totSGE+$value->cantidadSGE;
          $totDIF=$totDIF+$value->diferencia;

       
    }
    $html.="<tr  >";
          $html.="<td class='borderCellResu' colspan=3  >Total</td>
          <td class='borderCellResu'     >".$totPOE."</td>
          <td class='borderCellResu'     >".$totSGE."</td>
                   <td class='borderCellResu'     >".$totDIF."</td>";
          $html.="</tr>";
  }else
  {
      $html.="<td style='border:1px solid #cd6a51;'><center>&nbsp;NO HAY DATOS &nbsp;  </center></td> ";
  }
    $html.="</table>";

    $data->html=$html;
    $data->registros=$registros;

 
    return  $data ;
  }  

function rptCriadorPorDpto($nombre,$dpto,$isProp)
{

    $retorno = new Resultado();
    $retorno->html=$html;
    $retorno->cantidad=0;
    $objRpt = new ReporteLogica();
    $datos=$objRpt->reportCriadorXDpto($nombre,$dpto,$isProp);
    $dataFill=grillaRptCriadorXDpto($datos,$isProp);
    $retorno->html=$dataFill->html;
    $retorno->cantidad=$dataFill->registros;


    $datosConsol=$objRpt->reportCriadorXDptoConsol($isProp);
    $dataFillConsol=grillaRptCriadorXDptoConsol($datosConsol);
    $retorno->html2=$dataFillConsol->html;

    $retorno->result=1;
    return    json_encode($retorno);    
  } 
function rptCriadorPorDpto_Xls($nombre,$dpto,$isProp)
{
    header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
    header("Content-Disposition: filename=ficheroExcel.xls");
    header("Pragma: no-cache");
    header("Expires: 0");  
    $retorno = new Resultado();
    $retorno->html=$html;
    $retorno->cantidad=0;
    $objRpt = new ReporteLogica();
    $datos=$objRpt->reportCriadorXDpto($nombre,$dpto,$isProp);
    $dataFill=grillaRptCriadorXDpto($datos,$isProp);


    $datosConsol=$objRpt->reportCriadorXDptoConsol($isProp);
    $dataFillConsol=grillaRptCriadorXDptoConsol($datosConsol);
    
    $nombre=$nombre==""?'TODOS':$nombre;
    $criaProp=$isProp?"PROPIETARIOS":"CRIADORES";
    if($dpto!=0){
       foreach ($datos as $key => $value) {   $dpto=$value->dpto;        break;       }
    }else{
      $dpto='TODOS';
    }

    $htmlCab=" <img src='".K_PATH_DOMAIN_MAIN."images/logo/logo.jpg' ><table>";
    $htmlCab.="<tr><td colspan=6 >&nbsp;&nbsp;</td></tr>";
    $htmlCab.="<tr><td colspan=6 >&nbsp;&nbsp;</td></tr>";
    $htmlCab.="<tr><td colspan=6 >&nbsp;&nbsp;</td></tr>";
    $htmlCab.="<tr><td colspan=6 style='text-align:center;font-weight:bold; font-size:24px;'>
              REPORTE  $criaProp POR DEPARTAMENTO</td></tr>";
   

   $htmlCab.="<tr><td colspan=6 style='text-align:center;font-weight:bold; font-size:18;'> INFORMACION CONSOLIDADA</td></tr>";
   $htmlCab.="<tr><td colspan=6 >".$dataFillConsol->html."</tr>";
   $htmlCab.="<tr><td colspan=6 style='text-align:center;font-weight:bold; font-size:18px;'>INFORMACION DETALLADA</td></tr>";
   $htmlCab.="<tr><td>Nombre: $nombre  </td></tr>
              <tr><td>Departamento: $dpto </td></tr>
              </table>";
    
    $retorno->html= $htmlCab.$dataFill->html;
    $retorno->cantidad=$dataFill->registros; 
    $retorno->result=1;
 
    return    json_encode($retorno);    
  } 
function grillaRptCriadorXDpto($datos,$isProp)
{

  //echo "isProp..//.".$isProp;
$data=new stdClass();
$data->html="";
$data->registros=0;

    $html="<table border=1  class='tbDatoMain'>";
    $html.="<tr>    <th><b>Tipo Doc  </b></th>    
                    <th><b>Num Doc</b></th>
                    <th><b>Nombres Apellidos / Razon Social</b></th>";

   if($isProp=="false") { $html.="<th><b>Prefijo</b></th>";}
                 $html.="<th><b>Dpto</b></th>";                    
   if($isProp=="false")   {$html.="<th><b>Lugar Crianza</b></th>";}
                                                 
    $html.="</tr>";
    $registros=0;

 if(is_array($datos)){
      foreach ($datos as $key => $value) {

          $html.="<tr  >";
          $html.="<td class='borderCell' >".$value->tipoDoc."</td>
                  <td class='borderCell' >".$value->numDoc."</td>
                  <td class='borderCell' >".$value->razonSocial."</td>";
 if($isProp=="false") $html.="<td class='borderCell' >".$value->prefijo."</td>";
          $html.="<td class='borderCell' >".$value->dpto."</td>";
 if($isProp=="false") $html.="<td class='borderCell' >".$value->lugarCria."</td>";                  
          $html.="</tr>";
          $registros++;
    }
    
  }else
  {
      $html.="<td style='border:1px solid #cd6a51;'><center>&nbsp;NO HAY DATOS &nbsp;  </center></td> ";
  }
    $html.="</table>";

    $data->html=$html;
    $data->registros=$registros;

 
    return  $data ;
  }  

  function grillaRptCriadorXDptoConsol($datos)
{
$data=new stdClass();
$data->html="";
$data->registros=0;

    $html="<table border=1  class='tbDatoMain'>";
    $html.="<tr><th><b>Departamento  </b></th><th><b>Cantidad</b></th></tr>";
    $registros=0;

 if(is_array($datos)){
      foreach ($datos as $key => $value) {

          $html.="<tr  >";
          $html.="<td class='borderCell' >".$value->nombre."</td>
                  <td class='borderCell' >".$value->cantidad."</td>
               ";         
          $html.="</tr>";
          $registros++;
    }
    
  }else
  {
      $html.="<td style='border:1px solid #cd6a51;'><center>&nbsp;NO HAY DATOS &nbsp;  </center></td> ";
  }
    $html.="</table>";

    $data->html=$html;
    $data->registros=$registros;

 
    return  $data ;
  }  
/*begin addon RC 20190310*/  

/*begin addon dbs 20191114*/
function rptCierreCaja($anio,$mes,$origen,$castrado,$tipoReporte)
{

    $retorno = new Resultado();
    $retorno->html=$html;
    $retorno->cantidad=0;
    $objRpt = new ReporteLogica();
    $datos=$objRpt->reportCierreCaja($anio,$mes,$origen,$castrado,$tipoReporte);
    $dataFill=grillaRptCierreCaja($datos,$isProp);
    $retorno->html=$dataFill->html;
    $retorno->cantidad=$dataFill->registros;

    $retorno->valorA=$dataFill->numTN;
    $retorno->valorB=$dataFill->numTI;
    

    $retorno->result=1;
    return    json_encode($retorno);    
  } 
   function rptCierreCaja_Xls($anio,$mes,$origen,$castrado,$tipoReporte){
    header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
    header("Content-Disposition: filename=ficheroExcel.xls");
    header("Pragma: no-cache");
    header("Expires: 0");  

 $retorno = new Resultado();
    
    $objRpt = new ReporteLogica();
 $datos=$objRpt->reportCierreCaja($anio,$mes,$origen,$castrado,$tipoReporte);
    $dataFill=grillaRptCierreCaja($datos,$isProp);

$origenText="";
if($origen=='T')$origenText='TODOS';
if($origen=='N')$origenText='NACIONAL';
if($origen=='I')$origenText='IMPORTADO';
if($castrado=='T')$castradoText='TODOS';
if($castrado=='C')$castradoText='SI';
 
    
    //<img src='".K_PATH_DOMAIN_MAIN."images/logo/logo.jpg' >
    $htmlCab=" <table>";
    $htmlCab.="<tr><td colspan=2 >&nbsp;&nbsp;</td></tr>";
    $htmlCab.="<tr><td colspan=2 >&nbsp;&nbsp;</td></tr>";
    $htmlCab.="<tr><td colspan=2 >&nbsp;&nbsp;</td></tr>";
    $htmlCab.="<tr><td colspan=12 style='text-align:center;font-weight:bold; font-size:24px;'>
              REPORTE DE CIERRE MENSUAL - INSCRIPCIONES</td></tr> ";
    $htmlCab.="<tr><td colspan=2 >PERIODO:</td><td colspan=2> '$anio </td></tr>"; 
    $htmlCab.="<tr><td colspan=2>MES: </td><td colspan=2>'$mes </td></tr>"; 
    $htmlCab.="<tr><td colspan=2>ORIGEN: </td><td colspan=2>".$origenText." </td></tr>"; 
    $htmlCab.="<tr><td colspan=2>SOLO CASTRADOS: </td><td colspan=2>".$castradoText."</td></tr>";          
    $htmlCab.="     </table>";

    $retorno->html= $htmlCab.$dataFill->html;
    $retorno->cantidad=$dataFill->registros; 
    $retorno->result=1;

    
    return    json_encode($retorno);    
  }  
  function grillaRptCierreCaja($datos,$isProp)
{

  //echo "isProp..//.".$isProp;
$data=new stdClass();
$data->html="";
$data->registros=0;
$data->numTN=0;
$data->numTI=0;

    $html="<table border=1  class='tbDatoMain'>";
    $html.="<tr>   
                          <th><b>ID EJEMPLAR</b></th>
                          <th><b>PREFIJO</b></th>
                          <th><b>NOMBRE</b></th>
                          <th><b>FEC NAC.</b></th>                          
                          <th><b>PELAJE</b></th>
                          <th><b>PROPIETARIO</b></th>
                          <th><b>CRIADOR</b></th>
                          <th><b>FEC INS.</b></th>
                          <th><b>ORGIGEN.</b></th>
                          <th><b>FEC CAPADO</b></th>         
                           <th><b>Usu. Creaci&oacute;n</b></th>    
                             <th><b>Fec. Creaci&oacute;n</b></th>                                            


    ";
 
                                                 
    $html.="</tr>";
    $registros=0;
    $nac=0;
    $imp=0;
 if(is_array($datos)){
      foreach ($datos as $key => $value) {

          $html.="<tr  >";
          $html.="<td class='borderCell' >".$value->id."</td>
                  <td class='borderCell' >".$value->prefijo."</td>
                  <td class='borderCell' >".$value->nombre."</td>
                  <td class='borderCell' >".$value->fecNace."</td>
                  <td class='borderCell' >".$value->pelaje."</td>
                  <td class='borderCell' >".$value->propiedad."</td>
                  <td class='borderCell' >".$value->criador."</td>
                  <td class='borderCell' >".$value->fecReg."</td>
                  <td class='borderCell' >".$value->origen."</td>
                  <td class='borderCell' >".$value->fecCapado."</td>
                  <td class='borderCell' >".$value->usuCrea."</td>
                  <td class='borderCell' >".$value->fecCrea."</td>";

                 
          $html.="</tr>";
          if($value->origen=="NACIONAL") $nac++;
          if($value->origen=="IMPORTADO") $imp++;
          $registros++;
    }
    
  }else
  {
      $html.="<td style='border:1px solid #cd6a51;'><center>&nbsp;NO HAY DATOS &nbsp;  </center></td> ";
  }
    $html.="</table>";

    $data->html=$html;
    $data->registros=$registros;
    $data->numTN=$nac;
    $data->numTI=$imp;

 
    return  $data ;
  }

  function rptCierreCajaTransfer($anio,$mes,$origen,$castrado,$tipoReporte)
{

    $retorno = new Resultado();
    $retorno->html=$html;
    $retorno->cantidad=0;
    $objRpt = new ReporteLogica();
    $datos=$objRpt->reportCierreCajaTransfer($anio,$mes,$origen,$castrado,$tipoReporte);
    $dataFill=grillaRptCierreCajaTransfer($datos,$isProp);
    $retorno->html=$dataFill->html;
    $retorno->cantidad=$dataFill->registros;
 

    $retorno->valorA=$dataFill->numTN;
    $retorno->valorB=$dataFill->numTI;
    

    

    $retorno->result=1;
    return    json_encode($retorno);    
  } 
   function rptCierreCajaTransfer_Xls($anio,$mes,$origen,$castrado,$tipoReporte){
    header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
    header("Content-Disposition: filename=ficheroExcel.xls");
    header("Pragma: no-cache");
    header("Expires: 0");  

 $retorno = new Resultado();
    
    $objRpt = new ReporteLogica();
 $datos=$objRpt->reportCierreCajaTransfer($anio,$mes,$origen,$castrado,$tipoReporte);
    $dataFill=grillaRptCierreCajaTransfer($datos,$isProp);

$origenText="";
if($origen=='T')$origenText='TODOS';
if($origen=='N')$origenText='NACIONAL';
if($origen=='I')$origenText='IMPORTADO';
if($castrado=='T')$castradoText='TODOS';
if($castrado=='C')$castradoText='SI';
 
    
    //<img src='".K_PATH_DOMAIN_MAIN."images/logo/logo.jpg' >
    $htmlCab=" <table>";
    $htmlCab.="<tr><td colspan=2 >&nbsp;&nbsp;</td></tr>";
    $htmlCab.="<tr><td colspan=2 >&nbsp;&nbsp;</td></tr>";
    $htmlCab.="<tr><td colspan=2 >&nbsp;&nbsp;</td></tr>";
    $htmlCab.="<tr><td colspan=12 style='text-align:center;font-weight:bold; font-size:24px;'>
              REPORTE DE CIERRE MENSUAL - TRANSFERENCIAS</td></tr> ";
    $htmlCab.="<tr><td colspan=2 >PERIODO:</td><td colspan=2> '$anio </td></tr>"; 
    $htmlCab.="<tr><td colspan=2>MES: </td><td colspan=2>'$mes </td></tr>"; 
    $htmlCab.="<tr><td colspan=2>ORIGEN: </td><td colspan=2>".$origenText." </td></tr>"; 
    $htmlCab.="<tr><td colspan=2>SOLO CASTRADOS: </td><td colspan=2>".$castradoText."</td></tr>";          
    $htmlCab.="     </table>";

    $retorno->html= $htmlCab.$dataFill->html;
    $retorno->cantidad=$dataFill->registros; 
    $retorno->result=1;

    
    return    json_encode($retorno);    
  }  
  function grillaRptCierreCajaTransfer($datos,$isProp)
{

  //echo "isProp..//.".$isProp;
$data=new stdClass();
$data->html="";
$data->registros=0;
$data->numTN=0;
$data->numTI=0;

    $html="<table border=1  class='tbDatoMain'>";
    $html.="<tr>          <th><b>ID TRANSFER.</b></th>
                          <th><b>ID EJEMPLAR</b></th>
                          <th><b>PREFIJO</b></th>
                          <th><b>NOMBRE</b></th>
                          <th><b>ANTIGUO PROP.</b></th>                          
                          <th><b>NUEVO PROP.</b></th>
 
                          <th><b>FEC. REGISTRO</b></th>
                          <th><b>FEC. TRANSFER.</b></th>
                          <th><b>ORIGEN.</b></th>
                          <th><b>FEC CAPADO</b></th>         
                          <th><b>Usu. Creaci&oacute;n</b></th>    
                          <th><b>Fec. Creaci&oacute;n</b></th>                                            


    ";
 
                                                 
    $html.="</tr>";
    $registros=0;
    $nac=0;
    $imp=0;
 if(is_array($datos)){
      foreach ($datos as $key => $value) {
           $html.="<tr  >";
          $html.="<td class='borderCell' >".$value->id."</td>
                  <td class='borderCell' >".$value->idEjemplar."</td>
                  <td class='borderCell' >".$value->prefijo."</td>
                  <td class='borderCell' >".$value->nombre."</td>
                  <td class='borderCell' >".$value->antiguoProp."</td>
                  <td class='borderCell' >".$value->nuevoProp."</td>
                  <td class='borderCell' >".$value->fechaRegistro."</td>
                  <td class='borderCell' >".$value->fechaTransferencia."</td>
                  <td class='borderCell' >".$value->origen."</td>
                  <td class='borderCell' >".$value->fecCapado."</td>
                  <td class='borderCell' >".$value->usuCrea."</td>
                  <td class='borderCell' >".$value->fecCrea."</td>";

                 
          $html.="</tr>";
          if($value->origen=="NACIONAL") $nac++;
          if($value->origen=="IMPORTADO") $imp++;
          $registros++;
    }
    
  }else
  {
      $html.="<td style='border:1px solid #cd6a51;'><center>&nbsp;NO HAY DATOS &nbsp;  </center></td> ";
  }
    $html.="</table>";

    $data->html=$html;
    $data->registros=$registros;

$data->numTN=$nac;
$data->numTI=$imp;
 
    return  $data ;
  }
/*end addon dbs 20191114*/  

/*addon dbs 20200123*/
 function rptEjemplar_Xls(){
  // Create new PHPExcel object
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
               ->setLastModifiedBy("Maarten Balliauw")
               ->setTitle("Office 2007 XLSX Test Document")
               ->setSubject("Office 2007 XLSX Test Document")
               ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
               ->setKeywords("office 2007 openxml php")
               ->setCategory("Test result file");


// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Hello')
            ->setCellValue('B2', 'world!')
            ->setCellValue('C1', 'Hello')
            ->setCellValue('D2', 'world!');

// Miscellaneous glyphs, UTF-8
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A4', 'Miscellaneous glyphs')
            ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="01simple.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

exit;

 //   $retorno = new Resultado();
/*
    header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
    header("Content-Disposition: filename=ficheroExcel.xls");
    header("Pragma: no-cache");
    header("Expires: 0");  


    
    $ejemplarServicio=new EjemplarLogica();

$idEjemplar='';
$prefijo='';
$nombre='';$prop=0;
$cria=0;
$sexo='';
$edadDesde='';
$edadhasta='';
$estado='';
$ente=0;
$start=0;
$limit=7000;
$sidx='id';
$sord='asc';

  $resultado=$ejemplarServicio->buscarSearchXls($idEjemplar,$prefijo,$nombre,$prop,$cria,$sexo,$edadDesde,$edadhasta,$estado,$ente,$start,$limit,$sidx,$sord);
// echo "<pre>";     print_r($resultado);
 

$html="<table>";
    $html.="<tr>          
                          <th>ID EJEMPLAR</th>
                          <th>PREFIJO</th>
                          <th>NOMBRE</th>
                          <th>FEC. NAC.</th>                          
                          <th>FEC. REGISTRO</th>
                          <th>ID PADRE</th>
                          <th>PREF. PADRE</th>
                          <th>NOM. PADRE</th>
                           <th>ID MADRE</th>
                          <th>PREF. MADRE</th>
                          <th>NOM. MADRE</th>
                           <th>PROPIETARIOS</th>
                          <th>CRIADOR.</th>
                          <th>FEC. FALLECE.</th>
                          <th>PELAJE</th>         
                          <th>LUGAR DE NAC.</th>    
                          <th>MICROCHIP</th>   
                          <th>ADN</th>   
                            <th>CAPADO</th>   
                              <th>ESTADO</th>                                            


    ";
 
                                                 
    $html.="</tr>";
    $registros=0;
    $nac=0;
    $imp=0;
 if(is_array($resultado)){
      foreach ($resultado as $key => $value) {
           $html.="<tr>";
          $html.="<td>".$value->codigo."</td>
                  <td>".$value->prefijo."</td>
                  <td>".htmlentities($value->nombre,iso-8859-1)."</td>
                  <td>".$value->fecNace."</td>
                  <td>".$value->fecReg."</td>

                  <td>".$value->idPadre."</td>
                  <td>".$value->prefijoPad."</td>
                  <td>".htmlentities($value->nombrePad,iso-8859-1)."</td>

                  <td>".$value->idMadre."</td>
                  <td>".$value->prefijoMad."</td>
                  <td>".htmlentities($value->nombreMad,iso-8859-1)."</td>

                  <td>".htmlentities($value->propietarios,iso-8859-1)."</td>
                  <td>".htmlentities($value->criadores,iso-8859-1)."</td>
                  <td>".$value->fecFallece."</td>
                  <td>".htmlentities($value->nombrePelaje,iso-8859-1)."</td>
                  <td>".$value->LugarNace."</td>
                  <td>".$value->microchip."</td> 
                  <td>".$value->adn."</td>
                  <td>".$value->capado."</td> 
                  <td>".$value->estado."</td>";

                 
          $html.="</tr>";
           
          $registros++;
    }
    
  }else
  {
      $html.="<td>NO HAY EJEMPLARES</td> ";
  }
    $html.="</table>";

    $retorno->html=$html;
    $retorno->cantidad=$registros; 
    $retorno->result=1;
    $retorno->message="Datos generados con éxito.";

    */
    //return     json_encode($retorno);    
  }  
  /*addon dbs 20200123*/
?>

