<?php
    include_once ("modelo.php");
    include_once ("../entidad/SelectedItems.php");
    include_once ("../entidad/Resultado.inc.php");      
    
    class UsuarioData extends dal{

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
       
        //funcion para act
        //funcion para actualizar un registro
        
        //funcion para eliminar un registro
       
	

        public function listarComboUsuario($codigo,$descripcion){
            $retorno=new Resultado();
            $sql = "CALL SGESS_TIPO_USUARIO_CBO('$codigo','$descripcion')";
          // echo $sql;
            $result = parent::ejecutar2($sql);
            while($fila = mysqli_fetch_object($result)){
                $obj = new ListItem();
                $obj->valor = $fila->idEntidad;
                $obj->descripcion = $fila->Usuario;
                //$obj->nombreLargo = $fila->nombreLargo;
                $turno[] = $obj;
            }
            return $turno;
        }

         public function listarComboRol($codigo,$descripcion){
            $retorno=new Resultado();
            $sql = "CALL SGESS_TIPO_ROL_CBO('$codigo','$descripcion')";
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
    }
?>
