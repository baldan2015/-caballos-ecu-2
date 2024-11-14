<?php
//echo getcwd();
if (file_exists("../../data/EjemplarData.php")) include_once("../../data/EjemplarData.php");
if (file_exists("../../entidad/Ejemplar.inc.php")) include_once("../../entidad/Ejemplar.inc.php");
if (file_exists("../../entidad/Constantes.php")) include_once("../../entidad/Constantes.php");
if (file_exists("../../data/PropietarioLogData.php")) include_once("../../data/PropietarioLogData.php");
if (file_exists("../../data/CriadorLogData.php")) include_once("../../data/CriadorLogData.php");
if (file_exists("../../data/EntidadData.php")) include_once("../../data/EntidadData.php");
if (file_exists("../../logica/PropietarioLogLogica.php")) include_once("../../logica/PropietarioLogLogica.php");


if (file_exists("../data/EjemplarData.php"))  include_once("../data/EjemplarData.php");
if (file_exists("../entidad/Ejemplar.inc.php")) include_once("../entidad/Ejemplar.inc.php");
if (file_exists("../entidad/Constantes.php")) include_once("../entidad/Constantes.php");
if (file_exists("../data/PropietarioLogData.php")) include_once("../data/PropietarioLogData.php");
if (file_exists("../data/CriadorLogData.php")) include_once("../data/CriadorLogData.php");
if (file_exists("../data/EntidadData.php")) include_once("../data/EntidadData.php");
if (file_exists("../logica/PropietarioLogLogica.php")) include_once("../logica/PropietarioLogLogica.php");


class EjemplarLogica
{
  public $context;
  public function EjemplarLogica()
  {
    $this->context = new EjemplarData();
  }
  //Guardar
  public function insertar($codigo, $prefijo, $nombre, $fecNace, $padre, $madre, $idPelaje, $lugarNace, $microchip, $adn, $descripcion, $usuario_crea, $genero, $fecCapado, $listPropietarios, $listCriadores, $fecFallece, $motivoFallece, $idProvincia, $origen, $resenias, $fecReg, $nroLibro, $nroFolio, $fecServ, $metodo)
  {


    $retorno = new Resultado();
    if ((is_array($listCriadores) && count($listCriadores) > 1)) {
      $retorno->result = 4;
    } else {

      $retornoProps = $this->editarPropietarios($codigo, $listPropietarios, null, 0, $usuario_crea);
      //  print_r($retornoProps);
      if ($retornoProps->result == 1) {


        $retorno = $this->context->insertar($codigo, $prefijo, $nombre, $fecNace, $padre, $madre, $idPelaje, $lugarNace, $microchip, $adn, $descripcion, $usuario_crea, $genero, $fecCapado, $fecFallece, $motivoFallece, $idProvincia, $origen, $resenias, $fecReg, $nroLibro, $nroFolio, $fecServ, $metodo);

        if ($retorno->result == 1) {
          if ($retornoProps->code > 0) {
            $idNuevoProp = $retornoProps->code;
            $dataPL = new PropietarioLogData();
            $idEjemplarNeo = $retorno->code;
            $dataPL->insertar($idEjemplarNeo,  $idNuevoProp);
          }
          if (is_array($listCriadores)) {
            $dataCL = new CriadorLogData();
            foreach ($listCriadores as $key => $value) {
              $dataCL->insertar($idEjemplarNeo, $listCriadores[$key]['idEntidad'], $usuario_crea);
            }
          }
        } else {
          if ($retorno->result != 999 && $retorno->result != 998) {
            $retorno->result = 0;
          }
        }
      } else {
        if ($retornoPropos->result == 5) {
          $retorno->result = 5;
        } else {
          /*ocurrio un errro al registrar o actualizar propietarios*/
          $retorno->result = 6;
        }
      }
    }
    return $retorno;
  }
  //Editar
  public function editar($codigo, $prefijo, $nombre, $fecNace, $padre, $madre, $idPelaje, $lugarNace, $microchip, $adn, $descripcion, $usuario_modi, $genero, $fecCapado, $propietarios, $criadores, $propietariosDEL, $criadoresDEL, $fecFallece, $motivoFallece, $idProvincia, $resenias, $fecReg, $nroLibro, $nroFolio, $fecServ, $metodo, $origen)
  {

    $resultado = new Resultado();
    /*echo"<pre>"; print_r($propietarios);echo"</pre>";*/
    if (is_array($criadores) && count($criadores) > 1) {
      $resultado->result = 4;
    } else {
      $retornoPropos = $this->editarPropietarios($codigo, $propietarios, $propietariosDEL, 1, $usuario_modi);
      if ($retornoPropos->result == 1) {
        $resultado = $this->context->editar($codigo, $prefijo, $nombre, $fecNace, $padre, $madre, $idPelaje, $lugarNace, $microchip, $adn, $descripcion, $usuario_modi, $genero, $fecCapado, $fecFallece, $motivoFallece, $idProvincia, $resenias, $fecReg, $nroLibro, $nroFolio, $fecServ, $metodo, $origen);

        if ($resultado->result == 999 || $resultado->result == 998) {
          $resultado->result = $resultado->result;
        } else {
          if (is_array($criadores)) {
            $dataCL = new CriadorLogData();
            foreach ($criadores as $key => $value) {
              if ($criadores[$key]['origen'] != "BD") {
                $dataCL->insertar($codigo, $criadores[$key]['idEntidad'], $usuario_modi);
              }
            }
          }
          if (is_array($criadoresDEL)) {
            $dataCL = new CriadorLogData();
            foreach ($criadoresDEL as $key => $value) {
              if ($criadoresDEL[$key]['idCriaLog'] != 0) {
                $retornoPropLog = $dataCL->actualizarXId($criadoresDEL[$key]['idCriaLog']);
              }
            }
          }
        }
      } else {
        if ($retornoPropos->result == 5) {
          $resultado->result = 5;
        } else {
          /*ocurrio un errro al registrar o actualizar propietarios*/
          $resultado->result = 6;
        }
      }
    }

    return $resultado;
  }
  //Obtener ID
  public function obtenerID($codigo)
  {
    $contextProp = new PropietarioLogData();
    $contextCria = new CriadorLogData();
    $registros = $this->context->obtenerID($codigo);

    if ($registros != null) {
      $registros->propietarios = $contextProp->buscarXEjemplar($codigo);
      $registros->criadores = $contextCria->buscarXEjemplar($codigo);
      $registroPadre = $this->context->obtenerID($registros->idPadre);
      $registroMadre = $this->context->obtenerID($registros->idMadre);

      if ($registroPadre != null) $registros->nombrePadre = $registroPadre->prefijo . " " . $registroPadre->nombre . " - " . $registroPadre->codigo;
      if ($registroMadre != null) $registros->nombreMadre = $registroMadre->prefijo . " " . $registroMadre->nombre . " - " . $registroMadre->codigo;
    }
    return $registros;
  }

  //Buscar
  public function buscar($entity)
  {
    $registros = $this->context->buscar($entity);
    return $registros;
  }
  //Eliminar
  public function eliminar($codigo, $usuario_modi)
  {
    $registros = $this->context->eliminar($codigo, $usuario_modi);
    return $registros;
  }
  public function fallece($codigo, $usuario_modi, $motivoFallece, $fecFallece)
  {
    $registros = $this->context->fallece($codigo, $usuario_modi, $motivoFallece, $fecFallece);
    return $registros;
  }
  public function validarFecha($fechaServ, $fechaNac, $idMadre, $idHijo)
  {
    $registros = $this->context->validarFecha($fechaServ, $fechaNac, $idMadre, $idHijo);
    return $registros;
  }

  //funcion Generar codigo
  public function generarCodigo($entity)
  {
    $registros = $this->context->generarCodigo($entity);
    return $registros;
  }
  /*INICIO metodos para JQGRID PAGINADO*/
  public function numeroRegistro($id, $pref, $nom, $prop, $cria, $genero, $emin, $emax, $estado, $ente)
  {
    return $this->context->numeroRegistro($id, $pref, $nom, $prop, $cria, $genero, $emin, $emax, $estado, $ente);
  }
  public function buscarSearch($id, $pref, $nom, $prop, $cria, $genero, $emin, $emax, $estado, $ente, $start = 1, $limit = 100, $sidx = 1, $sord = "")
  {
    $registros = $this->context->buscarSearch($id, $pref, $nom, $prop, $cria, $genero, $emin, $emax, $estado, $ente, $start, $limit, $sidx, $sord);
    return $registros;
  }
  /*FIN metodos para JQGRID PAGINADO*/

  //funcion validar eliminación de categoria
  public function validarEliminar($entity)
  {
    $registros = $this->context->validarEliminar($entity);
    return $registros;
  }
  public function buscarDataTable()
  {
    $registros = $this->context->buscarDataTable();
    return $registros;
  }

  public function buscarMadre($nombre)
  {
    $registros = $this->context->buscarMadre($nombre);
    return $registros;
  }
  public function buscarPadre($nombre)
  {
    $registros = $this->context->buscarPadre($nombre);
    return $registros;
  }
  /*BUSQUEDA DE EJAMPLARES PARA EL BUSCADOR GENERAL  POPUP*/
  public function buscarTodos($nombre)
  {
    $registros = $this->context->buscarTodos($nombre);
    return $registros;
  }

  public function obtieneIdsProp($datospropietarios)
  {
    $ids = "";
    $i = 0;
    //EVALUAR SI HAY ID DE COOPROPIEDAD PARA REUTILIZAR 
    //     echo"<pre>";   print_r($datospropietarios);
    foreach ($datospropietarios as $key => $value) {
      $entidades = explode("|", $datospropietarios[$key]['idEntidad']);
      if (is_array($entidades)) {
        foreach ($entidades as $key => $value) {
          if ($i == 0) {
            $ids = $entidades[$key];
          } else {
            $ids = $ids . "," . $entidades[$key];
          }

          $i++;
        }
      }
    }


    return $ids;
  }
  public function buscarSearchGralEjemplar($nomFiltro, $genero, $start = 1, $limit = 15, $sidx = 1, $sord = "")
  {
    //  echo "buscarSearch";
    $registros = $this->context->buscarSearchGralEjemplar($nomFiltro, $genero, $start, $limit, $sidx, $sord);
    return $registros;
  }
  public function numeroRegistroGralEjemplar($nomFiltro, $genero)
  {

    return $this->context->numeroRegistroGralEjemplar($nomFiltro, $genero);
  }
  public function buscarPadres($codigo)
  {
    return $this->context->buscarPadres($codigo);
  }
  public function existeCooPropiedad($datospropietarios)
  {
    $retorno = false;
    $i = 0;

    foreach ($datospropietarios as $key => $value) {
      if ($datospropietarios[$key]['idPropietario'] > 0) $i++;
    }

    if ($i == 0) $retorno = true;
    return $retorno;
  }
  /*
        $codigo,=codigo del ejemplar
        $propietarios=arreglo de entidades a registrar como propietarios o coopropietarios 
        $propietariosDEL= propietarios finalizar  tiempo propiedad del caballo
        $insertNewPropToLog=indicador para actualizar y registrar  el propietariolo. 
        1=indica que si actualizara y registrara
        0=indica que solo creara la propiedad o coopropiedad pero no actualizara el  propietario log en ningun caso
  
        RETORNO:
        $resultado->code= codigo de propiedad generado.
        $resultado->result=5;
        indica que : "Sólo se puede agregar un copropietario. Si desea crear una nueva copropiedad, vuelva agregar los propietarios. Agregar uno a uno la nueva lista de propiedad"
        */
  public function editarPropietarios($codigo, $propietarios, $propietariosDEL, $insertNewPropToLog, $usuariolog)
  {

    $idProp = 0;
    $resultado = new Resultado();
    $resultado->code = $idProp;
    $resultado->result = 0;
    $continue = true;
    if (is_array($propietarios) && count($propietarios) > 1) {
      // SI en el arreglo de propietarios no existe alguna coopropiedad
      // seleccionada
      if (!$this->existeCooPropiedad($propietarios)) {
        $ids = $this->obtieneIdsProp($propietarios);
        $logicaPL = new PropietarioLogLogica();
        $cantidadCoop = $logicaPL->cuentaPropTempCoop($ids);
        if ($cantidadCoop == 1) {
          $continue = true;
        } else {
          $continue = false;;
        }
      }
    }

    if ($continue != true) {
      $resultado->result = 5;
    } else {
      $dataPL = new PropietarioLogData();
      /*Finaliza propiedad del ejemplar - propietarios quitados de lista*/
      // solo si se va registrar en el propietariolog
      if (is_array($propietariosDEL) && $insertNewPropToLog == 1) {
        foreach ($propietariosDEL as $key => $value) {
          if ($propietariosDEL[$key]['idPropLog'] != 0) {
            $retornoPropLog = $dataPL->actualizarXId($propietariosDEL[$key]['idPropLog']);
          }
        }
      }
      /*FINALIZA LA COOPROPIEDAD DE AQUELLOS QUE YA TIENEN EL idPropLog PROVIENE DE BD.*/
      // solo si se va registrar en el propietariolog
      if (is_array($propietarios) && $propietarios > 1 && $insertNewPropToLog == 1) {
        foreach ($propietarios as $key => $value) {
          if ($propietarios[$key]['idPropLog'] != 0) {
            $retornoPropLog = $dataPL->actualizarXId($propietarios[$key]['idPropLog']);
          }
        }
      }

      if (is_array($propietarios)) {
        if (count($propietarios) > 1) {
          /*
                              EN CASO SE HAYA AGREGADO  MAS PROPIETARIOS
                              ESTOS SE CONVIERTEN EN COOPROIETARIOS.
                              HAY QUE REGISTRAR LOS DOS PROPIETARIOS Y GENERAR UN ID UNICO DE COOPROPIETARIOS
                              EN LA TABLA PROPIEDAD
                            */
          //EVALUAR SI HAY ID DE COOPROPIEDAD PARA REUTILIZAR   
          $ids = $this->obtieneIdsProp($propietarios);
          $logicaPL = new PropietarioLogLogica();
          $idCooProp = $logicaPL->obtieneIdCooPropietario($ids);

          /*SI LOS IDS $ids  DE LA COOPROPIEDAD ENCONTRO  YA EXISTENTE SE REUTILIZA EL ID DE LA
                                  COOPROPIEDAD DEL CAMPO ID PROPIETARIO TABLA PROPIETARIO
                                */
          /* SI   $idCooProp==0 NO SE ENCONTRO ID PROPIETARIO DE LA COOPROPIEDAD PARA REUTILIZAR EL CODIGO.*/
          if ($idCooProp == 0) {
            foreach ($propietarios as $key => $value) {
              $dataProp = new EntidadData();
              if ($cuenta == 0) $idProp = 0;

              // solo si se va registrar en el propietariolog  
              if ($propietarios[$key]['origen'] == "BD" && $insertNewPropToLog == 1) {
                $retornoPropLogUPD = $dataPL->actualizarXId($propietarios[$key]['idPropLog']);
              }
              if ($propietarios[$key]['idEntidad'] != 0) {
                $entidades = explode("|", $propietarios[$key]['idEntidad']);
                if (is_array($entidades)) {
                  foreach ($entidades as $key => $value) {
                    $retornoProp = $dataProp->insertarPropietario(
                      $idProp,
                      $entidades[$key],
                      $usuariolog,
                      0,
                      1
                    );
                    if ($retornoProp->result == 1)  $idProp = $retornoProp->code;
                  }
                }
              } else {
                $retornoProp = $dataProp->insertarCoPropietario(
                  $propietarios[$key]['idPropietario'],
                  $propietarios[$key]['idEntidad'],
                  $usuariolog,
                  $idProp
                );

                if ($retornoProp->result == 1)  $idProp = $retornoProp->code;
              }

              $cuenta++;
            }
          } else {
            $idProp = $idCooProp;
          }
          /*LUEGO DE GENERAR LA COOPROPIEDAD REGISTRAR EN EL LOG DE PROPIETAROS */
          // solo si se va registrar en el propietariolog
          if ($idProp > 0 && $insertNewPropToLog == 1) {
            $dataPL->insertar($codigo, $idProp);
          }
        } else {
          $idProp = 0;
          /*SI SOLO ES UN PROPIETARIO REGISTRA EL ID DE PROPIEDAD AL LOG*/
          if ($propietarios[0]['idPropietario'] != "0") {
            // solo si se va registrar en el propietariolog
            if ($insertNewPropToLog == 1) {
              $dataPL->insertar($codigo,  $propietarios[0]['idPropietario']);
            }
            $idProp = $propietarios[0]['idPropietario'];
          } else {
            $dataProp = new EntidadData();
            $retornoPropNeo = $dataProp->insertarPropietario(
              0,
              $propietarios[0]['idEntidad'],
              $usuariolog,
              1
            );
            if ($retornoPropNeo->result == 1) {
              // solo si se va registrar en el propietariolog
              if ($insertNewPropToLog == 1) {
                $dataPL->insertar($codigo,  $retornoPropNeo->code);
              }
              $idProp = $retornoPropNeo->code;
            }
          }
        }
      } else {
        $resultado->result = 1;
        $idProp = 0;
      }
    }
    if ($idProp > 0) {
      $resultado->result = 1;
    }
    $resultado->code = $idProp;
    return $resultado;
  }

  /*INICIO metodos para JQGRID PAGINADO REPORTE ADN*/
  public function numeroRegistroRptAdn($id, $nombre, $idPadre, $nomPadre, $idMadre, $nomMadre, $idProp, $idEnte)
  {
    return $this->context->numeroRegistroRptAdn($id, $nombre, $idPadre, $nomPadre, $idMadre, $nomMadre, $idProp, $idEnte);
  }
  public function buscarSearchRptAdn($id, $nombre, $idPadre, $nomPadre, $idMadre, $nomMadre, $idProp, $idEnte, $start = 1, $limit = 100, $sidx = 1, $sord = "")
  {
    $registros = $this->context->buscarSearchRptAdn($id, $nombre, $idPadre, $nomPadre, $idMadre, $nomMadre, $idProp, $idEnte, $start, $limit, $sidx, $sord);
    return $registros;
  }
  /*FIN metodos para JQGRID PAGINADO REPORTE ADN*/

  public function buscarSearchXls($id, $pref, $nom, $prop, $cria, $genero, $emin, $emax, $estado, $ente, $start = 1, $limit = 100, $sidx = 1, $sord = "")
  {
    $registros = $this->context->buscarSearchXls($id, $pref, $nom, $prop, $cria, $genero, $emin, $emax, $estado, $ente, $start, $limit, $sidx, $sord);
    return $registros;
  }



  /*-------------------------------------INICIO DE LA FASE2 --------------------------*/
  public function listaComboMtdoReprop($id, $descripcion)
  {
    $registros = $this->context->listaComboMtdoReprop($id, $descripcion);
    return $registros;
  }
  public function listaComboIdNac($prop, $flag)
  {
    $registros = $this->context->listaComboIdNac($prop, $flag);
    return $registros;
  }
  public function listaComboIdMonta($prop, $flag)
  {
    $registros = $this->context->listaComboIdMonta($prop, $flag);
    return $registros;
  }
  public function listarPais()
  {
    $registros = $this->context->listarPais();
    return $registros;
  }
  public function listarTipoDocumento()
  {
    $registros = $this->context->listarTipoDocumento();
    return $registros;
  }

  public function obtenerDatosNacimientoEjemplar($id)
  {
    $registros = $this->context->obtenerDatosNacimientoEjemplar($id);
    return $registros;
  }

  public function obteneDatosServicioMontaPrint($id, $codigoMonta, $prop,$origen)
  {
    $registros = $this->context->obteneDatosServicioMontaPrint($id, $codigoMonta, $prop,$origen);
    return $registros;
  }
  public function obteneDatosNacimientoPrint($id, $codigoNacimiento, $prop,$origen)
  {
    $registros = $this->context->obteneDatosNacimientoPrint($id, $codigoNacimiento, $prop,$origen);
    return $registros;
  }
  public function obteneDatosInscripcionPrint($id, $codigoInscripcion, $prop,$origen)
  {
    $registros = $this->context->obteneDatosInscripcionPrint($id, $codigoInscripcion, $prop,$origen);
    return $registros;
  }
  /*-------------------------------------FIN DE LA FASE2 --------------------------*/
  public function listarMotivoBaja()
  {
    $registros = $this->context->listarMotivoBaja();
    return $registros;
  }
  public function editarMonta($codigo, $padre, $madre, $idProp, $idPoe, $fecMonta, $fecParir, $metodo, $isTE, $idTextoRec, $fecEmbrion){
    $registros = $this->context->editarMonta($codigo, $padre, $madre, $idProp, $idPoe, $fecMonta, $fecParir, $metodo, $isTE, $idTextoRec, $fecEmbrion);
    return $registros;
  }
  public function insertarMonta($padre, $madre, $idProp, $idPoe, $fecMonta, $fecParir, $metodo, $isTE, $idTextoRec, $fecEmbrion){
    $registros = $this->context->insertarMonta($padre, $madre, $idProp, $idPoe, $fecMonta, $fecParir, $metodo, $isTE, $idTextoRec, $fecEmbrion);
    return $registros;
  }
  public function getLastInsertMonta()
  {
    $registros = $this->context->getLastInsertMonta();
    return $registros;
  }
  public function obtenerNAC($codigo){
    $registros = $this->context->obtenerNAC($codigo);
    return $registros;
  }
}
