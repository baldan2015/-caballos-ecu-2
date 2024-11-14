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

        /*
        autor: dbs - 20160725
        nombre function
            insertar
        parametro entrada
            $nombre: nombre del pelaje obligatorio y no debe repetirse
        parametro de retorno
            $retorno->result: [0 1 2]
            0=error en el ejecucion del store
            1=inserto ok
            2=no inserto. Ya existe el parametro nombre como data/
        */
        public function insertar($codigo,$prefijo,$nombre,$fecNace,$padre,$madre,$idPelaje,$lugarNace,$microchip,$adn,$descripcion,$usuCrea,$genero,$fecCapado,$fecFallece,$motivoFallece,$idProvincia,$origen,$resenias,$fecReg,$nroLibro,$nroFolio,$fecServ,$metodo,$reseniaBasica){
          
             $resenias=serialize($resenias);
             $retorno=new Resultado();
            $sql = "CALL SGESI_EJEMPLAR('$codigo','$prefijo','$nombre','$fecNace','$padre','$madre','$idPelaje','$lugarNace','$microchip','$adn','$descripcion','$genero','$usuCrea','$fecCapado','$fecFallece','$motivoFallece','$idProvincia','$origen','$resenias','$fecReg','$nroLibro','$nroFolio','$fecServ','$metodo','$reseniaBasica',@vresultado)";
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
        public function editar($codigo,$prefijo,$nombre,$fecNace,$padre,$madre,$idPelaje,$lugarNace,$microchip,$adn,$descripcion,$usuModi, $genero,$fecCapado,$fecFallece,$motivoFallece,$idProvincia,$resenias,$fecReg,$nroLibro,$nroFolio,$fecServ,$metodo,$origen,$reseniaBasica){

            $resenias=serialize($resenias);

             $retorno=new Resultado();
        $sql = "CALL SGESU_EJEMPLAR('$codigo','$prefijo','$nombre','$fecNace','$padre','$madre','$idPelaje','$lugarNace','$microchip','$adn','$descripcion','$usuModi','$genero','$fecCapado','$fecFallece','$motivoFallece','$idProvincia','$resenias','$fecReg','$nroLibro','$nroFolio','$fecServ','$metodo','$origen','$reseniaBasica',@vresultado)";
         //echo $sql ; 
            $result = parent::ejecutar2($sql,'@vresultado');
            //echo "1";
            if($result){
               // echo "2";
                if($fila = mysqli_fetch_array($result)){
                   // echo "3";
                   //print_r($fila);
                   if($fila[0]==1){
                    //echo "4";
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
        public function eliminar($codigo,$usuModi){
             $retorno=new Resultado();
            $sql = "CALL SGESD_EJEMPLAR('$codigo','$usuModi')";
            //echo $sql;
            $result = parent::ejecutar2($sql);
            if($result){
                return true;
            }else{
                return false;
            }
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
           // echo $sql;
            $result = parent::ejecutar2($sql);
            if($result){
                if($fila = mysqli_fetch_object($result)){
                  $obj = new Ejemplar();
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
        
        public function numeroRegistro($id,$pref,$nom,$prop,$cria,$genero,$emin,$emax,$estado,$ente){
            // $retorno=new Resultado();
            if($emin=="")$emin=0;
           if($emax=="")$emax=0;
            $sql = "CALL SGESS_CUENTA_EJEMPLAR_JQGRID('$id','$pref','$nom','$prop','$cria','$genero','$emin','$emax','$estado','$ente')";
        // echo $sql ;
            $result = parent::ejecutar2($sql);
            $num_row=0;
            while ($fila = mysqli_fetch_object($result)){
                $num_row = $fila->num_row;
            }
            return $num_row;
        }
        public function buscarSearch($id,$pref,$nom,$prop,$cria,$genero,$emin,$emax,$estado,$ente, $start , $limit,$sidx,$sord){

           if($emin=="")$emin=0;
           if($emax=="")$emax=0;
            $sql = "CALL SGESS_EJEMPLAR_JQGRID('$id','$pref','$nom','$prop','$cria','$genero','$emin','$emax','$estado','$ente','$start','$limit','$sidx','$sord')";
      //    echo $sql;
            $result = parent::ejecutar2($sql);
            $ejemplares=[];
            while($fila = mysqli_fetch_object($result)){
               $obj = new Ejemplar();
                  $obj->codigo = $fila->id;
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


                  $obj->idMetodo=$fila->idMetodo;

                  if($obj->idMetodo==Constantes::K_TRANSFER_EMBRION && date("Ymd")>=Constantes::K_FECHA_VALIDATE_TE){
                    if(!(strpos($obj->nombre,"- TE")>0 || strpos($obj->nombre,"-TE")>0)){
                            $obj->nombre=$obj->nombre." - TE";
                    } 
                  }
                   $obj->esSuperCamp=$fila->esSuperCamp;

                $ejemplares[] = $obj;
            }
            return $ejemplares;
        }
       

        /*
        autor: dbs - 20160108
        nombre function
            buscarDataTable, solo para la grilla DataTable js.
        */
        public function buscarDataTable(){
            $aColumns=array("id","prefijo","nombre","FechaNac","FecFallece","pelaje","LugarNace","microchip","adn","capado","estado");
            $sIndexColumn="id";
            $sTable="sgev_ejemplar";
            return parent::loadDataTable($aColumns,$sIndexColumn,$sTable);
        } 

       public function buscarMadre($nombre){

            $sql = "CALL SGESS_LIST_MADRE('$nombre')";
            //echo $sql;
            $result = parent::ejecutar2($sql);
            
            while($fila = mysqli_fetch_object($result)){
                $obj = new Ejemplar();
                $obj->codigo = $fila->id;
                $obj->prefijo = $fila->prefijo;
                $obj->nombre = $fila->nombre;
                $obj->fecNace = $fila->fecNace;
                $obj->idPelaje = $fila->pelaje;
                $obj->propietarios = $fila->propietarios;
                $prop[] = $obj;
            }
            return $prop;
        }
        public function buscarPadre($nombre){

            $sql = "CALL SGESS_LIST_PADRE('$nombre')";
            //echo $sql;
            $result = parent::ejecutar2($sql);
            
            while($fila = mysqli_fetch_object($result)){
                $obj = new Ejemplar();
                $obj->codigo = $fila->id;
                $obj->prefijo = $fila->prefijo;
                $obj->nombre = $fila->nombre;
                $obj->fecNace = $fila->fecNace;
                $obj->idPelaje = $fila->pelaje;
                $obj->propietarios = $fila->propietarios;
                $prop[] = $obj;
            }
            return $prop;
        }
        public function buscarTodos($nombre){

            $sql = "CALL SGESS_LIST_PADRE_MADRE('$nombre')";
           // echo $sql;
            $result = parent::ejecutar2($sql);
            
            while($fila = mysqli_fetch_object($result)){
                $obj = new Ejemplar();
                $obj->codigo = $fila->id;
                $obj->prefijo = $fila->prefijo;
                $obj->nombre = $fila->nombre;
                $obj->fecNace = $fila->fecNace;
                $obj->idPelaje = $fila->pelaje;
                $obj->propietarios = $fila->propietarios;
                $prop[] = $obj;
            }
            return $prop;
        }
        public function numeroRegistroGralEjemplar($nomFiltro,$genero){
             $retorno=new Resultado();
            $sql = "CALL SGESS_CUENTA_BUSCAR_EJEMPLAR_JQGRID('$nomFiltro','$genero')";
            //echo $sql ;
            $result = parent::ejecutar2($sql);
            $num_row=0;
            while ($fila = mysqli_fetch_object($result)){
                $num_row = $fila->num_row;
            }
            return $num_row;
        }
        public function buscarSearchGralEjemplar($nomFiltro,$genero,$start,$limit,$sidx,$sord){
            $retorno=new Resultado();
            $sql = "CALL SGESS_BUSCAR_EJEMPLAR_JQGRID('$nomFiltro','$genero','$start','$limit','$sidx','$sord')";
           //echo $sql;
            $result = parent::ejecutar2($sql);
            
            while($fila = mysqli_fetch_object($result)){
               $obj = new stdClass();
                  $obj->id = $fila->id;
                  $obj->prefijo = $fila->prefijo;
                  $obj->nombre= $fila->nombre;
                  $obj->propietarios=$fila->propietarios;
                  $obj->pelaje=$fila->pelaje;

                  $ejemplares[] = $obj;
            }
            return $ejemplares;
        }
        public function buscarPadres($codigo){
          $retorno=new Resultado();
          $sql="CALL SGESS_BUSCAR_PADRES('$codigo')";
         //echo $sql;
          $result=parent::ejecutar2($sql);
          while ($fila=mysqli_fetch_object($result)) {
              $obj=new stdClass();
              $obj->idPadre=$fila->idPadre;
              $obj->prefijoPadre=$fila->prefijoPadre;
              $obj->nombrePadre=$fila->nombrePadre;
              $obj->idMadre=$fila->idMadre;
              $obj->prefijoMadre=$fila->prefijoMadre;
              $obj->nombreMadre=$fila->nombreMadre;
              $padres[]=$obj;
          }
          return $padres;
        }

        public function listaComboMtdoReprop($id,$descripcion){
          $retorno=new Resultado();
          $sql="CALL SGESS_LIST_METODO_REPROP('$id','$descripcion')";
          $metodo=[];
          $result=parent::ejecutar2($sql);
          while ($fila=mysqli_fetch_object($result)) {
            $obj=new stdClass();
              $obj->id=$fila->id;
              $obj->descripcion=$fila->descripcion;
              $metodo[]=$obj;
          }
          return $metodo;
        }

        public function validarFecha($fechaServ,$fechaNac,$idMadre,$idHijo){
          $retorno=new Resultado();
            $sql = "CALL SGES_VALIDARFECHA('$fechaServ','$fechaNac','$idMadre','$idHijo',@vresultado)";
            //echo $sql;
            $result = parent::ejecutar2($sql,'@vresultado');
            if($result){
                if($fila = mysqli_fetch_array($result)){
                   //print_r($fila);
                   if($fila[0]==1){
                     $retorno->result=1;
                    }else if($fila[0]==0){
                     $retorno->result=0;
                    }else if($fila[0]==2){
                      $retorno->result=2;
                    }
             }
            }

            return  $retorno;
        }

        /*ADDON PARA REPORTE ADN 20180713*/
         public function numeroRegistroRptAdn($id,$nombre,$idPadre,$nomPadre,$idMadre,$nomMadre,$idProp,$idEnte){
            $sql = "CALL SGESS_CUENTA_REPORTE_ADN_JQGRID('$id','$nombre','$idPadre','$nomPadre','$idMadre','$nomMadre','$idProp','$idEnte')";
        // echo $sql ;
            $result = parent::ejecutar2($sql);
            $num_row=0;
            while ($fila = mysqli_fetch_object($result)){
                $num_row = $fila->num_row;
            }
            return $num_row;
        }
        public function buscarSearchRptAdn($id,$nombre,$idPadre,$nomPadre,$idMadre,$nomMadre,$idProp, $idEnte,$start , $limit,$sidx,$sord){
            $sql = "CALL SGESS_REPORTE_ADN_JQGRID('$id','$nombre','$idPadre','$nomPadre','$idMadre','$nomMadre','$idProp','$idEnte','$start','$limit','$sidx','$sord')";
         // echo $sql;
            $result = parent::ejecutar2($sql);
            $ejemplares=[];
            while($fila = mysqli_fetch_object($result)){
               $obj = new stdClass();
                  $obj->id = $fila->id;
                  $obj->nombre = $fila->nombre;
                  $obj->fecNace=$fila->fecNace;
                  $obj->sexo=$fila->sexo;
                  $obj->pelaje=$fila->pelaje;
                  $obj->idPadre=$fila->idPadre;
                  $obj->nomPadre=$fila->nomPadre;
                  $obj->idMadre=$fila->idMadre;
                  $obj->nomMadre=$fila->nomMadre;
                  $obj->propietario=$fila->propietario;
                  $obj->capado=$fila->capado;

                  if($obj->idMetodo==Constantes::K_TRANSFER_EMBRION && date("Ymd")>=Constantes::K_FECHA_VALIDATE_TE){
                    if(!(strpos($obj->nombre,"- TE")>0 || strpos($obj->nombre,"-TE")>0)){
                            $obj->nombre=$obj->nombre." - TE";
                    } 
                  }
                  $ejemplares[] = $obj;
            }
            return $ejemplares;
        }
        /*BEGIN  PARA REPORTE ADN 20180713*/

        /*REPORTE XLS EJEMPLARES - ADDON DBS 20200305*/
         public function buscarSearchXls($id,$pref,$nom,$prop,$cria,$genero,$emin,$emax,$estado,$ente, $start , $limit,$sidx,$sord){

           if($emin=="")$emin=0;
           if($emax=="")$emax=0;
            $sql = "CALL SGESS_EJEMPLAR_JQGRID_XLS('$id','$pref','$nom','$prop','$cria','$genero','$emin','$emax','$estado','$ente','$start','$limit','$sidx','$sord')";
        //  echo $sql;
            $result = parent::ejecutar2($sql);
            $ejemplares=[];
            while($fila = mysqli_fetch_object($result)){
               $obj = new stdClass();
                  $obj->codigo = $fila->id;
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

                  $obj->idMadre = $fila->idMadre;
                  $obj->prefijoMad = $fila->prefijoMad;
                  $obj->nombreMad = $fila->nombreMad;                  

                  $obj->idPadre = $fila->idPadre;
                  $obj->prefijoPad = $fila->prefijoPad;
                  $obj->nombrePad = $fila->nombrePad;                  

                  $obj->idMetodo=$fila->idMetodo;

                  if($obj->idMetodo==Constantes::K_TRANSFER_EMBRION && date("Ymd")>=Constantes::K_FECHA_VALIDATE_TE){
                    if(!(strpos($obj->nombre,"- TE")>0 || strpos($obj->nombre,"-TE")>0)){
                            $obj->nombre=$obj->nombre." - TE";
                    } 
                  }
                   $obj->esSuperCamp=$fila->esSuperCamp;

                $ejemplares[] = $obj;
            }
            return $ejemplares;
        }


          /*
        autor: dbs - 20160725
        nombre function
            insertar
        parametro entrada
            $nombre: nombre del pelaje obligatorio y no debe repetirse
        parametro de retorno
            $retorno->result: [0 1 2]
            0=error en el ejecucion del store
            1=inserto ok
            2=no inserto. Ya existe el parametro nombre como data/
        */
        public function insertarTMP($codigo,$prefijo,$nombre,$fecNace,$padre,$madre,$idPelaje,$lugarNace,$microchip,$adn,$descripcion,$usuCrea,$genero,$fecCapado,$fecFallece,$motivoFallece,$idProvincia,$origen,$resenias,$fecReg,$nroLibro,$nroFolio,$fecServ,$metodo,$idCriador){
          
             $resenias=serialize($resenias);
             $retorno=new Resultado();
            $sql = "CALL SGESI_POE_EJEMPLAR_TMP('$codigo','$prefijo','$nombre','$fecNace','$padre','$madre','$idPelaje','$lugarNace','$microchip','$adn','$descripcion','$genero','$usuCrea','$fecCapado','$fecFallece','$motivoFallece','$idProvincia','$origen','$resenias','$fecReg','$nroLibro','$nroFolio','$fecServ','$metodo','$idCriador',@vresultado)";
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
        public function editarTMP($codigo,$prefijo,$nombre,$fecNace,$padre,$madre,$idPelaje,$lugarNace,$microchip,$adn,$descripcion,$usuModi, $genero,$fecCapado,$fecFallece,$motivoFallece,$idProvincia,$resenias,$fecReg,$nroLibro,$nroFolio,$fecServ,$metodo,$origen,$idCriador){

            $resenias=serialize($resenias);

             $retorno=new Resultado();
        $sql = "CALL SGESU_POE_EJEMPLAR_TMP('$codigo','$prefijo','$nombre','$fecNace','$padre','$madre','$idPelaje','$lugarNace','$microchip','$adn','$descripcion','$usuModi','$genero','$fecCapado','$fecFallece','$motivoFallece','$idProvincia','$resenias','$fecReg','$nroLibro','$nroFolio','$fecServ','$metodo','$origen','$idCriador',@vresultado)";
         //echo $sql ; 
            $result = parent::ejecutar2($sql,'@vresultado');
            //echo "1";
            if($result){
               // echo "2";
                if($fila = mysqli_fetch_array($result)){
                   // echo "3";
                   //print_r($fila);
                   if($fila[0]==1){
                    //echo "4";
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
       
    }
?>
