<?php
//echo getcwd();
if (file_exists("../../data/ImagenData.php")) include_once("../../data/ImagenData.php");
if (file_exists("../../entidad/Ejemplar.inc.php"))include_once("../../entidad/Ejemplar.inc.php");
if (file_exists("../../entidad/Constantes.php"))include_once("../../entidad/Constantes.php");



if (file_exists("../data/ImagenData.php"))  include_once("../data/ImagenData.php");
if (file_exists("../entidad/Ejemplar.inc.php"))include_once("../entidad/Ejemplar.inc.php");
if (file_exists("../entidad/Constantes.php"))include_once("../entidad/Constantes.php");



    class ImagenLogica{
        public $context;
        public function ImagenLogica(){
            $this->context = new ImagenData();
        }
        //Guardar
       
        //Eliminar
        public function eliminar($codigo){
            $registros = $this->context->eliminar($codigo);
            return $registros;
        }
        //Buscar
        public function buscar($entity){
            $registros = $this->context->buscar($entity);
            return $registros;
        }
        public function editar($codigo,$main,$idHorse){

            $registros = $this->context->editar($codigo,$main,$idHorse);
            return $registros;
        }
        //Guardar
        public function insertar($idHorse,$new_file_name,$esPrincipal,$activo){
           $retorno = $this->context->insertar($idHorse,$new_file_name,$esPrincipal,$activo);
           return $retorno;
        }
        public function buscarSearch($id){
          //  echo "buscarSearch";
            $registros = $this->context->buscarSearch($id);
            return $registros;
        }
        public function listarDocumentosMonta($idMonta,$esPadre){
            $registros = $this->context->listarDocumentosMonta($idMonta,$esPadre);
            return $registros;
        }
    }
?>
