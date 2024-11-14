<?php
    if (file_exists("../data/ResenaData.php")) {         include_once("../data/ResenaData.php");    }
    if (file_exists("../../data/ResenaData.php")) {         include_once("../../data/ResenaData.php"); }
    

    class ResenaLogica{
        public $context;
        public function ResenaLogica(){
            $this->context = new ResenaData();
        }
        //Guardar
        public function insertar($descripcion,$usuario_crea){
           $retorno = $this->context->insertar($descripcion,$usuario_crea);
           return $retorno;
        }
              
        //Editar'$codigo','$descripcion','$telefono','$fecModi','$usuModi'
        public function editar($id,$resenia,$usuario_modi){
            $registros = $this->context->editar($id,$resenia,$usuario_modi);
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
       public function buscarDataTable(){
            $registros = $this->context->buscarDataTable();
            return $registros;
        }
        //funcion validar eliminación de categoria
        public function validarEliminar($entity){
            $registros = $this->context->validarEliminar($entity);
            return $registros;
        }
        public function obtenerID($id){
            $registros = $this->context->obtenerID($id);
            return $registros;
        }
         public function listarCombo($codigo,$descripcion,$tipo){
            $registros = $this->context->listarCombo($codigo,$descripcion,$tipo);
            return $registros;
        }
        public function buscarSearch($nomResena ,$start=1, $limit=15,$sidx=1,$sord=""){
          //  echo "buscarSearch";
            $registros = $this->context->buscarSearch($nomResena, $start , $limit,$sidx,$sord);
            return $registros;
        }
         public function numeroRegistro($nomResena){
            
            return $this->context->numeroRegistro($nomResena);
        }
    }
?>
