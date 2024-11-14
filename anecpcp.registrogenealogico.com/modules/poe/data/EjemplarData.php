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
    // echo $sql;
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
    //    echo $sql;
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


  /*-------------------- INICIO DE LA FASE2 -------------------------*/

  public function listaComboIdNac($prop, $flag)
  {
    $retorno = new Resultado();
    $sql = "CALL SGESS_LIST_ID_NAC('$prop','$flag')";
    $metodo = [];
    $result = parent::ejecutar2($sql);
    //echo $sql;
    while ($fila = mysqli_fetch_object($result)) {
      $obj = new stdClass();
      $obj->id = $fila->id;
      $obj->descripcion = $fila->descripcion;
      $metodo[] = $obj;
    }
    return $metodo;
  }


  public function obtenerDatosNacimientoEjemplar($id)
  {
    $retorno = new Resultado();
    $sql = "CALL SGESS_GET_INFO_EJEMPLAR('$id')";
    $metodo = [];
    //  echo $sql;
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
    }
    //echo $metodo;
    return $obj;
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

  public function listaComboIdMonta($prop, $flag)
  {
    $retorno = new Resultado();
    $sql = "CALL SGESS_LIST_ID_MONTA('$prop','$flag')";
    $metodo = [];
    // echo $sql;
    $result = parent::ejecutar2($sql);
    while ($fila = mysqli_fetch_object($result)) {
      $obj = new stdClass();
      $obj->id = $fila->id;
      $obj->descripcion = $fila->descripcion;
      $metodo[] = $obj;
    }
    return $metodo;
  }
  public function listarPais()
  {
    $retorno = new Resultado();
    $sql = "CALL SGESS_LISTAR_PAIS()";
    $metodo = [];
    $result = parent::ejecutar2($sql);
    // echo $sql;
    while ($fila = mysqli_fetch_object($result)) {
      $obj = new stdClass();
      $obj->valor = $fila->id;
      $obj->descripcion = $fila->nombre;
      $metodo[] = $obj;
    }
    return $metodo;
  }
  public function listarTipoDocumento()
  {
    $retorno = new Resultado();
    $sql = "CALL SGESS_LIST_TIPO_DOC()";
    $metodo = [];
    $result = parent::ejecutar2($sql);
    // echo $sql;
    while ($fila = mysqli_fetch_object($result)) {
      $obj = new stdClass();
      $obj->valor = $fila->id;
      $obj->descripcion = $fila->descripcion;
      $metodo[] = $obj;
    }
    return $metodo;
  }
  public function obteneDatosServicioMontaPrint($id, $codigoMonta, $prop,$origen)
  {
    $retorno = new Resultado();
    $sql = "CALL SGESS_SERVICIOY_X_ID_PRINT('$id','$codigoMonta','$prop',$origen)";
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
      $obj->fechaImpresion = $fila->fechaImpresion;
      $obj->usuImpresion = $fila->usuImpresion;
      $obj->fechaEmbrion = $fila->fecEmbrion;
      $metodo[] = $obj;
    }
    //echo $metodo;
    return $metodo;
  }

  public function obteneDatosNacimientoPrint($id, $codigoNacimiento, $prop,$origen)
  {
    $retorno = new Resultado();
    $sql = "CALL SGESS_NACIMIENTO_X_ID_PRINT('$id','$codigoNacimiento','$prop',$origen)";
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
      $obj->idReceptor = $fila->idReceptor;
      $obj->idResenias = $fila->idResenias;
      $obj->diasGestacion = $fila->diasGestacion;
      $obj->fechaImpresion = $fila->fechaImpresion;
      $obj->usuCreaNac = $fila->usuCreaNac;
      $obj->usuCreaMonta = $fila->usuCreaMonta;
      $obj->fecCreaMonta = $fila->fecCreaMonta;
      $obj->fechaImpresion = $fila->fechaImpresion;
      $obj->usuImpresion = $fila->usuImpresion;
      $obj->reseniaBasica = $fila->reseniaBasica;
      $obj->documentosPDF = $fila->documentosPDF;
      $obj->fecEmbrion = $fila->fecEmbrion;
      $obj->isTE = $fila->isTE;
      $obj->estadoSolTexto = $fila->estadoSolTexto;
      $metodo[] = $obj;
    }
    //echo $metodo;
    return $metodo;
  }

  public function obteneDatosInscripcionPrint($id, $codigoInscripcion, $prop,$origen)
  {
    $retorno = new Resultado();
    $sql = "CALL SGESS_INSCRIPCION_X_ID_PRINT('$id','$codigoInscripcion','$prop',$origen)";
    $metodo = [];

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
      $obj->idReceptor = $fila->idReceptor;
      $obj->idResenias = $fila->idResenias;
      $obj->diasGestacion = $fila->diasGestacion;
      $obj->fechaImpresion = $fila->fechaImpresion;
      $obj->usuCreaNac = $fila->usuCreaNac;
      $obj->usuCreaMonta = $fila->usuCreaMonta;
      $obj->fecCreaMonta = $fila->fecCreaMonta;
      $obj->fechaImpresion = $fila->fechaImpresion;
      $obj->usuImpresion = $fila->usuImpresion;
      $obj->reseniaBasica = $fila->reseniaBasica;
      $obj->documentosPDF = $fila->documentosPDF;
      $obj->fecEmbrion = $fila->fecEmbrion;
      $obj->isTE = $fila->isTE;
      $obj->estadoSolTexto = $fila->estadoSolTexto;
      $metodo[] = $obj;
    }
    //echo $metodo;
    return $metodo;
  }
  /*------------------------------ FIN DE LA FASE2----------------------------*/
  public function listarMotivoBaja()
  {
    $retorno = new Resultado();
    $sql = "CALL SGESS_MOTIVO_BAJA()";
    $metodo = [];
    $result = parent::ejecutar2($sql);
    // echo $sql;
    while ($fila = mysqli_fetch_object($result)) {
      $obj = new stdClass();
      $obj->valor = $fila->id;
      $obj->descripcion = $fila->motivo;
      $metodo[] = $obj;
    }
    return $metodo;
  }

  public function editarMonta($codigo, $padre, $madre, $idProp, $idPoe, $fecMonta, $fecParir, $metodo, $isTE, $idTextoRec, $fecEmbrion)
  {

    $retorno = new Resultado();
    $sql = "CALL SGESU_SERVICIOY('$codigo','$padre','$madre','$idProp','$idPoe','$fecMonta','$fecParir','$metodo','$isTE','$idTextoRec','$fecEmbrion',@vresultado)";
    // echo $sql ; 
    $result = parent::ejecutar2($sql, '@vresultado');
    if ($result) {
      if ($fila = mysqli_fetch_array($result)) {
        if ($fila[0] == 1) {
          $retorno->result = 1;
        } else if ($fila[0] == 2) {
          $retorno->result = 2;
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

  public function insertarMonta($padre, $madre, $idProp, $idPoe, $fecMonta, $fecParir, $metodo, $isTE, $idTextoRec, $fecEmbrion)
  {

    $retorno = new Resultado();
    $sql = "CALL SGESI_SERVICIOY('$padre','$madre','$idProp','$idPoe','$fecMonta','$fecParir','$metodo','$isTE','$idTextoRec','$fecEmbrion',@vresultado)";
    //  echo $sql;
    $result = parent::ejecutar2($sql, '@vresultado');
    if ($result) {
      if ($fila = mysqli_fetch_array($result)) {
        if ($fila[0] == "") {
          $retorno->result = 0;
        }else if ($fila[0] == 999) {
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
}
