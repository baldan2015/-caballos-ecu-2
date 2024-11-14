<?php
//echo getcwd();
if (file_exists("../../data/ImagenInsData.php")) include_once("../../data/ImagenInsData.php");
if (file_exists("../../entidad/Ejemplar.inc.php"))include_once("../../entidad/Ejemplar.inc.php");
if (file_exists("../../entidad/Constantes.php"))include_once("../../entidad/Constantes.php");



if (file_exists("../data/ImagenInsData.php"))  include_once("../data/ImagenInsData.php");
if (file_exists("../entidad/Ejemplar.inc.php"))include_once("../entidad/Ejemplar.inc.php");
if (file_exists("../entidad/Constantes.php"))include_once("../entidad/Constantes.php");

if (file_exists("../../../data/ImagenInsData.php"))  include_once("../../../data/ImagenInsData.php");
if (file_exists("../../../entidad/Ejemplar.inc.php"))include_once("../../../entidad/Ejemplar.inc.php");
if (file_exists("../../../entidad/Constantes.php"))include_once("../../../entidad/Constantes.php");



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


        public function insertarNacTMP($idHorse,$new_file_name,$esPrincipal,$activo,$esPDF,$idTipoDocumento,$codigoGenerado){
           $retorno = $this->context->insertarNacTMP($idHorse,$new_file_name,$esPrincipal,$activo,$esPDF,$idTipoDocumento,$codigoGenerado);
           return $retorno;
        }
        public function eliminarNacTMP($codigo){
            $registros = $this->context->eliminarNacTMP($codigo);
            return $registros;
        }
         public function buscarSearchNacTMP($id,$esPDF, $codigoGenerado){
          //  echo "buscarSearch";
            $registros = $this->context->buscarSearchNacTMP($id,$esPDF, $codigoGenerado);
            return $registros;
        }

        public function insertarInsTMP($idHorse,$new_file_name,$esPrincipal,$activo,$esPDF,$idTipoDocumento,$codigoGenerado,$flag){
           $retorno = $this->context->insertarInsTMP($idHorse,$new_file_name,$esPrincipal,$activo,$esPDF,$idTipoDocumento,$codigoGenerado,$flag);
           return $retorno;
        }
        public function eliminarInsTMP($codigo){
            $registros = $this->context->eliminarInsTMP($codigo);
            return $registros;
        }
         public function buscarSearchInsTMP($id,$esPDF, $codigoGenerado){
          //  echo "buscarSearch";
            $registros = $this->context->buscarSearchInsTMP($id,$esPDF, $codigoGenerado);
            return $registros;
        }
        public function eliminarDocumentosINS($codigo, $esPdf)
        {
            $registros = $this->context->eliminarDocumentosINS($codigo, $esPdf);
            return $registros;
        }
    }
?>
