<?php  session_start();
    if (file_exists("../logica/ImagenInsLogica.php")) {  include_once ("../logica/ImagenInsLogica.php");}
    if (file_exists("../entidad/Ejemplar.inc.php")) {  include_once ("../entidad/Ejemplar.inc.php");}
    if (file_exists("../entidad/Resultado.inc.php")) {  include_once ("../entidad/Resultado.inc.php");}

    if (file_exists("../comunes/lib.comun.php")) {   include_once ("../comunes/lib.comun.php");} 
    if (file_exists("../constante.php")) {   include_once ("../constante.php");}

 
   if (file_exists("../entidad/Constantes.php")) {        include_once("../entidad/Constantes.php");}
   
if(!isset($_POST["opc"]))   {
    //echo"<pre>";print_r($_GET);echo "</pre>";
   // echo listarEjemplar('','','','','','','','');
}

    if(isset($_POST["opc"])){

        // $retorno=new Resultado();
     /*     $codigo = $_POST["codigo"];
        $nombre = $_POST["nombre"];
        $tlocal_codigo = $_POST["tlocal_codigo"];
        $responsable = $_POST["responsable"];
     */
      
        $usuario_crea = $_SESSION[Constantes::K_SESSION_CODIGO_USUARIO];
        $usuario_modi = $_SESSION[Constantes::K_SESSION_CODIGO_USUARIO];
        $codigo_empresa =0;
        $codigo_local = 0;
    
        
        if($_POST["opc"]=="lst"){
             $id = $_POST["id"];
            echo  listarImagen($id);
        } elseif($_POST["opc"]=="del"){
            $codigo = $_POST["id"];
            echo eliminar($codigo);
        }else if($_POST["opc"]=="setProp"){
            $codigo=$_POST["codigo"];
            echo  setProp($codigo);
        }else if($_POST["opc"]=="upd"){

            $codigo=$_POST["id"];
            $main=$_POST["main"];
            $idHorse=$_POST["idHorse"];
            echo editar($codigo,$main,$idHorse);
        }else   if($_POST["opc"]=="lstImgNac"){
             $id = $_POST["id"];
             $codigoGenerado = $_POST["codigoGenerado"];
             $edit = $_POST["edit"];
            echo  listarImagenEjemplarNac($id,$codigoGenerado,$edit);
        }elseif($_POST["opc"]=="delNacTMP"){
            $codigo = $_POST["id"];
            echo eliminarNacTMP($codigo);
        }else   if($_POST["opc"]=="lstPdfNac"){
             $id = $_POST["id"];
             $codigoGenerado = $_POST["codigoGenerado"];
             $edit = $_POST["edit"];
             echo  listarPdfEjemplarNac($id,$codigoGenerado,$edit);
        }
        else   if($_POST["opc"]=="lstImgIns"){
             $id = $_POST["id"];
             $tipo = $_POST["edit"];
             $codigoGenerado = $_POST["codigoGenerado"];
            echo  listarImagenEjemplarIns($id, $codigoGenerado, $tipo);
        }elseif($_POST["opc"]=="delInsTMP"){
            $codigo = $_POST["id"];
            echo eliminarInsTMP($codigo);
        }else if ($_POST["opc"] == "dltDocINS") {
            $codigo =   $_SESSION["xid"];
            $esPDF = $_POST["esPDF"];
            echo eliminarDocumentosINS($codigo, $esPDF);
        }else   if($_POST["opc"]=="lstPdfIns"){
             $id = $_POST["id"];
             $codigoGenerado = $_POST["codigoGenerado"];
             $edit = $_POST["edit"];
            echo  listarPdfEjemplarIns($id, $codigoGenerado, $edit);
        }


        
    }
    
     //Insertar
    
    
    //Eliminar
    function eliminar($codigo){
         $retorno=new Resultado();
       // echo $codigo;
        $objImagen = new ImagenLogica();
        $result = $objImagen->eliminar($codigo);

        if ($result == 1){
            $retorno->result=1;
            $retorno->message = Constantes::K_MENSAJE_DELETE_OK;
        }else{
            $retorno->result=0;
            $retorno->message = Constantes::K_MENSAJE_DELETE_NOOK;
        }
       return json_encode($retorno);
    }
   
//Editar
    function editar($codigo,$main,$idHorse){

        //echo ("ingreso");
         $retorno=new Resultado();
        $objImagen = new ImagenLogica();

       
        $response = $objImagen->editar($codigo,$main,$idHorse);

        if ($response->result == 1){
            $retorno->result=$response->result;
            $retorno->message = Constantes::K_MENSAJE_UPDATE_OK;
        }else if ($response->result == 0){
            $retorno->result=0;
            $retorno->message = Constantes::K_MENSAJE_UPDATE_NOOK;
        }else if($response->result==2){
            $retorno->result=$response->result;
            $retorno->message = "No puede tener más de 2 imagenes principales por ejemplar";
        }
        return json_encode($retorno);


    }

    function listarImagen($id){
        
        $thumb_prefix           = "thumb_"; //Normal thumb Prefix

        $retorno=new Resultado();
        $objImagen = new ImagenLogica();
        $html = "";
        $html.= "<table class='gridHtmls' style='width:100%;border-collapse: collapse;
    border: 1px solid #CCC; background:white;'  border=1 >";
        $html.= "<thead style='background:#d3d3d3;'>";
        $html.= "<tr>";
        $html.= "<th  >Id</th>";
        $html.= "<th  >IdCaballo</th>";
        $html.= "<th  >Ruta</th>";
        $html.= "<th  >Fecha</th>";
        $html.= "<th >Imagen</th>";
       // $html.= "<th style='height:35px;width:25%;'>Activo</th>";
        $html.= "<th  >Es principal</th>";
        $html.= "<th style='height:35px; '>...</th>";
        $html.= "</tr>";
        $html.= "</thead>";
        $html.= "<tbody  >";


        $datos = $objImagen->buscarSearch($id);
       // $sql=" Select idImagen,idCaballo,ruta,esPrincipal,activo,fecha from imagen where idCaballo='".$idHorse."'";
        //$response = $objImagen->buscarSearch($id);
         //print_r($datos);
        //echo $sql;
        if(is_array($datos)){


        foreach ($datos as $key => $fila) {
        
            $botonHtml="<label class='btnDel' style=' cursor:pointer;'
             onclick=eliminarImg(".$fila->id.",'".$fila->idCaballo. "'); >Eliminar</label>";


            $isMain=$fila->esPrincipal==1?"SI":"NO";
            $botonHtmlEsprincipal="<label class='btnUpd' onclick=updPrincipal(".$fila->id.",".$fila->esPrincipal.",'".$fila->idCaballo."'); style=' cursor:pointer;' >".$isMain."</label>";
             
            $html.= "<tr>";
            

                $html.= "<td align='left'>
                <label>".$fila->id."</label>
                <input type='hidden' class='cssItem'   value='".$fila->id."'>
                <input class='cssItem'  type='hidden'   value='".$res['esNuevo']."'>
                </td>";

                $html.= "<td align='left'>
                <label  id='txtEjemplar_".$fila->id."' >".$fila->idCaballo."</label>
                <input type='hidden' class='cssItem'  value='".$fila->idCaballo."'>
                </td>";

                $html.= "<td align='center'>
                <label id='txtRuta_".$fila->id."' >".$fila->ruta."</label>
                <input type='hidden' class='cssItem'  value='".$fila->ruta."'>
                </td>";

                
                $html.= "<td align='center'>
                <label  id='txtFecha_".$fila->id."' >".$fila->fecha."</label>
                <input type='hidden' class='cssItem' value='".$fila->fecha."'>
                </td>";

                $html.= "<td align='center'>
                 <img src='".K_PATHWEB.$thumb_prefix.$fila->ruta."' alt='Thumbnail' style=' cursor:pointer;'  onclick=mostrarImgGrande('".K_PATHWEB.$fila->ruta."'); /> 
                </td>";
/*
                $html.= "<td align='center'>
                <label  id='txtActivo_".$fila->id."' >".$fila->activo."</label>
                <input type='hidden' class='cssItem'   value='".$fila->activo."'>
                </td>";
*/
                
                $html.= "<td align='center'>
                <label  id='txtActivo_".$fila->id."' >".$botonHtmlEsprincipal."</label>
                <input type='hidden' class='cssItem'   value='".$fila->esPrincipal."'>
                </td>";

                $html.= "<td align='center'>";

                $html.=$botonHtml; 
                
                 $html.= "</td>";
            $html.= "</tr>";
          //  $fila++;
           //     }
             $i++;
        }
        }
        //mysqli_free_result($result);
        $html.= "</tbody>";
        $html.= "</table>";
        return $html;
}
 function listarImagenEjemplarNac($id, $codigoGenerado, $edit){
        
        $thumb_prefix           = "thumb_"; //Normal thumb Prefix

        $retorno=new Resultado();
        $objImagen = new ImagenLogica();
        $html = "";
        /*$html.= "<table class='table table-responsive' style='width:96%;margin-left:15px;'  >";
        $html.= "<thead>";
        $html.= "<tr>";
        $html.= "<th style='text-align:center;width:30%;'>Fecha</th>";
        $html.= "<th style='text-align:center;width:50%;'>Imagen</th>";
        $html.= "<th style='height:20px; '>...</th>";
        $html.= "</tr>";
        $html.= "</thead>";
        $html.= "</table>";
        */
        $html.= "<div  style='overflow-y:auto;overflow-x:hidden; width:96%;margin-left:15px;' >";
        $html.= "<table class='table table-responsive' style='width:100%;margin-left:15px;'>";
        
        $html.= "<thead>";
        $html.= "<tr>";
        $html.= "<th style='text-align:center;width:30%;'>Fecha</th>";
        $html.= "<th style='text-align:center;width:50%;'>Imagen</th>";
        $html.= "<th style='height:20px; '>...</th>";
        $html.= "</tr>";
        $html.= "</thead>";

        $html.= "<tbody  >";


        $datos = $objImagen->buscarSearchNacTMP($id,0,$codigoGenerado);
        if(is_array($datos)){
        foreach ($datos as $key => $fila) {
            $botonHtml="<span class='btnDel btn btn-sm btn-default glyphicon glyphicon-trash' style=' cursor:pointer;'
             onclick=eliminarImg(".$fila->id.",'".$fila->idNacimiento."','".$codigoGenerado. "','" . $edit . "');  id='btnDelE' ></span>";
           /* $isMain=$fila->esPrincipal==1?"SI":"NO";
            $botonHtmlEsprincipal="<label class='btnUpd' onclick=updPrincipal(".$fila->id.",".$fila->esPrincipal.",'".$fila->idCaballo."'); style=' cursor:pointer;' >".$isMain."</label>";
           */
            $html.= "<tr id='".$fila->id."_nac_img'>"; 
            $html.= "<label style='display:none;'  >".$fila->id."</label>
                <input type='hidden' class='cssItem'   value='".$fila->id."'>
                <input class='cssItem'  type='hidden'   value='".$res['esNuevo']."'/>
                <label style='display:none;'  id='txtEjemplar_".$fila->id."' >".$fila->idNacimiento."</label>
                <input type='hidden' class='cssItem'  value='".$fila->idNacimiento."'>
                </td>";
/*
                $html.= "<td align='center'>
                <label  id='txtRuta_".$fila->id."' >".$fila->ruta."</label>
                <input type='hidden' class='cssItem'  value='".$fila->ruta."'>
                </td>";
*/
                
                $html.= "<td  align='left'>
                <label  id='txtFecha_".$fila->id."' style='padding-right:30px;' >".$fila->fecha."</label>
                <input type='hidden' class='cssItem' value='".$fila->fecha."'>
                </td>";

               $html.= "<td style='text-align:center;' >
                 <img src='".K_PATHWEB_NAC_IMG.$thumb_prefix.$fila->ruta."' alt='Thumbnail' style=' cursor:pointer;'  onclick=mostrarImgGrande('".K_PATHWEB_NAC_IMG.$fila->ruta."'); /> 
                </td>";
              /*   $html.= "<td  >
                 <img src='".K_PATHWEB.$thumb_prefix.$fila->ruta."' alt='Thumbnail' style=' cursor:pointer;'  onclick=mostrarImgGrande('".K_PATHWEB.$fila->ruta."'); /> 
                </td>";*/
     /*
                $html.= "<td align='center'>
                <label  id='txtActivo_".$fila->id."' >".$botonHtmlEsprincipal."</label>
                <input type='hidden' class='cssItem'   value='".$fila->esPrincipal."'>
                </td>";
*/
                $html.= "<td  >";

                $html.=$botonHtml; 
                $html.= "<td  >
                <input type='hidden' id='hiddenImgIns' class='cssItem' value='".$fila->codigoGenerado."'>
                </td>";
                 $html.= "</td>";
            $html.= "</tr>";

             $i++;
        }
        }
        $html.= "</tbody>";
        $html.= "</table>";
        $html.= "</div>";
        return $html;
}
  function eliminarNacTMP($codigo){
         $retorno=new Resultado();
       // echo $codigo;
        $objImagen = new ImagenLogica();
        $result = $objImagen->eliminarNacTMP($codigo);
        //print_r($result);
        if ($result->result == 1){
            $retorno->result=1;
            $retorno->message = Constantes::K_MENSAJE_DELETE_OK;
        }else if($result->result == 999){
            $retorno->result=999;
            $retorno->message = "No se puede eliminar ya que la inscripción del ejemplar se encuentra aprobada";
        }else if($result->result == 998){
            $retorno->result=998;
            $retorno->message = "No se puede eliminar ya que la solicitud de nacimiento se encuentra aprobada";
        }else if($result->result == 997){
            $retorno->result=997;
            $retorno->message = "No se puede eliminar ya que la solicitud de nacimiento se encuentra rechazada";
        }else{
            $retorno->result=0;
            $retorno->message = Constantes::K_MENSAJE_DELETE_NOOK;
        }
       return json_encode($retorno);
    }


  function listarPdfEjemplarNac($id,$codigoGenerado,$edit){
        $thumb_prefix           = "thumb_"; //Normal thumb Prefix

        $retorno=new Resultado();
        $objImagen = new ImagenLogica();
        $html = "";/*
        $html.= "<table class='table table-responsive'  style='width:96%;' >";
        $html.= "<thead>";
        $html.= "<tr>";
        $html.= "<th style='text-align:center;width:40%;'>Tipo Documento</th>";
        $html.= "<th style='text-align:center;width:20%;'>Fecha</th>";
        $html.= "<th style='width:30%;'>PDF Adjuntado</th>";
        $html.= "<th style='height:20px; '>...</th>";
        $html.= "</tr>";
        $html.= "</thead>";
        $html.= "</table>";*/
        $html.= "<div  style='overflow-y:auto;overflow-x:hidden; width:96%;' >";
        $html.= "<table class='table table-responsive'  style='width:100%;' >";

        $html.= "<thead>";
        $html.= "<tr>";
        $html.= "<th style='text-align:center;width:40%;'>Tipo Documento</th>";
        $html.= "<th style='text-align:center;width:20%;'>Fecha</th>";
        $html.= "<th style='width:30%;'>PDF Adjuntado</th>";
        $html.= "<th style='height:20px; '>...</th>";
        $html.= "</tr>";
        $html.= "</thead>";

        $html.= "<tbody  >";


        $datos = $objImagen->buscarSearchNacTMP($id,1,$codigoGenerado);
        if(is_array($datos)){
        foreach ($datos as $key => $fila) {
            $botonHtml="<span class='btnDel btn btn-sm btn-default glyphicon glyphicon-trash' style=' cursor:pointer;'
             onclick=eliminarPdf(".$fila->id.",'".$fila->idNacimiento."','".$codigoGenerado. "','" . $edit . "'); ></span>";
           /* $isMain=$fila->esPrincipal==1?"SI":"NO";
            $botonHtmlEsprincipal="<label class='btnUpd' onclick=updPrincipal(".$fila->id.",".$fila->esPrincipal.",'".$fila->idCaballo."'); style=' cursor:pointer;' >".$isMain."</label>";
           */

            $html.= "<tr id='".$fila->id."_nac_pdf'>";
            $html.= "<label style='display:none;'   >".$fila->id."</label>
                <input type='hidden' class='cssItem'   value='".$fila->id."'>
                <input class='cssItem'  type='hidden'   value='".$res['esNuevo']."'/>
                <label  style='display:none;'  id='txtEjemplar_".$fila->id."' >".$fila->idNacimiento."</label>
                <input type='hidden' class='cssItem'  value='".$fila->idNacimiento."'>
                </td>";
/*
                $html.= "<td align='center'>
                <label  id='txtRuta_".$fila->id."' >".$fila->ruta."</label>
                <input type='hidden' class='cssItem'  value='".$fila->ruta."'>
                </td>";
*/
                
                $html.= "<td align='center'>
                <label  id='txtTipoDocumento_".$fila->id."' >".$fila->idTipoDocumento."</label>
                <input type='hidden' class='cssItem'  value='".$fila->idTipoDocumento."'>
                </td>";
                $html.= "<td  align='center'>
                <label  id='txtFecha_".$fila->id."' >".$fila->fecha."</label>
                <input type='hidden' class='cssItem' value='".$fila->fecha."'>
                </td>";

               $html.= "<td style='text-align:center;' >
                 <img  src='../../../images/icono/pdf.png' alt='Thumbnail' style=' cursor:pointer; width:30px;'  onclick=mostrarImgGrande('".K_PATHWEB_NAC_PDF.$fila->ruta."'); /> 
                </td>";
               /*  $html.= "<td  >
                 <img  src='images/icono/pdf.png' alt='Thumbnail' style=' cursor:pointer; width:30px;'  onclick=mostrarImgGrande('".K_PATHWEB.$fila->ruta."'); /> 
                </td>";*/
     /*
                $html.= "<td align='center'>
                <label  id='txtActivo_".$fila->id."' >".$botonHtmlEsprincipal."</label>
                <input type='hidden' class='cssItem'   value='".$fila->esPrincipal."'>
                </td>";
*/
                $html.= "<td  >";

                $html.=$botonHtml; 
                $html.= "<td style='width:5px;' >                
                <input type='hidden' id='hiddenPdfIns' class='cssItem' value='".$fila->codigoGenerado."'>
                </td>";
                 $html.= "</td>";
            $html.= "</tr>";

             $i++;
        }
        }
        $html.= "</tbody>";
        $html.= "</table>";
        $html.= "</div>";
        return $html;
} 




function listarImagenEjemplarIns($id, $codigoGenerado, $edit){
        
        $thumb_prefix           = "thumb_"; //Normal thumb Prefix

        $retorno=new Resultado();
        $objImagen = new ImagenLogica();
        $html = "";
        
       /* $html.= "<table class='table table-responsive' style='width:96%;margin-left:15px;' >";
        
        $html.= "<thead>";
        $html.= "<tr>";
        $html.= "<th style='text-align:center;width:30%;'>Fecha</th>";
        $html.= "<th style='text-align:center;width:50%;'>Imagen</th>";
        $html.= "<th style='height:20px; '>...</th>";
        $html.= "</tr>";
        $html.= "</thead>";

        $html.= "</table>";*/
        $html.= "<div  style='overflow-y:auto;overflow-x:hidden; width:96%;margin-left:15px;' >";
        $html.= "<table class='table table-responsive' style='width:100%;margin-left:15px;'>";

        $html.= "<thead>";
        $html.= "<tr>";
        $html.= "<th style='text-align:center;width:30%;'>Fecha</th>";
        $html.= "<th style='text-align:center;width:50%;'>Imagen</th>";
        $html.= "<th style='height:20px; '>...</th>";
        $html.= "</tr>";
        $html.= "</thead>";

        $html.= "<tbody  >";
        

        $datos = $objImagen->buscarSearchInsTMP($id,0, $codigoGenerado);
        if(is_array($datos)){
        foreach ($datos as $key => $fila) {
            $botonHtml="<span class='btnDel btn btn-sm btn-default glyphicon glyphicon-trash' style=' cursor:pointer;'
             onclick=eliminarImg(".$fila->id.",'".$fila->idInscripcion . "','" . $codigoGenerado . "','" . $edit . "'); ></span>";
           /* $isMain=$fila->esPrincipal==1?"SI":"NO";
            $botonHtmlEsprincipal="<label class='btnUpd' onclick=updPrincipal(".$fila->id.",".$fila->esPrincipal.",'".$fila->idCaballo."'); style=' cursor:pointer;' >".$isMain."</label>";
           */
            $html.= "<tr id='" . $fila->id . "_ins_img'>"; 
            $html.= "<label  style='display:none;' >".$fila->id."</label>
                <input type='hidden' class='cssItem'   value='".$fila->id."'>
                <input class='cssItem'  type='hidden'   value='".$res['esNuevo']."'/>
                <label  id='txtEjemplar_".$fila->id."' style='display:none;'  >".$fila->idInscripcion."</label>
                <input type='hidden' class='cssItem'  value='".$fila->idInscripcion."'>";
/*
                $html.= "<td align='center'>
                <label  id='txtRuta_".$fila->id."' >".$fila->ruta."</label>
                <input type='hidden' class='cssItem'  value='".$fila->ruta."'>
                </td>";
*/
            
                $html.= "<td align='left'  >
                <label  id='txtFecha_".$fila->id."' style='padding-right:30px;' >".$fila->fecha."</label>
                <input type='hidden' class='cssItem' value='".$fila->fecha."'>
                </td>";

                $html.= "<td  style='text-align:center;'>
                 <img src='".K_PATHWEB_INS_IMG.$thumb_prefix.$fila->ruta."' alt='Thumbnail' style=' cursor:pointer;'  onclick=mostrarImgGrande('".K_PATHWEB_INS_IMG.$fila->ruta."'); /> 
                </td>";

               /* $html.= "<td  >
                 <img src='".K_PATHWEB.$thumb_prefix.$fila->ruta."' alt='Thumbnail' style=' cursor:pointer;'  onclick=mostrarImgGrande('".K_PATHWEB.$fila->ruta."'); /> 
                </td>";*/

                 $html.= "<td  >";

                $html.=$botonHtml; 
                $html.= "<td  >
                <input type='hidden' id='hiddenImgIns' class='cssItem' value='".$fila->codigoGenerado."'>
                </td>";
                 $html.= "</td>";
            $html.= "</tr>";

             $i++;
        }
        }
        
        $html.= "</tbody>";
        $html.= "</table>";
        $html.= "</div>";
        
        return $html;
}
  function eliminarInsTMP($codigo){
         $retorno=new Resultado();
       // echo $codigo;
        $objImagen = new ImagenLogica();
        $result = $objImagen->eliminarInsTMP($codigo);

        if ($result->result == 1){
            $retorno->result=1;
            $retorno->message = Constantes::K_MENSAJE_DELETE_OK;
        }else if($result->result == 998){
            $retorno->result=998;
            $retorno->message = "No se puede eliminar ya que la inscripción del ejemplar se encuentra aprobada";
        }else if($result->result == 997){
            $retorno->result=997;
            $retorno->message = "No se puede eliminar ya que la inscripción del ejemplar se encuentra rechazada";
        }else{
            $retorno->result=0;
            $retorno->message = Constantes::K_MENSAJE_DELETE_NOOK;
        }
       return json_encode($retorno);
    }
  function listarPdfEjemplarIns($id, $codigoGenerado, $edit){
       $thumb_prefix           = "thumb_"; //Normal thumb Prefix

        $retorno=new Resultado();
        $objImagen = new ImagenLogica();
        $html = "";
      /*  $html.= "<table class='table table-responsive' style='width:96%;' >";
        $html.= "<thead>";
        $html.= "<tr>";
        $html.= "<th style='text-align:center;width:40%;'>Tipo Documento</th>";
        $html.= "<th style='text-align:center;width:20%;'>Fecha</th>";
        $html.= "<th style='width:30%;'>PDF Adjuntado</th>";
        $html.= "<th style='height:20px; '>...</th>";
        $html.= "</tr>";
        $html.= "</thead>";
        $html.= "</table>";*/
        $html.= "<div  style='overflow-y:auto;overflow-x:hidden;width:96%;' >";
        $html.= "<table class='table table-responsive'  style='width:100%;' >";

        $html.= "<thead>";
        $html.= "<tr>";
        $html.= "<th style='text-align:center;width:40%;'>Tipo Documento</th>";
        $html.= "<th style='text-align:center;width:20%;'>Fecha</th>";
        $html.= "<th style='width:30%;'>PDF Adjuntado</th>";
        $html.= "<th style='height:20px; '>...</th>";
        $html.= "</tr>";
        $html.= "</thead>";

        $html.= "<tbody  >";


        $datos = $objImagen->buscarSearchInsTMP($id,1, $codigoGenerado);
        if(is_array($datos)){
        foreach ($datos as $key => $fila) {
            $botonHtml="<span class='btnDel btn btn-sm btn-default glyphicon glyphicon-trash' style='float:right;cursor:pointer;'
             onclick=eliminarPdf(".$fila->id.",'".$fila->idInscripcion. "','" . $codigoGenerado . "','" . $edit . "'); ></span>";
           /* $isMain=$fila->esPrincipal==1?"SI":"NO";
            $botonHtmlEsprincipal="<label class='btnUpd' onclick=updPrincipal(".$fila->id.",".$fila->esPrincipal.",'".$fila->idCaballo."'); style=' cursor:pointer;' >".$isMain."</label>";
           */

            $html.= "<tr id='" . $fila->id . "_ins_pdf'>";
            $html.= "<label style='display:none;'  >".$fila->id."</label>
                <input type='hidden' class='cssItem'   value='".$fila->id."'>
                <input class='cssItem'  type='hidden'   value='".$res['esNuevo']."'/>
                <label  id='txtEjemplar_".$fila->id."' style='display:none;'  >".$fila->idInscripcion."</label>
                <input type='hidden' class='cssItem'  value='".$fila->idInscripcion."'>";
/*          
                $html.= "<td align='center'>
                <label  id='txtRuta_".$fila->id."' >".$fila->ruta."</label>
                <input type='hidden' class='cssItem'  value='".$fila->ruta."'>
                </td>";
*/  
                $html.= "<td align='center' >
                <label  id='txtTipoDocumento_".$fila->id."' >".$fila->idTipoDocumento."</label>
                <input type='hidden' class='cssItem'  value='".$fila->idTipoDocumento."'>
                </td>";
                $html.= "<td  align='center'>
                <label  id='txtFecha_".$fila->id."' >".$fila->fecha."</label>
                <input type='hidden' class='cssItem' value='".$fila->fecha."'>
                </td>";

                $html.= "<td style='text-align:center;' >
                 <img  src='../../../images/icono/pdf.png' alt='Thumbnail' style=' cursor:pointer; width:30px;'  onclick=mostrarImgGrande('".K_PATHWEB_INS_PDF.$fila->ruta."'); /> 
                </td>";

               /* $html.= "<td  >
                 <img  src='images/icono/pdf.png' alt='Thumbnail' style=' cursor:pointer; width:30px;'  onclick=mostrarImgGrande('".K_PATHWEB.$fila->ruta."'); /> 
                </td>";*/
     /*
                $html.= "<td align='center'>
                <label  id='txtActivo_".$fila->id."' >".$botonHtmlEsprincipal."</label>
                <input type='hidden' class='cssItem'   value='".$fila->esPrincipal."'>
                </td>";
*/
                $html.= "<td  >";

                $html.=$botonHtml; 
                $html.= "<td style='width:5px;' >                
                <input type='hidden' id='hiddenPdfIns' class='cssItem' value='".$fila->codigoGenerado."'>
                </td>";
                 $html.= "</td>";
            $html.= "</tr>";

             $i++;
        }
        }
        $html.= "</tbody>";
        $html.= "</table>";
        $html.= "</div>";
        return $html;
}
function eliminarDocumentosINS($codigo, $esPDF)
{
    $retorno = new Resultado();
    $objImagen = new ImagenLogica();
    $result = $objImagen->eliminarDocumentosINS($codigo, $esPDF);

    if ($result == 1) {
        $retorno->result = 1;
        $retorno->message = Constantes::K_MENSAJE_DELETE_OK;
    } else {
        $retorno->result = 0;
        $retorno->message = Constantes::K_MENSAJE_DELETE_NOOK;
    }
    return json_encode($retorno);
} 
?>
