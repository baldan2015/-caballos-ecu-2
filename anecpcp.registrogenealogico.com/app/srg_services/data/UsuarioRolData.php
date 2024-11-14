<?php
    include_once ("modelo.php");
    include_once ("../entidad/UsuarioRol.inc.php");
    include_once ("../entidad/Resultado.inc.php");     
    
    class UsuarioRolData extends dal{

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
             public $codigo;
        public $descripcion;
        public $telefono;
        public $usuCrea;
        public $fecCrea;
        public $usuModi;
        public $fecModi;

        */
        public function insertar($idUsuario,$idRol,$idOficina,$usuario_crea,$estado){
            $retorno=new Resultado();
            $sql = "CALL SGESI_USUARIO_ROL('$idUsuario','$idRol','$idOficina','$usuario_crea','$estado',@vresultado)";
           //echo $sql;
           // echo "prueba1";
            //echo "1";
           $result = parent::ejecutar2($sql,'@vresultado');
           // $result = parent::ejecutar2($sql,'1');
            if($result){
                if($fila = mysqli_fetch_array($result)){
                  //  print_r($fila);
                   if($fila[0]==1){
                     $retorno->result=1;
                    }else if($fila[0]==2){
                       // echo "5";
                     $retorno->result=2;
                    }else if($fila[0]==3){
                        $retorno->result=3;
                    }
               }
            }else{
                     $retorno->result=0; 
            }

            return  $retorno;
        }

        public function insertarLogin($idUsuario,$login,$pwd,$estado,$usuario_crea){
            $retorno=new Resultado();
            $sql = "CALL SGESI_USUARIO_LOGIN('$idUsuario','$login','$pwd','$estado','$usuario_crea',@vresultado)";
           //echo $sql;
           // echo "prueba1";
            //echo "1";
           $result = parent::ejecutar2($sql,'@vresultado');
           // $result = parent::ejecutar2($sql,'1');
            if($result){
                if($fila = mysqli_fetch_array($result)){
                  //  print_r($fila);
                   if($fila[0]==1){
                     $retorno->result=1;
                    }
               }
            }else{
                     $retorno->result=0; 
            }

            return  $retorno;
        }   

        //editar login y password
        public function editarLogin($idUsuario,$login,$pwd,$estado,$usuario_modi){
             $retorno=new Resultado();
        $sql = "CALL SGESU_USUARIO_LOGIN('$idUsuario','$login','$pwd' ,'$estado','$usuario_modi',@vresultado)";
            //echo $sql ; 
            $result = parent::ejecutar2($sql,'@vresultado');
            //echo "1";
            if($result){
               // echo "2";
                if($fila = mysqli_fetch_array($result)){
                   // echo "3";
                   //print_r($fila);
                   if($fila[0]==1){
                    //echo "4";
                     $retorno->result=1;
                    }
               }
            }else{
                     $retorno->result=0; 
            }
            return  $retorno;
        }

        //funcion para actualizar un registro
        public function editar($codigo,$idUsuario,$idOficina,$estado,$usuario_modi){
             $retorno=new Resultado();
    $sql = "CALL SGESU_USUARIO_ROL('$codigo','$idUsuario','$idOficina' ,'$estado','$usuario_modi',@vresultado)";
            //echo $sql ; 
            $result = parent::ejecutar2($sql,'@vresultado');
            //echo "1";
            if($result){
               // echo "2";
                if($fila = mysqli_fetch_array($result)){
                   // echo "3";
                   //print_r($fila);
                   if($fila[0]==1){
                    //echo "4";
                     $retorno->result=1;
                    }else if($fila[0]==2){
                       // echo "5";
                     $retorno->result=2;
                    }
               }
            }else{
                     $retorno->result=0; 
            }
            return  $retorno;
        }
        //funcion para eliminar un registro
        public function eliminar($id){
             $retorno=new Resultado();
            $sql = "CALL SGESD_USUARIO_ROL('$id')";
            //echo $sql;
            $result = parent::ejecutar2($sql);
            if($result){
                return true;
            }else{
                return false;
            }
        }
        
        //function para obtener turno
        public function obtenerID($id){
             $retorno=new Resultado();
            $sql = "CALL SGESS_USUARIO_ROL_X_ID('$id')";
           //echo $sql;
            $result = parent::ejecutar2($sql);
            if($fila = mysqli_fetch_object($result)){
                  $obj = new UsuarioRol();
                      $obj->id=$fila->id;
		              $obj->idUsuario = $fila->idUsuario;
		              $obj->idRol = $fila->idRol;
                      $obj->idOficina = $fila->idOficina;
                      $obj->estado = $fila->estado;
                      $obj->idEnt=$fila->idEntidad;
                      $obj->Usuario=$fila->Usuario;
                      $obj->Password=$fila->Password;
            }
            return $obj;
	}
        //function para buscar
        public function buscar(){
             $retorno=new Resultado();
            $sql = "CALL SGESS_EJEMPLAR('')";
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
        //function para generar un nuevo codigo
        public function generarCodigo($entity){
             $retorno=new Resultado();
            $sql = "CALL SGFSS_TURNO_CODIGO('$entity->codigo_empresa')";
            $result = parent::ejecutar2($sql);
            while($fila = mysqli_fetch_object($result)){
                $obj = new Turno();
                $obj->codigoNuevo = $fila->codigoNuevo;
            }
            return $obj;
        }
       /* public function numeroRegistro($codigo,$descripcion,$codigo_empresa){
             $retorno=new Resultado();
            $sql = "CALL SGFSS_CUENTA_TURNO('$codigo','$descripcion','$codigo_empresa')";
            $result = parent::ejecutar2($sql);
            $num_row=0;
            while ($fila = mysqli_fetch_object($result)){
                $num_row = $fila->num_row;
            }
            return $num_row;
        }*//*
        public function buscarSearch($entity, $start , $limit,$sidx,$sord){
            $sql = "CALL SGFSS_TURNO_SEARCH("
                    ."'$entity->codigo',"
                    ."'$entity->descripcion',"
                    ."'$entity->codigo_empresa',"
                    ."'$start' ,"
                    ."'$limit',"
                    ."'$sidx',"
                    ."'$sord')";
            $result = parent::ejecutar2($sql);
            
            while($fila = mysqli_fetch_object($result)){
                $obj = new Turno();
                $obj->codigo = $fila->codigo;
                $obj->descripcion = $fila->descripcion;
                $obj->hora_inicio = $fila->hora_inicio;
                $obj->hora_fin = $fila->hora_fin;
                $turno[] = $obj;
            }
            return $turno;
        }*/
        public function validarEliminar($entity){
             $retorno=new Resultado();
            $sql = "CALL SGFSS_VALIDAR_TURNO('$entity->codigo')";
            $result = parent::ejecutar2($sql);
            
            $fila = mysqli_fetch_object($result);
            $num = $fila->numReg;
            
            return $num;
        }

        /*
        autor: dbs - 20160108
        nombre function
            buscarDataTable, solo para la grilla DataTable js.
        */
       
       public function buscarMadre($nombre){

            $sql = "CALL SGESS_LIST_MADRE('$nombre')";
            //echo $sql;
            $result = parent::ejecutar2($sql);
            
            while($fila = mysqli_fetch_object($result)){
                $obj = new Ejemplar();
                $obj->codigo = $fila->id;
                $obj->prefijo = $fila->prefijo;
                $obj->nombre = $fila->nombre;
                $obj->fecNace = $fila->fecNace;
                $obj->idPelaje = $fila->pelaje;
                $prop[] = $obj;
            }
            return $prop;
        }
        public function buscarPadre($nombre){

            $sql = "CALL SGESS_LIST_PADRE('$nombre')";
            //echo $sql;
            $result = parent::ejecutar2($sql);
            
            while($fila = mysqli_fetch_object($result)){
                $obj = new Ejemplar();
                $obj->codigo = $fila->id;
                $obj->prefijo = $fila->prefijo;
                $obj->nombre = $fila->nombre;
                $obj->fecNace = $fila->fecNace;
                $obj->idPelaje = $fila->pelaje;
                $prop[] = $obj;
            }
            return $prop;
        }

        public function numeroRegistro($nomUsu,$nomOfic){
            // $retorno=new Resultado();
            $sql = "CALL SGESS_CUENTA_USUARIO_ROL_JQGRID('$nomUsu','$nomOfic')";
            //echo $sql ;
            $result = parent::ejecutar2($sql);
            $num_row=0;
            while ($fila = mysqli_fetch_object($result)){
                $num_row = $fila->num_row;
            }
            return $num_row;
        }
        public function buscarSearch($nomUsu,$nomOfic,$start,$limit,$sidx,$sord){
            //$retorno=new Resultado();
            $sql = "CALL SGESS_USUARIO_ROL_JQGRID('$nomUsu','$nomOfic','$start','$limit','$sidx','$sord')";
             //echo $sql;
            $result = parent::ejecutar2($sql);
            $roles=[];
            while($fila = mysqli_fetch_object($result)){
               $obj = new stdClass();
                  $obj->id = $fila->id;
                  $obj->usuario = $fila->usuario;
                  $obj->rol=$fila->rol;
                  $obj->oficina=$fila->oficina;
                  $obj->estado=$fila->estado;
                  $roles[] = $obj;
            }
            return $roles;
        }
        public function listarComboTipoRol($id,$descripcion){
            $retorno=new Resultado();
            $sql = "CALL SGESS_TIPO_ROL_CBO('$id','$descripcion')";
           // echo $sql;
            $result = parent::ejecutar2($sql);
            while($fila = mysqli_fetch_object($result)){
                $obj = new ListItem();
                $obj->valor = $fila->id;
                $obj->descripcion = $fila->descripcion;
                //$obj->nombreLargo = $fila->nombreLargo;
                $turno[] = $obj;
            }
            return $turno;
        }
         public function listarComboUsuario($id,$descripcion){
            $retorno=new Resultado();
            $sql = "CALL SGESS_USUARIO_CBO('$id','$descripcion')";
           // echo $sql;
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
    }
?>
