<?php
    if (file_exists("../data/UsuarioData.php")) {
        include_once("../data/UsuarioData.php");
    }
    

    class UsuarioLogica{
        public $context;
        public function UsuarioLogica(){
            $this->context = new UsuarioData();
        }
        //Guardar
       
              
        //Editar'$codigo','$descripcion','$telefono','$fecModi','$usuModi'
        public function listarComboUsuario($codigo,$descripcion){
            $registros = $this->context->listarComboUsuario($codigo,$descripcion);
            return $registros;
        }
         //Editar'$codigo','$descripcion','$telefono','$fecModi','$usuModi'
        public function listarComboRol($codigo,$descripcion){
            $registros = $this->context->listarComboRol($codigo,$descripcion);
            return $registros;
        }
    }
?>
