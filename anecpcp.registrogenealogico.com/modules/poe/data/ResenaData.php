<?php
    include_once ("modelo.php");
    /*include_once ("../entidad/Resena.inc.php");
    include_once ("../entidad/Resultado.inc.php");     
    */
    if (file_exists("../../entidad/Resena.inc.php")) include_once("../../entidad/Resena.inc.php");
    if (file_exists("../../entidad/Resultado.inc.php")) include_once("../../entidad/Resultado.inc.php");


    if (file_exists("../entidad/Resena.inc.php")) include_once("../entidad/Resena.inc.php");
    if (file_exists("../entidad/Resultado.inc.php")) include_once("../entidad/Resultado.inc.php");


    class ResenaData extends dal{

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
        public function insertar($descripcion,$usuario_crea){
            $retorno=new Resultado();
            $sql = "CALL SGESI_RESENA('$descripcion','$usuario_crea', @vresultado)";
            //echo $sql;
           $result = parent::ejecutar2($sql,'@vresultado');

            if($result){
                if($fila = mysqli_fetch_array($result)){
                   
                   if($fila[0]==1){
                         $retorno->result=1;
                    }else if($fila[0]==2){
                         $retorno->result=2;
                    }else{
                      $retorno->result=0; 
                    }
               
              }
            }else{
                     $retorno->result=0; 
            }

            return  $retorno;
        }
        //funcion para actualizar un registro
        public function editar($id,$resena,$usuario_modi){
             $retorno=new Resultado();
            $sql = "CALL SGESU_RESENA('$id','$resena','$usuario_modi',@vresultado)";
           //echo $sql ; 
            $result = parent::ejecutar2($sql,'@vresultado');
            if($result){
                if($fila = mysqli_fetch_array($result)){
                   if($fila[0]==1){
                         $retorno->result=1;
                    }else if($fila[0]==2){
                         $retorno->result=2;
                    }else{
                      $retorno->result=0;
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
             //echo $codigo;
            $sql = "CALL SGESD_RESENA('$codigo',@vresultado)";
            //echo $sql;
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
        
        //function para obtener turno
        public function obtenerID($id){
             $retorno=new Resultado();
            $sql = "CALL SGESS_RESENA_X_ID('$id')";
            //echo $sql;
            $result = parent::ejecutar2($sql);
            if($fila = mysqli_fetch_object($result)){
                  $obj = new stdClass();
		              $obj->codigo = $fila->id;
		              $obj->descripcion = $fila->descripcion;
                      $obj->tipo = $fila->tipo;
                      //$obj->telefono = $fila->telefono;
                                   
            }
            return $obj;
	}
        
         
        /*
        autor: dbs - 20160108
        nombre function
            buscarDataTable, solo para la grilla DataTable js.
        */
        public function buscarDataTable(){

            $aColumns=array("id","descripcion",);
            $sIndexColumn="id";
            $sTable="sge_resena";
            return parent::loadDataTable($aColumns,$sIndexColumn,$sTable);
        } 
        

        public function listarCombo($codigo,$descripcion,$tipo){
            $retorno=new Resultado();
            if($codigo=='')$codigo=0;
            $sql = "CALL SGESS_RESENA('$codigo','$descripcion','$tipo')";
           // echo $sql;
            $result = parent::ejecutar2($sql);
            while($fila = mysqli_fetch_object($result)){
                $obj = new ListItem();
                $obj->valor = $fila->id;
                $obj->descripcion = $fila->descripcion;
                $obj->tipo = $fila->tipo;
                $items[] = $obj;
            }
            return $items;
        }
         public function buscarSearch($nomResena,$start,$limit,$sidx,$sord){
            $sql = "CALL SGESS_RESENA_JQGRID('$nomResena','$start','$limit','$sidx','$sord')";
            // echo $sql;
            $result = parent::ejecutar2($sql);
            $resenas=[];
            while($fila = mysqli_fetch_object($result)){
               $obj = new stdClass();
                  $obj->id = $fila->id;
                  $obj->descripcion = $fila->descripcion;
                  $resenas[] = $obj;
            }
            return $resenas;
        }
        public function numeroRegistro($nomResena){
            // $retorno=new Resultado();
            $sql = "CALL SGESS_CUENTA_RESENA_JQGRID('$nomResena')";
            //echo $sql ;
            $result = parent::ejecutar2($sql);
            $num_row=0;
            while ($fila = mysqli_fetch_object($result)){
                $num_row = $fila->num_row;
            }
            return $num_row;
        }
       
    }
?>
