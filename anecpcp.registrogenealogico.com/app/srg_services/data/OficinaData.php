<?php
    include_once ("modelo.php");
    include_once ("../entidad/oficina.inc.php");
    include_once ("../entidad/Resultado.inc.php");     
    
    class OficinaData extends dal{

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
        public function insertar($descripcion,$telefono,$usuario_crea){
            $retorno=new Resultado();
            $sql = "CALL SGESI_OFICINA('$descripcion','$telefono','$usuario_crea', @vresultado)";
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
        //funcion para actualizar un registro
        public function editar($id,$descripcion,$telefono,$usuModi){
             $retorno=new Resultado();
        $sql = "CALL SGESU_OFICINA('$id','$descripcion','$telefono','$usuModi',@vresultado)";
           // echo $sql ; 
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
        public function eliminar($codigo,$usuModi){
             $retorno=new Resultado();
            $sql = "CALL SGESD_OFICINA('$codigo','$usuModi')";
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
            $sql = "CALL SGESS_OFICINA_X_ID('$id')";
            //echo $sql;
            $result = parent::ejecutar2($sql);
            if($fila = mysqli_fetch_object($result)){
                  $obj = new oficina();
		              $obj->codigo = $fila->id;
		              $obj->descripcion = $fila->descripcion;
                      $obj->telefono = $fila->telefono;
                      $obj->estado = $fila->estado;
                                   
            }
            return $obj;
	}
         
        
        public function validarEliminar($entity){
             $retorno=new Resultado();
            $sql = "CALL SGFSS_VALIDAR_TURNO('$entity->codigo')";
            $result = parent::ejecutar2($sql);
            
            $fila = mysqli_fetch_object($result);
            $num = $fila->numReg;
            
            return $num;
        }

        

            public function numeroRegistro($nomOficina){
            // $retorno=new Resultado();
            $sql = "CALL SGESS_CUENTA_OFICINA_JQGRID('$nomOficina')";
            //echo $sql ;
            $result = parent::ejecutar2($sql);
            $num_row=0;
            while ($fila = mysqli_fetch_object($result)){
                $num_row = $fila->num_row;
            }
            return $num_row;
        }
        public function buscarSearch($nomOficina,$start,$limit,$sidx,$sord){
            $sql = "CALL SGESS_OFICINA_JQGRID('$nomOficina','$start','$limit','$sidx','$sord')";
            // echo $sql;
            $result = parent::ejecutar2($sql);
            $oficinas=[];
            while($fila = mysqli_fetch_object($result)){
               $obj = new stdClass();
                  $obj->id = $fila->id;
                  $obj->descripcion = $fila->descripcion;
                  $obj->telefono = $fila->telefono;
                  $obj->estado = $fila->estado;
                  $oficinas[] = $obj;
            }
            return $oficinas;
        }

        public function listarComboTipoOficina($codigo,$descripcion){
            $retorno=new Resultado();
            $sql = "CALL SGESS_TIPO_OFICINA_CBO('$codigo','$descripcion')";
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
