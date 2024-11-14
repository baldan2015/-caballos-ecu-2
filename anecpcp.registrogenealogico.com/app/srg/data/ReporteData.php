<?php
    include_once ("modelo.php");
    include_once ("../entidad/SelectedItems.php");
    include_once ("../entidad/Resultado.inc.php");      
    
    class ReporteData extends dal{

        public $retorno;
          function __construct(){
            parent::dal();
            $retorno=new Resultado();
        }

        /*
        obtiene la lista de ejemplares nacidos bajo criadores 
        en un rango de periodo determinado.
        */
        public function reportNumNacidoXCriador($desde,$hasta,$nomre){
            $retorno=new Resultado();
            $sql = "CALL SGESS_REPORTE_NUM_EJEMPLAR_ANIO('$desde','$hasta','$nomre')";
          // echo $sql;
            $lista=[];
            $result = parent::ejecutar2($sql);
            while($fila = mysqli_fetch_object($result)){
                $obj = new stdClass();
                $obj->id = $fila->idCriador;
                $obj->nombre = $fila->razonSocial;
                $obj->anio = $fila->anio;
                $obj->cantidad = $fila->totalNacido;
                $obj->prefijo = $fila->prefijo;

                $lista[] = $obj;
            }
            return $lista;
        }

         /*
        obtiene la cantidad de nacidos por año segun el tipo de metopdo de reproduccion
        */
        public function reportNumNacidoXMetodo($desde,$hasta,$metodo){
            $retorno=new Resultado();
            $sql = "CALL SGESS_REPORTE_NUM_NACIDO_METODO('$desde','$hasta','$metodo')";
          // echo $sql;
            $lista=[];
            $result = parent::ejecutar2($sql);
            while($fila = mysqli_fetch_object($result)){
                $obj = new stdClass();
                $obj->anio = $fila->anio;
                $obj->cantidad = $fila->cantidad;
                $lista[] = $obj;
            }
            return $lista;
        }
        /*OBTIENE LA LISTA DE CRIADORES Y SUS PREFIJOS*/
        public function reportCriadorPrefijo($criador,$prefijo){
            $retorno=new Resultado();
            $sql = "CALL SGESS_REPORTE_PREFIJO_CRIADOR('$criador','$prefijo')";
          
            $lista=[];
            $result = parent::ejecutar2($sql);
            while($fila = mysqli_fetch_object($result)){
                $obj = new stdClass();
                $obj->criador = $fila->razonSocial;
                $obj->prefijo = $fila->prefijo;
                $lista[] = $obj;
            }
            return $lista;
        }
 /*
        obtiene la cantidad de nacidos por año segun el tipo de metopdo de reproduccion
        */
        public function reportNumServicioYegua($desde,$hasta){
            $retorno=new Resultado();
            $sql = "CALL SGESS_REPORTE_NUM_SERVY_ANIO('$desde','$hasta')";
          // echo $sql;
            $lista=[];
            $result = parent::ejecutar2($sql);
            while($fila = mysqli_fetch_object($result)){
                $obj = new stdClass();
                $obj->anio = $fila->anio;
                $obj->cantidadPOE = $fila->numPOE;
                $obj->cantidadSGE = $fila->numSGE;
                $obj->diferencia = round($fila->numPOE==0? 0:  (($fila->numSGE*100)/$fila->numPOE),2);
                $lista[] = $obj;
            }
            return $lista;
        }
          public function reportNumServicioYeguaDet($anio,$nombre ){
            $retorno=new Resultado();
            $sql = "CALL SGESS_REPORTE_NUM_SERVY_ANIO_DET('$anio','$nombre')";
          // echo $sql;
            $lista=[];
            $result = parent::ejecutar2($sql);
            while($fila = mysqli_fetch_object($result)){
                $obj = new stdClass();
                $obj->id = $fila->id;
                $obj->prefijo = $fila->prefijo;
                $obj->nombre = $fila->nombre;
                $obj->cantidadPOE = $fila->numPOE;
                $obj->cantidadSGE = $fila->numSGE;
                $obj->diferencia = ($fila->numPOE-$fila->numSGE);
                $lista[] = $obj;
            }
            return $lista;
        }


        /*
        obtiene la cantidad de nacidos por año segun el tipo de metopdo de reproduccion
        */
        public function reportNumServicioPotro($desde,$hasta){
            $retorno=new Resultado();
            $sql = "CALL SGESS_REPORTE_NUM_SERVP_ANIO('$desde','$hasta')";
          // echo $sql;
            $lista=[];
            $result = parent::ejecutar2($sql);
            while($fila = mysqli_fetch_object($result)){
                $obj = new stdClass();
                $obj->anio = $fila->anio;
                $obj->cantidadPOE = $fila->numPOE;
                $obj->cantidadSGE = $fila->numSGE;
                $obj->diferencia = round($fila->numPOE==0? 0:  (($fila->numSGE*100)/$fila->numPOE),2);
                $lista[] = $obj;
            }
            return $lista;
        }
          public function reportNumServicioPotroDet($anio,$nombre ){
            $retorno=new Resultado();
            $sql = "CALL SGESS_REPORTE_NUM_SERVP_ANIO_DET('$anio','$nombre')";
          // echo $sql;
            $lista=[];
            $result = parent::ejecutar2($sql);
            while($fila = mysqli_fetch_object($result)){
                $obj = new stdClass();
                $obj->id = $fila->id;
                $obj->prefijo = $fila->prefijo;
                $obj->nombre = $fila->nombre;
                $obj->cantidadPOE = $fila->numPOE;
                $obj->cantidadSGE = $fila->numSGE;
                $obj->diferencia = ($fila->numPOE-$fila->numSGE);
                $lista[] = $obj;
            }
            return $lista;
        }
           /*OBTIENE LA LISTA DE CRIADORES Y SUS PREFIJOS*/
        public function reportCriadorXDpto($criador,$dpto,$isProp){
            $retorno=new Resultado();
            $sql = "CALL SGESS_REPORTE_CRIADOR_X_DPTO('$criador','$dpto',$isProp)";
             //echo $sql;
            $lista=[];
            $result = parent::ejecutar2($sql);
            while($fila = mysqli_fetch_object($result)){
                $obj = new stdClass();
                $obj->tipoDoc = $fila->tipoDoc;
                $obj->numDoc = $fila->numDoc;
                $obj->razonSocial = $fila->razonSocial;
                $obj->prefijo = $fila->prefijo;
                $obj->dpto = $fila->dpto;
                $obj->lugarCria = $fila->lugarCria;
                $lista[] = $obj;
            }
            return $lista;
        }
           /*OBTIENE LA LISTA DE CRIADORES Y SUS PREFIJOS*/
        public function reportCriadorXDptoConsol($isProp){
            $retorno=new Resultado();
            $sql = "CALL SGESS_REPORTE_CRIADOR_X_DPTO_CONSOL($isProp)";
            //echo $sql;
            $lista=[];
            $result = parent::ejecutar2($sql);
            while($fila = mysqli_fetch_object($result)){
                $obj = new stdClass();
                $obj->nombre= $fila->dptos;
                $obj->cantidad = $fila->cant;
                $lista[] = $obj;
            }
            return $lista;
        }
         public function reportCierreCaja( $anio,$mes,$origen,$castrado,$tipoReporte){
            $retorno=new Resultado();
            $sql = "CALL SGESS_REPORTE_CIERRE_CAJA('$anio','$mes','$origen','$castrado','$tipoReporte')";
             //echo $sql;
            $lista=[];
            $result = parent::ejecutar2($sql);
            while($fila = mysqli_fetch_object($result)){
                $obj = new stdClass();
                    $obj->id = $fila->id;
                    $obj->prefijo = $fila->prefijo;
                    $obj->nombre = $fila->nombre;
                    $obj->fecNace = $fila->fecNace;
                    $obj->pelaje = $fila->pelaje;
                    $obj->propiedad = $fila->propiedad;
                    $obj->criador = $fila->criador;
                    $obj->fecReg = $fila->fecReg;
                    $obj->origen = $fila->origen;
                    $obj->fecCapado = $fila->fecCapado;
                    $obj->usuCrea = $fila->usuCrea;
                    $obj->fecCrea = $fila->fecCrea;
                $lista[] = $obj;
            }
            return $lista;
        }
        public function reportCierreCajaTransfer( $anio,$mes,$origen,$castrado,$tipoReporte){
            $retorno=new Resultado();
            $sql = "CALL SGESS_REPORTE_CIERRE_CAJA_TRANSFER('$anio','$mes','$origen','$castrado')";
             //echo $sql;
            $lista=[];
            $result = parent::ejecutar2($sql);
            while($fila = mysqli_fetch_object($result)){
                $obj = new stdClass();
                    $obj->id = $fila->id;
                    $obj->idEjemplar = $fila->idEjemplar;
                    $obj->prefijo = $fila->prefijo;
                    $obj->nombre = $fila->nombre;
                    $obj->antiguoProp = $fila->antiguoProp;
                    $obj->nuevoProp = $fila->nuevoProp;
                    $obj->fechaRegistro = $fila->fechaRegistro;
                    $obj->fechaTransferencia = $fila->fechaTransferencia;
                    $obj->origen = $fila->origen;
                    $obj->fecCapado = $fila->fecCapado;
                    $obj->usuCrea = $fila->usuCrea;
                    $obj->fecCrea = $fila->fecCrea;
                $lista[] = $obj;
            }
            return $lista;
        }
  

    }
?>
