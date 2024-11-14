<?php date_default_timezone_set('UTC');
include_once("modelo.php");
if (file_exists("../../entidad/Constantes.php")) include_once("../../entidad/Constantes.php");
if (file_exists("../../entidad/Ejemplar.inc.php")) include_once("../../entidad/Ejemplar.inc.php");
if (file_exists("../../entidad/Resultado.inc.php")) include_once("../../entidad/Resultado.inc.php");

if (file_exists("../entidad/Ejemplar.inc.php")) include_once("../entidad/Ejemplar.inc.php");
if (file_exists("../entidad/Resultado.inc.php")) include_once("../entidad/Resultado.inc.php");



class EjemplarData extends dal
{

  public $retorno;
  function __construct()
  {
    parent::dal();
    $retorno = new Resultado();
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
  public function insertar($codigo, $prefijo, $nombre, $fecNace, $padre, $madre, $idPelaje, $lugarNace, $microchip, $adn, $descripcion, $usuCrea, $genero, $fecCapado, $fecFallece, $motivoFallece, $idProvincia, $origen, $resenias, $fecReg, $nroLibro, $nroFolio, $fecServ, $metodo)
  {

    $resenias = serialize($resenias);
    $retorno = new Resultado();
    $sql = "CALL SGESI_EJEMPLAR('$codigo','$prefijo','$nombre','$fecNace','$padre','$madre','$idPelaje','$lugarNace','$microchip','$adn','$descripcion','$genero','$usuCrea','$fecCapado','$fecFallece','$motivoFallece','$idProvincia','$origen','$resenias','$fecReg','$nroLibro','$nroFolio','$fecServ','$metodo',@vresultado)";
    //  echo $sql;
    $result = parent::ejecutar2($sql, '@vresultado');
    if ($result) {
      if ($fila = mysqli_fetch_array($result)) {
        //  print_r($fila);
        if ($fila[0] == "") {
          $retorno->result = 0;
        } else if ($fila[0] == 3) {
          $retorno->result = 3;
        } else if ($fila[0] == 999) {
          $retorno->result = 999;
        } else if ($fila[0] == 998) {
          $retorno->result = 998;
        } else {
          $retorno->result = 1;
          $retorno->code = $fila[0];
        }
      }
    } else {
      $retorno->result = 0;
    }

    return  $retorno;
  }
  //funcion para actualizar un registro
  public function editar($codigo, $prefijo, $nombre, $fecNace, $padre, $madre, $idPelaje, $lugarNace, $microchip, $adn, $descripcion, $usuModi, $genero, $fecCapado, $fecFallece, $motivoFallece, $idProvincia, $resenias, $fecReg, $nroLibro, $nroFolio, $fecServ, $metodo, $origen)
  {

    $resenias = serialize($resenias);

    $retorno = new Resultado();
    $sql = "CALL SGESU_EJEMPLAR('$codigo','$prefijo','$nombre','$fecNace','$padre','$madre','$idPelaje','$lugarNace','$microchip','$adn','$descripcion','$usuModi','$genero','$fecCapado','$fecFallece','$motivoFallece','$idProvincia','$resenias','$fecReg','$nroLibro','$nroFolio','$fecServ','$metodo','$origen',@vresultado)";
    //echo $sql ; 
    $result = parent::ejecutar2($sql, '@vresultado');
    //echo "1";
    if ($result) {
      // echo "2";
      if ($fila = mysqli_fetch_array($result)) {
        // echo "3";
        //print_r($fila);
        if ($fila[0] == 1) {
          //echo "4";
          $retorno->result = 1;
        } else if ($fila[0] == 2) {
          // echo "5";
          $retorno->result = 2;
        } else if ($fila[0] == 3) {
          $retorno->result = 3;
        } else if ($fila[0] == 999) {
          $retorno->result = 999;
        } else if ($fila[0] == 998) {
          $retorno->result = 998;
        }
      }
    } else {
      $retorno->result = 0;
    }
    return  $retorno;
  }
  //funcion para eliminar un registro
  public function eliminar($codigo, $usuModi)
  {
    $retorno = new Resultado();
    $sql = "CALL SGESD_EJEMPLAR('$codigo','$usuModi')";
    //echo $sql;
    $result = parent::ejecutar2($sql);
    if ($result) {
      return true;
    } else {
      return false;
    }
  }
  public function fallece($codigo, $usuModi, $motivoFallece, $fecFallece)
  {
    $retorno = new Resultado();
    $sql = "CALL SGESU_EJEMPLARFALLECE('$codigo','$usuModi','$motivoFallece','$fecFallece')";
    // echo $sql;
    $result = parent::ejecutar2($sql);
    if ($result) {
      return true;
    } else {
      return false;
    }
  }
  //function para obtener turno
  public function obtenerID($codigo)
  {
    $retorno = new Resultado();
    $sql = "CALL SGESS_EJEMPLAR_X_ID('$codigo')";
    //echo $sql;
    $result = parent::ejecutar2($sql);
    if ($fila = mysqli_fetch_object($result)) {
      $obj = new Ejemplar();
      $obj->codigo = $fila->id;
      $obj->prefijo = $fila->prefijo;
      $obj->nombre = $fila->nombre;
      $obj->fecNace = $fila->fecNace;
      $obj->fecFallece = $fila->fecFallece;
      $obj->motivoFallece = $fila->motivoFallece;
      $obj->idPadre = $fila->idPadre;
      $obj->idMadre = $fila->idMadre;
      $obj->idPelaje = $fila->idPelaje;
      $obj->LugarNace = $fila->LugarNace;
      $obj->microchip = $fila->microchip;
      $obj->adn = $fila->adn;
      $obj->descripcion = $fila->descripcion;
      $obj->genero = $fila->genero;
      $obj->fecCapado = $fila->fecCapado;
      $obj->idProvincia = $fila->idProvincia;
      $obj->idResenias = $fila->idResenias;
      $obj->fecNaceString = $fila->fecNaceString;
      $obj->fecReg = $fila->fecReg;
      $obj->fecRegString = $fila->fecRegString;
      $obj->nroLibro = $fila->nroLibro;
      $obj->nroFolio = $fila->nroFolio;
      $obj->fecCrea = $fila->fecCrea;
      $obj->fecServ = $fila->fecServ;
      $obj->fecServString = $fila->fecServString;
      $obj->idMetodo = $fila->idMetodo;
      $obj->origen = $fila->origen;
    }
    return $obj;
  }
  //function para buscar
  public function buscar()
  {
    $retorno = new Resultado();
    $sql = "CALL SGESS_EJEMPLAR('')";
    $result = parent::ejecutar2($sql);
    while ($fila = mysqli_fetch_object($result)) {
      $obj = new Entidad();
      $obj->codigo = $fila->id;
      //$obj->nombreCorto = $fila->nombreCorto;
      //$obj->nombreLargo = $fila->nombreLargo;
      $turno[] = $obj;
    }
    return $turno;
  }

  public function numeroRegistro($id, $pref, $nom, $prop, $cria, $genero, $emin, $emax, $estado, $ente)
  {
    // $retorno=new Resultado();
    if ($emin == "") $emin = 0;
    if ($emax == "") $emax = 0;
    $sql = "CALL SGESS_CUENTA_EJEMPLAR_JQGRID('$id','$pref','$nom','$prop','$cria','$genero','$emin','$emax','$estado','$ente')";
    // echo $sql ;
    $result = parent::ejecutar2($sql);
    $num_row = 0;
    while ($fila = mysqli_fetch_object($result)) {
      $num_row = $fila->num_row;
    }
    return $num_row;
  }
  public function buscarSearch($id, $pref, $nom, $prop, $cria, $genero, $emin, $emax, $estado, $ente, $start, $limit, $sidx, $sord)
  {

    if ($emin == "") $emin = 0;
    if ($emax == "") $emax = 0;
    $sql = "CALL SGESS_EJEMPLAR_JQGRID('$id','$pref','$nom','$prop','$cria','$genero','$emin','$emax','$estado','$ente','$start','$limit','$sidx','$sord')";
    // echo $sql;
    $result = parent::ejecutar2($sql);
    $ejemplares = [];
    while ($fila = mysqli_fetch_object($result)) {
      $obj = new Ejemplar();
      $obj->codigo = $fila->id;
      $obj->prefijo = $fila->prefijo;
      $obj->nombre = $fila->nombre;
      $obj->fecNace = $fila->fecNace;
      $obj->fecFallece = $fila->fecFallece;
      /*$obj->motivoFallece=$fila->motivoFallece;
                  $obj->idPadre=$fila->idPadre;
                  $obj->idMadre=$fila->idMadre;*/
      $obj->nombrePelaje = $fila->pelaje;
      $obj->LugarNace = $fila->LugarNace;
      $obj->microchip = $fila->microchip;
      $obj->adn = $fila->adn;
      // $obj->descripcion=$fila->descripcion;
      $obj->estado = $fila->estado;
      $obj->capado = $fila->capado;
      $obj->propietarios = $fila->propiedad;
      $obj->criadores = $fila->criador;
      $obj->fecReg = $fila->fecReg;


      $obj->idMetodo = $fila->idMetodo;

      if ($obj->idMetodo == Constantes::K_TRANSFER_EMBRION && date("Ymd") >= Constantes::K_FECHA_VALIDATE_TE) {
        if (!(strpos($obj->nombre, "- TE") > 0 || strpos($obj->nombre, "-TE") > 0)) {
          $obj->nombre = $obj->nombre . " - TE";
        }
      }
      $obj->esSuperCamp = $fila->esSuperCamp;

      $ejemplares[] = $obj;
    }
    return $ejemplares;
  }


  /*
        autor: dbs - 20160108
        nombre function
            buscarDataTable, solo para la grilla DataTable js.
        */
  public function buscarDataTable()
  {
    $aColumns = array("id", "prefijo", "nombre", "FechaNac", "FecFallece", "pelaje", "LugarNace", "microchip", "adn", "capado", "estado");
    $sIndexColumn = "id";
    $sTable = "sgev_ejemplar";
    return parent::loadDataTable($aColumns, $sIndexColumn, $sTable);
  }

  public function buscarMadre($nombre)
  {

    $sql = "CALL SGESS_LIST_MADRE('$nombre')";
    //echo $sql;
    $result = parent::ejecutar2($sql);

    while ($fila = mysqli_fetch_object($result)) {
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
  public function buscarPadre($nombre)
  {

    $sql = "CALL SGESS_LIST_PADRE('$nombre')";
    //echo $sql;
    $result = parent::ejecutar2($sql);

    while ($fila = mysqli_fetch_object($result)) {
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
  public function buscarTodos($nombre)
  {

    $sql = "CALL SGESS_LIST_PADRE_MADRE('$nombre')";
    // echo $sql;
    $result = parent::ejecutar2($sql);

    while ($fila = mysqli_fetch_object($result)) {
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
  public function numeroRegistroGralEjemplar($nomFiltro, $genero)
  {
    $retorno = new Resultado();
    $sql = "CALL SGESS_CUENTA_BUSCAR_EJEMPLAR_JQGRID('$nomFiltro','$genero')";
    //echo $sql ;
    $result = parent::ejecutar2($sql);
    $num_row = 0;
    while ($fila = mysqli_fetch_object($result)) {
      $num_row = $fila->num_row;
    }
    return $num_row;
  }
  public function buscarSearchGralEjemplar($nomFiltro, $genero, $start, $limit, $sidx, $sord)
  {
    $retorno = new Resultado();
    $sql = "CALL SGESS_BUSCAR_EJEMPLAR_JQGRID('$nomFiltro','$genero','$start','$limit','$sidx','$sord')";
    //echo $sql;
    $result = parent::ejecutar2($sql);

    while ($fila = mysqli_fetch_object($result)) {
      $obj = new stdClass();
      $obj->id = $fila->id;
      $obj->prefijo = $fila->prefijo;
      $obj->nombre = $fila->nombre;
      $obj->propietarios = $fila->propietarios;
      $obj->pelaje = $fila->pelaje;

      $ejemplares[] = $obj;
    }
    return $ejemplares;
  }
  public function buscarPadres($codigo)
  {
    $retorno = new Resultado();
    $sql = "CALL SGESS_BUSCAR_PADRES('$codigo')";
    //echo $sql;
    $result = parent::ejecutar2($sql);
    while ($fila = mysqli_fetch_object($result)) {
      $obj = new stdClass();
      $obj->idPadre = $fila->idPadre;
      $obj->prefijoPadre = $fila->prefijoPadre;
      $obj->nombrePadre = $fila->nombrePadre;
      $obj->idMadre = $fila->idMadre;
      $obj->prefijoMadre = $fila->prefijoMadre;
      $obj->nombreMadre = $fila->nombreMadre;
      $padres[] = $obj;
    }
    return $padres;
  }

  public function listaComboMtdoReprop($id, $descripcion)
  {
    $retorno = new Resultado();
    $sql = "CALL SGESS_LIST_METODO_REPROP('$id','$descripcion')";
    $metodo = [];
    $result = parent::ejecutar2($sql);
    while ($fila = mysqli_fetch_object($result)) {
      $obj = new stdClass();
      $obj->id = $fila->id;
      $obj->descripcion = $fila->descripcion;
      $metodo[] = $obj;
    }
    return $metodo;
  }

  public function validarFecha($fechaServ, $fechaNac, $idMadre, $idHijo)
  {
    $retorno = new Resultado();
    $sql = "CALL SGES_VALIDARFECHA('$fechaServ','$fechaNac','$idMadre','$idHijo',@vresultado)";
    //echo $sql;
    $result = parent::ejecutar2($sql, '@vresultado');
    if ($result) {
      if ($fila = mysqli_fetch_array($result)) {
        //print_r($fila);
        if ($fila[0] == 1) {
          $retorno->result = 1;
        } else if ($fila[0] == 0) {
          $retorno->result = 0;
        } else if ($fila[0] == 2) {
          $retorno->result = 2;
        }
      }
    }

    return  $retorno;
  }

  /*ADDON PARA REPORTE ADN 20180713*/
  public function numeroRegistroRptAdn($id, $nombre, $idPadre, $nomPadre, $idMadre, $nomMadre, $idProp, $idEnte)
  {
    $sql = "CALL SGESS_CUENTA_REPORTE_ADN_JQGRID('$id','$nombre','$idPadre','$nomPadre','$idMadre','$nomMadre','$idProp','$idEnte')";
    // echo $sql ;
    $result = parent::ejecutar2($sql);
    $num_row = 0;
    while ($fila = mysqli_fetch_object($result)) {
      $num_row = $fila->num_row;
    }
    return $num_row;
  }
  public function buscarSearchRptAdn($id, $nombre, $idPadre, $nomPadre, $idMadre, $nomMadre, $idProp, $idEnte, $start, $limit, $sidx, $sord)
  {
    $sql = "CALL SGESS_REPORTE_ADN_JQGRID('$id','$nombre','$idPadre','$nomPadre','$idMadre','$nomMadre','$idProp','$idEnte','$start','$limit','$sidx','$sord')";
    // echo $sql;
    $result = parent::ejecutar2($sql);
    $ejemplares = [];
    while ($fila = mysqli_fetch_object($result)) {
      $obj = new stdClass();
      $obj->id = $fila->id;
      $obj->nombre = $fila->nombre;
      $obj->fecNace = $fila->fecNace;
      $obj->sexo = $fila->sexo;
      $obj->pelaje = $fila->pelaje;
      $obj->idPadre = $fila->idPadre;
      $obj->nomPadre = $fila->nomPadre;
      $obj->idMadre = $fila->idMadre;
      $obj->nomMadre = $fila->nomMadre;
      $obj->propietario = $fila->propietario;
      $obj->capado = $fila->capado;

      if ($obj->idMetodo == Constantes::K_TRANSFER_EMBRION && date("Ymd") >= Constantes::K_FECHA_VALIDATE_TE) {
        if (!(strpos($obj->nombre, "- TE") > 0 || strpos($obj->nombre, "-TE") > 0)) {
          $obj->nombre = $obj->nombre . " - TE";
        }
      }
      $ejemplares[] = $obj;
    }
    return $ejemplares;
  }
  /*BEGIN  PARA REPORTE ADN 20180713*/

  /*REPORTE XLS EJEMPLARES - ADDON DBS 20200305*/
  public function buscarSearchXls($id, $pref, $nom, $prop, $cria, $genero, $emin, $emax, $estado, $ente, $start, $limit, $sidx, $sord)
  {

    if ($emin == "") $emin = 0;
    if ($emax == "") $emax = 0;
    $sql = "CALL SGESS_EJEMPLAR_JQGRID_XLS('$id','$pref','$nom','$prop','$cria','$genero','$emin','$emax','$estado','$ente','$start','$limit','$sidx','$sord')";
    //  echo $sql;
    $result = parent::ejecutar2($sql);
    $ejemplares = [];
    while ($fila = mysqli_fetch_object($result)) {
      $obj = new stdClass();
      $obj->codigo = $fila->id;
      $obj->prefijo = $fila->prefijo;
      $obj->nombre = $fila->nombre;
      $obj->fecNace = $fila->fecNace;
      $obj->fecFallece = $fila->fecFallece;
      /*$obj->motivoFallece=$fila->motivoFallece;
                  $obj->idPadre=$fila->idPadre;
                  $obj->idMadre=$fila->idMadre;*/
      $obj->nombrePelaje = $fila->pelaje;
      $obj->LugarNace = $fila->LugarNace;
      $obj->microchip = $fila->microchip;
      $obj->adn = $fila->adn;
      // $obj->descripcion=$fila->descripcion;
      $obj->estado = $fila->estado;
      $obj->capado = $fila->capado;
      $obj->propietarios = $fila->propiedad;
      $obj->criadores = $fila->criador;
      $obj->fecReg = $fila->fecReg;

      $obj->idMadre = $fila->idMadre;
      $obj->prefijoMad = $fila->prefijoMad;
      $obj->nombreMad = $fila->nombreMad;

      $obj->idPadre = $fila->idPadre;
      $obj->prefijoPad = $fila->prefijoPad;
      $obj->nombrePad = $fila->nombrePad;

      $obj->idMetodo = $fila->idMetodo;

      if ($obj->idMetodo == Constantes::K_TRANSFER_EMBRION && date("Ymd") >= Constantes::K_FECHA_VALIDATE_TE) {
        if (!(strpos($obj->nombre, "- TE") > 0 || strpos($obj->nombre, "-TE") > 0)) {
          $obj->nombre = $obj->nombre . " - TE";
        }
      }
      $obj->esSuperCamp = $fila->esSuperCamp;

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

  /*----------------------------------------- INICIO DE LA FASE2 ----------------------------*/

  public function insertarINS($codigo, $prefijoProp, $nombre, $fecNace, $padre, $madre, $idPelaje, $lugarNace, $microchip, $adn, $descripcion, $usuCrea, $genero, $fecCapado, $idMonta, $idNac, $idProvincia, $origen, $resenias, $fecReg, $nroLibro, $nroFolio, $fecServ, $metodo, $idProp, $idPoe, $idCriador, $codigoGenerado,$reseniaBasica)
  {

    $resenias = serialize($resenias);
    $retorno = new Resultado();
    $sql = "CALL SGESI_POE_EJEMPLAR_INS('$codigo','$prefijoProp','$nombre','$fecNace','$padre','$madre','$idPelaje','$lugarNace','$microchip','$adn','$descripcion','$genero','$usuCrea','$fecCapado','$idMonta','$idNac','$idProvincia','$origen','$resenias','$fecReg','$nroLibro','$nroFolio','$fecServ','$metodo','$idProp','$idPoe','$idCriador','$codigoGenerado','$reseniaBasica',@vresultado)";
    // echo $sql;
    $result = parent::ejecutar2($sql, '@vresultado');
    if ($result) {
      if ($fila = mysqli_fetch_array($result)) {
        //  print_r($fila);
        if ($fila[0] == "") {
          $retorno->result = 0;
        } else if ($fila[0] == 3) {
          $retorno->result = 3;
        } else if ($fila[0] == 999) {
          $retorno->result = 999;
        } else if ($fila[0] == 998) {
          $retorno->result = 998;
        } else {
          $retorno->result = 1;
          $retorno->code = $fila[0];
        }
      }
    } else {
      $retorno->result = 0;
    }

    return  $retorno;
  }
  //funcion para actualizar un registro
  public function editarINS($codigo, $prefijo, $nombre, $fecNace, $padre, $madre, $idPelaje, $lugarNace, $microchip, $adn, $descripcion, $genero, $usuModi, $fecCapado, $idMonta, $idNac, $idProvincia, $origen, $resenias, $fecModi, $nroLibro, $nroFolio, $fecServ, $metodo, $idProp, $idPoe, $idCriador, $codigoGenerado,$reseniaBasica)
  {

    $resenias = serialize($resenias);

    $retorno = new Resultado();
    $sql = "CALL SGESU_POE_EJEMPLAR_INS('$codigo','$prefijo','$nombre','$fecNace','$padre','$madre','$idPelaje','$lugarNace','$microchip','$adn','$descripcion','$genero','$usuModi','$fecCapado','$idMonta','$idNac','$idProvincia','$origen','$resenias','$fecModi','$nroLibro','$nroFolio','$fecServ','$metodo','$idProp','$idPoe','$idCriador','$codigoGenerado','$reseniaBasica',@vresultado)";
    //echo $sql ; 
    $result = parent::ejecutar2($sql, '@vresultado');
    // echo "1";
    //echo $result;
    if ($result) {
      // echo "2";
      if ($fila = mysqli_fetch_array($result)) {
        // echo "3";
        // print_r($fila);
        if ($fila[0] == 1) {
          // echo "4";
          $retorno->result = 1;
        } else if ($fila[0] == 2) {
          // echo "5";
          $retorno->result = 2;
        } else if ($fila[0] == 3) {
          $retorno->result = 3;
        } else if ($fila[0] == 999) {
          $retorno->result = 999;
        } else if ($fila[0] == 998) {
          $retorno->result = 998;
        }
      }
    } else {
      $retorno->result = 0;
    }
    return  $retorno;
  }


  public function listarInscripcionINS($prop, $estado, $situacion,$genero,$pelaje,$fecNac,$madre,$padre)
  {
    try {

      $sql = "CALL SGESS_POE_EJEMPLAR_INS_LST('$prop','$estado','$situacion','$genero','$pelaje','$fecNac','$madre','$padre')";
     //echo $sql;
      $result = parent::ejecutar2($sql);
      $prop = [];
      while ($fila = mysqli_fetch_object($result)) {

        $obj = new stdClass();
        $obj->id = $fila->id;
        $obj->prefijo = $fila->prefijo;
        $obj->nombre = $fila->nombre;
        $obj->fecNace = $fila->fecNace;
        $obj->idPelaje = $fila->pelaje;
        $obj->LugarNace = $fila->LugarNace;
        $obj->capado = $fila->capado;
        $obj->situacion = $fila->situacion;
        $obj->criador = $fila->criador;
        $obj->estadoSolTexto = $fila->estadoSolTexto;
        $obj->estadoSolId = $fila->estadoSolId;
        $obj->idCriador = $fila->idCriador;
        $obj->idProp = $fila->idProp;
        $obj->estado = $fila->estado;
        $obj->fecSolicitud = $fila->fecSolicitud;
        $obj->nombrePadre = $fila->nombrePadre;
        $obj->nombreMadre = $fila->nombreMadre;
        $obj->genero = $fila->genero;
        $obj->codigoInscripcion = $fila->codigoInscripcion;



        $prop[] = $obj;
      }
    } catch (mysqli_sql_exception  $e) {
      echo 'Excepción capturada: ',  $e->getMessage(), "\n";
    }
    return $prop;
  }
  public function getEstadosLogInscripcion($id)
  {
    try {

      $sql = "CALL SGESS_GET_ESTADOS_LOG_X_IDSOL('$id')";
      //echo $sql;
      $result = parent::ejecutar2($sql);
      $metodo = [];
      while ($fila = mysqli_fetch_object($result)) {

        $obj = new stdClass();
        $obj->codigo = $fila->id;
        $obj->estado = $fila->estado;
        $obj->estadoTexto = $fila->estadoTexto;
        $obj->fecSol = $fila->fecSol;
        $obj->comentario = $fila->comentario;
        $obj->usuCrea = $fila->usuCrea;

        $metodo[] = $obj;
      }
    } catch (mysqli_sql_exception  $e) {
      echo 'Excepción capturada: ',  $e->getMessage(), "\n";
    }
    // echo $fila;
    return $metodo;
  }

  public function getEstadosLogNacimiento($id)
  {
    try {

      $sql = "CALL SGESS_GET_ESTADOS_LOG_X_IDNAC('$id')";
      //echo $sql;
      $result = parent::ejecutar2($sql);
      $metodo = [];
      while ($fila = mysqli_fetch_object($result)) {

        $obj = new stdClass();
        $obj->codigo = $fila->id;
        $obj->estado = $fila->estado;
        $obj->estadoTexto = $fila->estadoTexto;
        $obj->fecSol = $fila->fecSol;
        $obj->comentario = $fila->comentario;
        $obj->usuCrea = $fila->usuCrea;

        $metodo[] = $obj;
      }
    } catch (mysqli_sql_exception  $e) {
      echo 'Excepción capturada: ',  $e->getMessage(), "\n";
    }
    // echo $fila;
    return $metodo;
  }


  public function obtenerSolINS($codigo)
  {
    $retorno = new Resultado();
    $sql = "CALL SGESS_POE_EJEMPLAR_X_SOL_INS('$codigo')";
    //echo $sql;
    $result = parent::ejecutar2($sql);
    if ($fila = mysqli_fetch_object($result)) {
      $obj = new stdClass();
      $obj->codigo = $fila->id;
      $obj->prefijo = $fila->prefijo;
      $obj->nombre = $fila->nombre;
      $obj->fecNace = $fila->fecNace;
      $obj->idMonta = $fila->idMonta;
      $obj->codigoMonta = $fila->codigoMonta;
      $obj->idNac = $fila->idNac;
      $obj->codigoNacimiento = $fila->codigoNacimiento;
      $obj->idPadre = $fila->idPadre;
      $obj->idMadre = $fila->idMadre;
      $obj->idPelaje = $fila->idPelaje;
      $obj->LugarNace = $fila->LugarNace;
      $obj->microchip = $fila->microchip;
      $obj->adn = $fila->adn;
      $obj->descripcion = $fila->descripcion;
      $obj->genero = $fila->genero;
      $obj->fecCapado = $fila->fecCapado;
      $obj->idProvincia = $fila->idProvincia;
      $obj->idResenias = $fila->idResenias;
      $obj->fecNaceString = $fila->fecNaceString;
      $obj->fecReg = $fila->fecReg;
      $obj->fecRegString = $fila->fecRegString;
      $obj->nroLibro = $fila->nroLibro;
      $obj->nroFolio = $fila->nroFolio;
      $obj->fecCrea = $fila->fecCrea;
      $obj->fecServ = $fila->fecServ;
      $obj->fecServString = $fila->fecServString;
      $obj->idMetodo = $fila->idMetodo;
      $obj->origen = $fila->origen;

      $obj->nombrePadre = $fila->nombrePadre;
      $obj->nombreMadre = $fila->nombreMadre;
      $obj->idPoe = $fila->idPoe;
      $obj->idProp = $fila->idProp;
      $obj->idCriador = $fila->idCriador;
      $obj->estadoSol = $fila->estadoSol;
      $obj->estadoSolTexto = $fila->estadoSolTexto;
      $obj->codigoInscripcion = $fila->codigoInscripcion;
      $obj->fecMonta = $fila->fecMonta;

      $obj->fecEmbrion = $fila->fechaDeEmbrion;
      $obj->idReceptor = $fila->idReceptor;

      $obj->fecFallece = $fila->fecFallece;
      $obj->motivoFallece = $fila->motivoFallece;
      $obj->detalleFallece = $fila->detalleFallece;

      $obj->reseniaBasica = $fila->reseniaBasica;
    }
    return $obj;
  }



  public function eliminarINS($codigo)
  {
    $retorno = new Resultado();
    $sql = "CALL SGESD_POE_EJEMPLAR_INS('$codigo',@vresultado)";
    //echo $sql;
    $result = parent::ejecutar2($sql, '@vresultado');
    if ($result) {
      if ($fila = mysqli_fetch_array($result)) {
        // print_r($fila);
        if ($fila[0] == 1) {
          // echo "4";
          $retorno->result = 1;
        } else if ($fila[0] == 2) {
          // echo "5";
          $retorno->result = 2;
        } else if ($fila[0] == 995) {
          // echo "5";
          $retorno->result = 995;
        }
      }
    } else {

      $retorno->result = 0;
    }

    return  $retorno;
  }

  public function listarNacimientoNAC($prop, $estado, $situacion,$nombre,$genero,$pelaje,$fecNac,$madre,$padre)
  {
    try {

      $sql = "CALL SGESS_POE_EJEMPLAR_NAC_LST('$prop','$estado','$situacion','$nombre','$genero','$pelaje','$fecNac','$madre','$padre')";
      //echo $sql;
      $result = parent::ejecutar2($sql);
      $prop = [];
      while ($fila = mysqli_fetch_object($result)) {
        $obj = new stdClass();
        $obj->id = $fila->id;
        $obj->prefijo = $fila->prefijo;
        $obj->nombre = $fila->nombre;
        $obj->fecNace = $fila->fecNace;
        $obj->idPelaje = $fila->pelaje;
        $obj->LugarNace = $fila->LugarNace;
        $obj->capado = $fila->capado;
        $obj->situacion = $fila->situacion;
        $obj->criador = $fila->criador;
        $obj->estadoSolTexto = $fila->estadoSolTexto;
        $obj->estadoSolId = $fila->estadoSolId;
        $obj->idCriador = $fila->idCriador;
        $obj->idProp = $fila->idProp;
        $obj->estado = $fila->estado;
        $obj->fecSolicitud = $fila->fecSolicitud;
        $obj->nombrePadre = $fila->nombrePadre;
        $obj->nombreMadre = $fila->nombreMadre;
        $obj->genero = $fila->genero;
        $obj->codigoNacimiento = $fila->codigoNacimiento;


        $prop[] = $obj;
      }
    } catch (mysqli_sql_exception  $e) {
      echo 'Excepción capturada: ',  $e->getMessage(), "\n";
    }
    return $prop;
  }


  public function insertarNAC($codigo, $prefijoProp, $nombre, $fecNace, $padre, $madre, $idPelaje, $lugarNace, $microchip, $adn, $descripcion, $genero, $usuario_crea, $fecCapado, $idMonta, $idProvincia, $origen, $resenias, $fecReg, $nroLibro, $nroFolio, $fecServ, $metodo, $idProp, $idPoe, $idCriador, $codigoGenerado,$reseniaBasica)
  {
    $resenias = serialize($resenias);
    $retorno = new Resultado();
    $sql = "CALL SGESI_POE_EJEMPLAR_NAC('$codigo','$prefijoProp','$nombre','$fecNace','$padre','$madre','$idPelaje','$lugarNace','$microchip','$adn','$descripcion','$genero','$usuario_crea','$fecCapado','$idMonta','$idProvincia','$origen','$resenias','$fecReg','$nroLibro','$nroFolio','$fecServ','$metodo','$idProp','$idPoe','$idCriador','$codigoGenerado','$reseniaBasica',@vresultado)";
    //echo $sql;
    $result = parent::ejecutar2($sql, '@vresultado');
    if ($result) {
      if ($fila = mysqli_fetch_array($result)) {
        //  print_r($fila);
        if ($fila[0] == "") {
          $retorno->result = 0;
        }/*else if($fila[0]==3){
                      $retorno->result=3;
                    }*/ else if ($fila[0] == 999) {
          $retorno->result = 999;
        } else if ($fila[0] == 998) {
          $retorno->result = 998;
        } else {
          $retorno->result = 1;
          $retorno->code = $fila[0];
        }
      }
    } else {
      $retorno->result = 0;
    }

    return  $retorno;
  }


  public function obtenerNAC($codigo)
  {
    $retorno = new Resultado();
    $sql = "CALL SGESS_POE_EJEMPLAR_X_NAC('$codigo')";
    //echo $sql;
    $result = parent::ejecutar2($sql);
    if ($fila = mysqli_fetch_object($result)) {
      $obj = new stdClass();
      $obj->codigo = $fila->id;
      $obj->prefijo = $fila->prefijo;
      $obj->nombre = $fila->nombre;
      $obj->fecNace = $fila->fecNace;
      $obj->idMonta = $fila->idMonta;
      $obj->idNac = $fila->idNac;
      $obj->idPadre = $fila->idPadre;
      $obj->idMadre = $fila->idMadre;
      $obj->idPelaje = $fila->idPelaje;
      $obj->LugarNace = $fila->LugarNace;
      $obj->microchip = $fila->microchip;
      $obj->adn = $fila->adn;
      $obj->descripcion = $fila->descripcion;
      $obj->genero = $fila->genero;
      $obj->fecCapado = $fila->fecCapado;
      $obj->idProvincia = $fila->idProvincia;
      $obj->idResenias = $fila->idResenias;
      $obj->fecNaceString = $fila->fecNaceString;
      $obj->fecReg = $fila->fecReg;
      $obj->fecRegString = $fila->fecRegString;
      $obj->nroLibro = $fila->nroLibro;
      $obj->nroFolio = $fila->nroFolio;
      $obj->fecCrea = $fila->fecCrea;
      $obj->fecServ = $fila->fecServ;
      $obj->fecServString = $fila->fecServString;
      $obj->idMetodo = $fila->idMetodo;
      $obj->origen = $fila->origen;

      $obj->nombrePadre = $fila->nombrePadre;
      $obj->nombreMadre = $fila->nombreMadre;
      $obj->idPoe = $fila->idPoe;
      $obj->idProp = $fila->idProp;
      $obj->idCriador = $fila->idCriador;
      $obj->estadoSol = $fila->estadoSol;
      $obj->estadoSolTexto = $fila->estadoSolTexto;
      $obj->codigoNacimiento = $fila->codigoNacimiento;
      $obj->codigoMonta = $fila->codigoMonta;
      $obj->fecMonta = $fila->fecMonta;

      $obj->fecEmbrion = $fila->fecEmbrion;
      $obj->idReceptor = $fila->idReceptor;
      $obj->reseniaBasica = $fila->reseniaBasica;
      $obj->fecFallece = $fila->fecFallece;
      $obj->motivoFallece = $fila->motivoFallece;
      $obj->detalleFallece = $fila->detalleFallece;
    }
    return $obj;
  }

  public function obtenerDatosMonta($id)
  {
    $retorno = new Resultado();
    $sql = "CALL SGESS_GET_INFO_MONTA('$id')";
    $metodo = [];
    //echo $sql;
    $result = parent::ejecutar2($sql);
    while ($fila = mysqli_fetch_object($result)) {
      $obj = new stdClass();
      $obj->codigo = $fila->id;
      $obj->codYegua = $fila->codYegua;
      $obj->nombreYegua = $fila->nombreYegua;
      $obj->codPotro = $fila->codPotro;
      $obj->nombrePotro = $fila->nombrePotro;
      $obj->codigoMonta = $fila->codigoMonta;
      $obj->metodo = $fila->metodo;
      $obj->isTE = $fila->isTE;
      $obj->fecMonta = $fila->fecMonta;
      $obj->fecEmbrion = $fila->fecEmbrion;
      $obj->idReceptor = $fila->idReceptor;
    }
    //echo $metodo;
    return $obj;
  }
  public function obtenerDatosNacimientoEjemplar($id)
  {
    $retorno = new Resultado();
    $sql = "CALL SGESS_GET_INFO_EJEMPLAR('$id')";
    $metodo = [];
    //echo $sql;
    $result = parent::ejecutar2($sql);
    while ($fila = mysqli_fetch_object($result)) {
      $obj = new stdClass();
      $obj->id = $fila->id;
      $obj->fecha = $fila->fecNace;
      $obj->sexo = $fila->genero;
      $obj->pelaje = $fila->pelaje;
      $obj->nombre = $fila->nombre;
      $obj->nombreYegua = $fila->nomMadre;
      $obj->codYegua = $fila->codYegua;
      $obj->nombrePotro = $fila->nomPadre;
      $obj->codPotro = $fila->codPotro;
      $obj->idMonta = $fila->idMonta;
      $obj->metodo = $fila->metodo;
      $obj->isTE = $fila->isTE;
      $obj->codigoMonta = $fila->codigoMonta;
      $obj->codigoNacimiento = $fila->codigoNacimiento;
      $obj->prefijo = $fila->prefijo;
      $obj->idProvincia = $fila->idProvincia;
      $obj->idCriador = $fila->idCriador;
      $obj->microchip = $fila->microchip;
      $obj->descripcion = $fila->descripcion;
      $obj->idResenias = $fila->idResenias;
      $obj->LugarNace = $fila->LugarNace;
      $obj->fecMonta = $fila->fecMonta;
      $obj->reseniaBasica = $fila->reseniaBasica;
      $obj->fecEmbrion = $fila->fecEmbrion;
      $obj->idReceptor = $fila->idReceptor;
    }
    //echo $metodo;
    return $obj;
  }
  public function editarNAC($codigo, $prefijoProp, $nombre, $fecNace, $padre, $madre, $idPelaje, $lugarNace, $microchip, $adn, $descripcion, $genero, $usuModi, $fecCapado, $idMonta, $idProvincia, $origen, $resenias, $fecModi, $nroLibro, $nroFolio, $fecServ, $metodo, $idProp, $idPoe, $idCriador, $codigoGenerado,$reseniaBasica)
  {
    $resenias = serialize($resenias);

    $retorno = new Resultado();
    $sql = "CALL SGESU_POE_EJEMPLAR_NAC('$codigo','$prefijoProp','$nombre','$fecNace','$padre','$madre','$idPelaje','$lugarNace','$microchip','$adn','$descripcion','$genero','$usuModi','$fecCapado','$idMonta','$idProvincia','$origen','$resenias','$fecModi','$nroLibro','$nroFolio','$fecServ','$metodo','$idProp','$idPoe','$idCriador','$codigoGenerado','$reseniaBasica',@vresultado)";
    //echo $sql ; 
    $result = parent::ejecutar2($sql, '@vresultado');
    // echo "1";
    //echo $result;
    if ($result) {
      // echo "2";
      if ($fila = mysqli_fetch_array($result)) {
        // echo "3";
        // print_r($fila);
        if ($fila[0] == 1) {
          // echo "4";
          $retorno->result = 1;
        } else if ($fila[0] == 2) {
          // echo "5";
          $retorno->result = 2;
        }/*else if($fila[0]==3){
                      $retorno->result=3;
                    }*/ else if ($fila[0] == 999) {
          $retorno->result = 999;
        } else if ($fila[0] == 998) {
          $retorno->result = 998;
        }
      }
    } else {
      $retorno->result = 0;
    }
    return  $retorno;
  }

  public function eliminarNAC($codigo)
  {
    $retorno = new Resultado();
    $sql = "CALL SGESD_POE_EJEMPLAR_NAC('$codigo',@vresultado)";
    //echo $sql;
    $result = parent::ejecutar2($sql, '@vresultado');
    if ($result) {
      // echo "2";
      if ($fila = mysqli_fetch_array($result)) {
        // echo "3";
        // print_r($fila);
        if ($fila[0] == 1) {
          // echo "4";
          $retorno->result = 1;
        } else if ($fila[0] == 2) {
          // echo "5";
          $retorno->result = 2;
        } else if ($fila[0] == 995) {
          // echo "5";
          $retorno->result = 995;
        }
      }
    } else {
      $retorno->result = 0;
    }
    return  $retorno;
  }



  public function listarServicioY($idPoe, $idProp,$metodoReprod,$idReceptora,$madre,$padre,$anio,$mes,$start,$length)
  {
    try {

      $sql = "CALL SGESS_SERVICIOY_LIST('$idPoe','$idProp','$metodoReprod','$idReceptora','$madre','$padre','$anio','$mes','$start','$length')";
      //echo $sql;
      $result = parent::ejecutar2($sql);
      $prop = [];
      while ($fila = mysqli_fetch_object($result)) {
       // $prop[] = $fila;
        
        $obj = new stdClass();
        $obj->id = $fila->id;
        $obj->fechaMonta = $fila->fecha;
        $obj->metodo = $fila->metodo;
        $obj->textoMetodo = $fila->textoMetodo;
        $obj->codYegua = $fila->codYegua;
        $obj->codPotro = $fila->codPotro;
        $obj->idPoe = $fila->idPoe;
        $obj->prefYegua  = $fila->prefYegua;
        $obj->nombreYegua  = $fila->nombreYegua;
        $obj->yegua = $fila->yegua;
        $obj->prefPotro = $fila->prefPotro;
        $obj->nombrePotro  = $fila->nombrePotro;
        $obj->potro = $fila->potro;
        $obj->isTE = $fila->isTE;
        $obj->fecAborto = $fila->fecAborto;
        $obj->codigoMonta = $fila->codigoMonta;
        $obj->fecCrea = $fila->fecCrea;
        $obj->estado  = $fila->estado;
        $obj->estadoTexto  = $fila->estadoTexto;
        $obj->socioPotro  = $fila->socioPotro;
        $obj->socioYegua  = $fila->socioYegua;
        $obj->transEmbrion = $fila->transEmbrion;
        $obj->idReceptor = $fila->idReceptor;
        $obj->fechaDeEmbrion = $fila->fechaDeEmbrion;
        $obj->idPropYegua = $fila->idPropYegua;
        $obj->idPropPotro = $fila->idPropPotro;
        $obj->totalRegistros = $fila->totalRegistros;
        $prop[] = $obj;
      }
    } catch (mysqli_sql_exception  $e) {
      echo 'Excepción capturada: ',  $e->getMessage(), "\n";
    }
    return $prop;
  }


  public function insertarMonta($padre, $madre, $idProp, $idPoe, $fecMonta, $fecParir, $metodo, $isTE, $idTextoRec, $fecEmbrion)
  {

    $retorno = new Resultado();
    $sql = "CALL SGESI_SERVICIOY('$padre','$madre','$idProp','$idPoe','$fecMonta','$fecParir','$metodo','$isTE','$idTextoRec','$fecEmbrion',@vresultado)";
    //  echo $sql;
    $result = parent::ejecutar2($sql, '@vresultado');
    if ($result) {
      if ($fila = mysqli_fetch_array($result)) {
        //print_r($fila);
        if ($fila[0] == "") {
          $retorno->result = 0;
        }/*else if($fila[0]==3){
                      $retorno->result=3;
                    }*/ else if ($fila[0] == 999) {
          $retorno->result = 999;
        } else if ($fila[0] == 998) {
          $retorno->result = 998;
        } else {
          $retorno->result = 1;
          $retorno->code = $fila[0];
        }
      }
    } else {
      $retorno->result = 0;
    }

    return  $retorno;
  }


  public function obteneDatosServicioMonta($id)
  {
    $retorno = new Resultado();
    $sql = "CALL SGESS_SERVICIOY_X_ID('$id')";
    $metodo = [];
    //echo $sql;
    $result = parent::ejecutar2($sql);
    while ($fila = mysqli_fetch_object($result)) {
      $obj = new stdClass();
      $obj->id = $fila->id;
      $obj->fecMonta = $fila->fecMonta;
      $obj->metodo = $fila->metodo;
      $obj->textoMetodo = $fila->textoMetodo;
      $obj->codYegua = $fila->codYegua;
      $obj->codPotro = $fila->codPotro;
      $obj->idPoe = $fila->idPoe;
      $obj->prefYegua = $fila->prefYegua;
      $obj->yegua = $fila->yegua;
      $obj->prefPotro = $fila->prefPotro;
      $obj->potro = $fila->potro;
      $obj->isTE = $fila->isTE;
      $obj->fecParir = $fila->fecParir;
      $obj->codigoMonta = $fila->codigoMonta;
      $obj->idReceptor = $fila->idReceptor;
      $obj->padreADN = null;
      $obj->madreADN = null;
      $obj->fecCrea = $fila->fecCrea;
      $obj->fecEmbrion = $fila->fecEmbrion;
    }
    //echo $metodo;
    return $obj;
  }

  public function editarMonta($codigo, $padre, $madre, $idProp, $idPoe, $fecMonta, $fecParir, $metodo, $isTE, $idTextoRec, $fecEmbrion)
  {

    $retorno = new Resultado();
    $sql = "CALL SGESU_SERVICIOY('$codigo','$padre','$madre','$idProp','$idPoe','$fecMonta','$fecParir','$metodo','$isTE','$idTextoRec','$fecEmbrion',@vresultado)";
    // echo $sql ; 
    $result = parent::ejecutar2($sql, '@vresultado');
    // echo "1";
    //echo $result;
    if ($result) {
      // echo "2";
      if ($fila = mysqli_fetch_array($result)) {
        // echo "3";
        // print_r($fila);
        if ($fila[0] == 1) {
          // echo "4";
          $retorno->result = 1;
        } else if ($fila[0] == 2) {
          // echo "5";
          $retorno->result = 2;
        }/*else if($fila[0]==3){
                      $retorno->result=3;
                    }*/ else if ($fila[0] == 999) {
          $retorno->result = 999;
        } else if ($fila[0] == 998) {
          $retorno->result = 998;
        }
      }
    } else {
      $retorno->result = 0;
    }
    return  $retorno;
  }


  public function eliminarServicioy($codigo)
  {
    $retorno = new Resultado();
    $sql = "CALL SGESD_SERVICIOY('$codigo',@vresultado)";
    //  echo $sql;
    $result = parent::ejecutar2($sql, '@vresultado');
    if ($result) {
      if ($fila = mysqli_fetch_array($result)) {
        // print_r($fila);
        if ($fila[0] == 1) {

          $retorno->result = 1;
        } else if ($fila[0] == 0) {

          $retorno->result = 0;
        } else if ($fila[0] == 2) {
          // echo "5";
          $retorno->result = 2;
        } else if ($fila[0] == 995) {
          // echo "5";
          $retorno->result = 995;
        }
      }
    } else {

      $retorno->result = 0;
    }

    return  $retorno;
  }


  public function getADN($codigo)
  {
    $retorno = new Resultado();
    $sql = "CALL SGESS_EJEMPLAR_ADN_X_ID('$codigo')";
    //echo $sql;
    $metodo = [];
    //echo $sql;
    $result = parent::ejecutar2($sql);
    while ($fila = mysqli_fetch_object($result)) {
      $obj = new stdClass();
      $obj->adn = $fila->adn;
    }
    //echo $metodo;
    return $obj;
  }

  public function insertEjemplarExtranjero($codigo, $nombre, $prefijo, $fecNace, $idPelaje, $idPais, $genero, $origen)
  {

    $retorno = new Resultado();
    $sql = "CALL SGESI_EJEMPLAR_EXTRANJERO('$codigo','$nombre','$prefijo','$fecNace','$idPelaje','$idPais','$genero','$origen',@vresultado)";
    // echo $sql;
    $result = parent::ejecutar2($sql, '@vresultado');
    if ($result) {
      if ($fila = mysqli_fetch_array($result)) {
        //  print_r($fila);
        if ($fila[0] == "") {
          $retorno->result = 0;
        }/*else if($fila[0]==3){
                      $retorno->result=3;
                    }*/ else if ($fila[0] == 999) {
          $retorno->result = 999;
        } else if ($fila[0] == 998) {
          $retorno->result = 998;
        } else {
          $retorno->result = 1;
          $retorno->code = $fila[0];
        }
      }
    } else {
      $retorno->result = 0;
    }

    return  $retorno;
  }

  public function getLastInsertMonta()
  {
    $retorno = new Resultado();
    $sql = "CALL SGESS_LAST_MONTA_INS()";
    //echo $sql;
    $result = parent::ejecutar2($sql);
    while ($fila = mysqli_fetch_object($result)) {
      $obj = new stdClass();
      $obj->id = $fila->id;
      $obj->codigoMonta = $fila->codigoMonta;
    }
    return $obj;
  }
  public function getLastInsertNac()
  {
    $retorno = new Resultado();
    $sql = "CALL SGESS_LAST_NAC_INS()";
    //echo $sql;
    $result = parent::ejecutar2($sql);
    while ($fila = mysqli_fetch_object($result)) {
      $obj = new stdClass();
      $obj->id = $fila->id;
      $obj->codigoNacimiento = $fila->codigoNacimiento;
    }
    return $obj;
  }

  public function validadorMontaNac($codigo)
  {
    $retorno = new Resultado();
    $sql = "CALL SGESS_VALIDAD_MONT_NAC('$codigo',@vresultado)";
    //echo $sql;
    $result = parent::ejecutar2($sql, '@vresultado');
    if ($result) {
      if ($fila = mysqli_fetch_array($result)) {
        // print_r($fila);
        if ($fila[0] == 995) {

          $retorno->result = 995;
        } else {

          $retorno->result = 0;
        }
      }
    } else {

      $retorno->result = 0;
    }

    return  $retorno;
  }


  public function getCodNacbyCodMonta($codigo)
  {
    $retorno = new Resultado();
    $sql = "CALL SGESS_GET_CODNAC_BY_CODMONTA('$codigo')";
    //echo $sql;
    $result = parent::ejecutar2($sql);
    while ($fila = mysqli_fetch_object($result)) {
      $obj = new stdClass();
      $obj->codigoNacimiento = $fila->codigoNacimiento;
    }
    return $obj;
  }

  public function getCodInsbyCodNac($codigo)
  {
    $retorno = new Resultado();
    $sql = "CALL SGESS_GET_CODINS_BY_CODNAC('$codigo')";
    //echo $sql;
    $result = parent::ejecutar2($sql);
    while ($fila = mysqli_fetch_object($result)) {
      $obj = new stdClass();
      $obj->codigoInscripcion = $fila->codigoInscripcion;
    }
    return $obj;
  }
  public function validadorNacIns($codigo)
  {
    $retorno = new Resultado();
    $sql = "CALL SGESS_VALIDAD_NAC_INS('$codigo',@vresultado)";
    // echo $sql;
    $result = parent::ejecutar2($sql, '@vresultado');
    if ($result) {
      if ($fila = mysqli_fetch_array($result)) {
        // print_r($fila);
        if ($fila[0] == 995) {
          // echo "1";
          $retorno->result = 995;
        } else {
          //  echo "2";
          $retorno->result = 0;
        }
      }
    } else {
      // echo "3";
      $retorno->result = 0;
    }

    return  $retorno;
  }
  public function obteneDatosServicioMontaPrint($id, $codigoMonta, $prop)
  {
    $retorno = new Resultado();
    $sql = "CALL SGESS_SERVICIOY_X_ID_PRINT('$id','$codigoMonta','$prop')";
    $metodo = [];
    // echo $sql;
    $result = parent::ejecutar2($sql);
    while ($fila = mysqli_fetch_object($result)) {
      $obj = new stdClass();
      $obj->id = $fila->id;
      $obj->fecMonta = $fila->fecMonta;
      $obj->metodo = $fila->metodo;
      $obj->textoMetodo = $fila->textoMetodo;
      $obj->codYegua = $fila->codYegua;
      $obj->codPotro = $fila->codPotro;
      $obj->idPoe = $fila->idPoe;
      $obj->prefYegua = $fila->prefYegua;
      $obj->yegua = $fila->yegua;
      $obj->prefPotro = $fila->prefPotro;
      $obj->potro = $fila->potro;
      $obj->isTE = $fila->isTE;
      $obj->fecParir = $fila->fecParir;
      $obj->codigoMonta = $fila->codigoMonta;
      $obj->idReceptor = $fila->idReceptor;
      $obj->padreADN = $fila->adnPotro;
      $obj->madreADN = $fila->adnYegua;
      $obj->fecCrea = $fila->fecCrea;
      $obj->usuCrea = $fila->usuCrea;
      $obj->fecEmbrion = $fila->fecEmbrion;
      $obj->fechaImpresion = $fila->fechaImpresion;
      $obj->usuImpresion = $fila->usuImpresion;
      $metodo[] = $obj;
    }
    //echo $metodo;
    return $metodo;
  }

  public function getPrefijoProp($idProp)
  {
    $retorno = new Resultado();
    $sql = "CALL SGESS_GET_PREFIJO_PROP('$idProp')";
    //echo $sql;
    $result = parent::ejecutar2($sql);
    while ($fila = mysqli_fetch_object($result)) {
      $obj = new stdClass();
      $obj->prefijo = $fila->prefijo;
    }
    return $obj;
  }


  /*public function insertLogInscripcion($idProp){
        
             $retorno=new Resultado();
            $sql = "CALL SGESI_LOG_X_IDSOL('$idProp',@vresultado)";
        // echo $sql;
            $result = parent::ejecutar2($sql,'@vresultado');
            if($result){
                if($fila = mysqli_fetch_array($result)){
                    //print_r($fila);
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
        }*/

  public function getLastInsertIns()
  {
    $retorno = new Resultado();
    $sql = "CALL SGESS_LAST_INS_INS()";
    //echo $sql;
    $result = parent::ejecutar2($sql);
    while ($fila = mysqli_fetch_object($result)) {
      $obj = new stdClass();
      $obj->codigoInscripcion = $fila->codigoInscripcion;
      $obj->id = $fila->id;
    }
    return $obj;
  }




  public function obteneDatosNacimientoPrint($id, $codigoNacimiento, $prop)
  {
    $retorno = new Resultado();
    $sql = "CALL SGESS_NACIMIENTO_X_ID_PRINT('$id','$codigoNacimiento','$prop')";
    $metodo = [];
    //echo $sql;
    $result = parent::ejecutar2($sql);
    while ($fila = mysqli_fetch_object($result)) {
      $obj = new stdClass();
      $obj->id = $fila->id;
      $obj->nombre = $fila->nombre;
      $obj->prefijo = $fila->prefijo;
      $obj->fecCrea = $fila->fecCrea;
      $obj->genero = $fila->genero;
      $obj->pelaje = $fila->pelaje;
      $obj->fecNace = $fila->fecNace;
      $obj->codigoMonta = $fila->codigoMonta;
      $obj->foto = $fila->foto;
      $obj->propietario = $fila->propietario;
      $obj->idCriador = $fila->idCriador;
      $obj->criador = $fila->criador;
      $obj->LugarNace = $fila->LugarNace;
      $obj->prefijoPadre = $fila->prefijoPadre;
      $obj->nombrePadre = $fila->nombrePadre;
      $obj->pelajePadre = $fila->pelajePadre;
      $obj->idAbueloPadre = $fila->idAbueloPadre;
      $obj->nombreAbueloPadre = $fila->nombreAbueloPadre;
      $obj->prefijoAbueloPadre = $fila->prefijoAbueloPadre;
      $obj->idAbuelaPadre = $fila->idAbuelaPadre;
      $obj->nombreAbuelaPadre = $fila->nombreAbuelaPadre;
      $obj->prefijoAbuelaPadre = $fila->prefijoAbuelaPadre;
      $obj->idPadre = $fila->idPadre;
      $obj->prefijoMadre = $fila->prefijoMadre;
      $obj->nombreMadre = $fila->nombreMadre;
      $obj->pelajeMadre = $fila->pelajeMadre;
      $obj->idAbueloMadre = $fila->idAbueloMadre;
      $obj->nombreAbueloMadre = $fila->nombreAbueloMadre;
      $obj->prefijoAbueloMadre = $fila->prefijoAbueloMadre;
      $obj->idAbuelaMadre = $fila->idAbuelaMadre;
      $obj->nombreAbuelaMadre = $fila->nombreAbuelaMadre;
      $obj->prefijoAbuelaMadre = $fila->prefijoAbuelaMadre;
      $obj->idMadre = $fila->idMadre;
      $obj->metodo = $fila->metodo;
      $obj->idReceptor = $fila->idReceptor;
      $obj->idResenias = $fila->idResenias;
      $obj->isTE = $fila->isTE;
      $obj->documentosPDF = $fila->documentosPDF;
      $obj->fecEmbrion = $fila->fecEmbrion;

      $metodo[] = $obj;
    }
  //echo $metodo;
    return $metodo;
  }

  public function obteneDatosInscripcionPrint($id, $codigoInscripcion, $prop)
  {
    $retorno = new Resultado();
    $sql = "CALL SGESS_INSCRIPCION_X_ID_PRINT($id,'$codigoInscripcion',$prop)";
    $metodo = [];
     //echo $sql;
    $result = parent::ejecutar2($sql);
    while ($fila = mysqli_fetch_object($result)) {
      $obj = new stdClass();
      $obj->id = $fila->id;
      $obj->nombre = $fila->nombre;
      $obj->prefijo = $fila->prefijo;
      $obj->fecCrea = $fila->fecCrea;
      $obj->genero = $fila->genero;
      $obj->pelaje = $fila->pelaje;
      $obj->fecNace = $fila->fecNace;
      $obj->codigoMonta = $fila->codigoMonta;
      $obj->codigoNacimiento = $fila->codigoNacimiento;
      $obj->foto = $fila->foto;
      $obj->propietario = $fila->propietario;
      $obj->idCriador = $fila->idCriador;
      $obj->criador = $fila->criador;
      $obj->LugarNace = $fila->LugarNace;
      $obj->prefijoPadre = $fila->prefijoPadre;
      $obj->nombrePadre = $fila->nombrePadre;
      $obj->pelajePadre = $fila->pelajePadre;
      $obj->idAbueloPadre = $fila->idAbueloPadre;
      $obj->nombreAbueloPadre = $fila->nombreAbueloPadre;
      $obj->prefijoAbueloPadre = $fila->prefijoAbueloPadre;
      $obj->idAbuelaPadre = $fila->idAbuelaPadre;
      $obj->nombreAbuelaPadre = $fila->nombreAbuelaPadre;
      $obj->prefijoAbuelaPadre = $fila->prefijoAbuelaPadre;
      $obj->idPadre = $fila->idPadre;
      $obj->prefijoMadre = $fila->prefijoMadre;
      $obj->nombreMadre = $fila->nombreMadre;
      $obj->pelajeMadre = $fila->pelajeMadre;
      $obj->idAbueloMadre = $fila->idAbueloMadre;
      $obj->nombreAbueloMadre = $fila->nombreAbueloMadre;
      $obj->prefijoAbueloMadre = $fila->prefijoAbueloMadre;
      $obj->idAbuelaMadre = $fila->idAbuelaMadre;
      $obj->nombreAbuelaMadre = $fila->nombreAbuelaMadre;
      $obj->prefijoAbuelaMadre = $fila->prefijoAbuelaMadre;
      $obj->idMadre = $fila->idMadre;
      $obj->metodo = $fila->metodo;
      $obj->isTE = $fila->isTE;
      $obj->idReceptor = $fila->idReceptor;
      $obj->fecEmbrion = $fila->fecEmbrion;
      $obj->idResenias = $fila->idResenias;
      $metodo[] = $obj;
    }
    //echo $metodo;
    return $metodo;
  }



  public function listarMiPropiedad($idProp,$nombre,$genero,$pelaje,$madre,$padre,$adn)
  {
    try {

      $sql = "CALL SGESS_LIST_MI_PROPIEDAD($idProp,'$nombre','$genero','$pelaje','$madre','$padre','$adn')";
      // echo $sql;
      $result = parent::ejecutar2($sql);
      $prop = [];
      while ($fila = mysqli_fetch_object($result)) {
        $obj = new stdClass();
        $obj->id = $fila->id;
        $obj->codigo = $fila->codigo;
        $obj->prefijo = $fila->prefijo;
        $obj->nombre = $fila->nombre;
        $obj->pelaje = $fila->pelaje;
        $obj->fecnac = $fila->fecnac;
        $obj->fallec = $fila->fallec;
        $obj->criador  = $fila->criador;
        $obj->codpad  = $fila->codpad;
        $obj->prefpa  = $fila->prefpa;
        $obj->nompad  = $fila->nompad;
        $obj->codmad  = $fila->codmad;
        $obj->prefma  = $fila->prefma;
        $obj->codmad  = $fila->codmad;
        $obj->nommad  = $fila->nommad;
        $obj->genero  = $fila->genero;
        $obj->fecnac  = $fila->fecnac;
        $obj->xfecnac  = $fila->xfecnac;
        $obj->adn     = $fila->adn_horse;
        $prop[] = $obj;
      }
    } catch (mysqli_sql_exception  $e) {
      echo 'Excepción capturada: ',  $e->getMessage(), "\n";
    }
    return $prop;
  }
 
  public function resumenContNotificaciones($idProp){
    try {
  
      $sql = "CALL SGESS_CUENTA_LOG_NOTIF_IDPROP('$idProp')";
      // echo $sql;
      $result = parent::ejecutar2($sql);
      $prop = [];
      while ($fila = mysqli_fetch_object($result)) {
        $obj = new stdClass();
        $obj->notificacionesInfo = $fila->notificacionesInfo;
        $obj->notificaionesApro = $fila->notificaionesApro;
        $prop[] = $obj;
      }
    } catch (mysqli_sql_exception  $e) {
      echo 'Excepción capturada: ',  $e->getMessage(), "\n";
    }
    return $prop;
  }

  public function listarNovedades($idProp)
  {
    try {

      $sql = "CALL SGESS_LIST_NOVEDADES('$idProp')";
      // echo $sql;
      $result = parent::ejecutar2($sql);
      $prop = [];
      while ($fila = mysqli_fetch_object($result)) {
        $obj = new stdClass();
        $obj->id = $fila->id;
        $obj->cantMisEjemplares = $fila->cantMisEjemplares;
        $obj->cantInscripcion = $fila->cantInscripcion;
        $obj->cantNacimiento = $fila->cantNacimiento;
        $obj->cantMonta = $fila->cantMonta;
        $obj->cantFallecido = $fila->cantFallecido;
        $obj->cantCastrado = $fila->cantCastrado;
        $obj->cantTransferido  = $fila->cantTransferido;
      }
    } catch (mysqli_sql_exception  $e) {
      echo 'Excepción capturada: ',  $e->getMessage(), "\n";
    }
    return $obj;
  }





  public function listarNotificaciones($idProp)
  {
    try {

      $sql = "CALL SGESS_LOG_NOTIF_IDPROP('$idProp')";
      // echo $sql;
      $result = parent::ejecutar2($sql);
      $prop = [];
      while ($fila = mysqli_fetch_object($result)) {
        $obj = new stdClass();
        $obj->id = $fila->id;
        $obj->codigo = $fila->codigo;
        $obj->idPropPotro = $fila->idPropPotro;
        $obj->socioPotro = $fila->socioPotro;
        $obj->codPotro = $fila->codPotro;
        $obj->codYegua = $fila->codYegua;
        $obj->socioYegua = $fila->socioYegua;
        $obj->nombrePotro = $fila->nombrePotro;
        $obj->nombreYegua = $fila->nombreYegua;
        $obj->fecCreacion = $fila->fecCreacion;
        $obj->mensaje = $fila->mensaje;
        $obj->flag = $fila->flag;
        $prop[] = $obj;
      }
    } catch (mysqli_sql_exception  $e) {
      echo 'Excepción capturada: ',  $e->getMessage(), "\n";
    }
    return $prop;
  }


  public function aprobarMonta($idMonta, $idProp)
  {

    $retorno = new Resultado();
    $sql = "CALL SGESU_APROBAR_MONTA('$idMonta','$idProp',@vresultado,'')";
    // echo $sql ; 
    $result = parent::ejecutar2($sql, '@vresultado');
    // echo "1";
    //echo $result;
    if ($result) {
      // echo "2";
      if ($fila = mysqli_fetch_array($result)) {
        // echo "3";
        // print_r($fila);
        if ($fila[0] == 1) {
          // echo "4";
          $retorno->result = 1;
        } else if ($fila[0] == 0) {
          $retorno->result = 0;
        } else {
          $retorno->result = 0;
        }
      }
    } else {
      $retorno->result = 0;
    }
    return  $retorno;
  }



  public function rechazarMonta($idMonta, $idProp)
  {

    $retorno = new Resultado();
    $sql = "CALL SGESU_RECHAZAR_MONTA('$idMonta','$idProp',@vresultado,'')";
    // echo $sql ; 
    $result = parent::ejecutar2($sql, '@vresultado');
    // echo "1";
    //echo $result;
    if ($result) {
      // echo "2";
      if ($fila = mysqli_fetch_array($result)) {
        // echo "3";
        // print_r($fila);
        if ($fila[0] == 1) {
          // echo "4";
          $retorno->result = 1;
        } else if ($fila[0] == 0) {
          $retorno->result = 0;
        } else {
          $retorno->result = 0;
        }
      }
    } else {
      $retorno->result = 0;
    }
    return  $retorno;
  }

  public function getTextoInscripcionPopup($id, $flag)
  {
    try {

      $sql = "CALL SGESS_TEXTO_NOTIF_IDPROP('$id','$flag')";
      // echo $sql;
      $result = parent::ejecutar2($sql);

      while ($fila = mysqli_fetch_object($result)) {
        $obj = new stdClass();
        $obj->mensaje = $fila->mensaje;
        $obj->fecha = $fila->fecCrea;
        $obj->usuCrea = $fila->usuCrea;
        $obj->nombrePotro = $fila->nombrePotro;
        $obj->nombreYegua = $fila->nombreYegua;
        $obj->socioP = $fila->socioP;
        $obj->socioY = $fila->socioY;
      }
    } catch (mysqli_sql_exception  $e) {
      echo 'Excepción capturada: ',  $e->getMessage(), "\n";
    }
    return $obj;
  }




  public function valStatus($id, $flag)
  {

    $retorno = new Resultado();
    $sql = "CALL SGESS_VAL_STATUS('$id','$flag',@vresultado)";
    //echo $sql ; 
    $result = parent::ejecutar2($sql, '@vresultado');
    // echo "1";
    //echo $result;
    if ($result) {
      // echo "2";
      if ($fila = mysqli_fetch_array($result)) {
        // echo "3";
        // print_r($fila);
        if ($fila[0] == 1) {
          // echo "4";
          $retorno->result = 1;
        } else if ($fila[0] == 0) {
          $retorno->result = 0;
        } else {
          $retorno->result = 0;
        }
      }
    } else {
      $retorno->result = 0;
    }
    return  $retorno;
  }



  public function saveTransferencia($ejemplar, $newPropietario, $fechaTrans, $comentario, $idProp, $idComprobante,$flagEsIdPropietario)
  {

    $retorno = new Resultado();
    $sql = "CALL SGESI_EJEMPLAR_MOVIMIENTO('$ejemplar','$newPropietario','$fechaTrans','$comentario','$idProp','$idComprobante',@vresultado,$flagEsIdPropietario)";
    // echo $sql;
    $result = parent::ejecutar2($sql, '@vresultado');
    if ($result) {
      if ($fila = mysqli_fetch_array($result)) {
        //  print_r($fila);
        if ($fila[0] == 1) {
          $retorno->result = 1;
        } else {
          $retorno->result = 0;
        }
      }
    } else {
      $retorno->result = 0;
    }

    return  $retorno;
  }

  public function listarMovimiento($idProp)
  {
    try {

      $sql = "CALL SGESS_LIST_EJEMPLAR_MOVIMIENTO('$idProp')";
      // echo $sql;
      $result = parent::ejecutar2($sql);
      $prop = [];
      while ($fila = mysqli_fetch_object($result)) {
        $obj = new stdClass();
        $obj->id = $fila->id;
        $obj->nomContacto = $fila->nomContacto;
        $obj->codContacto = $fila->codContacto;
        $obj->ejemplar = $fila->ejemplar;
        $obj->fecMov = $fila->fecMov;
        $obj->fecCrea = $fila->fecCrea;
        $obj->estado = $fila->estado;
        $obj->estadoTexto = $fila->estadoTexto;
        $obj->ruta = $fila->ruta;
        $obj->comentario = $fila->comentario;
        $obj->fecRevision = $fila->fecRevision;
        $prop[] = $obj;
      }
    } catch (mysqli_sql_exception  $e) {
      echo 'Excepción capturada: ',  $e->getMessage(), "\n";
    }
    return $prop;
  }


  public function deleteMovimiento($id)
  {
    $retorno = new Resultado();
    $sql = "CALL SGESD_EJEMPLAR_MOVIMIENTO('$id',@vresultado)";
    //echo $sql;
    $result = parent::ejecutar2($sql, '@vresultado');
    if ($result) {
      if ($fila = mysqli_fetch_array($result)) {
        // print_r($fila);
        if ($fila[0] == 1) {
          // echo "4";
          $retorno->result = 1;
        } else {
          $retorno->result = 0;
        }
      }
    } else {

      $retorno->result = 0;
    }

    return  $retorno;
  }

  public function saveNewPropietario($tipoDoc, $numDoc, $nombre, $apePat, $apeMat, $direccion, $correo, $idProp)
  {

    $retorno = new Resultado();
    $sql = "CALL SGESI_ENTIDAD_TMP('$tipoDoc','$numDoc','$nombre','$apePat','$apeMat','$direccion','$correo','$idProp')";
    // echo $sql;
    $result = parent::ejecutar2($sql);
    while ($fila = mysqli_fetch_object($result)) {
      $obj = new stdClass();
      $obj->id = $fila->id;
      $obj->flag = $fila->vresultado;
    }

    return  $obj;
  }


  public function saveFallecimiento($idEjemplar, $fechaF, $idProp)
  {

    $retorno = new Resultado();
    $sql = "CALL SGESI_EJEMPLAR_HISTORIAL_FAC('$idEjemplar','$fechaF','$idProp',@vresultado)";
    //echo $sql;
    $result = parent::ejecutar2($sql, '@vresultado');
    if ($result) {
      if ($fila = mysqli_fetch_array($result)) {
        //  print_r($fila);
        if ($fila[0] == 1) {
          $retorno->result = 1;
        } else {
          $retorno->result = 0;
        }
      }
    } else {
      $retorno->result = 0;
    }

    return  $retorno;
  }


  public function listarHistorialF($idProp)
  {
    try {

      $sql = "CALL SGESS_LIST_HISTORIAL_FA('$idProp')";
      // echo $sql;
      $result = parent::ejecutar2($sql);
      $prop = [];
      while ($fila = mysqli_fetch_object($result)) {
        $obj = new stdClass();
        $obj->id = $fila->id;
        $obj->ejemplar = $fila->ejemplar;
        $obj->fecFac = $fila->fecFac;
        $obj->estado = $fila->estado;
        $obj->estadoTexto = $fila->estadoTexto;
        $obj->comentario = $fila->comentario;
        $obj->fecRev = $fila->fecRev;
        $prop[] = $obj;
      }
    } catch (mysqli_sql_exception  $e) {
      echo 'Excepción capturada: ',  $e->getMessage(), "\n";
    }
    return $prop;
  }


  public function deleteFallecimiento($id)
  {
    $retorno = new Resultado();
    $sql = "CALL SGESD_EJEMPLAR_FALLECIDO('$id',@vresultado)";
    //echo $sql;
    $result = parent::ejecutar2($sql, '@vresultado');
    if ($result) {
      if ($fila = mysqli_fetch_array($result)) {
        // print_r($fila);
        if ($fila[0] == 1) {
          // echo "4";
          $retorno->result = 1;
        } else {
          $retorno->result = 0;
        }
      }
    } else {

      $retorno->result = 0;
    }

    return  $retorno;
  }

  public function saveCastracion($idEjemplar, $fechaC, $idProp)
  {

    $retorno = new Resultado();
    $sql = "CALL SGESI_EJEMPLAR_HISTORIAL_CAS('$idEjemplar','$fechaC','$idProp',@vresultado)";
    //echo $sql;
    $result = parent::ejecutar2($sql, '@vresultado');
    if ($result) {
      if ($fila = mysqli_fetch_array($result)) {
        //  print_r($fila);
        if ($fila[0] == 1) {
          $retorno->result = 1;
        } else {
          $retorno->result = 0;
        }
      }
    } else {
      $retorno->result = 0;
    }

    return  $retorno;
  }


  public function listarHistorialC($idProp)
  {
    try {

      $sql = "CALL SGESS_LIST_HISTORIAL_CA('$idProp')";
      // echo $sql;
      $result = parent::ejecutar2($sql);
      $prop = [];
      while ($fila = mysqli_fetch_object($result)) {
        $obj = new stdClass();
        $obj->id = $fila->id;
        $obj->ejemplar = $fila->ejemplar;
        $obj->fecCas = $fila->fecCas;
        $obj->estado = $fila->estado;
        $obj->estadoTexto = $fila->estadoTexto;
        $obj->comentario = $fila->comentario;
        $obj->fecRev = $fila->fecRev;
        $prop[] = $obj;
      }
    } catch (mysqli_sql_exception  $e) {
      echo 'Excepción capturada: ',  $e->getMessage(), "\n";
    }
    return $prop;
  }


  public function deleteCastracion($id)
  {
    $retorno = new Resultado();
    $sql = "CALL SGESD_EJEMPLAR_CASTRADO('$id',@vresultado)";
    //echo $sql;
    $result = parent::ejecutar2($sql, '@vresultado');
    if ($result) {
      if ($fila = mysqli_fetch_array($result)) {
        // print_r($fila);
        if ($fila[0] == 1) {
          // echo "4";
          $retorno->result = 1;
        } else {
          $retorno->result = 0;
        }
      }
    } else {

      $retorno->result = 0;
    }

    return  $retorno;
  }
  /*--------------------------------- FIN DE LA FASE2 --------------------------------*/

  function BajaInsNac($codigo, $motivoBaja, $fecBaja, $detalleBaja, $tabla,$usuCrea){
    $retorno = new Resultado();
    $sql = "CALL SGESU_DAR_BAJA('$tabla','$fecBaja','$motivoBaja','$detalleBaja','$codigo','$usuCrea',@vresultado)";
    //echo $sql;
    $result = parent::ejecutar2($sql, '@vresultado');
    if ($result) {
      if ($fila = mysqli_fetch_array($result)) {
        // print_r($fila);
        if ($fila[0] == 1) {
          // echo "4";
          $retorno->result = 1;
        } else {
          $retorno->result = 0;
        }
      }
    } else {

      $retorno->result = 0;
    }

    return  $retorno;
  }

  function EsMiEjemplar($codigo,$idProp){
    $retorno = new Resultado();
    $sql = "CALL SGESS_VALIDACION_PROPIEDAD_EJEMPLAR('$codigo','$idProp',@vresultado)";
    //echo $sql;
    $result = parent::ejecutar2($sql, '@vresultado');
    if ($result) {
      if ($fila = mysqli_fetch_array($result)) {
        if ($fila[0] == 1) {
          $retorno->result = 1;
        } else {
          $retorno->result = 0;
        }
      }
    } else {
      $retorno->result = 0;
    }
    return  $retorno;
  }
}
