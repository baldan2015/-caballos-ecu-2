<?php
    include_once ("modelo.php");
    include_once ("../entidad/TipoDoc.inc");
    include_once ("../entidad/Resultado.inc.php");      
    
    class TipoDocData extends dal{

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
        public function insertar($nombreCorto,$nombreLargo,$usuario_crea){
            $retorno=new Resultado();
            $sql = "CALL SGESI_TIPO_DOC('$nombreCorto','$nombreLargo','$usuario_crea',@vresultado)";
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
        public function editar($codigo,$nombreCorto,$nombreLargo,$usuario_modi){
            $retorno=new Resultado();
            $sql = "CALL SGESU_TIPO_DOC('$codigo','$nombreCorto','$nombreLargo',$usuario_modi,@vresultado)";
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
            $sql = "CALL SGESD_TIPO_DOC('$codigo')";
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
            $sql = "CALL SGESS_DOC_X_ID('$codigo')";
            $result = parent::ejecutar2($sql);
            if($fila = mysqli_fetch_object($result)){
                  $obj = new TipoDoc();
		          $obj->codigo = $fila->id;
		          $obj->nombreCorto = $fila->nombreCorto;
                  $obj->nombreLargo = $fila->nombreLargo;
            }
            return $obj;
	}
        //function para buscar
        public function buscar($entity){
            $retorno=new Resultado();
            $sql = "CALL SGESS_TIPO_DOC('')";
            $result = parent::ejecutar2($sql);
            while($fila = mysqli_fetch_object($result)){
                $obj = new TipoDoc();
                $obj->codigo = $fila->id;
                $obj->nombreCorto = $fila->nombreCorto;
                $obj->nombreLargo = $fila->nombreLargo;
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
        public function numeroRegistro($nomTipoDoc){
            // $retorno=new Resultado();
            $sql = "CALL SGESS_CUENTA_TIPO_DOC_JQGRID('$nomTipoDoc')";
            //echo $sql ;
            $result = parent::ejecutar2($sql);
            $num_row=0;
            while ($fila = mysqli_fetch_object($result)){
                $num_row = $fila->num_row;
            }
            return $num_row;
        }
        public function buscarSearch($nomTipoDoc,$start,$limit,$sidx,$sord){
            $sql = "CALL SGESS_TIPO_DOC_JQGRID('$nomTipoDoc','$start','$limit','$sidx','$sord')";
           //  echo $sql;
            $result = parent::ejecutar2($sql);
            $docs=[];
            while($fila = mysqli_fetch_object($result)){
               $obj = new stdClass();
                  $obj->id = $fila->id;
                  $obj->nombreCorto = $fila->nombreCorto;
                  $obj->nombreLargo = $fila->nombreLargo;
                  $docs[] = $obj;
            }
            return $docs;
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
            $aColumns=array("id","nombreCorto","nombreLargo");
            $sIndexColumn="id";
            $sTable="sge_documento_tipo";
            return parent::loadDataTable($aColumns,$sIndexColumn,$sTable);
        }

        public function listarComboTipoDoc($codigo,$descripcion){
            $retorno=new Resultado();
            $sql = "CALL SGESS_TIPO_DOC_CBO('$codigo','$descripcion')";
            $turno=[];
            $result = parent::ejecutar2($sql);
            while($fila = mysqli_fetch_object($result)){
                $obj = new ListItem();
                $obj->valor = $fila->id;
                $obj->descripcion = $fila->nombreCorto;
                $turno[] = $obj;
            }
            return $turno;
        }
    }
?>