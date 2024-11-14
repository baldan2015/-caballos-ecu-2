<?php
    if (file_exists("../data/ReporteData.php")) {
        include_once("../data/ReporteData.php");
    }
    

    class ReporteLogica{
        public $context;
        public function ReporteLogica(){
            $this->context = new ReporteData();
        }
        //LISTA  POR AÑO LA CANTIDAD DE NACIDOS BAJO UN CRIADOR
       public function reportNumNacidoXCriador($desde,$hasta,$nombre ){
            $registros = $this->context->reportNumNacidoXCriador($desde,$hasta,$nombre);
            return $registros;
       }
       //LISTA  POR AÑO LA CANTIDAD DE NACIDOS POR AÑO
       public function reportNumNacidoXMetodo($desde,$hasta,$metodo ){
            $registros = $this->context->reportNumNacidoXMetodo($desde,$hasta,$metodo);
            return $registros;
       }
        //LISTA   CRIADORES Y PREFIJOS
       public function reportCriadorPrefijo($criador,$prefijo){
            $registros = $this->context->reportCriadorPrefijo($criador,$prefijo);
            return $registros;
       }

        //LISTA   CRIADORES Y PREFIJOS
       public function reportNumServicioYegua($desde,$hasta){
            $registros = $this->context->reportNumServicioYegua($desde,$hasta);
            return $registros;
       }
        //LISTA   CRIADORES Y PREFIJOS
       public function reportNumServicioYeguaDet($anio,$nombre){
            $registros = $this->context->reportNumServicioYeguaDet($anio,$nombre);
            return $registros;
       }


         //LISTA   CRIADORES Y PREFIJOS
       public function reportNumServicioPotro($desde,$hasta){
            $registros = $this->context->reportNumServicioPotro($desde,$hasta);
            return $registros;
       }
        //LISTA   CRIADORES Y PREFIJOS
       public function reportNumServicioPotroDet($anio,$nombre){
            $registros = $this->context->reportNumServicioPotroDet($anio,$nombre);
            return $registros;
       }
         //LISTA   CRIADORES X DPTO
       public function reportCriadorXDpto($criador,$dpto,$isProp){
            $registros = $this->context->reportCriadorXDpto($criador,$dpto,$isProp);
            return $registros;
       }
         public function reportCriadorXDptoConsol($isProp){
            $registros = $this->context->reportCriadorXDptoConsol( $isProp);
            return $registros;
       }
        public function reportCierreCaja($anio,$mes,$origen,$castrado,$tipoReporte){
            $registros = $this->context->reportCierreCaja( $anio,$mes,$origen,$castrado,$tipoReporte);
            return $registros;
       }
       public function reportCierreCajaTransfer($anio,$mes,$origen,$castrado,$tipoReporte){
            $registros = $this->context->reportCierreCajaTransfer( $anio,$mes,$origen,$castrado,$tipoReporte);
            return $registros;
       }
             

             
        
    }
?>
