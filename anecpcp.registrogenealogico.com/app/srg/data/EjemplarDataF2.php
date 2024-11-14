<?php date_default_timezone_set('UTC');
    include_once ("modelo.php");
    if (file_exists("../../entidad/Constantes.php")) include_once("../../entidad/Constantes.php");
    if (file_exists("../../entidad/Ejemplar.inc.php")) include_once("../../entidad/Ejemplar.inc.php");
    if (file_exists("../../entidad/Resultado.inc.php")) include_once("../../entidad/Resultado.inc.php");

    if (file_exists("../entidad/Ejemplar.inc.php")) include_once("../entidad/Ejemplar.inc.php");
    if (file_exists("../entidad/Resultado.inc.php")) include_once("../entidad/Resultado.inc.php");

  
    
    class EjemplarData extends dal{

        public $retorno;
          function __construct(){
            parent::dal();
            $retorno=new Resultado();
        }

        public function insertar($codigo,$prefijoProp,$nombre,$fecNace,$padre,$madre,$idPelaje,$lugarNace,$microchip,$adn,$descripcion,$usuCrea,$genero,$fecCapado,$idMonta,$idNac,$idProvincia,$origen,$resenias,$fecReg,$nroLibro,$nroFolio,$fecServ,$metodo,$idProp,$idPoe,$idCriador,$codigoGenerado){
          
             $resenias=serialize($resenias);
             $retorno=new Resultado();
            $sql = "CALL SGESI_POE_EJEMPLAR_INS('$codigo','$prefijoProp','$nombre','$fecNace','$padre','$madre','$idPelaje','$lugarNace','$microchip','$adn','$descripcion','$genero','$usuCrea','$fecCapado','$idMonta','$idNac','$idProvincia','$origen','$resenias','$fecReg','$nroLibro','$nroFolio','$fecServ','$metodo','$idProp','$idPoe','$idCriador','$codigoGenerado',@vresultado)";
         // echo $sql;
            $result = parent::ejecutar2($sql,'@vresultado');
            if($result){
                if($fila = mysqli_fetch_array($result)){
                  //  print_r($fila);
                   if($fila[0]==""){
                      $retorno->result=0;
                    }else if($fila[0]==3){
                      $retorno->result=3;
                    }else if($fila[0]==999){
                      $retorno->result=999;
                    }else if($fila[0]==998){
                      $retorno->result=998;
                    }else{
                      $retorno->result=1;
                      $retorno->code=$fila[0];
                    }
               }
            }else{
                     $retorno->result=0; 
            }

            return  $retorno;
        }
        //funcion para actualizar un registro
        public function editar($codigo,$prefijoProp,$nombre,$fecNace,$padre,$madre,$idPelaje,$lugarNace,$microchip,$adn,$descripcion,$genero,$usuModi,$fecCapado,$idMonta,$idNac,$idProvincia,$origen,$resenias,$fecModi,$nroLibro,$nroFolio,$fecServ,$metodo,$idProp,$idPoe,$idCriador,$codigoGenerado, $reseniaBasica){

            $resenias=serialize($resenias);

             $retorno=new Resultado();
        $sql = "CALL SGESU_POE_EJEMPLAR_INS('$codigo','$prefijoProp','$nombre','$fecNace','$padre','$madre','$idPelaje','$lugarNace','$microchip','$adn','$descripcion','$genero','$usuModi','$fecCapado','$idMonta','$idNac','$idProvincia','$origen','$resenias','$fecModi','$nroLibro','$nroFolio','$fecServ','$metodo','$idProp','$idPoe','$idCriador','$codigoGenerado','$reseniaBasica',@vresultado)";
         //echo $sql ; 
            $result = parent::ejecutar2($sql,'@vresultado');
           // echo "1";
            //echo $result;
            if($result){
               // echo "2";
                if($fila = mysqli_fetch_array($result)){
                   // echo "3";
                  // print_r($fila);
                   if($fila[0]==1){
                   // echo "4";
                     $retorno->result=1;
                    }else if($fila[0]==2){
                       // echo "5";
                     $retorno->result=2;
                    }else if($fila[0]==3){
                      $retorno->result=3;
                    }else if($fila[0]==999){
                      $retorno->result=999;
                    }else if($fila[0]==998){
                      $retorno->result=998;
                    }
             }
            }else{
                     $retorno->result=0; 
            }
            return  $retorno;
        }
        //funcion para eliminar un registro
        public function eliminarIns($codigo,$usuModi){
               $retorno=new Resultado();
            $sql = "CALL SGESD_POE_EJEMPLAR_INS('$codigo',@vresultado)";
            //echo $sql;
            $result = parent::ejecutar2($sql,'@vresultado');
            if($result){
               // echo "2";
                if($fila = mysqli_fetch_array($result)){
                   // echo "3";
                  // print_r($fila);
                   if($fila[0]==1){
                   // echo "4";
                     $retorno->result=1;
                    }else if($fila[0]==2){
                       // echo "5";
                     $retorno->result=2;
                    }else if($fila[0]==995){
                        // echo "5";
                      $retorno->result=995;
                    }
             }
            }else{
                     $retorno->result=0; 
            }
            return  $retorno;
        }
        public function fallece($codigo,$usuModi,$motivoFallece,$fecFallece){
             $retorno=new Resultado();
            $sql = "CALL SGESU_EJEMPLARFALLECE('$codigo','$usuModi','$motivoFallece','$fecFallece')";
           // echo $sql;
            $result = parent::ejecutar2($sql);
            if($result){
                return true;
            }else{
                return false;
            }
        }
        //function para obtener turno
        public function obtenerID($codigo){
             $retorno=new Resultado();
            $sql = "CALL SGESS_EJEMPLAR_X_ID('$codigo')";
            //echo $sql;
            $result = parent::ejecutar2($sql);
            if($fila = mysqli_fetch_object($result)){
                  $obj = new stdClass();
                  $obj->codigo = $fila->id;
                  $obj->prefijo = $fila->prefijo;
                  $obj->nombre = $fila->nombre;
                  $obj->fecNace=$fila->fecNace;
                  $obj->fecFallece=$fila->fecFallece;
                  $obj->motivoFallece=$fila->motivoFallece;
                  $obj->idPadre=$fila->idPadre;
                  $obj->idMadre=$fila->idMadre;
                  $obj->idPelaje=$fila->idPelaje;
                  $obj->LugarNace=$fila->LugarNace;
                  $obj->microchip=$fila->microchip;
                  $obj->adn=$fila->adn;
                  $obj->descripcion=$fila->descripcion;
                  $obj->genero=$fila->genero;
                  $obj->fecCapado=$fila->fecCapado;
                  $obj->idProvincia=$fila->idProvincia;
                  $obj->idResenias=$fila->idResenias;
                  $obj->fecNaceString=$fila->fecNaceString;
                  $obj->fecReg=$fila->fecReg;
                  $obj->fecRegString=$fila->fecRegString;
                  $obj->nroLibro=$fila->nroLibro;
                  $obj->nroFolio=$fila->nroFolio;
                  $obj->fecCrea=$fila->fecCrea;
                  $obj->fecServ=$fila->fecServ;
                  $obj->fecServString=$fila->fecServString;
                  $obj->idMetodo=$fila->idMetodo;
                  $obj->origen=$fila->origen;
                  $obj->reseniaBasica=$fila->reseniaBasica;
            }
            return $obj;
         }


      public function obtenerIDINS($codigo){
             $retorno=new Resultado();
            $sql = "CALL SGESS_POE_EJEMPLAR_X_SOL_INS('$codigo')";
          // echo $sql;
            $result = parent::ejecutar2($sql);
            if($fila = mysqli_fetch_object($result)){
                  $obj = new stdClass();
                  $obj->codigo = $fila->id;
                  $obj->prefijo = $fila->prefijo;
                  $obj->nombre = $fila->nombre;
                  $obj->fecNace=$fila->fecNace;
                  $obj->idMonta=$fila->idMonta;
                  $obj->codigoMonta=$fila->codigoMonta;
                  $obj->idNac=$fila->idNac;
                  $obj->codigoNacimiento=$fila->codigoNacimiento;
                  $obj->idPadre=$fila->idPadre;
                  $obj->idMadre=$fila->idMadre;
                  $obj->idPelaje=$fila->idPelaje;
                  $obj->LugarNace=$fila->LugarNace;
                  $obj->microchip=$fila->microchip;
                  $obj->adn=$fila->adn;
                  $obj->descripcion=$fila->descripcion;
                  $obj->genero=$fila->genero;
                  $obj->fecCapado=$fila->fecCapado;
                  $obj->idProvincia=$fila->idProvincia;
                  $obj->idResenias=$fila->idResenias;
                  $obj->fecNaceString=$fila->fecNaceString;
                  $obj->fecReg=$fila->fecReg;
                  $obj->fecRegString=$fila->fecRegString;
                  $obj->nroLibro=$fila->nroLibro;
                  $obj->nroFolio=$fila->nroFolio;
                  $obj->fecCrea=$fila->fecCrea;
                  $obj->fecCreaString=$fila->fecCreaString;
                  $obj->fecServ=$fila->fecServ;
                  $obj->fecServString=$fila->fecServString;
                  $obj->idMetodo=$fila->idMetodo; 
                  $obj->origen=$fila->origen;

                  $obj->nombrePadre=$fila->nombrePadre;
                  $obj->nombreMadre=$fila->nombreMadre;
                  $obj->idPoe=$fila->idPoe;
                  $obj->idProp=$fila->idProp;
                  $obj->idCriador=$fila->idCriador;
                  $obj->estadoSol=$fila->estadoSol;
                  $obj->estadoSolTexto=$fila->estadoSolTexto;
                  $obj->codigoInscripcion=$fila->codigoInscripcion;
                  $obj->pelaje=$fila->pelajeString;
                  $obj->provincia=$fila->provinciaString;
                  $obj->criador=$fila->CriadorString;
                  $obj->estadoSol=$fila->estadoSol;
                  $obj->comentario=$fila->comentario;
                  $obj->fecMonta=$fila->fecMonta;
                  $obj->usuCrea=$fila->usuCrea;

                  $obj->idReceptora=$fila->idReceptor;
                  $obj->fecEmbrion=$fila->fechaDeEmbrion;

                  $obj->fecFallece=$fila->fecFallece;
                  $obj->motivoFallece=$fila->motivoFallece;
                  $obj->detalleFallece=$fila->detalleFallece;

                  $obj->reseniaBasica=$fila->reseniaBasica;
            }
            return $obj;
  }
        //function para buscar
        public function buscar(){
             $retorno=new Resultado();
            $sql = "CALL SGESS_EJEMPLAR('')";
            $result = parent::ejecutar2($sql);
            while($fila = mysqli_fetch_object($result)){
                $obj = new Entidad();
                $obj->codigo = $fila->id;
                //$obj->nombreCorto = $fila->nombreCorto;
                //$obj->nombreLargo = $fila->nombreLargo;
                $turno[] = $obj;
            }
            return $turno;
        }
        
        public function numeroRegistro($id,$pref,$nom,$prop,$estado,$ente){
            // $retorno=new Resultado();
            if($emin=="")$emin=0;
           if($emax=="")$emax=0;
            $sql = "CALL SGESS_CUENTA_EJEMPLAR_INSCRIPCION_JQGRID('$id','$pref','$nom','$prop','$estado','$ente')";
      //  echo $sql ;
            $result = parent::ejecutar2($sql);
            $num_row=0;
            while ($fila = mysqli_fetch_object($result)){
                $num_row = $fila->num_row;
            }
            return $num_row;
        }
        public function buscarSearch($id,$pref,$nom,$prop,$estado,$ente, $start , $limit,$sidx,$sord){

           
            $sql = "CALL SGESS_EJEMPLAR_INSCRIPCION_JQGRID('$id','$pref','$nom','$prop','$estado','$ente','$start','$limit','$sidx','$sord')";
       // echo $sql;
            $result = parent::ejecutar2($sql);
            $ejemplares=[];
            while($fila = mysqli_fetch_object($result)){
               $obj = new stdClass();
                  $obj->codigo = $fila->id;
                  $obj->codigoInscripcion = $fila->codigoInscripcion;
                  $obj->prefijo = $fila->prefijo;
                  $obj->nombre = $fila->nombre;
                  $obj->fecNace=$fila->fecNace;
                  $obj->fecFallece=$fila->fecFallece;
                  /*$obj->motivoFallece=$fila->motivoFallece;
                  $obj->idPadre=$fila->idPadre;
                  $obj->idMadre=$fila->idMadre;*/
                  $obj->nombrePelaje=$fila->pelaje;
                  $obj->LugarNace=$fila->LugarNace;
                  $obj->microchip=$fila->microchip;
                  $obj->adn=$fila->adn;
                 // $obj->descripcion=$fila->descripcion;
                  $obj->estado=$fila->estado;
                  $obj->capado=$fila->capado;
                  $obj->propietarios=$fila->propiedad;
                  $obj->criadores=$fila->criador;
                  $obj->fecReg=$fila->fecReg;
                  $obj->fecCrea=$fila->fecCrea;
                  $obj->idProp=$fila->idProp;

                  $obj->idMetodo=$fila->idMetodo;

                  if($obj->idMetodo==Constantes::K_TRANSFER_EMBRION && date("Ymd")>=Constantes::K_FECHA_VALIDATE_TE){
                    if(!(strpos($obj->nombre,"- TE")>0 || strpos($obj->nombre,"-TE")>0)){
                            $obj->nombre=$obj->nombre." - TE";
                    } 
                  }
                   $obj->esSuperCamp=$fila->esSuperCamp;
                   $obj->codEjemplar = $fila->codEjemplar;
                   $obj->estadoSol = $fila->estadoSol;

                $ejemplares[] = $obj;
            }
            return $ejemplares;
        }
       


        public function getPrefijoProp($idProp){
           $retorno=new Resultado();
           $sql="CALL SGESS_GET_PREFIJO_PROP('$idProp')";
          //echo $sql;
           $result=parent::ejecutar2($sql);
            while ($fila=mysqli_fetch_object($result)) {
            $obj=new stdClass();
            $obj->prefijo=$fila->prefijo;
          }
          return $obj;
        }

       
         public function listarTipoDocumento(){
          $retorno=new Resultado();
          $sql="CALL SGESS_LIST_TIPO_DOC()";
          $metodo=[];
          $result=parent::ejecutar2($sql);
         // echo $sql;
          while ($fila=mysqli_fetch_object($result)) {
            $obj=new stdClass();
              $obj->valor=$fila->id;
              $obj->descripcion=$fila->descripcion;
              $metodo[]=$obj;
          }
          return $metodo;
        }


         public function getEstadosLogInscripcion($id){
          try {
          
          $sql="CALL SGESS_GET_ESTADOS_LOG_X_IDSOL('$id')";
          //echo $sql;
          $result=parent::ejecutar2($sql);
          $metodo=[];
          while ($fila=mysqli_fetch_object($result)) {

              $obj=new stdClass();
              $obj->codigo=$fila->id;
              $obj->estado=$fila->estado;
              $obj->estadoTexto=$fila->estadoTexto;
              $obj->fecSol=$fila->fecSol;
              $obj->comentario=$fila->comentario;
              $obj->usuCrea=$fila->usuCrea;

              $metodo[] = $obj;
            }

          } catch (mysqli_sql_exception  $e) {
              echo 'Excepción capturada: ',  $e->getMessage(), "\n";

          }
           // echo $fila;
            return $metodo;
        }

        public function getEstadosLogNacimiento($id){
          try {
          
          $sql="CALL SGESS_GET_ESTADOS_LOG_X_IDNAC('$id')";
          //echo $sql;
          $result=parent::ejecutar2($sql);
          $metodo=[];
          while ($fila=mysqli_fetch_object($result)) {

              $obj=new stdClass();
              $obj->codigo=$fila->id;
              $obj->estado=$fila->estado;
              $obj->estadoTexto=$fila->estadoTexto;
              $obj->fecSol=$fila->fecSol;
              $obj->comentario=$fila->comentario;
              $obj->usuCrea=$fila->usuCrea;

              $metodo[] = $obj;
            }

          } catch (mysqli_sql_exception  $e) {
              echo 'Excepción capturada: ',  $e->getMessage(), "\n";

          }
           // echo $fila;
            return $metodo;
        }

        public function obteneDatosInscripcionPrint($id,$codigoInscripcion,$prop,$origen){
          $retorno=new Resultado();
          $sql="CALL SGESS_INSCRIPCION_X_ID_PRINT('$id','$codigoInscripcion','$prop',$origen)";
          $metodo=[];
         //echo $sql;
          $result=parent::ejecutar2($sql);
          while ($fila=mysqli_fetch_object($result)) {
            $obj=new stdClass();
              $obj->id=$fila->id;
              $obj->nombre=$fila->nombre;
              $obj->prefijo=$fila->prefijo;
              $obj->fecCrea=$fila->fecCrea;
              $obj->genero=$fila->genero;
              $obj->pelaje=$fila->pelaje;
              $obj->fecNace=$fila->fecNace;
              $obj->codigoMonta=$fila->codigoMonta;
              $obj->codigoNacimiento=$fila->codigoNacimiento;
              $obj->foto=$fila->foto;
              $obj->propietario=$fila->propietario;
              $obj->idCriador=$fila->idCriador;
              $obj->criador=$fila->criador;
              $obj->LugarNace=$fila->LugarNace;
              $obj->prefijoPadre=$fila->prefijoPadre;
              $obj->nombrePadre=$fila->nombrePadre;
              $obj->pelajePadre=$fila->pelajePadre;
              $obj->idAbueloPadre=$fila->idAbueloPadre;
              $obj->nombreAbueloPadre=$fila->nombreAbueloPadre;
              $obj->prefijoAbueloPadre=$fila->prefijoAbueloPadre;
              $obj->idAbuelaPadre=$fila->idAbuelaPadre;
              $obj->nombreAbuelaPadre=$fila->nombreAbuelaPadre;
              $obj->prefijoAbuelaPadre=$fila->prefijoAbuelaPadre;
              $obj->idPadre=$fila->idPadre;
              $obj->prefijoMadre=$fila->prefijoMadre;
              $obj->nombreMadre=$fila->nombreMadre;
              $obj->pelajeMadre=$fila->pelajeMadre;
              $obj->idAbueloMadre=$fila->idAbueloMadre;
              $obj->nombreAbueloMadre=$fila->nombreAbueloMadre;
              $obj->prefijoAbueloMadre=$fila->prefijoAbueloMadre;
              $obj->idAbuelaMadre=$fila->idAbuelaMadre;
              $obj->nombreAbuelaMadre=$fila->nombreAbuelaMadre;
              $obj->prefijoAbuelaMadre=$fila->prefijoAbuelaMadre;
              $obj->idMadre=$fila->idMadre;
              $obj->metodo=$fila->metodo;
              $obj->idReceptor=$fila->idReceptor;
              $obj->idResenias=$fila->idResenias;
              $obj->diasGestacion=$fila->diasGestacion;
              $obj->fechaImpresion=$fila->fechaImpresion;
              $obj->usuCreaNac=$fila->usuCreaNac;
              $obj->usuCreaMonta=$fila->usuCreaMonta;
              $obj->fecCreaMonta=$fila->fecCreaMonta;
              $obj->fechaImpresion=$fila->fechaImpresion;
              $obj->usuImpresion=$fila->usuImpresion;
              $obj->reseniaBasica=$fila->reseniaBasica;
              $obj->isTE = $fila->isTE;
              $obj->fecEmbrion=$fila->fecEmbrion;
              $obj->documentosPDF = $fila->documentosPDF;
              $obj->estadoSolTexto=$fila->estadoSolTexto;
              $metodo[]=$obj;
          }
          //echo $metodo;
          return $metodo;
        }


        public function actualizarEstadoSol($id,$estado,$comentario,$idProp,$vProp,$vCria){

             $retorno=new Resultado();
        $sql = "CALL SGESU_ESTADO_SOL_X_ID('$id','$estado','$comentario','$idProp','$vProp','$vCria',@vresultado)";
        //echo $sql ; 
            $result = parent::ejecutar2($sql,'@vresultado');
           // echo "1";
            //echo $result;
            if($result){
               // echo "2";
                if($fila = mysqli_fetch_array($result)){
                   // echo "3";
                  // print_r($fila);
                   //echo strlen($fila[0]);
                   if($fila[0]==1){
                   // echo "4";
                     $retorno->result=1;
                    }else if(($fila[0])==2){
                       // echo "5";
                     $retorno->result=2;
                    }else if($fila[0]==998){
                     $retorno->result=998; 
                    }
                }
            }else{
                     $retorno->result=0; 
            }
            return  $retorno;
        }

        public function actualizarEstadoSolNac($id,$estado,$comentario,$idProp,$vProp,$vCria){

             $retorno=new Resultado();
        $sql = "CALL SGESU_ESTADO_SOL_X_IDNAC('$id','$estado','$comentario','$idProp','$vProp','$vCria',@vresultado)";
        //echo $sql ; 
            $result = parent::ejecutar2($sql,'@vresultado');
           // echo "1";
            //echo $result;
            if($result){
               // echo "2";
                if($fila = mysqli_fetch_array($result)){
                   // echo "3";
                  // print_r($fila);
                   //echo strlen($fila[0]);
                   if($fila[0]==1){
                   // echo "4";
                     $retorno->result=1;
                    }else if(($fila[0])==2){
                       // echo "5";
                     $retorno->result=2;
                    }else if($fila[0]==999){
                     $retorno->result=999; 
                    }else if($fila[0]==998){
                     $retorno->result=998; 
                    }
                }
            }else{
                     $retorno->result=0; 
            }
            return  $retorno;
        }

        public function getCodigoEjemplar($id){
              $retorno=new Resultado();
               $sql="CALL SGESS_GET_CODIGO_EJEMPLAR($id)";
               //echo $sql;
               $result=parent::ejecutar2($sql);
                while ($fila=mysqli_fetch_object($result)) {
                $obj=new stdClass();
                $obj->codEjemplar=$fila->codEjemplar;
              }
              return $obj;
        }


         public function numeroRegistroNovedades($anio,$mes,$prop,$flag){
            // $retorno=new Resultado();
            if($emin=="")$emin=0;
           if($emax=="")$emax=0;
            $sql = "CALL SGESS_CUENTA_NOVEDAD_JQGRID('$anio','$mes','$prop','$flag')";
        // echo $sql ;
            $result = parent::ejecutar2($sql);
            $num_row=0;
            while ($fila = mysqli_fetch_object($result)){
                $num_row = $fila->num_row;
            }
            return $num_row;
        }
        public function buscarSearchNovedades($anio,$mes,$prop,$flag,$start,$limit,$sidx,$sord){

           
            $sql = "CALL SGESS_LIST_NOVEDAD_JQGRID('$anio','$mes','$prop','$flag','$start','$limit','$sidx','$sord')";
         // echo $sql;
            $result = parent::ejecutar2($sql);
            $ejemplares=[];
            while($fila = mysqli_fetch_object($result)){
               $obj = new Ejemplar();
                  $obj->id = $fila->id;
                  $obj->codigo = $fila->codigo;
                  $obj->prefijo = $fila->prefijo;
                  $obj->ejemplar = $fila->ejemplar;
                  $obj->fecha=$fila->fecha;
                  $obj->fecCrea=$fila->fecCrea;
                  $obj->prop=$fila->prop;
                  $obj->nuevoPropietario=$fila->nomContacto;
                  $obj->comentarioSocio=$fila->comentarioSocio;
                  $obj->ruta=$fila->ruta;
                  $obj->estado=$fila->estado;
                  $obj->comentario=$fila->comentario;
                  $obj->fecRevision=$fila->fecRevision;
                  $obj->flagNewProp=$fila->flagNewProp;
                  $obj->codContacto=$fila->codContacto;
                $ejemplares[] = $obj;
            }
            return $ejemplares;
        }


        public function insertLogHistorial($id,$accion,$flag,$prop,$comentario,$fecha){

             $retorno=new Resultado();
        $sql = "CALL SGESI_LOG_HISTORIAL('$id','$accion','$flag','$prop','$comentario','$fecha',@vresultado)";
      
        //echo $sql ; 
           /**/ $result = parent::ejecutar2($sql,'@vresultado');
           // echo "1";
            //echo $result;
            if($result){
               // echo "2";
                if($fila = mysqli_fetch_array($result)){
                   // echo "3";
                  // print_r($fila);
                   //echo strlen($fila[0]);
                   if($fila[0]==1){
                   // echo "4";
                     $retorno->result=1;
                    }else {
                      $retorno->result=0;
                    }
             }
            }else{
                     $retorno->result=0; 
            }
            return  $retorno;
        }
       

       public function cantidadRregistroxAproOrRech(){
          $retorno=new Resultado();
          $sql="CALL SGESS_CANTIDAD_REG_HISTORIAL()";
          $metodo=[];
          $result=parent::ejecutar2($sql);
         // echo $sql;
          while ($fila=mysqli_fetch_object($result)) {
            $obj=new stdClass();
              $obj->cantidad=$fila->cantidad;
              $obj->tipo=$fila->tipo;
              $metodo[]=$obj;
          }
          return $metodo;
        }


        public function cantidadAllNovedades(){

             $retorno=new Resultado();
        $sql = "CALL SGESS_NOTIFICACIONES_ALL_NOVEDADES(@vresultado)";
       // echo $sql ; 
            $result = parent::ejecutar2($sql,'@vresultado');
           // echo "1";
            //echo $result;
            if($result){
               // echo "2";
                if($fila = mysqli_fetch_array($result)){
                   // echo "3";
                  // print_r($fila);
                   //echo strlen($fila[0]);
                   if($fila[0]==0){
                    //echo "4";
                     $retorno->result=0;
                    }else if($fila[0]==999){
                      $retorno->result=999;
                    }else {
                      //echo "5";
                      $retorno->result=$fila[0];
                    }
             }
            }else{
                     $retorno->result=0; 
            }
            return  $retorno;
        }

        public function cantidadAllInscripciones(){

             $retorno=new Resultado();
        $sql = "CALL SGESS_NOTIFICACIONES_ALL_INSCRIPCIONES(@vresultado)";
       // echo $sql ; 
            $result = parent::ejecutar2($sql,'@vresultado');
           // echo "1";
            //echo $result;
            if($result){
               // echo "2";
                if($fila = mysqli_fetch_array($result)){
                   // echo "3";
                  // print_r($fila);
                   //echo strlen($fila[0]);
                   if($fila[0]==0){
                    //echo "4";
                     $retorno->result=0;
                    }else if($fila[0]==999){
                      $retorno->result=999;
                    }else {
                      //echo "5";
                      $retorno->result=$fila[0];
                    }
             }
            }else{
                     $retorno->result=0; 
            }
            return  $retorno;
        }

        public function cantidadAllNacimientos(){

             $retorno=new Resultado();
        $sql = "CALL SGESS_NOTIFICACIONES_ALL_NACIMIENTOS(@vresultado)";
       // echo $sql ; 
            $result = parent::ejecutar2($sql,'@vresultado');
           // echo "1";
            //echo $result;
            if($result){
               // echo "2";
                if($fila = mysqli_fetch_array($result)){
                   // echo "3";
                  // print_r($fila);
                   //echo strlen($fila[0]);
                   if($fila[0]==0){
                    //echo "4";
                     $retorno->result=0;
                    }else if($fila[0]==999){
                      $retorno->result=999;
                    }else {
                      //echo "5";
                      $retorno->result=$fila[0];
                    }
             }
            }else{
                     $retorno->result=0; 
            }
            return  $retorno;
        }


        public function getInfoHistorialAll($id){

           
            $sql = "CALL SGESS_HISTORIAL_ALL('$id')";
          // echo $sql;
            $result = parent::ejecutar2($sql);
            while($fila = mysqli_fetch_object($result)){
               $obj = new stdClass();
                  $obj->id = $fila->id;
                  $obj->prefijo = $fila->prefijo;
                  $obj->nombre = $fila->nombre;
                  $obj->propietario = $fila->propietario;
                  $obj->codigoMonta=$fila->codigoMonta;
                  $obj->prefijoPotro=$fila->prefijoPotro;
                  $obj->nombrePotro=$fila->nombrePotro;
                  $obj->codPotro=$fila->codPotro;
                  $obj->prefijoYegua=$fila->prefijoYegua;
                  $obj->nombreYegua=$fila->nombreYegua;
                  $obj->codYegua=$fila->codYegua;
                  $obj->metodo=$fila->metodo;
                  $obj->isTE=$fila->isTE;
                  $obj->idReceptor=$fila->idReceptor;
                  $obj->fecMonta=$fila->fecMonta;
                  $obj->fecCrea=$fila->fecCrea;
                  $obj->responsableMonta=$fila->responsableMonta;
                  $obj->fecParir=$fila->fecParir;
                  $obj->fecEmbrion=$fila->fecEmbrion;
                  $obj->idNac=$fila->idNac;
                  $obj->codigoNacimiento=$fila->codigoNacimiento;
                  $obj->prefijoNac=$fila->prefijoNac;
                  $obj->nombreNac=$fila->nombreNac;
                  $obj->generoNac=$fila->generoNac;
                  $obj->pelajeNac=$fila->pelajeNac;
                  $obj->fecNaceNac=$fila->fecNaceNac;
                  $obj->origenNac=$fila->origenNac;
                  $obj->idReseniasNac=$fila->idReseniasNac;
                  $obj->reseniaBasicaNac=$fila->reseniaBasicaNac;
                  $obj->criadorNac=$fila->criadorNac;
                  $obj->responsableNac=$fila->responsableNac;
                  $obj->fecSol=$fila->fecSol;
                  $obj->idIns=$fila->idIns;
                  $obj->codigoInscripcion=$fila->codigoInscripcion;
                  $obj->prefijoIns=$fila->prefijoIns;
                  $obj->nombreIns=$fila->nombreIns;
                  $obj->generoIns=$fila->generoIns;
                  $obj->pelajeIns=$fila->pelajeIns;
                  $obj->fecNaceIns=$fila->fecNaceIns;
                  $obj->origenIns=$fila->origenIns;
                  $obj->idReseniasIns=$fila->idReseniasIns;
                  $obj->criadorIns=$fila->criadorIns;
                  $obj->responsableIns=$fila->responsableIns;
                  $obj->reseniaBasicaIns=$fila->reseniaBasicaIns;
                 // $obj->resp=$fila->resp;
                 // $obj->fecApro=$fila->fecApro;

            }
            return $obj;
        }

        public function getInfoUsuarioApro($id){

           
            $sql = "CALL SGESS_GET_USUARIO_APRO_HISTORIAL('$id')";
          // echo $sql;
            $result = parent::ejecutar2($sql);
            while($fila = mysqli_fetch_object($result)){
               $obj = new stdClass();
                  $obj->usuarioApro=$fila->usuarioApro;
                  $obj->fecApro=$fila->fecApro;

            }
            return $obj;
        }

        
        public function getLastInsertIns(){
           $retorno=new Resultado();
           $sql="CALL SGESS_LAST_INS_INS()";
           //echo $sql;
           $result=parent::ejecutar2($sql);
            while ($fila=mysqli_fetch_object($result)) {
            $obj=new stdClass();
            $obj->codigoInscripcion=$fila->codigoInscripcion;
            $obj->id=$fila->id;
          }
          return $obj;
        }

         public function numeroRegistroNacimiento($id,$pref,$nom,$prop,$estado,$ente){
            // $retorno=new Resultado();
            if($emin=="")$emin=0;
           if($emax=="")$emax=0;
            $sql = "CALL SGESS_CUENTA_EJEMPLAR_NACIMIENTO_JQGRID('$id','$pref','$nom','$prop','$estado','$ente')";
      //  echo $sql ;
            $result = parent::ejecutar2($sql);
            $num_row=0;
            while ($fila = mysqli_fetch_object($result)){
                $num_row = $fila->num_row;
            }
            return $num_row;
        }
        public function buscarSearchNacimiento($id,$pref,$nom,$prop,$estado,$ente, $start , $limit,$sidx,$sord){

           
            $sql = "CALL SGESS_EJEMPLAR_NACIMIENTO_JQGRID('$id','$pref','$nom','$prop','$estado','$ente','$start','$limit','$sidx','$sord')";
        //echo $sql;
            $result = parent::ejecutar2($sql);
            $ejemplares=[];
            while($fila = mysqli_fetch_object($result)){
               $obj = new stdClass();
                  $obj->codigo = $fila->id;
                  $obj->codigoNacimiento = $fila->codigoNacimiento;
                  $obj->prefijo = $fila->prefijo;
                  $obj->nombre = $fila->nombre;
                  $obj->fecNace=$fila->fecNace;
                  $obj->fecFallece=$fila->fecFallece;
                  /*$obj->motivoFallece=$fila->motivoFallece;
                  $obj->idPadre=$fila->idPadre;
                  $obj->idMadre=$fila->idMadre;*/
                  $obj->nombrePelaje=$fila->pelaje;
                  $obj->LugarNace=$fila->LugarNace;
                  $obj->microchip=$fila->microchip;
                  $obj->adn=$fila->adn;
                 // $obj->descripcion=$fila->descripcion;
                  $obj->estado=$fila->estado;
                  $obj->capado=$fila->capado;
                  $obj->propietarios=$fila->propiedad;
                  $obj->criadores=$fila->criador;
                  $obj->fecReg=$fila->fecReg;
                  $obj->fecCrea=$fila->fecCrea;
                  $obj->idProp=$fila->idProp;

                  $obj->idMetodo=$fila->idMetodo;

                  if($obj->idMetodo==Constantes::K_TRANSFER_EMBRION && date("Ymd")>=Constantes::K_FECHA_VALIDATE_TE){
                    if(!(strpos($obj->nombre,"- TE")>0 || strpos($obj->nombre,"-TE")>0)){
                            $obj->nombre=$obj->nombre." - TE";
                    } 
                  }
                   $obj->esSuperCamp=$fila->esSuperCamp;
                   $obj->codEjemplar = $fila->codEjemplar;
                   $obj->activo=$fila->activo;
                   $obj->estadoSol=$fila->estadoSol;

                $ejemplares[] = $obj;
            }
            return $ejemplares;
        }


        public function insertarNac($codigo,$prefijoProp,$nombre,$fecNace,$padre,$madre,$idPelaje,$lugarNace,$microchip,$adn,$descripcion,$usuCrea,$genero,$fecCapado,$idMonta,$idProvincia,$origen,$resenias,$fecReg,$nroLibro,$nroFolio,$fecServ,$metodo,$idProp,$idPoe,$idCriador,$codigoGenerado){
          
             $resenias=serialize($resenias);
             $retorno=new Resultado();
            $sql = "CALL SGESI_POE_EJEMPLAR_NAC('$codigo','$prefijoProp','$nombre','$fecNace','$padre','$madre','$idPelaje','$lugarNace','$microchip','$adn','$descripcion','$genero','$usuCrea','$fecCapado','$idMonta','$idProvincia','$origen','$resenias','$fecReg','$nroLibro','$nroFolio','$fecServ','$metodo','$idProp','$idPoe','$idCriador','$codigoGenerado',@vresultado)";
         // echo $sql;
            $result = parent::ejecutar2($sql,'@vresultado');
            if($result){
                if($fila = mysqli_fetch_array($result)){
                  //  print_r($fila);
                   if($fila[0]==""){
                      $retorno->result=0;
                    }else if($fila[0]==3){
                      $retorno->result=3;
                    }else if($fila[0]==999){
                      $retorno->result=999;
                    }else if($fila[0]==998){
                      $retorno->result=998;
                    }else{
                      $retorno->result=1;
                      $retorno->code=$fila[0];
                    }
               }
            }else{
                     $retorno->result=0; 
            }

            return  $retorno;
        }
        //funcion para actualizar un registro
        public function editarNac($codigo,$prefijoProp,$nombre,$fecNace,$padre,$madre,$idPelaje,$lugarNace,$microchip,$adn,$descripcion,$genero,$usuModi,$fecCapado,$idMonta,$idProvincia,$origen,$resenias,$fecModi,$nroLibro,$nroFolio,$fecServ,$metodo,$idProp,$idPoe,$idCriador,$codigoGenerado,$reseniaBasica){

            $resenias=serialize($resenias);

             $retorno=new Resultado();
        $sql = "CALL SGESU_POE_EJEMPLAR_NAC('$codigo','$prefijoProp','$nombre','$fecNace','$padre','$madre','$idPelaje','$lugarNace','$microchip','$adn','$descripcion','$genero','$usuModi','$fecCapado','$idMonta','$idProvincia','$origen','$resenias','$fecModi','$nroLibro','$nroFolio','$fecServ','$metodo','$idProp','$idPoe','$idCriador','$codigoGenerado','$reseniaBasica',@vresultado)";
        // echo $sql ; 
            $result = parent::ejecutar2($sql,'@vresultado');
           // echo "1";
            //echo $result;
            if($result){
               // echo "2";
                if($fila = mysqli_fetch_array($result)){
                   // echo "3";
                  // print_r($fila);
                   if($fila[0]==1){
                   // echo "4";
                     $retorno->result=1;
                    }else if($fila[0]==2){
                       // echo "5";
                     $retorno->result=2;
                    }else if($fila[0]==3){
                      $retorno->result=3;
                    }else if($fila[0]==999){
                      $retorno->result=999;
                    }else if($fila[0]==998){
                      $retorno->result=998;
                    }
             }
            }else{
                     $retorno->result=0; 
            }
            return  $retorno;
        }
        

        public function obtenerIDNAC($codigo){
             $retorno=new Resultado();
            $sql = "CALL SGESS_POE_EJEMPLAR_X_NAC('$codigo')";
           // echo $sql;
            $result = parent::ejecutar2($sql);
            if($fila = mysqli_fetch_object($result)){
                  $obj = new stdClass();
                  $obj->codigo = $fila->id;
                  $obj->prefijo = $fila->prefijo;
                  $obj->nombre = $fila->nombre;
                  $obj->fecNace=$fila->fecNace;
                  $obj->idMonta=$fila->idMonta;
                  $obj->idPadre=$fila->idPadre;
                  $obj->idMadre=$fila->idMadre;
                  $obj->idPelaje=$fila->idPelaje;
                  $obj->LugarNace=$fila->LugarNace;
                  $obj->microchip=$fila->microchip;
                  $obj->adn=$fila->adn;
                  $obj->descripcion=$fila->descripcion;
                  $obj->genero=$fila->genero;
                  $obj->fecCapado=$fila->fecCapado;
                  $obj->idProvincia=$fila->idProvincia;
                  $obj->idResenias=$fila->idResenias;
                  $obj->fecNaceString=$fila->fecNaceString;
                  $obj->fecReg=$fila->fecReg;
                  $obj->fecRegString=$fila->fecRegString;
                  $obj->nroLibro=$fila->nroLibro;
                  $obj->nroFolio=$fila->nroFolio;
                  $obj->fecCrea=$fila->fecCrea;
                  $obj->fecServ=$fila->fecServ;
                  $obj->fecServString=$fila->fecServString;
                  $obj->idMetodo=$fila->idMetodo; 
                  $obj->origen=$fila->origen;

                  $obj->nombrePadre=$fila->nombrePadre;
                  $obj->nombreMadre=$fila->nombreMadre;
                  $obj->idPoe=$fila->idPoe;
                  $obj->idProp=$fila->idProp;
                  $obj->idCriador=$fila->idCriador;
                  $obj->estadoSol=$fila->estadoSol;
                  $obj->estadoSolTexto=$fila->estadoSolTexto;
                  $obj->codigoNacimiento=$fila->codigoNacimiento;
                  $obj->codigoMonta=$fila->codigoMonta;
                  $obj->fecMonta=$fila->fecMonta;

                  $obj->pelaje=$fila->pelajeString;
                  $obj->provincia=$fila->provinciaString;
                  $obj->criador=$fila->CriadorString;
                  $obj->comentario=$fila->comentario;
                  $obj->usuCrea=$fila->usuCrea;

                  $obj->idReceptora=$fila->idReceptor;
                  $obj->fecEmbrion=$fila->fecEmbrion;

                  $obj->fecFallece=$fila->fecFallece;
                  $obj->motivoFallece=$fila->motivoFallece;
                  $obj->detalleFallece=$fila->detalleFallece;

                  $obj->reseniaBasica=$fila->reseniaBasica;
            }
                return $obj;
          }

          public function eliminarNAC($codigo){
             $retorno=new Resultado();
            $sql = "CALL SGESD_POE_EJEMPLAR_NAC('$codigo',@vresultado)";
            //echo $sql;
            $result = parent::ejecutar2($sql,'@vresultado');
            if($result){
               // echo "2";
                if($fila = mysqli_fetch_array($result)){
                   // echo "3";
                  // print_r($fila);
                   if($fila[0]==1){
                   // echo "4";
                     $retorno->result=1;
                    }else if($fila[0]==2){
                       // echo "5";
                     $retorno->result=2;
                    }else if($fila[0]==995){
                        // echo "5";
                      $retorno->result=995;
                    }
             }
            }else{
                     $retorno->result=0; 
            }
            return  $retorno;
        }

        public function obteneDatosNacimientoPrint($id,$codigoNacimiento,$prop,$origen){
          $retorno=new Resultado();
          $sql="CALL SGESS_NACIMIENTO_X_ID_PRINT('$id','$codigoNacimiento','$prop',$origen)";
          $metodo=[];
         //echo $sql;
          $result=parent::ejecutar2($sql);
          while ($fila=mysqli_fetch_object($result)) {
            $obj=new stdClass();
              $obj->id=$fila->id;
              $obj->nombre=$fila->nombre;
              $obj->prefijo=$fila->prefijo;
              $obj->fecCrea=$fila->fecCrea;
              $obj->genero=$fila->genero;
              $obj->pelaje=$fila->pelaje;
              $obj->fecNace=$fila->fecNace;
              $obj->codigoMonta=$fila->codigoMonta;
              $obj->codigoNacimiento=$fila->codigoNacimiento;
              $obj->foto=$fila->foto;
              $obj->propietario=$fila->propietario;
              $obj->idCriador=$fila->idCriador;
              $obj->criador=$fila->criador;
              $obj->LugarNace=$fila->LugarNace;
              $obj->prefijoPadre=$fila->prefijoPadre;
              $obj->nombrePadre=$fila->nombrePadre;
              $obj->pelajePadre=$fila->pelajePadre;
              $obj->idAbueloPadre=$fila->idAbueloPadre;
              $obj->nombreAbueloPadre=$fila->nombreAbueloPadre;
              $obj->prefijoAbueloPadre=$fila->prefijoAbueloPadre;
              $obj->idAbuelaPadre=$fila->idAbuelaPadre;
              $obj->nombreAbuelaPadre=$fila->nombreAbuelaPadre;
              $obj->prefijoAbuelaPadre=$fila->prefijoAbuelaPadre;
              $obj->idPadre=$fila->idPadre;
              $obj->prefijoMadre=$fila->prefijoMadre;
              $obj->nombreMadre=$fila->nombreMadre;
              $obj->pelajeMadre=$fila->pelajeMadre;
              $obj->idAbueloMadre=$fila->idAbueloMadre;
              $obj->nombreAbueloMadre=$fila->nombreAbueloMadre;
              $obj->prefijoAbueloMadre=$fila->prefijoAbueloMadre;
              $obj->idAbuelaMadre=$fila->idAbuelaMadre;
              $obj->nombreAbuelaMadre=$fila->nombreAbuelaMadre;
              $obj->prefijoAbuelaMadre=$fila->prefijoAbuelaMadre;
              $obj->idMadre=$fila->idMadre;
              $obj->metodo=$fila->metodo;
              $obj->idReceptor=$fila->idReceptor;
              $obj->idResenias=$fila->idResenias;
              $obj->diasGestacion=$fila->diasGestacion;
              $obj->usuCreaNac=$fila->usuCreaNac;
              $obj->usuCreaMonta=$fila->usuCreaMonta;
              $obj->fecCreaMonta=$fila->fecCreaMonta;
              $obj->fechaImpresion=$fila->fechaImpresion;
              $obj->usuImpresion=$fila->usuImpresion;
              $obj->reseniaBasica=$fila->reseniaBasica;
              $obj->fecEmbrion=$fila->fecEmbrion;
              $obj->documentosPDF = $fila->documentosPDF;
              $obj->estadoSolTexto=$fila->estadoSolTexto;
              $obj->isTE = $fila->isTE;
              $metodo[]=$obj;
          }
          //echo $metodo;
          return $metodo;
        }


       public function getLastInsertNac(){
           $retorno=new Resultado();
           $sql="CALL SGESS_LAST_NAC_INS()";
           //echo $sql;
           $result=parent::ejecutar2($sql);
            while ($fila=mysqli_fetch_object($result)) {
            $obj=new stdClass(); 
            $obj->codigoNacimiento=$fila->codigoNacimiento;
            $obj->id=$fila->id;
          }
          return $obj;
        }


        public function numeroRegistroMonta($anio,$mes,$prop,$estado,$activo){
            // $retorno=new Resultado();
            if($emin=="")$emin=0;
           if($emax=="")$emax=0;
            $sql = "CALL SGESS_CUENTA_MONTA_JQGRID('$anio','$mes','$prop','$estado',$activo)";
        // echo $sql ;
            $result = parent::ejecutar2($sql);
            $num_row=0;
            while ($fila = mysqli_fetch_object($result)){
                $num_row = $fila->num_row;
            }
            return $num_row;
        }
        public function buscarSearchMonta($anio,$mes,$prop,$estado,$start,$limit,$sidx,$sord,$activo){

           
            $sql = "CALL SGESS_LIST_MONTA_JQGRID('$anio','$mes','$prop','$estado','$start','$limit','$sidx','$sord',$activo)";
           // echo $sql;
            $result = parent::ejecutar2($sql);
            $ejemplares=[];
            while($fila = mysqli_fetch_object($result)){
               $obj = new Ejemplar();
                  $obj->id = $fila->id;
                  $obj->codigoMonta = $fila->codigoMonta;
                  $obj->yegua = $fila->prefYegua.' '.$fila->nombreYegua.' '.$fila->codYegua;
                  $obj->codPotro=$fila->codPotro;
                  $obj->codYegua=$fila->codYegua;
                  $obj->idPotroExtranjero=$fila->codPotro;
                  $obj->idYeguaExtranjero=$fila->codYegua;
                  $obj->potro = $fila->prefPotro.' '.$fila->nomPotro.' '.$fila->codPotro;
                  $obj->idUser = $fila->idUser;
                  $obj->metodo=$fila->textoMetodo;
                  $obj->fecMonta=$fila->fecha;
                  $obj->fecParir=$fila->fecParir;
                  $obj->fecReg=$fila->fecCrea;
                  $obj->estado=$fila->estado;
                  $obj->flagExtP=$fila->flagExtP;
                  $obj->flagExtY=$fila->flagExtY;
                  $obj->btnflag=$fila->btnflag;
                  $obj->flagPeruP = $fila->flagPeruP;
                  $obj->flagPeruY = $fila->flagPeruY;
                  $obj->idReceptor=$fila->idReceptor;
                  $obj->fecEmbrion=$fila->fecEmbrion;
                  $obj->flagTercero=$fila->flagTercero;
                  $obj->flagDocP=$fila->flagDocP;
                  $obj->flagDocY=$fila->flagDocY;
                  $obj->activo=$fila->activo;
                $ejemplares[] = $obj;
            }
            return $ejemplares;
        }

        public function aprobarMonta($id,$prop){

             $retorno=new Resultado();
        $sql = "CALL SGESU_APROBAR_MONTA('$id','$prop',@vresultado,'1')";
       //echo $sql ; 
            $result = parent::ejecutar2($sql,'@vresultado');
            if($result){
                if($fila = mysqli_fetch_array($result)){
                   if($fila[0]==1){
                     $retorno->result=1;
                    }else {
                      $retorno->result=0;
                    }
             }
            }else{
                     $retorno->result=0; 
            }
            return  $retorno;
        }

        public function rechazarMonta($id,$prop){

             $retorno=new Resultado();
        $sql = "CALL SGESU_RECHAZAR_MONTA('$id','$prop',@vresultado,'1')";
        //echo $sql ; 
            $result = parent::ejecutar2($sql,'@vresultado');
            if($result){
                if($fila = mysqli_fetch_array($result)){
                   if($fila[0]==1){
                     $retorno->result=1;
                    }else {
                      $retorno->result=0;
                    }
             }
            }else{
                     $retorno->result=0; 
            }
            return  $retorno;
        }

        public function obteneDatosServicioMontaPrint($id,$codigoMonta,$prop,$origen){
          $retorno=new Resultado();
          $sql="CALL SGESS_SERVICIOY_X_ID_PRINT('$id','$codigoMonta','$prop',$origen)";
          $metodo=[];
        // echo $sql;
          $result=parent::ejecutar2($sql);
          while ($fila=mysqli_fetch_object($result)) {
            $obj=new stdClass();
              $obj->id=$fila->id;
              $obj->fecMonta=$fila->fecMonta;
              $obj->metodo=$fila->metodo;
              $obj->textoMetodo=$fila->textoMetodo;
              $obj->codYegua=$fila->codYegua;
              $obj->codPotro=$fila->codPotro;
              $obj->idPoe=$fila->idPoe;
              $obj->prefYegua=$fila->prefYegua;
              $obj->yegua=$fila->yegua;
              $obj->prefPotro=$fila->prefPotro;
              $obj->potro=$fila->potro;
              $obj->isTE=$fila->isTE;
              $obj->fecParir=$fila->fecParir;
              $obj->codigoMonta=$fila->codigoMonta;
              $obj->idReceptor=$fila->idReceptor;
              $obj->padreADN=$fila->adnPotro;
              $obj->madreADN=$fila->adnYegua;
              $obj->fecCrea=$fila->fecCrea;
              $obj->usuCrea=$fila->usuCrea;
              $obj->fecEmbrion=$fila->fecEmbrion;
              $obj->fechaImpresion=$fila->fechaImpresion;
              $obj->usuImpresion=$fila->usuImpresion;
              $metodo[]=$obj;
          }
          //echo $metodo;
          return $metodo;
        }

        public function listarPais(){
          $retorno=new Resultado();
          $sql="CALL SGESS_LISTAR_PAIS()";
          $metodo=[];
          $result=parent::ejecutar2($sql);
         // echo $sql;
          while ($fila=mysqli_fetch_object($result)) {
            $obj=new stdClass();
              $obj->valor=$fila->id;
              $obj->descripcion=$fila->nombre;
              $metodo[]=$obj;
          }
          return $metodo;
        }

        public function getDatosExtranjero($id){
            $retorno=new Resultado();
            $sql="CALL SGESS_EJEMPLAR_EXTRANJERO('$id')";
          // echo $sql ; 
                 $result = parent::ejecutar2($sql);
                if($fila = mysqli_fetch_object($result)){
                      $obj = new stdClass();
                      $obj->id = $fila->id;
                      $obj->codigo = $fila->codigo;
                      $obj->prefijo = $fila->prefijo;
                      $obj->nombre = $fila->nombre;
                      $obj->fecNace=$fila->fecNace;
                      $obj->idPelaje=$fila->idPelaje;
                      $obj->idPais=$fila->idPais;
                      $obj->genero=$fila->genero;
                     
                }
                    return $obj;
        }



        public function updateDatosExtranjero($id,$codigo,$nombre,$prefijo,$dtpFecNacExt,$pelaje,$pais){

             $retorno=new Resultado();
        $sql = "CALL SGESU_DATOS_EJEMPLAR_EXTRANJERO('$id','$codigo','$nombre','$prefijo','$dtpFecNacExt','$pelaje','$pais',@vresultado)";
        //echo $sql ; 
            $result = parent::ejecutar2($sql,'@vresultado');
            if($result){
                if($fila = mysqli_fetch_array($result)){
                   if($fila[0]==1){
                     $retorno->result=1;
                    }else {
                      $retorno->result=0;
                    }
             }
            }else{
                     $retorno->result=0; 
            }
            return  $retorno;
        }

        public function detalleAprobacion($id){
            $retorno=new Resultado();
            $sql="CALL SGESS_DETALLE_APROBACION_MONTA('$id')";
          // echo $sql ; 
                 $result = parent::ejecutar2($sql);
                if($fila = mysqli_fetch_object($result)){
                      $obj = new stdClass();
                      $obj->sociop = $fila->sociop;
                      $obj->mensajeP = $fila->mensajeP;
                      $obj->socioy = $fila->socioy;
                      $obj->mensajeY = $fila->mensajeY;
                      $obj->fecAproPotro = $fila->fecAproPotro;
                      $obj->fecAproYegua = $fila->fecAproYegua;
                      $obj->origenAprRec = $fila->origenAprRec;
                      $obj->fecOrigen = $fila->fecOrigen;
                }
                    return $obj;
        }

        public function listaComboIdMonta($prop,$flag){
          $retorno=new Resultado();
          $sql="CALL SGESS_LIST_ID_MONTA('$prop','$flag')";
          $metodo=[];
         // echo $sql;
          $result=parent::ejecutar2($sql);
          while ($fila=mysqli_fetch_object($result)) {
            $obj=new stdClass();
              $obj->id=$fila->id;
              $obj->descripcion=$fila->descripcion;
              $metodo[]=$obj;
          }
          return $metodo;
        }

        public function listaComboIdNac($prop,$flag){
          $retorno=new Resultado();
          $sql="CALL SGESS_LIST_ID_NAC('$prop','$flag')";
          $metodo=[];
          $result=parent::ejecutar2($sql);
          //echo $sql;
          while ($fila=mysqli_fetch_object($result)) {
            $obj=new stdClass();
              $obj->id=$fila->id;
              $obj->descripcion=$fila->descripcion;
              $metodo[]=$obj;
          }
          return $metodo;
        }

        public function getFechaNovedades($id,$flag){
          $retorno=new Resultado();
          $sql="CALL SGESS_GET_FECHA_NOVEDADES('$id','$flag')";
          $metodo=[];
         // echo $sql;
          $result=parent::ejecutar2($sql);
          while ($fila=mysqli_fetch_object($result)) {
            $obj=new stdClass();
              $obj->id=$fila->id;
              $obj->fecha=$fila->fecha;
             // $metodo[]=$obj;
          }
          return $obj;
        }

        public function getInfoNewProp($idProp){
          $retorno=new Resultado();
          $sql="CALL SGESS_ENTIDAD_TMP_X_ID('$idProp')";
          $metodo=[];
         // echo $sql;
          $result=parent::ejecutar2($sql);
          while ($fila=mysqli_fetch_object($result)) {
            $obj=new stdClass();
              $obj->id=$fila->id;
              $obj->idTipoDoc=$fila->idTipoDoc;
              $obj->numDoc=$fila->numDoc;
              $obj->apePaterno=$fila->apePaterno;
              $obj->apeMaterno=$fila->apeMaterno;
              $obj->nombres=$fila->nombres;
              $obj->correo=$fila->correo;
              $obj->observacion=$fila->observacion;
             // $metodo[]=$obj;
          }
          return $obj;
        }

        public function updateDatosNewProp($id,$tipoDoc,$numDoc,$nombreProp,$apePatProp,$apeMatProp,$direccion,$correo,$idProp){

             $retorno=new Resultado();
        $sql = "CALL SGESU_DATOS_ENTIDAD_TMP('$id','$tipoDoc','$numDoc','$nombreProp','$apePatProp','$apeMatProp','$direccion','$correo','$idProp',@vresultado)";
        //echo $sql ; 
            $result = parent::ejecutar2($sql,'@vresultado');
            if($result){
                if($fila = mysqli_fetch_array($result)){
                   if($fila[0]==1){
                     $retorno->result=1;
                    }else {
                      $retorno->result=0;
                    }
             }
            }else{
                     $retorno->result=0; 
            }
            return  $retorno;
        }
        public function listarMotivoBaja()
  {
    $retorno = new Resultado();
    $sql = "CALL SGESS_MOTIVO_BAJA()";
    $metodo = [];
    $result = parent::ejecutar2($sql);
    // echo $sql;
    while ($fila = mysqli_fetch_object($result)) {
      $obj = new stdClass();
      $obj->id = $fila->id;
      $obj->motivo = $fila->motivo;
      $metodo[] = $obj;
    }
    return $metodo;
  }

  public function eliminarMonta($id,$usuEliminado){
    $sql = "CALL SGESD_MONTA_X_ID('$id','$usuEliminado',@vresultado)";
    //echo $sql;
    $result=parent::ejecutar2($sql,'@vresultado');
    $retorno=new Resultado();
    if($result){
      if($fila = mysqli_fetch_array($result)){
         if($fila[0]==1){
           $retorno->result=1;
          }else if($fila[0]==2){
            $retorno->result=2;
          }else {
            $retorno->result=0;
          }
        }
      }else{
           $retorno->result=0; 
      }
    return  $retorno;
    }
    }
    
?>
