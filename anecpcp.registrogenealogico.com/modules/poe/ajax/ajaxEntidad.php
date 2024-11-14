<?php  session_start();
    include_once ("../logica/EntidadLogica.php");
    include_once ("../entidad/Entidad.inc");
    include_once ("../entidad/Resultado.inc.php");    
    include_once ("../comunes/lib.comun.php");    
    
    include_once ("../comunes/lib.comun.php");   
    if (file_exists("../entidad/Constantes.php")) {
        include_once("../entidad/Constantes.php");
    }
//if(!isset($_POST["opc"]))   echo listarEntidad('','','','','','','');
    
    if(isset($_POST["opc"])){

         $retorno=new Resultado();
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
             $idTipoDoc = $_POST["idTipoDoc"];
             $numDoc = $_POST["numDoc"];
             $nombres=addslashes($_POST["nombres"]);
             $apePaterno=addslashes($_POST["apePaterno"]);
             $apeMaterno=addslashes($_POST["apeMaterno"]);
             $raznSocial=addslashes($_POST["razonSocial"]);
             $correo=$_POST["correo"];

             $nomRazon=$nombres." ".$apePaterno." ".$apeMaterno;

             if($raznSocial==""){
                $razonSocial=$nomRazon;
                echo  listarEntidad($idTipoDoc,$numDoc,$razonSocial,$correo,0,0,0);
             }else if($nomRazon==""){
                $razonSocial=$raznSocial;
                echo  listarEntidad($idTipoDoc,$numDoc,$razonSocial,$correo,0,0,0);
             }
            
        }else if($_POST["opc"]=="ins"){
            $idTipoDoc = $_POST["idTipoDoc"];
            $numDoc = $_POST["numDoc"];
            $apePaterno = addslashes($_POST["apePaterno"]);
            $apeMaterno =addslashes($_POST["apeMaterno"]);
            $razSocial=addslashes($_POST["razonSocial"]);
            $nombres = addslashes($_POST["nombres"]);
            $correo=$_POST["correo"];
            $telefono1 = $_POST["telefono1"];
            $telefono2 = $_POST["telefono2"];
            $observacion = addslashes($_POST["observacion"]);
            $flgSocio=$_POST["esSocio"];
            $flgCriador=$_POST["esCriador"];
            $flgPropietario=$_POST["esPropietario"];
            $idDpto=$_POST["idDpto"];
            $lugarCria=addslashes($_POST["lugarCria"]);
            $prefijo=$_POST["prefijo"];
            $login=$_POST["login"];
            $pwd=$_POST["pwd"];
            $nomRazon=$nombres." ".$apePaterno." ".$apeMaterno;
            if($razSocial==""){
                $razonSocial=$nomRazon;
                echo insertar($idTipoDoc,$numDoc,$apePaterno,$apeMaterno,$nombres,$razonSocial,$correo,$telefono1,$telefono2,$observacion,$usuario_crea,$flgSocio,$flgCriador,$flgPropietario,$idDpto,$lugarCria,$prefijo,$login,$pwd);
            }else if($nombre=="" || $apePaterno=="" || $apeMaterno==""){
                $razonSocial=$razSocial;
                echo insertar($idTipoDoc,$numDoc,$apePaterno,$apeMaterno,$nombres,$razonSocial,$correo,$telefono1,$telefono2,$observacion,$usuario_crea,$flgSocio,$flgCriador,$flgPropietario,$idDpto,$lugarCria,$prefijo,$login,$pwd);
            }
        }else if($_POST["opc"]=="upd"){
            $codigo = $_POST["codigo"];
            $idTipoDoc = $_POST["idTipoDoc"];
            $numDoc = $_POST["numDoc"];
            $apePaterno = addslashes($_POST["apePaterno"]);
            $apeMaterno = addslashes($_POST["apeMaterno"]);
            $razSocial=addslashes($_POST["razonSocial"]);
            $nombres = addslashes($_POST["nombres"]);
            $correo=$_POST["correo"];
            $telefono1 = $_POST["telefono1"];
            $telefono2 = $_POST["telefono2"];
            $observacion = addslashes($_POST["observacion"]);
            $flgSocio=$_POST["esSocio"];
            $flgCriador=$_POST["esCriador"];
            $flgPropietario=$_POST["esPropietario"];
            $flagSituacion=$_POST["situacion"];
            $idPropietario=$_POST["idPropietario"];
            $idDpto=$_POST["idDpto"];
            $lugarCria=addslashes($_POST["lugarCria"]);
            $prefijo=$_POST["prefijo"];
            $login=$_POST["login"];
            $pwd=$_POST["pwd"];
            $nomRazon=$nombres." ".$apePaterno." ".$apeMaterno;
            if($razSocial=="" ){
                $razonSocial=$nomRazon;
                echo editar($codigo,$idTipoDoc,$numDoc,$apePaterno,$apeMaterno,$nombres,$razonSocial,$correo,$telefono1,$telefono2,$observacion,$usuario_modi,$flgSocio,$flgCriador,$flgPropietario,$flagSituacion,$idPropietario,$idDpto,$lugarCria,$prefijo,$login,$pwd);
            }else if($nombre=="" || $apePaterno=="" || $apeMaterno=="") {
                $razonSocial=$razSocial;
                echo editar($codigo,$idTipoDoc,$numDoc,$apePaterno,$apeMaterno,$nombres,$razonSocial,$correo,$telefono1,$telefono2,$observacion,$usuario_modi,$flgSocio,$flgCriador,$flgPropietario,$flagSituacion,$idPropietario,$idDpto,$lugarCria,$prefijo,$login,$pwd);
            }

            
        }elseif ($_POST["opc"]=="bus"){
            echo mostrarAlmacenJSON($codigo,$idTipoDoc,$numDoc,$nombres,$correo,0,0,0,$codigo_empresa);
        }elseif($_POST["opc"]=="del"){
            $codigo = $_POST["key"];
            echo eliminar($codigo,$usuario_modi);
        }elseif($_POST["opc"]=="cod"){
            echo generarCodigo($codigo_empresa);
        }elseif($_POST["opc"]=="get"){
             $codigo = $_POST["key"];
            echo obtenerID($codigo);
        }elseif($_POST["opc"]=="lstAlmDeault"){
            
            if($_SESSION[Constantes::K_SESSION_PERFIL_SEL]=="999"){
                $codigo_local = '';
            }else{
                $codigo_local = $_SESSION[Constantes::K_SESSION_CODIGO_LOCAL];
            }
            echo listarAlmLocal($codigo_local,$codigo_empresa);
        }elseif($_POST["opc"]=="delAll"){
            $codigo = $_POST["keys"];
            echo eliminarVarios($codigo,$usuario_modi);
        }else if($_POST["opc"]=="setEntSession"){

            $retorno=new Resultado();
            $codigo=$_POST["codigo"];
            $nombres=$_POST["nombre"];
            $origen=$_POST["origen"];
            $idProp=$_POST["idProp"];

            if(!(ExisteEntidad($codigo,$origen,$idProp))){
                $result=  agregarEntidad($codigo,$nombres,$origen,$idProp);
                 if($result){                    
                     $retorno->result=1;
                     $retorno->html= listarPreEntidad($origen);
                 }else{
                     $retorno->result=0;
                 }

            }else{
                     $retorno->result=0;
                     $retorno->message="Ya existe el Propietario en la lista";
                     $retorno->html= listarPreEntidad($origen);
            }
               
                
           echo json_encode($retorno);
           
        }else if($_POST["opc"]=="session"){
            echo finalizarSession();
        }else if($_POST["opc"]=="quit"){
           $retorno=new Resultado();
           $origen=$_POST["origen"];
           $esSourceBD=$_POST["esSourceBD"]; /*el item esta en BD o solo temporalmente*/
           $idxArray=$_POST["idxArray"];

           $result=  quitarPreEntidad($_POST['id'],$origen,$esSourceBD,$idxArray);
           if($result){
                    if($origen==1){
                     $retorno->result=1;
                     $retorno->html= listarPreEntidad($origen);
                 }else{
                    $retorno->result=1;
                     $retorno->html= listarPreEntidad($origen);
                 }
             }else{
                     $retorno->result=0;
                }

            echo json_encode($retorno);
        }else if($_POST["opc"]=="lstItemsProp"){
           $codigo="";//$_POST["codigo"];
           $descripcion="";//$_POST["descripcion"];
           echo listarComboProp($codigo,$descripcion);
       }else if($_POST["opc"]=="lstItemsCria"){
           $codigo="";//$_POST["codigo"];
           $descripcion="";//$_POST["descripcion"];
           echo listarComboCria($codigo,$descripcion);
       }else if($_POST["opc"]=="lstItemsEjmpl"){
           $prop=$_POST["prop"];
           $codigo="";//$_POST["codigo"];
           $descripcion="";//$_POST["descripcion"];
           echo listarMisEjemplares($prop);
       }else if($_POST["opc"]=="lstItemsPropTrans"){
           $codigo="";//$_POST["codigo"];
           $descripcion="";//$_POST["descripcion"];
           echo listarComboPropTrans($codigo,$descripcion);
       }else if($_POST["opc"]=="lstItemsEjmplFac"){
           $prop=$_POST["prop"];
           $codigo="";//$_POST["codigo"];
           $descripcion="";//$_POST["descripcion"];
           echo listarComboEjemplarFac($prop);
       }else if($_POST["opc"]=="lstItemsEjmplCas"){
           $prop=$_POST["prop"];
           $codigo="";//$_POST["codigo"];
           $descripcion="";//$_POST["descripcion"];
           echo listarComboEjemplarCas($prop);
       }
    }
    if(isset($_POST["opc"])){
        if($_POST["opc"]=="bus2"){
            $page = $_POST['page'];
            $limit = $_POST['rows'];
            $sidx = $_POST['sidx'];
            $sord = $_POST['sord'];

            $codigo = $_POST["codigo"];
            $idTipoDoc = $_POST["idTipoDoc"];
            $numDoc = $_POST["numDoc"];
            $razonSocial=$_POST["razonSocial"];
            $correo=$_POST["correo"];
            if (!$sidx) $sidx = 1;
            
            echo mostrarAlmacenGrilla($codigo, $idTipoDoc,$numDoc,$razonSocial,$correo,$page, $limit, $sidx, $sord);
        }
    }
    if(isset($_GET["opc"])){
         if($_GET["opc"]=="jqgrid"){
            $response=buscarDatos();
            echo json_encode($response);
         }
    
    }
   
    //Listar pelakes datatable
    function listarEntidad($idTipoDoc,$numDoc,$razonSocial,$correo,$socio,$criador,$propie){
        $retorno=new Resultado();
        $servicio = new EntidadLogica();
        return json_encode($servicio->buscarDataTable());
    };
    //Insertar
    
    function insertar($idTipoDoc,$numDoc,$apePaterno,$apeMaterno,$nombres,$razonSocial,$correo,$telefono1,$telefono2,$observacion,$usuario_crea,$flgSocio,$flgCriador,$flgPropietario,$idDpto,$lugarCria,$prefijo,$login,$pwd){
              $retorno=new Resultado();  
              
        if(validarSesion($retorno)->result==1){ 
        $ins = new EntidadLogica();
       // echo $flgSocio.$flgCriador.$flgPropietario;
        if(strlen($numDoc)>0 or strlen($razonSocial) >0 ){
            
                if($flgSocio=='true'){
                    $flagSocio=1;
                }
                if($flgCriador=='true'){
                    $flagCriador=1;
                }
                if($flgPropietario=='true'){
                    $flagPropietario=1;
                }
                $response = $ins->insertar($idTipoDoc,$numDoc,$apePaterno,$apeMaterno,$nombres,$razonSocial,$correo,$telefono1,$telefono2,$observacion,$usuario_crea,$flagSocio,$flagCriador,$flagPropietario,$idDpto,$lugarCria,$prefijo,$login,$pwd);
                if ($response->result == 1){
                    $retorno->result=$response->result;
                    $retorno->message = Constantes::K_MENSAJE_INSERT_OK;
                }else if ($response->result == 0){
                    $retorno->result=$response->result;
                    $retorno->message = Constantes::K_MENSAJE_INSERT_NOOK;
                }else if ($response->result == 2){
                    $retorno->result=0;
                    $retorno->message = "La entidad ya existe";
                }else if($response->result==999){
                    $retorno->result=999;
                    $retorno->message= "El tipo y el número de documento ya existe";
                }
        }else{
                    $retorno->result=2;
                    $retorno->message = "Ingrese el nombre de la entidad.";

        }
    }
        return json_encode($retorno);
    }

    //Eliminar
    function eliminar($codigo,$usuario_modi){
        $retorno=new Resultado();
        if(validarSesion($retorno)->result==1){
        $objDel = new EntidadLogica();
        $result = $objDel->eliminar($codigo,$usuario_modi);

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
    //ELIMNAR VARIOS ITEMS
     function eliminarVarios($listCodigos,$usuario_modi){
        $retorno=new Resultado();
        if(validarSesion($retorno)->result==1){
        $objDel = new EntidadLogica();
        $c=0;
        foreach ($listCodigos as $key  ) {
            $result = $objDel->eliminar($key,$usuario_modi);
            if ($result == 1) $c++;
            else              $c--;
        }
        if (sizeof($listCodigos) == $c){
            $retorno->result=1;
            $retorno->message = "Se eliminaron correctamente todos los registros";
        }else if(sizeof($listCodigos) > $c){
            $retorno->result=0;
            $retorno->message = "No se eliminaron todos los registros, verifíque";
        }else if($c == 0){
            $retorno->result=0;
            $retorno->message = "No se envió la lista de codigos para eliminar";
        }else{
            $retorno->result=0;
            $retorno->message = "No se pudo eliminar los registros enviados.";

        }
    }
       return json_encode($retorno);
    }
    //Generar codigo
   /* function generarCodigo($codigo_empresa){
        $cod = new AlmacenBR();
        $entity = new Almacen();
        $entity->codigo_empresa = $codigo_empresa;
        $result = $cod->generarCodigo($entity);
        
        return json_encode($result);
    }*/
    //Obtener ID
    function obtenerID($codigo){
        $retorno=new Resultado();
        if(validarSesion($retorno)->result==1){
        $get = new EntidadLogica();
        
       
        $result = $get->obtenerID($codigo);
        if(is_null($result)){
                    $retorno->result=0;
                    $retorno->message="No se encontro datos";
        }else{
                    $retorno->result=1;
                    $retorno->message="dato encontrado";
                    $retorno->data=$result;
        }
    }

        return json_encode($retorno);
    }
    //Buscar
    /*function mostrarAlmacenJSON($codigo,$idTipoDoc,$numDoc,$razonSocial,$correo,$socio,$criador,$propie,$codigo_empresa){
        $bus = new AlmacenBR();
        $entity = new Almacen();
        $entity->codigo = $codigo;
        $entity->idTipoDoc = $idTipoDoc;
        $entity->numDoc = $numDoc;
        $entity->razonSocial=$razonSocial;
        $entity->correo=$correo;
        $entity->codigo_empresa = $codigo_empresa;
        
        $result = $bus->buscar($entity);
        
        return json_encode($result);
    }*/
    //Editar
    function editar($codigo,$idTipoDoc,$numDoc,$apePaterno,$apeMaterno,$nombres,$razonSocial,$correo,$telefono1,$telefono2,$observacion,$usuario_modi,$flgSocio,$flgCriador,$flgPropietario,$flagSituacion,$idPropietario,$idDpto,$lugarCria,$prefijo,$login,$pwd){
        $retorno=new Resultado();
        if(validarSesion($retorno)->result==1){
        $edi = new EntidadLogica();

        if($flgSocio=='true'){
            $flagSocio=1;
        }
        if($flgCriador=='true'){
            $flagCriador=1;
        }
        if($flgPropietario=='true'){
            $flagPropietario=1;
        }
        $response = $edi->editar($codigo,$idTipoDoc,$numDoc,$apePaterno,$apeMaterno,$nombres,$razonSocial,$correo,$telefono1,$telefono2,$observacion,$usuario_modi,$flagSocio,$flagCriador,$flagPropietario,$flagSituacion,$idPropietario,$idDpto,$lugarCria,$prefijo,$login,$pwd);
        if ($response->result == 1){
            $retorno->result=$response->result;
            $retorno->message = Constantes::K_MENSAJE_UPDATE_OK;
        }else if ($response->result == 0){
            $retorno->result=$response->result;
            $retorno->message = Constantes::K_MENSAJE_UPDATE_NOOK;
        }else if ($response->result == 2){
            $retorno->result=0;
            $retorno->message = "La entidad ya esta actualizada";
        }else if($response->result==999){
            $retorno->result=999;
            $retorno->message="El tipo y el número de documento ya existe";   
        }
    }
        return json_encode($retorno);


    }
  
    
    

    function agregarEntidad($codigo,$nombres,$origen,$idProp){
        //echo $codigo.' '.$nombres;
        //echo $origen

        if($codigo==0 && $idProp>0){
                $servicioEnte = new EntidadLogica();
                $codigosEntidad=$servicioEnte->listarIdEntidadXProp($idProp);
                $ids=[];
                foreach ($codigosEntidad as $key => $value) {
                        $ids[]=$value->IdEntidad;
                }
                if(is_array($codigosEntidad)){
                    $codigo=implode("|", $ids);
                }

        }   

        if($origen==1){

        $dataProp=array('codigo'=>0,'nombres'=>$nombres,'origen'=>'TMP','idEntidad'=>$codigo,'idPropietario'=>$idProp);
         $_SESSION['_datosProp'][]=$dataProp; 
        }else{
        $dataCri=array('codigo'=>0,'nombres'=>$nombres,'origen'=>'TMP','idEntidad'=>$codigo);
         $_SESSION['_datosCri'][]=$dataCri;         
        }

        return true;
     //print_r($_SESSION['_datosCri']);
    }
    function listarPreEntidad($origen){
        if($origen==1){
            $entidad= $_SESSION['_datosProp'];    
        }else{
             $entidad= $_SESSION['_datosCri'];    
        }
        $html=listarFilasCriaProp($entidad,$origen);
        return $html;
    }

    function finalizarSession(){
       unset( $_SESSION['_datosProp']);
       unset( $_SESSION['_datosCri']);
       unset( $_SESSION['_datosPropDEL']);
       unset( $_SESSION['_datosCriDEL']);
    }

    function quitarPreEntidad($id,$origen,$esSourceBD,$idxArray){
        if($origen==1){
             //echo"<pre>";
             //print_r($_SESSION['_datosProp'])   ; 
            // echo "---- ".$idxArray;
            $entidad= $_SESSION['_datosProp'];
            //echo "entroooo...";
            if(is_array($entidad)){

                    $_SESSION['_datosPropDEL'][]=$_SESSION['_datosProp'][$idxArray]; 
                    unset ($_SESSION['_datosProp'][$idxArray]);

                /*
                foreach ($entidad as $key =>$value){
                    if($entidad[$key]['idPropietario']==$id){
                    $_SESSION['_datosPropDEL'][]=$_SESSION['_datosProp'][$key]; 
                                   
                    unset ($_SESSION['_datosProp'][$key]);
            
                    }
                } */

            }   
         //   echo"<pre>";
          //  print_r($_SESSION['_datosPropDEL'])   ;
        }else{
            $entidad= $_SESSION['_datosCri'];
            if(is_array($entidad)){
                foreach ($entidad as $key =>$value){
                    if($entidad[$key]['idEntidad']==$id){
                        $_SESSION['_datosCriDEL'][]=$_SESSION['_datosCri'][$key];
                        unset ($_SESSION['_datosCri'][$key]);
                    }
                }
            }
        }
     

    return true;
}
function ExisteEntidad($codigo,$origen,$idProp){

        if($origen==1){
            $entidad=$_SESSION['_datosProp'];         
            if(is_array($entidad)){
                foreach ($entidad as $key => $value) {
                    if($entidad[$key]['idPropietario']==$idProp && $entidad[$key]['idEntidad']==$codigo){
                        return true;
                    }
                } 
            } 
        }else{
            $entidad=$_SESSION['_datosCri'];         
            if(is_array($entidad)){
                foreach ($entidad as $key => $value) {
                    if($entidad[$key]['idEntidad']==$codigo){
                        return true;
                    }
                } 
            } 
    
        }
       return false;

    }
function buscarDatos(){

    $page = $_GET['page']; // Obtiene la petición de la página a mostrar
    $limit = $_GET['rows']; // Obtiene cuantas filas queremos tener dentro de la rejilla
    $sidx = $_GET['sidx']; // Obtiene el campo indice "index" para ordenar los datos
    $sord = $_GET['sord']; // Obtiene la forma de ordenamiento
     
     /*FILTROS DE BUSQUEDA*/
    $id=$_GET['id'];
    $numDoc= $_GET['numDoc']; 
    $nombre=$_GET['nombre'];  
    $rol="";//$_GET['rol'];  
    $estado=$_GET['estado']; 
    $prefijo=$_GET['prefijo']; 
 
    if(!$sidx) $sidx =1;
 
    
     $entidadServicio= new EntidadLogica();
    $count = $entidadServicio->numeroRegistro($id,$numDoc,$nombre,$rol,$estado,$prefijo); 
     
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
     
     $resultado=$entidadServicio->buscarSearch($id,$numDoc,$nombre,$rol,$estado,$prefijo,$start,$limit,$sidx,$sord);
     
     foreach ($resultado as $key => $fila) {
        $responce->rows[$i]['id']=$fila->id;
        $responce->rows[$i]['cell']=array($fila->id,
                                          $fila->nombreCorto,
                                          $fila->numDoc,
                                          $fila->razonSocial,
                                          $fila->prefijo,
                                          $fila->estado,
                                          $fila->esSocio,
                                          $fila->esCriador,
                                          $fila->esPropietario,
                                          $fila->idProps                          
                                          );
        $i++;
     }
 
    // Se devuelven los datos a mostrar en la rejilla   
    return $responce;  


}    



function listarComboProp($codigo,$descripcion){

        $retorno=new Resultado();
        $obj=new EntidadLogica();
        $result = $obj->listarComboProp($codigo,$descripcion);

                    $retorno->result=1;
                    $retorno->message ="";
                    $retorno->data=$result;
       // echo "<pre>";print_r($result);
        return json_encode($retorno);
    }
    function listarComboCria($codigo,$descripcion){

        $retorno=new Resultado();
        $obj=new EntidadLogica();
        $result = $obj->listarComboCria($codigo,$descripcion);

                    $retorno->result=1;
                    $retorno->message = Constantes::K_MENSAJE_INSERT_OK;
                    $retorno->data=$result;
        //echo $result;
        return json_encode($retorno);
    }


    function listarMisEjemplares($prop){

        $retorno=new Resultado();
        $obj=new EntidadLogica();
        $result = $obj->listarMisEjemplares($prop);

                    $retorno->result=1;
                    $retorno->message = '';
                    $retorno->data=$result;
        //echo $result;
        return json_encode($retorno);
    }
    function listarComboPropTrans($codigo,$descripcion){

        $retorno=new Resultado();
        $obj=new EntidadLogica();
        $result = $obj->listarComboPropTrans($codigo,$descripcion);

                    $retorno->result=1;
                    $retorno->message ="";
                    $retorno->data=$result;
       // echo "<pre>";print_r($result);
        return json_encode($retorno);
    }

    function listarComboEjemplarFac($prop){

        $retorno=new Resultado();
        $obj=new EntidadLogica();
        $result = $obj->listarComboEjemplarFac($prop);

                    $retorno->result=1;
                    $retorno->message ="";
                    $retorno->data=$result;
       // echo "<pre>";print_r($result);
        return json_encode($retorno);
    }

    function listarComboEjemplarCas($prop){

        $retorno=new Resultado();
        $obj=new EntidadLogica();
        $result = $obj->listarComboEjemplarCas($prop);

                    $retorno->result=1;
                    $retorno->message ="";
                    $retorno->data=$result;
       // echo "<pre>";print_r($result);
        return json_encode($retorno);
    }
?>
