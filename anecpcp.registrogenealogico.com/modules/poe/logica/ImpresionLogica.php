<?php
//echo getcwd();
if (file_exists("../../data/ImpresionData.php")) include_once("../../data/ImpresionData.php");
if (file_exists("../../entidad/Ejemplar.inc.php"))include_once("../../entidad/Ejemplar.inc.php");
if (file_exists("../../entidad/Constantes.php"))include_once("../../entidad/Constantes.php");



if (file_exists("../data/ImpresionData.php"))  include_once("../data/ImpresionData.php");
if (file_exists("../entidad/Ejemplar.inc.php"))include_once("../entidad/Ejemplar.inc.php");
if (file_exists("../entidad/Constantes.php"))include_once("../entidad/Constantes.php");



    class ImpresionLogica{
        public $context;
        public function ImpresionLogica(){
            $this->context = new ImpresionData();
        }
        //obtenerVecesImpresion
        
       public function obtenerVecesImpresion($codigo){
            $registros = $this->context->obtenerVecesImpresion($codigo);
            return $registros;
        }
      
        //Guardar
        public function insertarLog($idEjemplar,$usuaCrea,$tipo) {
           $retorno = $this->context->insertarLog($idEjemplar,$usuaCrea,$tipo);
           return $retorno;
        }
       
    }
?>
