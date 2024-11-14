<?php
    include_once ("modelo.php");
    //include_once ("../entidad/Entidad.inc");
    //include_once ("../entidad/Resultado.inc.php");      
    if (file_exists("../../entidad/Entidad.inc"))include_once("../../entidad/Entidad.inc");
    if (file_exists("../../entidad/Resultado.inc.php")) include_once("../../entidad/Resultado.inc.php");

    if (file_exists("../entidad/Entidad.inc"))include_once("../entidad/Entidad.inc");
    if (file_exists("../entidad/Resultado.inc.php")) include_once("../entidad/Resultado.inc.php");


    class EntidadData extends dal{

        public $retorno;
          function __construct(){
            parent::dal();
            $retorno=new Resultado();
        }

        /*
        autor: dbs - 20160725
        nombre function
            insertar
        parametro entrada
            $nombre: nombre del pelaje obligatorio y no debe repetirse
        parametro de retorno
            $retorno->result: [0 1 2]
            0=error en el ejecucion del store
            1=inserto ok
            2=no inserto. Ya existe el parametro nombre como data/
        */
        public function insertar($idTipoDoc,$numDoc,$apePaterno,$apeMaterno,$nombres,$razonSocial,$correo,$telefono1,$telefono2,$observacion,$usuCrea,$flagSocio,$flagCriador,$flagPropietario,$idDpto,$lugarCria,$prefijo,$login,$pwd){


            $retorno=new Resultado();
            
            $sql = "CALL SGESI_ENTIDAD('$idTipoDoc','$numDoc','$apePaterno','$apeMaterno','$nombres','$razonSocial','$correo','$telefono1','$telefono2','$observacion','$usuCrea','$flagSocio','$flagCriador','$flagPropietario','$idDpto','$lugarCria','$prefijo','$login','$pwd',@vresultado)";
         //   echo $sql;
            $result = parent::ejecutar2($sql,'@vresultado');
            if($result){
                if($fila = mysqli_fetch_array($result)){

                   if($fila[0]==1){
                     $retorno->result=1;
                    }else if($fila[0]==2){
                     $retorno->result=2;
                    }else{
                        $retorno->result=999;
                    }
               }
            }else{
                     $retorno->result=0; 
            }

            return  $retorno;
        }
        //funcion para actualizar un registro
        public function editar($codigo,$idTipoDoc,$numDoc,$apePaterno,$apeMaterno,$nombres,$razonSocial,$correo,$telefono1,$telefono2,$observacion,$usuModi,$flagSocio,$flagCriador,$flagPropietario,$flagSituacion,$idPropietario,$idDpto,$lugarCria,$prefijo,$login,$pwd){
            $retorno=new Resultado();
        $sql = "CALL SGESU_ENTIDAD('$codigo','$idTipoDoc','$numDoc','$apePaterno','$apeMaterno','$nombres','$razonSocial','$correo','$telefono1','$telefono2','$observacion','$usuModi','$flagSocio','$flagCriador','$flagPropietario','$flagSituacion','$idPropietario','$idDpto','$lugarCria','$prefijo','$login','$pwd',@vresultado)";
           //echo $sql ; 
            $result = parent::ejecutar2($sql,'@vresultado');
            //echo "1";
            if($result){
               // echo "2";
                if($fila = mysqli_fetch_array($result)){
                    //echo "3";
                   //echo "s...".$fila[0];
                   if($fila[0]==1){
                    //echo "4";
                     $retorno->result=1;
                    }else if($fila[0]==2){
                      //  echo "5";
                     $retorno->result=2;
                    }else if($fila[0]==999){
                      //echo "   6";
                     $retorno->result=999;   
                    }
               }
            }else{
                     $retorno->result=0; 
            }
            return  $retorno;
        }
        //funcion para eliminar un registro
        public function eliminar($codigo,$usuModi){
            $retorno=new Resultado();
            $sql = "CALL SGESD_ENTIDAD('$codigo','$usuModi')";
            $result = parent::ejecutar2($sql);
            if($result){
                return true;
            }else{
                return false;
            }
        }
        //function para obtener turno
        public function obtenerID($codigo){
            $retorno=new Resultado();
            $sql = "CALL SGESS_ENTIDAD_X_ID('$codigo')";
            $result = parent::ejecutar2($sql);
            if($fila = mysqli_fetch_object($result)){
                  $obj = new Entidad();
		          $obj->codigo = $fila->id;
		          $obj->idTipoDoc = $fila->idTipoDoc;
                  $obj->numDoc = $fila->numDoc;
                  $obj->apePaterno=$fila->apePaterno;
                  $obj->apeMaterno=$fila->apeMaterno;
                  $obj->nombres = $fila->nombres;
                  $obj->razonSocial=$fila->razonSocial;
                  $obj->correo = $fila->correo;
                  $obj->telefono1=$fila->telefono1;
                  $obj->telefono2=$fila->telefono2;
                  $obj->observacion=$fila->observacion;
                  $obj->flagSocio=$fila->esSocio!=0?1:0;
                  $obj->flagCriador=$fila->esCriador!=0?1:0;
                  $obj->flagPropietario=$fila->esPropietario!=0?1:0;
                  $obj->fecEliminado=$fila->fecEliminado;
                  $obj->flagSituacion=$fila->fecEliminado==null?"A":"I";
                  $obj->idPropietario=$fila->idPropietario;
                  $obj->idDpto=$fila->idDpto;
                  $obj->lugarCria=$fila->lugarCria;
                  $obj->prefijo=$fila->prefijo;
                  $obj->login=$fila->login;
                  $obj->password=$fila->password;
            }
               // echo $sql;
            return $obj;
	}
        //function para buscar
        public function buscar(){
            $retorno=new Resultado();
            $sql = "CALL SGESS_ENTIDAD('')";
            $result = parent::ejecutar2($sql);
            while($fila = mysqli_fetch_object($result)){
                $obj = new Entidad();
                $obj->codigo = $fila->id;
                //$obj->nombreCorto = $fila->nombreCorto;
                //$obj->nombreLargo = $fila->nombreLargo;
                $turno[] = $obj;
            }
            return $turno;
        }
       

        /*
        autor: dbs - 20160108
        nombre function
            buscarDataTable, solo para la grilla DataTable js.
        */
        public function buscarDataTable(){
            $retorno=new Resultado();
            $aColumns=array("id","nombreCorto","numDoc","razonSocial","correo","estado","esSocio","esCriador","esPropietario");
            $sIndexColumn="id";
            $sTable="sgev_entidad";
            return parent::loadDataTable($aColumns,$sIndexColumn,$sTable);
        } 
     public function buscarPropietario($nombre){

            $sql = "CALL SGESS_LIST_PROP('$nombre')";
            //echo $sql;
            $result = parent::ejecutar2($sql);
            
            while($fila = mysqli_fetch_object($result)){
                $obj = new Entidad();
                $obj->codigo = $fila->id;
                $obj->idTipoDoc = $fila->idTipoDoc;
                $obj->numDoc = $fila->numDoc;
                $obj->razonSocial = $fila->razonSocial;
                $obj->correo = $fila->correo;
                $obj->telefono1 = $fila->telefono1;
                $obj->idPropietario = $fila->idProp;

                $prop[] = $obj;
            }
            return $prop;
        }
        public function buscarCriador($nombre){

            $sql = "CALL SGESS_LIST_CRIAD('$nombre')";
            //echo $sql;
            $result = parent::ejecutar2($sql);
            
            while($fila = mysqli_fetch_object($result)){
                $obj = new Entidad();
                $obj->codigo = $fila->id;
                $obj->idTipoDoc = $fila->idTipoDoc;
                $obj->numDoc = $fila->numDoc;
                $obj->razonSocial = $fila->razonSocial;
                $obj->correo = $fila->correo;
                $obj->telefono1 = $fila->telefono1;
                $prop[] = $obj;
            }
            return $prop;
        }
        public function insertarPropietario($idProp,$idEntidad,$usuCrea,$evalExists,$esCooProp='0'){
            $retorno=new Resultado();
            $sql = "CALL SGESI_PROPIETARIO('$idProp','$idEntidad','$usuCrea','$evalExists','$esCooProp',@vresultado)";
           // echo $sql;
            $result = parent::ejecutar2($sql,'@vresultado');
            if($result){
                if($fila = mysqli_fetch_array($result)){

                   if($fila[0]>0){
                     $retorno->result=1;
                     $retorno->code=$fila[0];
                    }else if($fila[0]==-2){
                     $retorno->result=2;
                    }else{
                        $retorno->result=999;
                    }
               }
            }else{
                     $retorno->result=0; 
            }

            return  $retorno;
        }
        public function insertarCoPropietario($idProp,$idEntidad,$usuCrea,$idCoProp){
            $retorno=new Resultado();
            $sql = "CALL SGESI_COPROPIETARIO('$idProp','$idEntidad','$usuCrea','$idCoProp',@vresultado)";
           // echo $sql;
            $result = parent::ejecutar2($sql,'@vresultado');
            if($result){
                if($fila = mysqli_fetch_array($result)){

                   if($fila[0]>0){
                     $retorno->result=1;
                     $retorno->code=$fila[0];
                    }else if($fila[0]==-2){
                     $retorno->result=2;
                    }else{
                        $retorno->result=999;
                    }
               }
            }else{
                     $retorno->result=0; 
            }

            return  $retorno;
        }
         
         public function numeroRegistro($id,$numDoc,$nombre,$rol,$estado,$prefijo){
            // $retorno=new Resultado();
          if($id=='')$id=0;
            $sql = "CALL SGESS_CUENTA_ENTIDAD_JQGRID('$id','$numDoc','$nombre','$rol','$estado','$prefijo')";
           // echo $sql ;
            $result = parent::ejecutar2($sql);
            $num_row=0;
            while ($fila = mysqli_fetch_object($result)){
                $num_row = $fila->num_row;
            }
            return $num_row;
        }
        public function buscarSearch($id,$numDoc,$nombre,$rol,$estado,$prefijo,$start,$limit,$sidx,$sord){
          if($id=='')$id=0;
            $sql = "CALL SGESS_ENTIDAD_JQGRID('$id','$numDoc','$nombre','$rol','$estado','$prefijo','$start','$limit','$sidx','$sord')";
           
            $result = parent::ejecutar2($sql);
            $entidades=[];
            while($fila = mysqli_fetch_object($result)){
               $obj = new stdClass();

                  $obj->id = $fila->id;
                  $obj->nombreCorto = $fila->nombreCorto;
                  $obj->numDoc = $fila->numDoc;
                  $obj->razonSocial=$fila->razonSocial;
                  $obj->prefijo=$fila->prefijo;
                  $obj->correo=$fila->correo;
                  $obj->estado=$fila->estado;
                  $obj->esSocio=$fila->esSocio;
                  $obj->esCriador=$fila->esCriador;
                  $obj->esPropietario=$fila->esPropietario;
                  $obj->idProps=$fila->idProps;
                  
                $entidades[] = $obj;
            }
            return $entidades;
        }

        /*-----------------------------Busqueda a Propietario------------*/
        public function numeroRegistroGralEntidadProp($nomFiltro){
             $retorno=new Resultado();
            $sql = "CALL SGESS_CUENTA_LIST_PROP('$nomFiltro')";
          // echo $sql ;
            $result = parent::ejecutar2($sql);
            $num_row=0;
            while ($fila = mysqli_fetch_object($result)){
                $num_row = $fila->num_row;
            }
            return $num_row;
        }
        public function buscarSearchGralEntidadProp($nomFiltro,$start,$limit,$sidx,$sord){
            //$retorno=new Resultado();
            $sql = "CALL SGESS_LIST_PROP_JQGRID('$nomFiltro','$start','$limit','$sidx','$sord')";
           //echo $sql;
            $result = parent::ejecutar2($sql);
            
            while($fila = mysqli_fetch_object($result)){
               $obj = new stdClass();
                  $obj->id = $fila->id;
                  $obj->idProp=$fila->idProp;
                  $obj->nombre= $fila->razonSocial;
                  $obj->prefijo=$fila->prefijo;
                  $propietarios[] = $obj;
            }
            return $propietarios;
        }
       /*-----------------------------------------------------------*/

        /*----------------------Busqueda Gral Cria--------------------*/
        public function buscarSearchGralEntidadCria($nomFiltro,$start,$limit,$sidx,$sord){
            //$retorno=new Resultado();
            $sql = "CALL SGESS_LIST_CRIAD_JQGRID('$nomFiltro','$start','$limit','$sidx','$sord')";
           // echo $sql;
            $result = parent::ejecutar2($sql);
            
            while($fila = mysqli_fetch_object($result)){
               $obj = new stdClass();
                  $obj->id = $fila->id;
                  $obj->idCria=$fila->idCria;
                  $obj->nombre= $fila->razonSocial;
                  $obj->prefijo=$fila->prefijo;
                  $entidades[] = $obj;
            }
            return $entidades;
        }
        public function numeroRegistroGralEntidadCria($nomFiltro){
             $retorno=new Resultado();
            $sql = "CALL SGESS_CUENTA_LIST_CRIAD('$nomFiltro')";
           // echo $sql ;
            $result = parent::ejecutar2($sql);
            $num_row=0;
            while ($fila = mysqli_fetch_object($result)){
                $num_row = $fila->num_row;
            }
            return $num_row;
        }
        /*------------------------Fin de busqueda Gral Cria---------------------------*/
        public function listarComboProp($codigo,$descripcion){
            $retorno=new Resultado();
            if($codigo=='')$codigo=0;
            $sql = "CALL SGESS_TIPO_PROPIETARIO_CBO('$codigo','$descripcion')";
           //echo $sql;
            
             $turno=[];
            $result = parent::ejecutar2($sql);
            while($fila = mysqli_fetch_object($result)){
                $obj = new ListItem();
                $obj->valor = $fila->IdEntidad;
                $obj->descripcion = $fila->razonSocial;
                //$obj->nombreLargo = $fila->nombreLargo;
                $turno[] = $obj;
            }
            return $turno;
        }
        public function listarComboCria($codigo,$descripcion){
            $retorno=new Resultado();
            if($codigo=='')$codigo=0;
            $sql = "CALL SGESS_TIPO_CRIADOR_CBO('$codigo','$descripcion')";
           // echo $sql;
                  $turno=[];
            $result = parent::ejecutar2($sql);
            while($fila = mysqli_fetch_object($result)){
                $obj = new ListItem();
                $obj->valor = $fila->id;
                $obj->descripcion = $fila->razonSocial;
                //$obj->nombreLargo = $fila->nombreLargo;
                $turno[] = $obj;
            }
            return $turno;
        }
        public function listarIdEntidadXProp($idPropietario){
            $retorno=new Resultado();
            $sql = "CALL SGESS_CODIGOS_ENTIDAD_PROP('$idPropietario')";
           // echo $sql;
            $dato=[];
            $result = parent::ejecutar2($sql);
            while($fila = mysqli_fetch_object($result)){
                $obj = new stdClass();
                $obj->idProp = $fila->idProp;
                $obj->IdEntidad = $fila->IdEntidad;
                $obj->flgTipo = $fila->flgTipo;
                $dato[] = $obj;
            }
            return $dato;
        }

        public function listarMisEjemplares($prop){
            $retorno=new Resultado();
            $sql = "CALL SGESS_MI_PROPIEDAD_ITEMS_CBO_TRANS('$prop')";
            //echo $sql;
            $dato=[];
            $result = parent::ejecutar2($sql);
            while($fila = mysqli_fetch_object($result)){
                $obj = new stdClass();
                $obj->valor = $fila->id;
                $obj->descripcion = $fila->descripcion;
                $dato[] = $obj;
            }
            return $dato;
        }

        public function listarComboPropTrans($codigo,$descripcion){
            $retorno=new Resultado();
            if($codigo=='')$codigo=0;
            $sql = "CALL SGESS_TIPO_PROPIETARIO_CBO_TRANS('$codigo','$descripcion')";
           //echo $sql;
            
             $turno=[];
            $result = parent::ejecutar2($sql);
            while($fila = mysqli_fetch_object($result)){
                $obj = new ListItem();
                $obj->valor = $fila->IdEntidad;
                $obj->descripcion = $fila->razonSocial;
                //$obj->nombreLargo = $fila->nombreLargo;
                $turno[] = $obj;
            }
            return $turno;
        }

        public function listarComboEjemplarFac($prop){
            $retorno=new Resultado();
            $sql = "CALL SGESS_MI_PROPIEDAD_ITEMS_CBO_FA('$prop')";
            //echo $sql;
            $dato=[];
            $result = parent::ejecutar2($sql);
            while($fila = mysqli_fetch_object($result)){
                $obj = new stdClass();
                $obj->valor = $fila->id;
                $obj->descripcion = $fila->descripcion;
                $dato[] = $obj;
            }
            return $dato;
        }
        public function listarComboEjemplarCas($prop){
            $retorno=new Resultado();
            $sql = "CALL SGESS_MI_PROPIEDAD_ITEMS_CBO_CA('$prop')";
            //echo $sql;
            $dato=[];
            $result = parent::ejecutar2($sql);
            while($fila = mysqli_fetch_object($result)){
                $obj = new stdClass();
                $obj->valor = $fila->id;
                $obj->descripcion = $fila->descripcion;
                $dato[] = $obj;
            }
            return $dato;
        }
    }
?>
