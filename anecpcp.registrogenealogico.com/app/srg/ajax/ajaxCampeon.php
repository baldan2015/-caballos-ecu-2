<?php  session_start();
    include_once ("../logica/CampeonLogica.php");
    include_once ("../entidad/Pelaje.inc");
    include_once ("../entidad/Resultado.inc.php");    

    
    include_once ("../comunes/lib.comun.php"); 
    if (file_exists("../entidad/Constantes.php")) {
        include_once("../entidad/Constantes.php");
    }

    if(isset($_POST["opc"])){
         $retorno=new Resultado();

        if($_POST["opc"]=="ins"){

            $vanio= $_POST["anio"];
            $vprefijo= $_POST["prefijo"];
            $vejemplar= $_POST["ejemplar"];
            $vidEjemplar= $_POST["idEjemplar"];
            $vpropietario= $_POST["propietario"];
            $iesSuperCamp= $_POST["esSuperCamp"];

            echo insertar($vanio,$vprefijo,$vejemplar,$vidEjemplar,$vpropietario,$iesSuperCamp);

        }elseif($_POST["opc"]=="lst"){
            $codigo = $_POST["idEjemplar"];
            echo listarCampeonato($codigo);
        } 
        if($_POST["opc"]=="del"){

            $id= $_POST["keys"];
            
            echo eliminar($id);

        }
    }
    
     
    //Listar almacen por Local
    function listarCampeonato($vejemplar){
        $lis = new CampeonLogica();
        
        $datos = $lis->listar($vejemplar);
        $html="<table border=1 style=' width:100%;  border: 1px solid black; border-collapse: collapse;'>";
        $html.="<tr >";
        $html.="<td class='  btn-primary'>Año del campeonato</td><td class='  btn-primary' style='cursor:hand;' title='Es Campe&oacute;n de Campeones'>C.C</td><td class='  btn-primary'>opc</td>";
        $html.="</tr>";
 
        foreach ($datos as $key => $value) {
            $html.="<tr>";
            $html.="<td>".$datos[$key]->anio."</td><td>".($datos[$key]->esSuperCamp==1?"Si":"No")."</td>";
            $html.="<td><a href='#' title='eliminar registro de campe&oacute;n' onclick='eliminarCamp(".$datos[$key]->id.");'>eliminar</a></td>";
            $html.="</tr>";

        }
        $html.="</table>";

        return $html;
    }
    
    //Insertar
    function insertar($vanio,$vprefijo,$vejemplar,$vidEjemplar,$vpropietario,$iesSuperCamp){
        $retorno=new Resultado();
        if(validarSesion($retorno)->result==1){ 
        $ins = new CampeonLogica();

        $response = $ins->insertar($vanio,$vprefijo,$vejemplar,$vidEjemplar,$vpropietario,$iesSuperCamp);
        $retorno->result=$response->result;
        if ($response->result == 1){
            $retorno->message = Constantes::K_MENSAJE_INSERT_OK;
        }else  
            $retorno->message = Constantes::K_MENSAJE_INSERT_NOOK;
        }
        return json_encode($retorno);
    }

    //Eliminar
    function eliminar($codigo){
         $retorno=new Resultado();
            if(validarSesion($retorno)->result==1){ 
        $objDel = new CampeonLogica();
        $result = $objDel->eliminar($codigo);
        if ($result == 1){
            $retorno->result=1;
            $retorno->message = Constantes::K_MENSAJE_DELETE_OK;
        }else{
            $retorno->result=0;
            $retorno->message = Constantes::K_MENSAJE_DELETE_NOOK;
        }
    }
       return json_encode($retorno);
    }
  
    //Editar
    function editar($codigo,$nombreCorto){
         $retorno=new Resultado();
            if(validarSesion($retorno)->result==1){ 
        $edi = new PelajeLogica();
        $response = $edi->editar($codigo,$nombreCorto);
        if ($response->result == 1){
            $retorno->result=$response->result;
            $retorno->message = Constantes::K_MENSAJE_UPDATE_OK;
        }else if ($response->result == 0){
            $retorno->result=$response->result;
            $retorno->message = Constantes::K_MENSAJE_UPDATE_NOOK;
        }else if ($response->result == 2){
            $retorno->result=0;
            $retorno->message = "El nombre del tipo de documento que desea actualizar ya existe.";
        }
    }
        return json_encode($retorno);
    }
 
?>
