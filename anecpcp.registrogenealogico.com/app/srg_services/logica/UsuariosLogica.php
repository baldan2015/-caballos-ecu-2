<?php
    if (file_exists("../data/UsuariosData.php")) {
        include_once("../data/UsuariosData.php");
    }
    if (file_exists("../entidad/Usuarios.inc")) {
        include_once("../entidad/Usuarios.inc");
    }
    if (file_exists("../entidad/Constantes.php")) {
        include_once("../entidad/Constantes.php");
    }
    class UsuariosLogica{
        public $context;
        public function UsuariosLogica(){
            $this->context = new UsuariosData();
        }
        //Guardar
        public function insertar($nombre){
           $retorno = $this->context->insertar($nombre);
           return $retorno;
        }
        //Obtener ID
        public function obtenerID($entity){
            $registros = $this->context->obtenerID($entity);
            return $registros;
        }
        //Editar
        public function editar($codigo,$nombre){
            $registros = $this->context->editar($codigo,$nombre);
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
        
        public function numeroRegistro($codigo,$descripcion,$codigo_empresa){
            return $this->context->numeroRegistro($codigo,$descripcion,$codigo_empresa);
        }
        
        public function buscarSearch($entity ,$start=1, $limit=100,$sidx=1,$sord=""){
            $registros = $this->context->buscarSearch($entity, $start , $limit,$sidx,$sord);
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
        public function listarComboTipoUsuarios($codigo,$descripcion){
            $registros = $this->context->listarComboTipoUsuarios($codigo,$descripcion);
            return $registros;
        }
    }
?>
