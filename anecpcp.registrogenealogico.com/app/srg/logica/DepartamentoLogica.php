<?php
    if (file_exists("../data/DepartamentoData.php")) {         include_once("../data/DepartamentoData.php");    }
    if (file_exists("../entidad/Departamento.inc")) {         include_once("../entidad/Departamento.inc");    }
    if (file_exists("../entidad/Constantes.php")) {        include_once("../entidad/Constantes.php");  }

    if (file_exists("../../data/DepartamentoData.php")) {    include_once("../../data/DepartamentoData.php");    }
    if (file_exists("../../entidad/Departamento.inc")) {     include_once("../../entidad/Departamento.inc");    }
    if (file_exists("../../entidad/Constantes.php")) {  include_once("../../entidad/Constantes.php");  }


    class DepartamentoLogica{
        public $context;
        public function DepartamentoLogica(){
            $this->context = new DepartamentoData();
        }
        
         public function buscarSearch($nomDepart,$start=1, $limit=25,$sidx=1,$sord=""){
          //  echo "buscarSearch";
            $registros = $this->context->buscarSearch($nomDepart, $start , $limit,$sidx,$sord);
            return $registros;
        }
        public function numeroRegistro($nomDepart){
            
            return $this->context->numeroRegistro($nomDepart);
        }
        public function listarComboTipoDepart($codigo,$descripcion){
            $registros = $this->context->listarComboTipoDepart($codigo,$descripcion);
            return $registros;
        }
        public function obtenerID($entity){
            $registros = $this->context->obtenerID($entity);
            return $registros;
        }
      
    }
?>
