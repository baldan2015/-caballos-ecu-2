<?php
    if (file_exists("../data/CampeonData.php")) {
        include_once("../data/CampeonData.php");
    }
    

    class CampeonLogica{
        public $context;
        public function CampeonLogica(){
            $this->context = new CampeonData();
        }
        //Guardar
       public function insertar($vanio,$vprefijo,$vejemplar,$vidEjemplar,$vpropietario,$iesSuperCamp){
            $registros = $this->context->insertar($vanio,$vprefijo,$vejemplar,$vidEjemplar,$vpropietario,$iesSuperCamp);
            return $registros;
       }
              
        public function listar($vejemplar){
            $registros = $this->context->listar($vejemplar);
            return $registros;
        }
      
       public function eliminar($id){
            $registros = $this->context->eliminar($id);
            return $registros;
       }
    }
?>
