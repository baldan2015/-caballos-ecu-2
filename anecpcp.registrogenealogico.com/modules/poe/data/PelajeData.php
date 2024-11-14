<?php
    include_once ("modelo.php");
    if (file_exists("../entidad/Pelaje.inc")) include_once ("../entidad/Pelaje.inc");
   if (file_exists("../entidad/Resultado.inc.php"))  include_once ("../entidad/Resultado.inc.php"); 

   if (file_exists("../../entidad/Pelaje.inc")) include_once ("../../entidad/Pelaje.inc");
   if (file_exists("../../entidad/Resultado.inc.php"))  include_once ("../../entidad/Resultado.inc.php"); 
    
    class PelajeData extends dal{

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
        public function insertar($nombre,$usuario_crea){
             $retorno=new Resultado();

            $sql = "CALL SGESI_PELAJE('$nombre','$usuario_crea',@vresultado)";
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
        //funcion para actualizar un registro
        public function editar($codigo,$nombre,$usuario_modi){
             $retorno=new Resultado();
            $sql = "CALL SGESU_PELAJE('$codigo','$nombre','$usuario_modi',@vresultado)";
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
            $sql = "CALL SGESD_PELAJE('$codigo',@vresultado)";
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
        public function obtenerID($codigo){
             $retorno=new Resultado();
            $sql = "CALL SGESS_PELAJE_X_ID('$codigo')";
            $result = parent::ejecutar2($sql);
            if($fila = mysqli_fetch_object($result)){
                  $obj = new Pelaje();
		          $obj->codigo = $fila->id;
		          $obj->nombre = $fila->nombre;
            }
            return $obj;
	}
        //function para buscar
        public function buscar($entity){
             $retorno=new Resultado();
            $sql = "CALL SGESS_PELAJE('')";
            $result = parent::ejecutar2($sql);
            while($fila = mysqli_fetch_object($result)){
                $obj = new Pelaje();
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
        /*public function numeroRegistro($codigo,$descripcion,$codigo_empresa){
            $sql = "CALL SGFSS_CUENTA_TURNO('$codigo','$descripcion','$codigo_empresa')";
            $result = parent::ejecutar2($sql);
            $num_row=0;
            while ($fila = mysqli_fetch_object($result)){
                $num_row = $fila->num_row;
            }
            return $num_row;
        }*/

       /*public function buscarSearch($entity, $start , $limit,$sidx,$sord){
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
        public function buscarDataTable(){
             $retorno=new Resultado();
            $aColumns=array("id","nombre");
            $sIndexColumn="id";
            $sTable="sge_pelaje";
            return parent::loadDataTable($aColumns,$sIndexColumn,$sTable);
        }

        public function listarComboTipoPelaje($codigo,$descripcion){
            $retorno=new Resultado();
            $sql = "CALL SGESS_TIPO_PELAJE_CBO('$codigo','$descripcion')";
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
        public function numeroRegistro($nomPelaje){
            // $retorno=new Resultado();
            $sql = "CALL SGESS_CUENTA_PELAJE_JQGRID('$nomPelaje')";
           // echo $sql ;
            $result = parent::ejecutar2($sql);
            $num_row=0;
            while ($fila = mysqli_fetch_object($result)){
                $num_row = $fila->num_row;
            }
            return $num_row;
        }
        public function buscarSearch($nomPelaje,$start,$limit,$sidx,$sord){
            //$retorno=new Resultado();
            $sql = "CALL SGESS_PELAJE_JQGRID('$nomPelaje','$start','$limit','$sidx','$sord')";
            // echo $sql;
            $result = parent::ejecutar2($sql);
            $pelajes=[];
            while($fila = mysqli_fetch_object($result)){
               $obj = new stdClass();
                  $obj->id = $fila->id;
                  $obj->nombre = $fila->nombre;
                  $pelajes[] = $obj;
            }
            return $pelajes;
        }
         
    }
?>
