<?php
    if (file_exists("../data/TipoDocData.php")) {
        include_once("../data/TipoDocData.php");
    }
    if (file_exists("../entidad/TipoDoc.inc")) {
        include_once("../entidad/TipoDoc.inc");
    }
    if (file_exists("../entidad/Constantes.php")) {
        include_once("../entidad/Constantes.php");
    }
    class TipoDocLogica{
        public $context;
        public function TipoDocLogica(){
            $this->context = new TipoDocData();
        }
        //Guardar
        public function insertar($nombreCorto,$nombreLargo,$usuario_crea){
           $retorno = $this->context->insertar($nombreCorto,$nombreLargo,$usuario_crea);
           return $retorno;
        }
        //Obtener ID
        public function obtenerID($entity){
            $registros = $this->context->obtenerID($entity);
            return $registros;
        }
        //Editar
        public function editar($codigo,$nombreCorto,$nombreLargo,$usuario_modi){
            $registros = $this->context->editar($codigo,$nombreCorto,$nombreLargo,$usuario_modi);
            return $registros;
        }
        //Buscar
        public function buscar($entity){
            $registros = $this->context->buscar($entity);
            return $registros;
        }
        //Eliminar
        public function eliminar($codigo){
            $registros = $this->context->eliminar($codigo);
            return $registros;
        }
        //funcion Generar codigo
        public function generarCodigo($entity){
            $registros = $this->context->generarCodigo($entity);
            return $registros;
        }
        
        public function numeroRegistro($nomTipoDoc){
            
            return $this->context->numeroRegistro($nomTipoDoc);
        }
        public function buscarSearch($nomTipoDoc ,$start=1, $limit=15,$sidx=1,$sord=""){
          //  echo "buscarSearch";
            $registros = $this->context->buscarSearch($nomTipoDoc, $start , $limit,$sidx,$sord);
            return $registros;
        }
        //funcion validar eliminación de categoria
        public function validarEliminar($entity){
            $registros = $this->context->validarEliminar($entity);
            return $registros;
        }
        public function buscarDataTable(){
            $registros = $this->context->buscarDataTable();
            return $registros;
        }
        public function listarComboTipoDoc($codigo,$descripcion){
            $registros = $this->context->listarComboTipoDoc($codigo,$descripcion);
            return $registros;
        }
    }
?>