<?php
    if (file_exists("../data/PropietarioLogData.php")) {
        include_once("../data/PropietarioLogData.php");
    }
    if (file_exists("../entidad/PropietarioLog.inc.php")) {
        include_once("../entidad/PropietarioLog.inc.php");
    }
    if (file_exists("../entidad/Constantes.php")) {
        include_once("../entidad/Constantes.php");
    }
    if (file_exists("../logica/EntidadLogica.php")) {
        include_once("../logica/EntidadLogica.php");
    }
    if (file_exists("../../logica/EntidadLogica.php")) {
        include_once("../../logica/EntidadLogica.php");
    }
    class PropietarioLogLogica{
        public $context;
        public function PropietarioLogLogica(){
            $this->context = new PropietarioLogData();
        }
         
        public function obtieneIdCooPropietario($ids){
        	$idProp=0;
            $registros = $this->context->obtieneIdsCooPropietario($ids);
            $arrIdsVal=explode(",",$ids);
            $cuentaLisProp=count($arrIdsVal);

           // echo $ids."<br> ".count($arrIdsVal)." = ".count($registros)." <br>";
            /*echo"...<pre>";
            print_r($arrIdsVal);
            echo"</pre>"; */
            if(is_array($registros)){
               // $arr=[];
	           //$cuenta=0;

                if($cuentaLisProp<=count($registros)){
                	/*foreach ($registros as $key => $value) {
                		$cuenta=0;*/
                        $valueLast=0;
                        $cuentaIgualdadProp=1;
                		foreach ($registros as $key2 => $value2) {
                			/*if($value==$value2){
                					$cuenta++; 
                			}*/
                            if($value2==$valueLast){
                                $cuentaIgualdadProp++;
                            }else{
                                $arrCooProps[]=$value2;
                            }
                        $valueLast=$value2;
                		}
                         if($cuentaIgualdadProp<=count($registros)) {
                          $idProp=$valueLast;
                		  
                        }
                	//}
                   // $idProp=max($arr);
                }
            	//echo "<pre>";            	print_r($arr);
            	
            }
         /*
            echo"<pre>";
            print_r($arrCooProps);
            echo"</pre>";
              echo"<br>pre .. ".$idProp."<br>";
              */
            if($idProp>0){
                  $idProp=0;

                /* SI SE OBTUBO UN ID DE CCOOPROIEDAD, COMPROBAR QUE LOS IDS ENTIDAD VALIDADOS
                * SEA  IGUAL AL TOTAL DE ID ENTIDAD CORRESPONDIENTE AL ID COPPROP ENCONRTADO
                * SI ES MAYOR, SIGNIFICA LOS PROP SELECC ESTAN INCLUIDOS EN LA COOPROP PERO NO SON TODOS
                */
                foreach ($arrCooProps as $key => $idPropFound) {
                    # code...
               
                $servicioEnte = new EntidadLogica();
                $codigosEntidad=$servicioEnte->listarIdEntidadXProp($idPropFound);
                if(count($codigosEntidad)==count($arrIdsVal)){
                     $c=0;
                foreach ($codigosEntidad as $key => $valueA) {
                        foreach ($arrIdsVal as $key => $value) {
                            if($valueA->IdEntidad==$value){
                                $c++;
                            }
                            if($c==count($arrIdsVal)){
                                $idProp=$valueA->idProp;
                                //echo "<br>".$valueA->idProp."<br>";
                                //break;
                            }
                            # code...
                        }
                    # code...
                    }
                } 
                /*
                echo"<pre>";
                print_r($codigosEntidad);
                echo"</pre>"; */
                
               }
              // echo"<br>pre .. ".$idProp."<br>";
                //if(count($codigosEntidad)>count($registros))  $idProp=0;

                 
            }
         // echo"<br>post ".$idProp."<br>";
          //die("stop xxx");
            return $idProp;
        }


        //si retorna 1  significa  es una coopropieda que existe
        //y puede continuar el proceso desde donde es invocado
         public function cuentaPropTempCoop($ids){
            //$ids='6883,6884,6882';
            $idsPropFound=0;
            $cuentaLisProp=count(explode(",",$ids));
            $registros = $this->context->obtieneIdsCooPropietario($ids);
          //  echo "<br> ".count(explode(",",$ids))." = ".count($registros)." <br>...<pre>";
          //  print_r($registros);
          //  echo"</pre>";
            if(is_array($registros)){
                //echo "<pre>";             print_r($arr);
                if(count($registros)==0){
                   $idsPropFound=1; 
                }
                
                if($cuentaLisProp==count($registros)){
                  //$idsPropFound=1;
                    $valueLast=0;
                    $cuentaIgualdadProp=1;
                   foreach ($registros as $key => $value) {
                      //  echo "<br>".$value." == ".$valueLast." ** ".$cuentaIgualdadProp."<br>";
                        if($value==$valueLast){
                            $cuentaIgualdadProp++;
                        }
                        $valueLast=$value;
                    }
                     if($cuentaIgualdadProp==count($registros))  $idsPropFound=1;
                }
            }
           // echo " xxx ..".$idsPropFound;
            return $idsPropFound;
        }

         public function buscarPropOriginalXEjemplar($idEjemplar){
            return $this->context->buscarPropOriginalXEjemplar($idEjemplar);
        }
    }
?>



 