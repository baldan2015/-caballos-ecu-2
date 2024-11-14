<?php
    if (file_exists("../data/OficinaData.php")) {
        include_once("../data/OficinaData.php");
    }
    

    class OficinaLogica{
        public $context;
        public function OficinaLogica(){
            $this->context = new OficinaData();
        }
        //Guardar
        public function insertar($descripcion,$telefono,$usuario_crea){
           $retorno = $this->context->insertar($descripcion,$telefono,$usuario_crea);
           return $retorno;
        }
              
        //Editar'$codigo','$descripcion','$telefono','$fecModi','$usuModi'
        public function editar($id,$descripcion,$telefono,$usuModi){
            $registros = $this->context->editar($id,$descripcion,$telefono,$usuModi);
            return $registros;
        }
        //Buscar
        public function buscar($entity){
            $registros = $this->context->buscar($entity);
            return $registros;
        }
        //Eliminar
        public function eliminar($codigo,$usuario_modi){
            $registros = $this->context->eliminar($codigo,$usuario_modi);
            return $registros;
        }
      /* public function buscarDataTable(){
            $registros = $this->context->buscarDataTable();
            return $registros;
        }*/
        public function buscarSearch($nomOficina ,$start=1, $limit=15,$sidx=1,$sord=""){
          //  echo "buscarSearch";
            $registros = $this->context->buscarSearch($nomOficina, $start , $limit,$sidx,$sord);
            return $registros;
        }

        public function numeroRegistro($nomOficina){
            
            return $this->context->numeroRegistro($nomOficina);
        }
        //funcion validar eliminación de categoria
        public function validarEliminar($entity){
            $registros = $this->context->validarEliminar($entity);
            return $registros;
        }
        public function obtenerID($entity){
            $registros = $this->context->obtenerID($entity);
            return $registros;
        }
        public function listarComboTipoOficina($codigo,$descripcion){
            $registros = $this->context->listarComboTipoOficina($codigo,$descripcion);
            return $registros;
        }
    }
?>
