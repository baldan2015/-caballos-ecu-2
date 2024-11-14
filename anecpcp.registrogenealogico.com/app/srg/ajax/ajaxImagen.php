<?php  session_start();
    include_once ("../logica/ImagenLogica.php");
    include_once ("../entidad/Ejemplar.inc.php");
    include_once ("../entidad/Resultado.inc.php");    

     include_once ("../comunes/lib.comun.php");    
     include_once ("../constante.php");  

 
   if (file_exists("../entidad/Constantes.php")) {        include_once("../entidad/Constantes.php");    }
   
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
        }else if($_POST["opc"]=="detDocumentos"){
            $idMonta=$_POST["id"];
            $esPadre=$_POST["genero"];
            echo listarDocumentosMonta($idMonta,$esPadre);
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
             onclick=eliminarImg(".$fila->id.",'".$fila->idCaballo."'); >Eliminar</label>";


            $isMain=$fila->esPrincipal==1?"SI":"NO";
            $botonHtmlEsprincipal="<label class='btnUpd' onclick=updPrincipal(".$fila->id.",".$fila->esPrincipal.",'".$fila->idCaballo."'); style=' cursor:pointer;' >".$isMain."</label>";
             
            $html.= "<tr>";
            

                $html.= "<td align='left' >
                <label  >".$fila->id."</label>
                <input type='hidden' class='cssItem'   value='".$fila->id."'>
                <input class='cssItem'  type='hidden'   value='".$res['esNuevo']."'/>
                </td>";

                $html.= "<td align='left'>
                <label  id='txtEjemplar_".$fila->id."' >".$fila->idCaballo."</label>
                <input type='hidden' class='cssItem'  value='".$fila->idCaballo."'>
                </td>";

                $html.= "<td align='center'>
                <label  id='txtRuta_".$fila->id."' >".$fila->ruta."</label>
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
function listarDocumentosMonta($idMonta,$esPadre)
{
    $objDocumento = new ImagenLogica();

    $datos = $objDocumento->listarDocumentosMonta($idMonta,$esPadre);
    $collection = [];
    $i=0;
    if(is_array($datos)){
        foreach ($datos as $key => $fila) {
           $obj = new stdClass();
           $obj->ruta =  K_PATHWEB_MONTA_PDF.$fila->ruta;
           $obj->idMonta = $fila->idMonta;
           $obj->id =  $fila->id;
           $obj->fecha = $fila->fecha;
           $obj->esPadre = $fila->esPadre;
        $collection[$i] = $obj;
           $i++;

        }
       
    }
    return json_encode($collection);
}
   
?>
