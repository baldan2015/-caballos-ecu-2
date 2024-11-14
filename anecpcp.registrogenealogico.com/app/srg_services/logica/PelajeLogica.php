<?php
    if (file_exists("../data/PelajeData.php")) {         include_once("../data/PelajeData.php");    }
    if (file_exists("../entidad/Pelaje.inc")) {         include_once("../entidad/Pelaje.inc");    }
    if (file_exists("../entidad/Constantes.php")) {        include_once("../entidad/Constantes.php");  }

    if (file_exists("../../data/PelajeData.php")) {    include_once("../../data/PelajeData.php");    }
    if (file_exists("../../entidad/Pelaje.inc")) {     include_once("../../entidad/Pelaje.inc");    }
    if (file_exists("../../entidad/Constantes.php")) {  include_once("../../entidad/Constantes.php");  }


    class PelajeLogica{
        public $context;
        public function PelajeLogica(){
            $this->context = new PelajeData();
        }
        //Guardar
        public function insertar($nombre,$usuario_crea){
           $retorno = $this->context->insertar($nombre,$usuario_crea);
           return $retorno;
        }
        //Obtener ID
        public function obtenerID($entity){
            $registros = $this->context->obtenerID($entity);
            return $registros;
        }
        //Editar
        public function editar($codigo,$nombre,$usuario_modi){
            $registros = $this->context->editar($codigo,$nombre,$usuario_modi);
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
         public function buscarSearch($nomPelaje,$start=1, $limit=15,$sidx=1,$sord=""){
          //  echo "buscarSearch";
            $registros = $this->context->buscarSearch($nomPelaje, $start , $limit,$sidx,$sord);
            return $registros;
        }
        public function numeroRegistro($nomPelaje){
            
            return $this->context->numeroRegistro($nomPelaje);
        }
        
        
        //funcion validar eliminación de categoria
        public function validarEliminar($entity){
            $registros = $this->context->validarEliminar($entity);
            return $registros;
        }
        /*public function buscarDataTable(){
            $registros = $this->context->buscarDataTable();
            return $registros;
        }*/
        public function listarComboTipoPelaje($codigo,$descripcion){
            $registros = $this->context->listarComboTipoPelaje($codigo,$descripcion);
            return $registros;
        }
    }
?>
