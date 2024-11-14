<?php
    include_once ("modelo.php");
    include_once ("../entidad/Usuarios.inc");
    include_once ("../entidad/Resultado.inc.php");      
    
    class UsuariosData extends dal{

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
            $nombre: nombre del Usuarios obligatorio y no debe repetirse
        parametro de retorno
            $retorno->result: [0 1 2]
            0=error en el ejecucion del store
            1=inserto ok
            2=no inserto. Ya existe el parametro nombre como data/
        */
        public function insertar($descripcion,$telefono,$usuario_crea){
            $retorno=new Resultado();
            $sql = "CALL SGESI_USUARIO('$descripcion','$telefono','$usuario_crea', @vresultado)";
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
                    }else{
                     $retorno->result=0;
                    }
               }
            }else{
                     $retorno->result=0; 
            }

            return  $retorno;
        }
        //funcion para act
        //funcion para actualizar un registro
        public function editar($codigo,$nombre){
             $retorno=new Resultado();
            $sql = "CALL SGESU_Usuarios('$codigo','$nombre',@vresultado)";
            $result = parent::ejecutar2($sql,'@vresultado');
            if($result){
                if($fila = mysqli_fetch_array($result)){
                   if($fila[0]==1){
                     $retorno->result=1;
                    }else{
                     $retorno->result=2;
                    }
               }
            }else{
                     $retorno->result=0; 
            }
            return  $retorno;
        }
        //funcion para eliminar un registro
        public function eliminar($codigo){
             $retorno=new Resultado();
            $sql = "CALL SGESD_Usuarios('$codigo')";
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
            $sql = "CALL SGESS_Usuarios_X_ID('$codigo')";
            $result = parent::ejecutar2($sql);
            if($fila = mysqli_fetch_object($result)){
                  $obj = new Usuarios();
		          $obj->codigo = $fila->id;
		          $obj->nombre = $fila->nombre;
            }
            return $obj;
	}
        //function para buscar
        public function buscar($entity){
             $retorno=new Resultado();
            $sql = "CALL SGESS_Usuarios('')";
            $result = parent::ejecutar2($sql);
            while($fila = mysqli_fetch_object($result)){
                $obj = new Usuarios();
                $obj->codigo = $fila->id;
                $obj->nombre = $fila->nombre;
                $turno[] = $obj;
            }
            return $turno;
        }
        //function para generar un nuevo codigo
        public function generarCodigo($entity){
            $sql = "CALL SGFSS_TURNO_CODIGO('$entity->codigo_empresa')";
            $result = parent::ejecutar2($sql);
            while($fila = mysqli_fetch_object($result)){
                $obj = new Turno();
                $obj->codigoNuevo = $fila->codigoNuevo;
            }
            return $obj;
        }
        public function numeroRegistro($codigo,$descripcion,$codigo_empresa){
            $sql = "CALL SGFSS_CUENTA_TURNO('$codigo','$descripcion','$codigo_empresa')";
            $result = parent::ejecutar2($sql);
            $num_row=0;
            while ($fila = mysqli_fetch_object($result)){
                $num_row = $fila->num_row;
            }
            return $num_row;
        }
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
        }
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
        public function buscarDataTable(){
             $retorno=new Resultado();
            $aColumns=array("id","nombre");
            $sIndexColumn="id";
            $sTable="sge_Usuarios";
            return parent::loadDataTable($aColumns,$sIndexColumn,$sTable);
        }

        public function listarComboTipoUsuarios($codigo,$descripcion){
            $retorno=new Resultado();
            $sql = "CALL SGESS_TIPO_Usuarios_CBO('$codigo','$descripcion')";
           // echo $sql;
            $result = parent::ejecutar2($sql);
            while($fila = mysqli_fetch_object($result)){
                $obj = new ListItem();
                $obj->valor = $fila->id;
                $obj->descripcion = $fila->nombre;
                //$obj->nombreLargo = $fila->nombreLargo;
                $turno[] = $obj;
            }
            return $turno;
        }
    }
?>
