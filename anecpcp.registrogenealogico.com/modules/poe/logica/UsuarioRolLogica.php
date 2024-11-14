<?php
    if (file_exists("../data/UsuarioRolData.php")) {
        include_once("../data/UsuarioRolData.php");
    }
    

    class UsuarioRolLogica{
        public $context;
        public function UsuarioRolLogica(){
            $this->context = new UsuarioRolData();
        }
        //Guardar
        public function insertar($idUsuario,$idRol,$idOficina,$usuario_crea,$estado){
           $retorno = $this->context->insertar($idUsuario,$idRol,$idOficina,$usuario_crea,$estado);
           return $retorno;
        }
         //insertar login y password    
              public function insertarLogin($idUsuario,$login,$pwd,$estado,$usuario_crea){
           $retorno = $this->context->insertarLogin($idUsuario,$login,$pwd,$estado,$usuario_crea);
           return $retorno;
        } 
        //Editar'$codigo','$descripcion','$telefono','$fecModi','$usuModi'
        public function editar($codigo,$idUsuario,$idOficina,$estado,$usuario_modi){
            $registros = $this->context->editar($codigo,$idUsuario,$idOficina,$estado,$usuario_modi);
            return $registros;
        }
        //editar login y password
        public function editarLogin($idUsuario,$login,$pwd,$estado,$usuario_modi){
            $registros = $this->context->editarLogin($idUsuario,$login,$pwd,$estado,$usuario_modi);
            return $registros;   
        }

        //Buscar
        public function buscar($entity){
            $registros = $this->context->buscar($entity);
            return $registros;
        }
        //Eliminar
        public function eliminar($id){
            $registros = $this->context->eliminar($id);
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
        public function obtenerID($entity){
            $registros = $this->context->obtenerID($entity);
            return $registros;
        }

         public function buscarSearch($nomUsu,$nomOfic,$start=1, $limit=15,$sidx=1,$sord=""){
          //  echo "buscarSearch";
            $registros = $this->context->buscarSearch($nomUsu,$nomOfic ,$start , $limit,$sidx,$sord);
            return $registros;
        }
        public function numeroRegistro($nomUsu,$nomOfic){
            
            return $this->context->numeroRegistro($nomUsu,$nomOfic);
        }
        public function listarComboTipoRol($id,$descripcion){
            $registros = $this->context->listarComboTipoRol($id,$descripcion);
            return $registros;
        }
         public function listarComboUsuario($id,$descripcion){
            $registros = $this->context->listarComboUsuario($id,$descripcion);
            return $registros;
        }
    }
?>
